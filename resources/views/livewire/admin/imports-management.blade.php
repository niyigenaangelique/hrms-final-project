<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.imports-root {
    --glass-bg:       rgba(255,255,255,0.50);
    --glass-border:   rgba(255,255,255,0.72);
    --glass-shadow:   0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --blur:           blur(22px) saturate(1.7);
    --radius:         20px;
    --radius-sm:      13px;
    --text-primary:   rgba(15,15,25,0.96);
    --text-secondary: rgba(15,15,25,0.68);
    --text-tertiary:  rgba(15,15,25,0.44);
    font-family: 'DM Sans', -apple-system, sans-serif;
    padding: 32px 36px 110px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    height: 100vh;
    overflow-y: auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

@keyframes fadeSlideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.anim-1 { animation: fadeSlideUp 0.35s ease both; }
.anim-2 { animation: fadeSlideUp 0.35s 0.07s ease both; }

.g-card {
    background: var(--glass-bg);
    backdrop-filter: var(--blur);
    -webkit-backdrop-filter: var(--blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    position: relative;
}

.g-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
    border-radius: var(--radius) var(--radius) 0 0;
}

.page-header {
    padding: 24px 30px;
    text-align: center;
}

.page-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.4px;
    margin: 0 0 6px;
}

.page-header p {
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary);
    margin: 0;
}

.upload-area {
    border: 2px dashed var(--glass-border);
    border-radius: var(--radius);
    padding: 40px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #2563eb;
    background: rgba(37,99,235,0.05);
}

.upload-icon {
    font-size: 48px;
    margin-bottom: 16px;
    color: var(--text-secondary);
}

.upload-text {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.upload-subtext {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.btn {
    padding: 10px 20px;
    border-radius: var(--radius-sm);
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #2563eb, #6366f1);
    color: white;
    box-shadow: 0 4px 14px rgba(37,99,235,0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37,99,235,0.4);
}

.btn-secondary {
    background: rgba(255,255,255,0.2);
    color: var(--text-primary);
    border: 1px solid var(--glass-border);
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.3);
}

.import-item {
    padding: 16px;
    border-bottom: 1px solid var(--glass-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.import-item:last-child {
    border-bottom: none;
}

.import-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.import-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.import-details h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px 0;
}

.import-details p {
    font-size: 12px;
    color: var(--text-secondary);
    margin: 0;
}

.import-status {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}

.status-success {
    background: rgba(16,185,129,0.1);
    color: #10b981;
}

.status-processing {
    background: rgba(245,158,11,0.1);
    color: #f59e0b;
}

.status-failed {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
}

@media (max-width: 768px) {
    .imports-root { padding: 18px 14px 100px; }
    .upload-area { padding: 24px; }
}
</style>

<div class="imports-root">

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="page-header">
            <h1>Imports/Exports Management</h1>
            <p>Import data from files and export system data</p>
        </div>
    </div>

    <!-- Upload Area -->
    <div class="g-card anim-2">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--glass-border);">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0;">Import Data</h3>
        </div>
        
        <div class="upload-area">
            <div class="upload-icon">📁</div>
            <div class="upload-text">Drop files here or click to upload</div>
            <div class="upload-subtext">Support for CSV, Excel, and JSON files</div>
            <button class="btn btn-primary">Choose Files</button>
        </div>
        
        <div style="padding: 20px 24px; border-top: 1px solid var(--glass-border); display: flex; gap: 12px;">
            <button class="btn btn-secondary">Download Template</button>
            <button class="btn btn-primary">View Import History</button>
        </div>
    </div>

    <!-- Recent Imports -->
    <div class="g-card anim-2">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0;">Recent Imports</h3>
            <button class="btn btn-primary">Export Data</button>
        </div>
        
        <div style="max-height: 400px; overflow-y: auto;">
            <div class="import-item">
                <div class="import-info">
                    <div class="import-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                        📊
                    </div>
                    <div class="import-details">
                        <h4>employees_data.csv</h4>
                        <p>156 employee records imported</p>
                    </div>
                </div>
                <div class="import-status status-success">Completed</div>
            </div>
            
            <div class="import-item">
                <div class="import-info">
                    <div class="import-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                        📈
                    </div>
                    <div class="import-details">
                        <h4>payroll_data.xlsx</h4>
                        <p>Processing 89 payroll records</p>
                    </div>
                </div>
                <div class="import-status status-processing">Processing</div>
            </div>
            
            <div class="import-item">
                <div class="import-info">
                    <div class="import-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                        🏦
                    </div>
                    <div class="import-details">
                        <h4>bank_accounts.json</h4>
                        <p>45 bank account records imported</p>
                    </div>
                </div>
                <div class="import-status status-success">Completed</div>
            </div>
            
            <div class="import-item">
                <div class="import-info">
                    <div class="import-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
                        ❌
                    </div>
                    <div class="import-details">
                        <h4>departments.csv</h4>
                        <p>Import failed - invalid format</p>
                    </div>
                </div>
                <div class="import-status status-failed">Failed</div>
            </div>
        </div>
    </div>

</div>
</div>
