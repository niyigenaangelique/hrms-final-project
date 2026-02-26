<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employment Contract - {{ $contract->code }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .contract-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-section h3 {
            margin-top: 0;
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-expired {
            background: #f8d7da;
            color: #721c24;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .signature-section {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        .signature-box {
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EMPLOYMENT CONTRACT</h1>
        <p>Contract Code: {{ $contract->code }}</p>
    </div>

    <div class="contract-info">
        <div class="info-section">
            <h3>Employee Information</h3>
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Employee Code:</span>
                <span class="info-value">{{ $contract->employee->code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $contract->employee->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $contract->employee->phone_number }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Contract Details</h3>
            <div class="info-row">
                <span class="info-label">Position:</span>
                <span class="info-value">{{ $contract->position->name ?? 'Not specified' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Employee Category:</span>
                <span class="info-value">{{ ucfirst($contract->employee_category->value ?? 'Not specified') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Daily Working Hours:</span>
                <span class="info-value">{{ $contract->daily_working_hours }} hours</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $contract->status->value }}">
                        {{ ucfirst($contract->status->value) }}
                    </span>
                </span>
            </div>
        </div>
    </div>

    <div class="contract-info">
        <div class="info-section">
            <h3>Employment Period</h3>
            <div class="info-row">
                <span class="info-label">Start Date:</span>
                <span class="info-value">{{ $contract->start_date->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">End Date:</span>
                <span class="info-value">{{ $contract->end_date->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Contract Duration:</span>
                <span class="info-value">{{ $contract->start_date->diffInDays($contract->end_date) }} days</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Compensation</h3>
            <div class="info-row">
                <span class="info-label">Remuneration:</span>
                <span class="info-value">{{ number_format($contract->remuneration, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Remuneration Type:</span>
                <span class="info-value">{{ ucfirst($contract->remuneration_type->value ?? 'Not specified') }}</span>
            </div>
        </div>
    </div>

    <div class="contract-info">
        <div class="info-section">
            <h3>Approval Information</h3>
            <div class="info-row">
                <span class="info-label">Approval Status:</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $contract->approval_status->value }}">
                        {{ ucfirst($contract->approval_status->value) }}
                    </span>
                </span>
            </div>
            @if($contract->approved_at)
                <div class="info-row">
                    <span class="info-label">Approved Date:</span>
                    <span class="info-value">{{ $contract->approved_at->format('F d, Y H:i') }}</span>
                </div>
            @endif
            <div class="info-row">
                <span class="info-label">Created Date:</span>
                <span class="info-value">{{ $contract->created_at->format('F d, Y H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Employee Signature</strong></p>
            <p>{{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</p>
            <p>Date: _________________</p>
        </div>
        <div class="signature-box">
            <p><strong>Company Representative</strong></p>
            <p>Authorized Signatory</p>
            <p>Date: _________________</p>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated employment contract. For any questions, please contact HR department.</p>
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    </div>
</body>
</html>
