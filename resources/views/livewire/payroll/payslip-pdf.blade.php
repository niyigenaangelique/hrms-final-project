<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', 'Segoe UI', Arial, sans-serif;
            background: #f8fafc;
            color: #0f0f19;
            padding: 40px;
            font-size: 13.5px;
            line-height: 1.6;
        }

        .payslip {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* ── Hero header ── */
        .payslip-hero {
            background: linear-gradient(135deg, rgba(13,148,136,0.9) 0%, rgba(8,145,178,0.9) 50%, rgba(79,70,229,0.85) 100%);
            padding: 32px 36px;
            text-align: center;
            position: relative;
        }
        .payslip-hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        .payslip-hero h1 {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .payslip-hero .period {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.75);
            margin-bottom: 3px;
        }
        .payslip-hero .generated {
            font-size: 11px;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* ── Info grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-bottom: 1px solid rgba(0,0,0,0.07);
        }
        .info-block {
            padding: 24px 28px;
        }
        .info-block:first-child {
            border-right: 1px solid rgba(0,0,0,0.07);
        }
        .info-block-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(15,15,25,0.4);
            margin-bottom: 12px;
        }
        .info-row {
            display: flex;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 13px;
        }
        .info-label {
            font-weight: 600;
            color: rgba(15,15,25,0.5);
            min-width: 110px;
            flex-shrink: 0;
        }
        .info-value {
            font-weight: 500;
            color: rgba(15,15,25,0.9);
        }
        .info-value.bold {
            font-weight: 700;
            color: rgba(15,15,25,0.96);
        }

        /* ── Sections ── */
        .section {
            padding: 22px 28px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .section:last-child { border-bottom: none; }

        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(15,15,25,0.4);
            margin-bottom: 14px;
        }

        table.ledger {
            width: 100%;
            border-collapse: collapse;
        }
        .ledger tr {
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }
        .ledger tr:last-child { border-bottom: none; }
        .ledger td {
            padding: 7px 0;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(15,15,25,0.8);
        }
        .ledger td.amount {
            text-align: right;
            font-weight: 600;
            color: rgba(15,15,25,0.9);
        }
        .ledger tr.subtotal td {
            padding-top: 12px;
            font-weight: 700;
            font-size: 14px;
            color: rgba(15,15,25,0.96);
            border-top: 1px solid rgba(0,0,0,0.12);
        }
        .ledger tr.subtotal td.amount {
            font-weight: 700;
        }

        /* ── Net pay ── */
        .net-pay-block {
            margin: 0 28px 24px;
            padding: 18px 22px;
            background: linear-gradient(135deg, rgba(13,148,136,0.07), rgba(8,145,178,0.05));
            border: 1px solid rgba(13,148,136,0.2);
            border-radius: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .net-pay-label {
            font-size: 15px;
            font-weight: 700;
            color: rgba(15,15,25,0.96);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .net-pay-value {
            font-size: 28px;
            font-weight: 700;
            color: #0d9488;
            letter-spacing: -1px;
        }

        /* ── Employer contributions ── */
        .employer-block {
            background: rgba(0,0,0,0.02);
        }

        /* ── Footer ── */
        .payslip-footer {
            padding: 20px 28px;
            background: rgba(0,0,0,0.02);
            border-top: 1px solid rgba(0,0,0,0.06);
            text-align: center;
        }
        .payslip-footer p {
            font-size: 11.5px;
            color: rgba(15,15,25,0.4);
            margin-bottom: 3px;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .payslip { box-shadow: none; border-radius: 0; border: none; max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="payslip">

    {{-- Hero --}}
    <div class="payslip-hero">
        <h1>ZIBITECH</h1>
        <div class="period">Payslip for {{ $payrollEntry->payrollMonth->name }}</div>
        <div class="generated">Generated on {{ now()->format('F d, Y') }}</div>
    </div>

    {{-- Employee + Pay Period --}}
    <div class="info-grid">
        <div class="info-block">
            <div class="info-block-title">Employee Details</div>
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value bold">{{ $payrollEntry->employee->first_name }} {{ $payrollEntry->employee->last_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Employee No</span>
                <span class="info-value">{{ $payrollEntry->employee->employee_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Department</span>
                <span class="info-value">{{ $payrollEntry->employee->department->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Position</span>
                <span class="info-value">{{ $payrollEntry->employee->position->name ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="info-block">
            <div class="info-block-title">Pay Period</div>
            <div class="info-row">
                <span class="info-label">Period</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($payrollEntry->payrollMonth->start_date)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($payrollEntry->payrollMonth->end_date)->format('M d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Date</span>
                <span class="info-value">{{ now()->format('M d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payroll Code</span>
                <span class="info-value">{{ $payrollEntry->code }}</span>
            </div>
        </div>
    </div>

    {{-- Earnings --}}
    <div class="section">
        <div class="section-title">Earnings</div>
        <table class="ledger">
            <tr>
                <td>Basic Salary ({{ $payrollEntry->work_days }} days)</td>
                <td class="amount">${{ number_format($payrollEntry->work_days_pay, 2) }}</td>
            </tr>
            @if($payrollEntry->overtime_hours_worked > 0)
            <tr>
                <td>Overtime ({{ $payrollEntry->overtime_hours_worked }} hrs @ ${{ number_format($payrollEntry->overtime_hour_rate, 2) }}/hr)</td>
                <td class="amount">${{ number_format($payrollEntry->overtime_total_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="subtotal">
                <td>Gross Pay</td>
                <td class="amount">${{ number_format($payrollEntry->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    @if($payrollEntry->payslipEntry)

    {{-- Deductions --}}
    <div class="section">
        <div class="section-title">Deductions</div>
        <table class="ledger">
            <tr>
                <td>PAYE Tax (30%)</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->paye, 2) }}</td>
            </tr>
            <tr>
                <td>Pension (5%)</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->pension, 2) }}</td>
            </tr>
            <tr>
                <td>Maternity (1%)</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->maternity, 2) }}</td>
            </tr>
            <tr>
                <td>CBHI (1%)</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->cbhi, 2) }}</td>
            </tr>
            <tr class="subtotal">
                <td>Total Deductions</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->paye + $payrollEntry->payslipEntry->pension + $payrollEntry->payslipEntry->maternity + $payrollEntry->payslipEntry->cbhi, 2) }}</td>
            </tr>
        </table>
    </div>

    {{-- Net Pay --}}
    <div class="net-pay-block">
        <span class="net-pay-label">Net Pay</span>
        <span class="net-pay-value">${{ number_format($payrollEntry->payslipEntry->net_pay, 2) }}</span>
    </div>

    {{-- Employer Contributions --}}
    <div class="section employer-block">
        <div class="section-title">Employer Contributions</div>
        <table class="ledger">
            <tr>
                <td>Pension (7%)</td>
                <td class="amount">${{ number_format($payrollEntry->payslipEntry->employer_contribution, 2) }}</td>
            </tr>
        </table>
    </div>

    @endif

    {{-- Footer --}}
    <div class="payslip-footer">
        <p>This is a computer-generated payslip. No signature required.</p>
        <p>For any queries, please contact the HR Department.</p>
    </div>

</div>
</body>
</html>