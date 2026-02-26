<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSalaryCalculationProcedures extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $calculateNetFromGross = "
            DROP PROCEDURE IF EXISTS `CalculateNetFromGrossProc`;
            CREATE PROCEDURE `CalculateNetFromGrossProc`(
                IN gross DECIMAL(12,2),
                IN use_percentage TINYINT(1),
                IN transport_percentage DECIMAL(5,2),
                IN transport_fixed DECIMAL(12,2),
                IN employment_type VARCHAR(20),
                OUT out_gross DECIMAL(12,2),
                OUT out_paye DECIMAL(12,2),
                OUT out_pension DECIMAL(12,2),
                OUT out_maternity DECIMAL(12,2),
                OUT out_cbhi DECIMAL(12,2),
                OUT out_net DECIMAL(12,2)
            )
            DETERMINISTIC
            BEGIN
                DECLARE transport_allowance DECIMAL(12,2);

                IF use_percentage IS NULL THEN SET use_percentage = 1; END IF;
                IF transport_percentage IS NULL THEN SET transport_percentage = 0.00; END IF;
                IF transport_fixed IS NULL THEN SET transport_fixed = 0.00; END IF;
                IF employment_type IS NULL THEN SET employment_type = 'Permanent'; END IF;

                SET out_gross = gross;

                IF use_percentage = 1 THEN
                    SET transport_allowance = gross * (transport_percentage / 100);
                ELSE
                    SET transport_allowance = transport_fixed;
                END IF;

                SET transport_allowance = LEAST(transport_allowance, gross);

                CASE employment_type
                    WHEN 'Permanent' THEN
                        IF gross <= 60000 THEN
                            SET out_paye = 0;
                        ELSEIF gross <= 100000 THEN
                            SET out_paye = (gross - 60000) * 0.10;
                        ELSEIF gross <= 200000 THEN
                            SET out_paye = (40000 * 0.10) + ((gross - 100000) * 0.20);
                        ELSE
                            SET out_paye = (40000 * 0.10) + (100000 * 0.20) + ((gross - 200000) * 0.30);
                        END IF;
                    WHEN 'Casual' THEN
                        IF gross <= 60000 THEN
                            SET out_paye = 0;
                        ELSE
                            SET out_paye = (gross - 60000) * 0.15;
                        END IF;
                    WHEN 'Exempted' THEN
                        SET out_paye = 0;
                    WHEN 'Second Employer' THEN
                        SET out_paye = gross * 0.30;
                    ELSE
                        SET out_paye = 0;
                    END CASE;

                SET out_pension = gross * 0.06;
                SET out_maternity = GREATEST((gross - transport_allowance), 0) * 0.003;
                SET out_cbhi = GREATEST((gross - out_paye - out_pension - out_maternity), 0) * 0.005;

                SET out_net = gross - out_paye - out_pension - out_maternity - out_cbhi;
            END;
        ";

        $estimateGrossFromNet = "
            DROP PROCEDURE IF EXISTS `EstimateGrossFromNet`;
            CREATE PROCEDURE `EstimateGrossFromNet`(
                IN target_net DECIMAL(12,2),
                IN use_percentage TINYINT(1),
                IN transport_percentage DECIMAL(5,2),
                IN transport_fixed DECIMAL(12,2),
                IN employment_type VARCHAR(20),
                OUT out_gross DECIMAL(12,2),
                OUT out_paye DECIMAL(12,2),
                OUT out_pension DECIMAL(12,2),
                OUT out_maternity DECIMAL(12,2),
                OUT out_cbhi DECIMAL(12,2),
                OUT out_net DECIMAL(12,2)
            )
            BEGIN
                DECLARE low DECIMAL(12,2) DEFAULT 0;
                DECLARE high DECIMAL(12,2) DEFAULT 100000000;
                DECLARE mid DECIMAL(12,2);
                DECLARE calculated_net DECIMAL(12,2);
                DECLARE temp_paye DECIMAL(12,2);
                DECLARE temp_pension DECIMAL(12,2);
                DECLARE temp_maternity DECIMAL(12,2);
                DECLARE temp_cbhi DECIMAL(12,2);
                DECLARE i INT DEFAULT 0;

                IF use_percentage IS NULL THEN SET use_percentage = 1; END IF;
                IF transport_percentage IS NULL THEN SET transport_percentage = 0.00; END IF;
                IF transport_fixed IS NULL THEN SET transport_fixed = 0.00; END IF;
                IF employment_type IS NULL THEN SET employment_type = 'Permanent'; END IF;

                WHILE i < 100 DO
                    SET mid = (low + high) / 2;
                    CALL CalculateNetFromGrossProc(mid, use_percentage, transport_percentage, transport_fixed, employment_type, out_gross, temp_paye, temp_pension, temp_maternity, temp_cbhi, calculated_net);

                    IF ABS(calculated_net - target_net) < 0.01 THEN
                        SET i = 100;
                    ELSEIF calculated_net < target_net THEN
                        SET low = mid;
                    ELSE
                        SET high = mid;
                    END IF;

                    SET i = i + 1;
                END WHILE;

                SET out_gross = ROUND((low + high) / 2, 2);
                CALL CalculateNetFromGrossProc(out_gross, use_percentage, transport_percentage, transport_fixed, employment_type, out_gross, out_paye, out_pension, out_maternity, out_cbhi, out_net);
            END;
        ";

        DB::unprepared($calculateNetFromGross);
        DB::unprepared($estimateGrossFromNet);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS `CalculateNetFromGrossProc`;');
        DB::unprepared('DROP PROCEDURE IF EXISTS `EstimateGrossFromNet`;');
    }
}
