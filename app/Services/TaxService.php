<?php

namespace App\Services;

class TaxService
{
    /**
     * Calculate all taxes for a given gross salary and rates.
     * Returns an array matching PayslipEntry fields exactly.
     */
    public function calculate(
        float $grossSalary,
        float $pensionRate = 5,
        float $maternityRate = 1,
        float $cbhiRate = 1,
        float $payeRate = 30,
        bool  $useRwandanTax = true,
        array $customDeductions = [],
        array $customBenefits = []
    ): array {
        if ($grossSalary <= 0) {
            return $this->empty();
        }

        $pension    = round(($grossSalary * $pensionRate)    / 100, 2);
        $maternity  = round(($grossSalary * $maternityRate)  / 100, 2);
        $cbhi       = round(($grossSalary * $cbhiRate)       / 100, 2);

        $totalCustomDeductions = collect($customDeductions)->sum('amount');
        $totalCustomBenefits   = collect($customBenefits)->sum('amount');

        // Taxable income = gross - pension - custom deductions
        $taxableIncome = $grossSalary - $pension - $totalCustomDeductions;

        $paye = $useRwandanTax
            ? $this->rwandanPAYE($taxableIncome)
            : round(($taxableIncome * $payeRate) / 100, 2);

        $employerContribution = round(($grossSalary * 7) / 100, 2);
        $totalDeductions      = $paye + $pension + $maternity + $cbhi + $totalCustomDeductions;
        $netPay               = $taxableIncome - $paye - $maternity - $cbhi + $totalCustomBenefits;
        $effectiveRate        = $grossSalary > 0 ? round(($totalDeductions / $grossSalary) * 100, 2) : 0;

        return [
            'gross_pay'            => round($grossSalary, 2),
            'taxable_income'       => round($taxableIncome, 2),
            'paye'                 => round($paye, 2),
            'pension'              => round($pension, 2),
            'maternity'            => round($maternity, 2),
            'cbhi'                 => round($cbhi, 2),
            'employer_contribution' => $employerContribution,
            'net_pay'              => round($netPay, 2),
            'total_deductions'     => round($totalDeductions, 2),
            'effective_tax_rate'   => $effectiveRate,
            'tax_bracket_used'     => $useRwandanTax ? $this->taxBracket($taxableIncome) : "Flat {$payeRate}%",
        ];
    }

    /**
     * Rwandan progressive PAYE brackets.
     */
    public function rwandanPAYE(float $taxableIncome): float
    {
        if ($taxableIncome <= 30000) {
            return 0;
        } elseif ($taxableIncome <= 100000) {
            return round($taxableIncome * 0.20, 2);
        } elseif ($taxableIncome <= 500000) {
            return round(20000 + (($taxableIncome - 100000) * 0.30), 2);
        } else {
            return round(140000 + (($taxableIncome - 500000) * 0.35), 2);
        }
    }

    /**
     * Human-readable bracket label for metadata.
     */
    private function taxBracket(float $taxableIncome): string
    {
        if ($taxableIncome <= 30000)  return '0% (≤30,000)';
        if ($taxableIncome <= 100000) return '20% (30,001–100,000)';
        if ($taxableIncome <= 500000) return '30% (100,001–500,000)';
        return '35% (>500,000)';
    }

    private function empty(): array
    {
        return [
            'gross_pay' => 0, 'taxable_income' => 0, 'paye' => 0,
            'pension' => 0, 'maternity' => 0, 'cbhi' => 0,
            'employer_contribution' => 0, 'net_pay' => 0,
            'total_deductions' => 0, 'effective_tax_rate' => 0,
            'tax_bracket_used' => 'N/A',
        ];
    }
}
