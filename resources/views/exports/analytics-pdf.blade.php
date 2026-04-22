<!DOCTYPE html>
<html>
<head>
    <title>HR Analytics Report</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4A3FC0; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; color: #4A3FC0; }
        .meta { font-size: 12px; color: #666; }
        .stats-grid { display: table; width: 100%; margin-bottom: 30px; }
        .stat-box { display: table-cell; padding: 15px; background: #f4f2fb; border: 1px solid #e0e0e0; border-radius: 8px; text-align: center; }
        .stat-lbl { font-size: 10px; text-transform: uppercase; color: #8884A8; margin-bottom: 5px; }
        .stat-val { font-size: 18px; font-weight: bold; color: #1A1730; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #4A3FC0; color: white; text-align: left; padding: 10px; font-size: 12px; }
        td { border-bottom: 1px solid #eee; padding: 10px; font-size: 12px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 15px; color: #1A1730; border-left: 4px solid #4A3FC0; padding-left: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">TalentFlow Pro | HR Intelligence Report</div>
        <div class="meta">Generated on {{ now()->format('M d, Y H:i') }} · Period: {{ $period }} months</div>
    </div>

    <div class="section-title">Key Performance Indicators</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-lbl">Headcount</div>
            <div class="stat-val">{{ $totalEmployees }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Turnover Rate</div>
            <div class="stat-val">{{ $turnoverRate }}%</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Avg Tenure</div>
            <div class="stat-val">{{ $avgTenure }}y</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Avg Salary</div>
            <div class="stat-val">{{ number_format($avgSalary) }}</div>
        </div>
    </div>

    <div class="section-title">Department Distribution</div>
    <table>
        <thead>
            <tr>
                <th>Department</th>
                <th>Headcount</th>
                <th>% of Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deptData as $d)
            <tr>
                <td>{{ $d['label'] }}</td>
                <td>{{ $d['value'] }}</td>
                <td>{{ round(($d['value'] / max($totalEmployees, 1)) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Diversity Metrics</div>
    <table style="margin-bottom:10px;">
        <thead>
            <tr>
                <th>Gender</th>
                <th>Count</th>
                <th>Percent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genderData as $g)
            <tr>
                <td>{{ $g['label'] }}</td>
                <td>{{ $g['value'] }}</td>
                <td>{{ $g['percent'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-bottom:30px;">
        <thead>
            <tr>
                <th>Nationality</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nationalityData as $n)
            <tr>
                <td>{{ $n['label'] }}</td>
                <td>{{ $n['value'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($skillGap) && count($skillGap) > 0)
    <div class="section-title">Skill Gap Analysis</div>
    <table>
        <thead>
            <tr>
                <th>Skill</th>
                <th>Have</th>
                <th>Need</th>
                <th>Gap</th>
            </tr>
        </thead>
        <tbody>
            @foreach($skillGap as $s)
            <tr>
                <td>{{ $s['skill'] }}</td>
                <td>{{ $s['have'] }}</td>
                <td>{{ $s['need'] }}</td>
                <td>–{{ $s['gap'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</body>
</html>
