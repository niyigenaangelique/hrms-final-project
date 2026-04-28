<!DOCTYPE html>
<html>
<head>
    <title>Admin Audit Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3B6FE8; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #3B6FE8; }
        .meta { font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f0f4ff; color: #3B6FE8; text-align: left; padding: 10px; border-bottom: 1px solid #ddd; font-size: 10px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .bg-blue { background: #e0e7ff; color: #4338ca; }
        .bg-red { background: #fee2e2; color: #b91c1c; }
        .bg-green { background: #dcfce7; color: #15803d; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">System Administration: Audit Report</div>
        <div class="meta">Category: {{ strtoupper($category) }} | Period: {{ $start }} to {{ $end }} | Generated: {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            @if($category === 'users')
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th></tr>
            @elseif($category === 'security' || $category === 'activity')
                <tr><th>Timestamp</th><th>Action</th><th>Identity</th><th>Description</th></tr>
            @else
                <tr><th>Role</th><th>Permission Node</th><th>Status</th></tr>
            @endif
        </thead>
        <tbody>
            @foreach($data as $item)
                @if($category === 'users')
                    <tr>
                        <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->is_active ? 'Active' : 'Locked' }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    </tr>
                @elseif($category === 'security' || $category === 'activity')
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->action }}</td>
                        <td>User #{{ $item->user_id }}</td>
                        <td>System level operation recorded</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->permission }}</td>
                        <td>{{ $item->allowed ? 'Allowed' : 'Denied' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
