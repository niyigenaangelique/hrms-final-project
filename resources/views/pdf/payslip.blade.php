<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $payslip->code }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        
        body { font-family: 'Inter', 'Helvetica', Arial, sans-serif; font-size: 11pt; color: #1f2937; line-height: 1.5; margin: 0; padding: 0; background: #fff; }
        .page { padding: 40px; }
        
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #3B6FE8; padding-bottom: 20px; margin-bottom: 30px; }
        .header-left h1 { color: #3B6FE8; margin: 0; font-size: 26pt; font-weight: 800; letter-spacing: -1px; }
        .header-left p { margin: 5px 0 0; color: #6b7280; font-weight: 600; font-size: 10pt; text-transform: uppercase; letter-spacing: 1px; }
        .header-right { text-align: right; }
        .header-right .org-name { font-size: 14pt; font-weight: 800; color: #111827; }
        .header-right .period { color: #3B6FE8; font-weight: 700; margin-top: 5px; }

        .section-grid { display: table; width: 100%; margin-bottom: 25px; border-spacing: 20px 0; margin-left: -20px; }
        .section-col { display: table-cell; width: 50%; vertical-align: top; }
        
        .section-title { font-size: 9pt; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #9ca3af; margin-bottom: 12px; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; }
        .card-sub-title { font-size: 12pt; font-weight: 700; color: #111827; margin-bottom: 15px; }

        .info-row { display: table; width: 100%; margin-bottom: 8px; font-size: 10pt; }
        .info-label { display: table-cell; color: #6b7280; font-weight: 500; width: 45%; }
        .info-value { display: table-cell; color: #111827; font-weight: 700; text-align: right; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { text-align: left; font-size: 8pt; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; padding: 10px 12px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        .data-table td { padding: 12px; border-bottom: 1px solid #f3f4f6; font-size: 10pt; }
        .data-table .label { font-weight: 600; color: #374151; }
        .data-table .amount { font-weight: 700; text-align: right; font-family: 'Courier New', Courier, monospace; }
        .data-table .plus { color: #059669; }
        .data-table .minus { color: #dc2626; }
        
        .total-row { background: #f9fafb; }
        .total-row td { font-weight: 800 !important; font-size: 11pt !important; color: #111827 !important; border-top: 2px solid #e5e7eb; }

        .net-pay-section { margin-top: 40px; background: linear-gradient(135deg, #1e40af 0%, #3B6FE8 100%); padding: 30px; border-radius: 12px; color: #fff; text-align: center; }
        .net-pay-label { font-size: 10pt; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em; opacity: 0.9; margin-bottom: 8px; }
        .net-pay-amount { font-size: 32pt; font-weight: 800; letter-spacing: -1px; }
        .net-pay-sub { font-size: 9pt; opacity: 0.7; margin-top: 5px; font-weight: 500; }

        .footer { margin-top: 50px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .footer p { margin: 4px 0; font-size: 8pt; color: #9ca3af; font-weight: 500; }
        
        .badge { display: inline-block; padding: 4px 12px; border-radius: 100px; font-size: 8pt; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="header-left">
                <h1>PAYSLIP</h1>
                <p>Official Salary Statement</p>
            </div>
            <div class="header-right">
                <div class="org-name">{{ $orgName }}</div>
                <div class="period">
                    @if($computation)
                        {{ $computation->period_name }}
                    @else
                        {{ $payrollEntry->payrollMonth->name ?? 'N/A' }}
                    @endif
                </div>
            </div>
        </div>

        <div class="section-grid">
            <div class="section-col">
                <div class="section-title">Employee Details</div>
                <div class="card-sub-title">Personal & employment info</div>
                
                <div class="info-row"><div class="info-label">Full Name</div><div class="info-value">{{ $employee->full_name }}</div></div>
                <div class="info-row"><div class="info-label">Employee ID</div><div class="info-value">{{ $employee->code }}</div></div>
                <div class="info-row">
                    <div class="info-label">Nationality</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->nationality }}
                        @else
                            Rwandan
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bank Name</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->bank_name ?? '—' }}
                        @else
                            {{ $employee->bank_name ?? '—' }}
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Account No.</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->bank_account ?? '—' }}
                        @else
                            {{ $employee->bank_account_number ?? '—' }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="section-col">
                <div class="section-title">Position</div>
                <div style="height: 12px;"></div>
                <div class="info-row">
                    <div class="info-label">Department</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->department ?? '—' }}
                        @else
                            {{ $employee->department->name ?? '—' }}
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Position</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->position ?? '—' }}
                        @else
                            {{ $employee->position->name ?? '—' }}
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Days Present</div>
                    <div class="info-value">
                        @if($computation)
                            {{ $computation->present_days }} / {{ $computation->working_days }}
                        @else
                            {{ $payrollEntry->work_days }}
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payroll Status</div>
                    <div class="info-value">
                        <span class="badge badge-success">
                            {{ ucfirst($payslip->status->value ?? 'Generated') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-grid">
            <div class="section-col">
                <div class="section-title">Earnings Breakdown</div>
                <div class="card-sub-title">Gross income details</div>
                
                <table class="data-table">
                    <tr><td class="label">Basic Salary</td><td class="amount plus">{{ number_format($computation ? $computation->basic_salary : $payrollEntry->work_days_pay, 0) }}</td></tr>
                    <tr><td class="label">House Allowance</td><td class="amount plus">{{ number_format($computation ? $computation->house_allowance : ($payslip->housing_allowance ?? 0), 0) }}</td></tr>
                    <tr><td class="label">Transport Allowance</td><td class="amount plus">{{ number_format($computation ? $computation->transport_allowance : ($payslip->transport_allowance ?? 0), 0) }}</td></tr>
                    <tr><td class="label">Other Allowances</td><td class="amount plus">{{ number_format($computation ? $computation->other_allowances : 0, 0) }}</td></tr>
                    <tr><td class="label">Overtime Pay</td><td class="amount plus">{{ number_format($computation ? $computation->overtime_pay : ($payrollEntry->overtime_total_amount ?? 0), 0) }}</td></tr>
                    <tr class="total-row"><td class="label">Total Gross Income</td><td class="amount">{{ number_format($computation ? $computation->gross_pay : $payslip->gross_pay, 0) }}</td></tr>
                </table>
            </div>
            <div class="section-col">
                <div class="section-title">Statutory Deductions</div>
                <div class="card-sub-title">Rwanda tax compliance</div>
                
                <table class="data-table">
                    <tr><td class="label">PAYE Tax</td><td class="amount minus">-{{ number_format($computation ? $computation->paye_tax : $payslip->paye, 0) }}</td></tr>
                    <tr><td class="label">RSSB (Employee 3%)</td><td class="amount minus">-{{ number_format($computation ? $computation->rssb_employee : $payslip->pension, 0) }}</td></tr>
                    <tr><td class="label">Maternity Fund</td><td class="amount minus">-{{ number_format($computation ? $computation->maternity_fund : $payslip->maternity, 0) }}</td></tr>
                    <tr><td class="label">CBHI (4.5%)</td><td class="amount minus">-{{ number_format($computation ? $computation->cbhi : ($payslip->cbhi ?? 0), 0) }}</td></tr>
                    @if($computation && $computation->salary_advance > 0)
                        <tr><td class="label">Salary Advance</td><td class="amount minus">-{{ number_format($computation->salary_advance, 0) }}</td></tr>
                    @endif
                    <tr class="total-row">
                        <td class="label">Total Deducted</td>
                        <td class="amount minus">
                            -{{ number_format($computation ? $computation->total_deductions : ($payslip->gross_pay - $payslip->net_pay), 0) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="net-pay-section">
            <div class="net-pay-label">Net Pay Received (RWF)</div>
            <div class="net-pay-amount">{{ number_format($payslip->net_pay, 0) }}</div>
            <div class="net-pay-sub">Transfer to Bank Account</div>
        </div>

        <div class="footer">
            <p>This is a computer-generated payslip for <strong>{{ $orgName }}</strong> Rwanda operations.</p>
            <p>Generated on {{ $generatedAt }} • Code: {{ $payslip->code }}</p>
        </div>
    </div>
</body>
</html>
