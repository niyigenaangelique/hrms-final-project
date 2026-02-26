<?php

namespace Tests\Unit\Helpers;

use App\Helpers\AdvancedImporterHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Mockery;

class AdvancedImporterHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set up temporary storage disk
        Storage::fake('local');

        // Ensure tables are dropped before creating to avoid conflicts
        Schema::dropIfExists('test_table');
        Schema::dropIfExists('employees');

        // Create temporary tables for testing
        Schema::create('test_table', function ($table) {
            $table->id();
            $table->string('name');
            $table->integer('employee_id')->nullable();
            $table->timestamps();
        });

        Schema::create('employees', function ($table) {
            $table->id();
            $table->string('employee_code')->unique();
            $table->string('name');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        // Drop tables to ensure clean state
        Schema::dropIfExists('test_table');
        Schema::dropIfExists('employees');

        // Clear Mockery mocks
        Mockery::close();

        parent::tearDown();
    }

    public function test_import_to_database_successful()
    {
        // Prepare test data
        $filePath = 'test.xlsx';
        $data = [
            ['name' => 'John Doe', 'employee_code' => 'EMP001'],
            ['name' => 'Jane Doe', 'employee_code' => 'EMP002'],
        ];
        DB::table('employees')->insert([
            ['employee_code' => 'EMP001', 'name' => 'John', 'created_at' => now(), 'updated_at' => now()],
            ['employee_code' => 'EMP002', 'name' => 'Jane', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Mock Excel import
        Excel::shouldReceive('toCollection')
            ->once()
            ->andReturn(collect([collect($data)]));

        Storage::disk('local')->put($filePath, '');

        $rules = [
            'name' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
        ];
        $fieldMap = ['name' => 'name', 'employee_code' => 'employee_code'];
        $lookupFields = [
            'employee_id' => [
                'table' => 'employees',
                'source_column' => 'employee_code',
                'target_column' => 'id',
            ],
        ];

        $result = AdvancedImporterHelper::importToDatabase(
            filePath: $filePath,
            target: 'test_table',
            rules: $rules,
            fieldMap: $fieldMap,
            lookupFields: $lookupFields,
            disk: 'local',
            dryRun: false
        );

        $this->assertEquals(2, $result['inserted']);
        $this->assertEquals(2, $result['valid_count']);
        $this->assertEquals(0, $result['invalid_count']);
        $this->assertEquals(2, DB::table('test_table')->count());
    }

    public function test_import_to_database_invalid_file_path()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Invalid file path/');

        AdvancedImporterHelper::importToDatabase(
            filePath: '../invalid/path/test.xlsx',
            target: 'test_table',
            disk: 'local'
        );
    }

    public function test_import_to_array_validation_failure()
    {
        $filePath = 'test.xlsx';
        $data = [
            ['name' => '', 'employee_code' => 'EMP001'], // Invalid: empty name
            ['name' => 'Jane Doe', 'employee_code' => 'EMP999'], // Invalid: non-existent employee
        ];
        DB::table('employees')->insert([
            ['employee_code' => 'EMP001', 'name' => 'John', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Excel::shouldReceive('toCollection')
            ->once()
            ->andReturn(collect([collect($data)]));

        Storage::disk('local')->put($filePath, '');

        $rules = [
            'name' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
        ];
        $lookupFields = [
            'employee_id' => [
                'table' => 'employees',
                'source_column' => 'employee_code',
                'target_column' => 'id',
            ],
        ];

        $result = AdvancedImporterHelper::importToArray(
            filePath: $filePath,
            rules: $rules,
            lookupFields: $lookupFields,
            disk: 'local'
        );

        $this->assertEquals(0, $result['valid_count']);
        $this->assertEquals(2, $result['invalid_count']);
        $this->assertArrayHasKey('errors', $result['invalid_rows'][0]);
        $this->assertArrayHasKey('errors', $result['invalid_rows'][1]);
    }

    public function test_load_excel_file()
    {
        $filePath = 'test.xlsx';
        $data = [
            ['name' => 'John Doe', 'code' => 'EMP001'],
        ];
        Excel::shouldReceive('toCollection')
            ->once()
            ->andReturn(collect([collect($data)]));

        Storage::disk('local')->put($filePath, '');

        $collection = AdvancedImporterHelper::loadExcelFile($filePath, [], 1000, null, null, 'local');

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals('John Doe', $collection[0]['name']);
    }

    public function test_build_lookup_cache()
    {
        DB::table('employees')->insert([
            ['employee_code' => 'EMP001', 'name' => 'John', 'created_at' => now(), 'updated_at' => now()],
            ['employee_code' => 'EMP002', 'name' => 'Jane', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $lookupFields = [
            'employee_id' => [
                'table' => 'employees',
                'source_column' => 'employee_code',
                'target_column' => 'id',
            ],
        ];

        $cache = AdvancedImporterHelper::buildLookupCache($lookupFields);

        $this->assertArrayHasKey('employee_id', $cache);
        $this->assertArrayHasKey('EMP001', $cache['employee_id']);
        $this->assertEquals(1, $cache['employee_id']['EMP001']);
        $this->assertEquals(2, $cache['employee_id']['EMP002']);
    }

    public function test_insert_rows_batch()
    {
        $rows = [
            ['name' => 'John Doe', 'employee_id' => 1],
            ['name' => 'Jane Doe', 'employee_id' => 2],
        ];

        $inserted = AdvancedImporterHelper::insertRows($rows, 'test_table', 1000, true);

        $this->assertEquals(2, $inserted);
        $this->assertEquals(2, DB::table('test_table')->count());
    }

    public function test_export_invalid_rows()
    {
        $invalidRows = [
            ['name' => '', 'employee_code' => 'EMP001', 'errors' => ['name' => ['The name field is required.']]],
        ];
        $outputPath = 'invalid_rows.xlsx';

        Excel::shouldReceive('store')
            ->once()
            ->withArgs(function ($exporter, $path, $disk, $format) use ($outputPath) {
                return $path === $outputPath && $disk === 'local' && $format === 'Xlsx';
            })
            ->andReturn(true);

        AdvancedImporterHelper::exportInvalidRows($invalidRows, $outputPath, 'local');

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    public function test_import_to_database_dry_run()
    {
        $filePath = 'test.xlsx';
        $data = [
            ['name' => 'John Doe', 'employee_code' => 'EMP001'],
        ];
        DB::table('employees')->insert([
            ['employee_code' => 'EMP001', 'name' => 'John', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Excel::shouldReceive('toCollection')
            ->once()
            ->andReturn(collect([collect($data)]));

        Storage::disk('local')->put($filePath, '');

        $rules = [
            'name' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
        ];
        $lookupFields = [
            'employee_id' => [
                'table' => 'employees',
                'source_column' => 'employee_code',
                'target_column' => 'id',
            ],
        ];

        $result = AdvancedImporterHelper::importToDatabase(
            filePath: $filePath,
            target: 'test_table',
            rules: $rules,
            lookupFields: $lookupFields,
            disk: 'local',
            dryRun: true
        );

        $this->assertEquals(1, $result['inserted']);
        $this->assertEquals(1, $result['valid_count']);
        $this->assertEquals(0, $result['invalid_count']);
        $this->assertEquals(0, DB::table('test_table')->count()); // No actual insertion in dry run
    }
}
