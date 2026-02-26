<?php

namespace Tests\Unit\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Mockery;

class HelperFunctionsTest extends TestCase
{
    /**
     * Test parseNumber with valid inputs.
     *
     * @return void
     */
    public function testParseNumberWithValidInputs()
    {
        $this->assertEquals(123, parseNumber('123'));
        $this->assertEquals(123.45, parseNumber('123.45'));
        $this->assertEquals(-123.45, parseNumber('-123.45'));
        $this->assertEquals(123456, parseNumber('123,456')); // Expect full number
        $this->assertEquals(123.45, parseNumber('$123.45'));
    }

    /**
     * Test parseNumber with invalid inputs.
     *
     * @return void
     */
    public function testParseNumberWithInvalidInputs()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid numeric value');
        parseNumber('');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid numeric format: multiple decimal points');
        parseNumber('123.45.67');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid numeric format: invalid minus sign');
        parseNumber('12-34');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid numeric value');
        parseNumber('.');
    }

    /**
     * Test stringCapitalize with valid inputs.
     *
     * @return void
     */
    public function testStringCapitalizeWithValidInputs()
    {
        $this->assertEquals('John Doe', stringCapitalize('john doe'));
        $this->assertEquals('João Silva', stringCapitalize('joão silva', 'UTF-8'));
        $this->assertEquals('', stringCapitalize(''));
        $this->assertEquals('Hello World', stringCapitalize('  hello   world  '));
    }

    /**
     * Test stringCapitalize with invalid encoding.
     *
     * @return void
     */
    public function testStringCapitalizeWithInvalidEncoding()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unsupported encoding: 'INVALID'");
        stringCapitalize('test', 'INVALID');
    }

    /**
     * Test numberToWords with valid inputs.
     *
     * @return void
     */
    public function testNumberToWordsWithValidInputs()
    {
        // Mock NumberToWords to simulate correct behavior
        $mock = Mockery::mock(NumberToWords::class);
        $mock->shouldReceive('toWords')->with(123, 'en')->andReturn('one hundred twenty-three');
        $mock->shouldReceive('toWords')->with(0, 'en')->andReturn('zero');
        $this->app->instance(NumberToWords::class, $mock);

        $this->assertEquals('one hundred twenty-three', numberToWords(123));
        $this->assertEquals('zero', numberToWords(0));
        $this->assertEquals('Invalid number', numberToWords('abc'));
    }

    /**
     * Test numberToWords with large numbers.
     *
     * @return void
     */
    public function testNumberToWordsWithLargeNumbers()
    {
        $tooBig = bcpow('10', '20'); // way above PHP_INT_MAX
        $this->assertEquals('Number too large for conversion', numberToWords($tooBig));
    }


    /**
     * Test localizedNumberToWords with valid inputs.
     *
     * @return void
     */
    public function testLocalizedNumberToWordsWithValidInputs()
    {
        $this->assertStringContainsString('one hundred twenty-three', localizedNumberToWords(123, 'en'));
        $this->assertStringContainsString('point four five', localizedNumberToWords(123.45, 'en'));
        $this->assertStringContainsString('minus one hundred twenty-three', localizedNumberToWords(-123, 'en'));
        $this->assertEquals('Invalid number', localizedNumberToWords('abc'));
    }

    /**
     * Test localizedNumberToWords with large numbers.
     *
     * @return void
     */
    public function testLocalizedNumberToWordsWithLargeNumbers()
    {
        $this->assertEquals('Number too large for accurate conversion', localizedNumberToWords('1234567890123456'));
    }

    /**
     * Test localizedNumberToWords with invalid locale.
     *
     * @return void
     */
    public function testLocalizedNumberToWordsWithInvalidLocale()
    {
        $this->assertEquals('Conversion error: Invalid locale', localizedNumberToWords(123, 'invalid_locale'));
    }

    /**
     * Test getPayslipDetails with valid inputs.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithValidInputs()
    {
        // Mock the DB facade
        $dbMock = Mockery::mock('alias:Illuminate\Support\Facades\DB');

        $dbMock->shouldReceive('beginTransaction')->once();
        $dbMock->shouldReceive('statement')
            ->with('SET SESSION max_execution_time = ?', [5000])
            ->once();

        $dbMock->shouldReceive('select')
            ->withArgs(function ($sql, $params) {
                return str_contains($sql, 'CALL EstimateGrossFromNet') && $params[0] === 50000.0;
            })
            ->once();

        $dbMock->shouldReceive('selectOne')
            ->with(Mockery::on(fn($sql) => str_contains($sql, '@out_gross')))
            ->once()
            ->andReturn((object)[
                'gross_salary' => 60000.0,
                'paye' => 10000.0,
                'pension' => 2000.0,
                'maternity' => 500.0,
                'cbhi' => 300.0,
                'net_salary' => 50000.0,
            ]);

        $dbMock->shouldReceive('commit')->once();
        $dbMock->shouldReceive('rollBack')->zeroOrMoreTimes();

        $result = getPayslipDetails(50000, 'Permanent', true, 10.0, 0.0, 5);

        $this->assertEquals([
            'gross_salary' => 60000.0,
            'paye' => 10000.0,
            'pension' => 2000.0,
            'maternity' => 500.0,
            'cbhi' => 300.0,
            'net_salary' => 50000.0,
            'calculation_date' => now()->toDateTimeString(),
        ], $result);
    }

    /**
     * Test getPayslipDetails with invalid net salary.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithInvalidNetSalary()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Net salary must be a non-negative number.');
        getPayslipDetails(-100, 'Permanent');
    }

    /**
     * Test getPayslipDetails with invalid employment type.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithInvalidEmploymentType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid employment type');
        getPayslipDetails(50000, 'InvalidType');
    }

    /**
     * Test getPayslipDetails with invalid transport percentage.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithInvalidTransportPercentage()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Transport percentage must be between 0 and 100.');
        getPayslipDetails(50000, 'Permanent', true, 150.0);
    }

    /**
     * Test getPayslipDetails with invalid timeout.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithInvalidTimeout()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Timeout must be between 1 and 60 seconds.');
        getPayslipDetails(50000, 'Permanent', true, 10.0, 0.0, 0);
    }

    /**
     * Test getPayslipDetails with database error.
     *
     * @return void
     */
    public function testGetPayslipDetailsWithDatabaseError()
    {
        $dbMock = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $dbMock->shouldReceive('beginTransaction')->once();
        $dbMock->shouldReceive('statement')->with('SET SESSION max_execution_time = ?', [5000])->once();
        $dbMock->shouldReceive('select')
            ->with(
                'CALL EstimateGrossFromNet(?, ?, ?, ?, ?, @out_gross, @out_paye, @out_pension, @out_maternity, @out_cbhi, @out_net)',
                [50000.0, 1, 10.0, 0.0, 'Permanent']
            )
            ->andThrow(new QueryException('connection', 'SQL error', [], new \Exception('Database error')));
        $dbMock->shouldReceive('rollBack')->once();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Database error during payslip calculation');
        getPayslipDetails(50000, 'Permanent', true, 10.0, 0.0, 5);
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
