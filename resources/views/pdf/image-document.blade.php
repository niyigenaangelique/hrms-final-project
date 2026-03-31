<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $imageName }} - Document</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 20mm; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'DM Sans', Arial, sans-serif; 
            font-size: 13px; 
            color: #0F1629; 
            line-height: 1.55; 
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
            text-align: center;
            margin: 20px 0;
        }
        .content img {
            max-width: 100%;
            max-height: 400px;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        <p>{{ $imageName }} - {{ $employee->full_name ?? 'Employee Document' }}</p>
    </div>
    
    <div class="content">
        <img src="{{ $imagePath }}" alt="{{ $imageName }}" />
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
