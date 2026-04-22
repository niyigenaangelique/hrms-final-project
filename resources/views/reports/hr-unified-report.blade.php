<!DOCTYPE html>
<html>
<head>
    <title>HR Report - {{ ucfirst($category) }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3B6FE8; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; color: #3B6FE8; }
        .meta { font-size: 12px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8fafc; color: #333; text-align: left; padding: 10px; border-bottom: 1px solid #ddd; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 12px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; padding: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">ZIBITECH HRMS - {{ strtoupper($category) }} REPORT</div>
        <div class="meta">Period: {{ $start }} to {{ $end }} | Generated on {{ now()->format('M d, Y H:i') }}</div>
    </div>

    <table>
        <thead>
            @if($category === 'employee')
                <tr><th>Code</th><th>Name</th><th>Email</th><th>Department</th><th>Position</th></tr>
            @elseif($category === 'attendance')
                <tr><th>Employee</th><th>Date</th><th>Status</th><th>Check In</th><th>Check Out</th></tr>
            @elseif($category === 'performance')
                <tr><th>Employee</th><th>Date</th><th>Type</th><th>Score</th><th>Rating</th></tr>
            @elseif($category === 'leave')
                <tr><th>Employee</th><th>Type</th><th>Start</th><th>End</th><th>Status</th></tr>
            @elseif($category === 'payroll')
                <tr><th>Employee</th><th>Month</th><th>Basic</th><th>Net Salary</th><th>Status</th></tr>
            @endif
        </thead>
        <tbody>
            @foreach($data as $item)
                @if($category === 'employee')
                    <tr><td>{{ $item->code }}</td><td>{{ $item->full_name }}</td><td>{{ $item->email }}</td><td>{{ $item->department->name ?? '—' }}</td><td>{{ $item->position->name ?? '—' }}</td></tr>
                @elseif($category === 'attendance')
                    <tr><td>{{ $item->employee->full_name ?? 'Unknown' }}</td><td>{{ $item->date->format('Y-m-d') }}</td><td>{{ $item->status }}</td><td>{{ $item->check_in }}</td><td>{{ $item->check_out }}</td></tr>
                @elseif($category === 'performance')
                    <tr><td>{{ $item->employee->full_name ?? 'Unknown' }}</td><td>{{ $item->review_date->format('Y-m-d') }}</td><td>{{ $item->type }}</td><td>{{ $item->overall_score }}</td><td>{{ $item->overall_rating }}</td></tr>
                @elseif($category === 'leave')
                    <tr><td>{{ $item->employee->full_name ?? 'Unknown' }}</td><td>{{ $item->leaveType->name ?? '—' }}</td><td>{{ $item->start_date }}</td><td>{{ $item->end_date }}</td><td>{{ $item->status }}</td></tr>
                @elseif($category === 'payroll')
                    <tr><td>{{ $item->employee->full_name ?? 'Unknown' }}</td><td>{{ $item->payrollMonth->name ?? '—' }}</td><td>{{ number_format($item->basic_salary, 2) }}</td><td>{{ number_format($item->net_salary, 2) }}</td><td>{{ $item->status }}</td></tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Confidential Document | ZIBITECH C-HRMS | Page 1 of 1
    </div>
</body>
</html>
