<?php



use App\Enum\ApprovalStatus;
use App\Enum\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('swift_code')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        DB::table('banks')->insert([
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00001', 'name' => 'AB BANK RWANDA PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'ABBRRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00002', 'name' => 'ACCESS BANK (RWANDA) PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'BKORRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00003', 'name' => 'BANK OF KIGALI PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'BKIGRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00006', 'name' => 'BPR BANK RWANDA PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'BPRWRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00007', 'name' => 'DEVELOPMENT BANK OF RWANDA', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'BRDRRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00008', 'name' => 'ECOBANK RWANDA', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'ECOCRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00009', 'name' => 'EQUITY BANK RWANDA PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'EQBLRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00010', 'name' => 'GUARANTY TRUST BANK (RWANDA) PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'GTBIRWRK'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00011', 'name' => 'I AND M BANK (RWANDA) PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'IMRWRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00012', 'name' => 'NCBA BANK RWANDA PLC', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'CBAFRWRW'],
            ['id' => Str::orderedUuid(), 'code' =>  'SGA-00013', 'name' => 'Zigama CSS', 'city' => 'Kigali', 'country' => 'Rwanda', 'swift_code' => 'ZIGARWRW']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
