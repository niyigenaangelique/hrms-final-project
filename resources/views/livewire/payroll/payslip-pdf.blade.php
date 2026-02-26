<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .employee-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h3 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td, th {
            padding: 8px;
            text-align: left;
        }
        .total-row {
            border-top: 2px solid #333;
            font-weight: bold;
        }
        .net-pay {
            border-top: 3px double #333;
            font-size: 18px;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ZIBITECH</h1>
        <p>Payslip for {{ $payrollEntry->payrollMonth->name }}</p>
        <p>Generated on: {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="employee-info">
        <div>
            <h3>Employee Details</h3>
            <p><strong>Name:</strong> {{ $payrollEntry->employee->first_name }} {{ $payrollEntry->employee->last_name }}</p>
            <p><strong>Employee No:</strong> {{ $payrollEntry->employee->employee_number }}</p>
            <p><strong>Department:</strong> {{ $payrollEntry->employee->department->name ?? 'N/A' }}</p>
            <p><strong>Position:</strong> {{ $payrollEntry->employee->position->name ?? 'N/A' }}</p>
        </div>
        <div>
            <h3>Pay Period</h3>
            <p><strong>Period:</strong> {{ $payrollEntry->payrollMonth->start_date->format('M d, Y') }} - {{ $payrollEntry->payrollMonth->end_date->format('M d, Y') }}</p>
            <p><strong>Payment Date:</strong> {{ now()->format('M d, Y') }}</p>
            <p><strong>Payroll Code:</strong> {{ $payrollEntry->code }}</p>
        </div>
    </div>

    <div class="section">
        <h3>Earnings</h3>
        <table>
            <tr>
                <td>Basic Salary ({{ $payrollEntry->work_days }} days)</td>
                <td class="text-right">${{ number_format($payrollEntry->work_days_pay, 2) }}</td>
            </tr>
            @if($payrollEntry->overtime_hours_worked > 0)
            <tr>
                <td>Overtime ({{ $payrollEntry->overtime_hours_worked }} hours @ ${{ number_format($payrollEntry->overtime_hour_rate, 2) }}/hr)</td>
                <td class="text-right">${{ number_format($payrollEntry->overtime_total_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td><strong>Gross Pay</strong></td>
                <td class="text-right"><strong>${{ number_format($payrollEntry->total_amount, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    @if($payrollEntry->payslipEntry)
    <div class="section">
        <h3>Deductions</h3>
        <table>
            <tr>
                <td>PAYE Tax (30%)</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->paye, 2) }}</td>
            </tr>
            <tr>
                <td>Pension (5%)</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->pension, 2) }}</td>
            </tr>
            <tr>
                <td>Maternity (1%)</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->maternity, 2) }}</td>
            </tr>
            <tr>
                <td>CBHI (1%)</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->cbhi, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total Deductions</strong></td>
                <td class="text-right"><strong>${{ number_format($payrollEntry->payslipEntry->paye + $payrollEntry->payslipEntry->pension + $payrollEntry->payslipEntry->maternity + $payrollEntry->payslipEntry->cbhi, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table>
            <tr class="net-pay">
                <td>NET PAY</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->net_pay, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Employer Contributions</h3>
        <table>
            <tr>
                <td>Pension (7%)</td>
                <td class="text-right">${{ number_format($payrollEntry->payslipEntry->employer_contribution, 2) }}</td>
            </tr>
        </table>
    </div>
    @endif

    <div style="margin-top: 50px; text-align: center; color: #666; font-size: 12px;">
        <p>This is a computer-generated payslip. No signature required.</p>
        <p>For any queries, please contact HR Department.</p>
    </div>
</body>
</html>
