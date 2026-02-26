<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Add rssb_rate column if it doesn't exist
            if (!Schema::hasColumn('employees', 'rssb_rate')) {
                $table->decimal('rssb_rate', 5, 2)->default(3.00)->after('is_taxable')->comment('RSSB contribution rate');
            }
            
            // Update default currency to RWF
            $table->string('salary_currency', 3)->default('RWF')->change();
            
            // Drop nssf_rate column if it exists
            if (Schema::hasColumn('employees', 'nssf_rate')) {
                $table->dropColumn('nssf_rate');
            }
        });
        
        // Update existing records
        \DB::table('employees')
            ->where('salary_currency', 'TZS')
            ->update(['salary_currency' => 'RWF']);
            
        \DB::table('employees')
            ->whereNull('rssb_rate')
            ->update(['rssb_rate' => 3.00]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Add back nssf_rate column
            $table->decimal('nssf_rate', 5, 2)->default(10.00)->after('is_taxable')->comment('NSSF contribution rate');
            
            // Change default currency back to TZS
            $table->string('salary_currency', 3)->default('TZS')->change();
            
            // Drop rssb_rate column
            $table->dropColumn('rssb_rate');
        });
        
        // Update existing records back
        \DB::table('employees')
            ->where('salary_currency', 'RWF')
            ->update(['salary_currency' => 'TZS']);
    }
};
