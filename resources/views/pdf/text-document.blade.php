<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - Document</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 20mm; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'DM Sans', Arial, sans-serif; 
            font-size: 12px; 
            color: #0F1629; 
            line-height: 1.6; 
            background: #fff; 
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3B6FE8;
        }
        .header h1 {
            color: #3B6FE8;
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
        }
        .header p {
            color: #6B7094;
            font-size: 12px;
            margin: 0;
        }
        
        .content {
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e8eaf0;
            min-height: 400px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.4;
        }
        
        .info {
            margin-top: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 11px;
            color: #6B7094;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #A8ADCA;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Document Viewer</h1>
        <p>{{ $title }} - {{ $employee->full_name ?? 'Employee Document' }}</p>
    </div>
    
    <div class="content">
        {{ $content }}
    </div>
    
    <div class="info">
        <strong>Document Information:</strong><br>
        Employee: {{ $employee->full_name ?? 'N/A' }}<br>
        Employee ID: {{ $employee->code ?? 'N/A' }}<br>
        Generated: {{ now()->format('M d, Y H:i') }}
    </div>
    
    <div class="footer">
        Generated on {{ now()->format('M d, Y') }} by TalentFlow Pro HR System
    </div>
</body>
</html>
