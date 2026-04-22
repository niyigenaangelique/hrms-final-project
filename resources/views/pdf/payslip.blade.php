<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $payslip->code }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.4; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3B6FE8; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #3B6FE8; margin: 0; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #666; }
        
        .section-title { background: #f0f4fa; padding: 5px 10px; font-weight: bold; color: #1a3fa8; margin: 15px 0 10px; border-left: 4px solid #3B6FE8; }
        
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .grid td { padding: 5px; vertical-align: top; width: 50%; }
        
        .info-label { font-weight: bold; color: #666; width: 40%; display: inline-block; }
        .info-value { color: #000; font-weight: bold; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 8px; text-align: left; font-size: 11px; text-transform: uppercase; color: #666; }
        table.data-table td { padding: 8px; border-bottom: 1px solid #eee; }
        
        .total-row { background: #f8f9fa; font-weight: bold; font-size: 13px; }
        .net-pay-box { background: #3B6FE8; color: #fff; padding: 15px; text-align: center; border-radius: 5px; margin-top: 20px; }
        .net-pay-box h2 { margin: 0; font-size: 24px; }
        .net-pay-box p { margin: 5px 0 0; opacity: 0.8; text-transform: uppercase; font-size: 10px; letter-spacing: 1px; }
        
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $orgName }} PAYSLIP</h1>
        <p>Period: {{ $month->name ?? 'N/A' }} ({{ \Carbon\Carbon::parse($month->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($month->end_date)->format('M d, Y') }})</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="section-title">Employee Details</div>
                <p><span class="info-label">Name:</span> <span class="info-value">{{ $employee->full_name }}</span></p>
                <p><span class="info-label">ID:</span> <span class="info-value">{{ $employee->code }}</span></p>
                <p><span class="info-label">Department:</span> <span class="info-value">{{ $employee->department->name ?? '—' }}</span></p>
                <p><span class="info-label">Position:</span> <span class="info-value">{{ $employee->position->name ?? '—' }}</span></p>
            </td>
            <td>
                <div class="section-title">Payment Info</div>
                <p><span class="info-label">Payslip No:</span> <span class="info-value">{{ $payslip->code }}</span></p>
                <p><span class="info-label">Payment Date:</span> <span class="info-value">{{ now()->format('M d, Y') }}</span></p>
                <p><span class="info-label">Bank:</span> <span class="info-value">{{ $employee->bank_name ?? '—' }}</span></p>
                <p><span class="info-label">Account:</span> <span class="info-value">{{ $employee->bank_account_number ?? '—' }}</span></p>
            </td>
        </tr>
    </table>

    <div class="section-title">Earnings & Deductions</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 70%;">Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary (Work Days: {{ $payrollEntry->work_days }})</td>
                <td style="text-align: right;">{{ number_format($payrollEntry->work_days_pay, 2) }}</td>
            </tr>
            @if($payrollEntry->overtime_total_amount > 0)
            <tr>
                <td>Overtime Pay ({{ $payrollEntry->overtime_hours_worked }} hrs)</td>
                <td style="text-align: right;">{{ number_format($payrollEntry->overtime_total_amount, 2) }}</td>
            </tr>
            @endif
            @if($payslip->housing_allowance > 0)
            <tr>
                <td>Housing Allowance</td>
                <td style="text-align: right;">{{ number_format($payslip->housing_allowance, 2) }}</td>
            </tr>
            @endif
            @if($payslip->transport_allowance > 0)
            <tr>
                <td>Transport Allowance</td>
                <td style="text-align: right;">{{ number_format($payslip->transport_allowance, 2) }}</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td>Gross Earnings</td>
                <td style="text-align: right;">{{ number_format($payslip->gross_pay, 2) }}</td>
            </tr>

            {{-- Deductions --}}
            <tr>
                <td>PAYE Tax</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->paye, 2) }}</td>
            </tr>
            <tr>
                <td>Pension (Employee Part)</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->pension, 2) }}</td>
            </tr>
            @if($payslip->maternity > 0)
            <tr>
                <td>Maternity Contribution</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->maternity, 2) }}</td>
            </tr>
            @endif
            @if($payslip->loan_deduction > 0)
            <tr>
                <td>Loan Repayment</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->loan_deduction, 2) }}</td>
            </tr>
            @endif
            @if($payslip->advance_deduction > 0)
            <tr>
                <td>Salary Advance</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->advance_deduction, 2) }}</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td>Total Deductions</td>
                <td style="text-align: right; color: #c00;">-{{ number_format($payslip->gross_pay - $payslip->net_pay, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="net-pay-box">
        <p>Take Home Pay</p>
        <h2>${{ number_format($payslip->net_pay, 2) }}</h2>
    </div>

    <div class="footer">
        <p>This is a computer generated document and does not require a physical signature.</p>
        <p>Generated on {{ $generatedAt }}</p>
    </div>
</body>
</html>
