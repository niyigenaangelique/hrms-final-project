<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.banks-root {
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

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    padding: 20px;
    text-align: center;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #2563eb;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-secondary);
}

.bank-item {
    padding: 16px;
    border-bottom: 1px solid var(--glass-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.bank-item:last-child {
    border-bottom: none;
}

.bank-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bank-logo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.bank-details h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px 0;
}

.bank-details p {
    font-size: 12px;
    color: var(--text-secondary);
    margin: 0;
}

.bank-stats {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.account-count {
    font-size: 14px;
    font-weight: 600;
    color: #2563eb;
}

.bank-status {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}

.status-active {
    background: rgba(16,185,129,0.1);
    color: #10b981;
}

.status-inactive {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
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

@media (max-width: 768px) {
    .banks-root { padding: 18px 14px 100px; }
    .content-grid { grid-template-columns: 1fr; }
}
</style>

<div class="banks-root">

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="page-header">
            <h1>Banks Management</h1>
            <p>Manage bank accounts and financial institutions</p>
        </div>
    </div>

    {{-- Stats Overview --}}
    <div class="content-grid anim-2">
        <div class="g-card stat-card">
            <div class="bank-logo" style="background: linear-gradient(135deg, #2563eb, #6366f1);">
                🏦
            </div>
            <div class="stat-number">12</div>
            <div class="stat-label">Total Banks</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="bank-logo" style="background: linear-gradient(135deg, #10b981, #059669);">
                💳
            </div>
            <div class="stat-number">156</div>
            <div class="stat-label">Bank Accounts</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="bank-logo" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                💰
            </div>
            <div class="stat-number">8</div>
            <div class="stat-label">Active Banks</div>
        </div>
    </div>

    <!-- Banks List -->
    <div class="g-card anim-2">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0;">Bank Institutions</h3>
            <button class="btn btn-primary">Add Bank</button>
        </div>
        
        <div style="max-height: 400px; overflow-y: auto;">
            <div class="bank-item">
                <div class="bank-info">
                    <div class="bank-logo" style="background: linear-gradient(135deg, #2563eb, #6366f1);">
                        BNR
                    </div>
                    <div class="bank-details">
                        <h4>Bank of Kigali</h4>
                        <p>Primary banking partner • 45 accounts</p>
                    </div>
                </div>
                <div class="bank-stats">
                    <div class="account-count">45 accounts</div>
                    <div class="bank-status status-active">Active</div>
                </div>
            </div>
            
            <div class="bank-item">
                <div class="bank-info">
                    <div class="bank-logo" style="background: linear-gradient(135deg, #10b981, #059669);">
                        BCR
                    </div>
                    <div class="bank-details">
                        <h4>Bank of Credit and Commerce</h4>
                        <p>Commercial banking • 32 accounts</p>
                    </div>
                </div>
                <div class="bank-stats">
                    <div class="account-count">32 accounts</div>
                    <div class="bank-status status-active">Active</div>
                </div>
            </div>
            
            <div class="bank-item">
                <div class="bank-info">
                    <div class="bank-logo" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        COGEB
                    </div>
                    <div class="bank-details">
                        <h4>Cogebanque</h4>
                        <p>Investment banking • 28 accounts</p>
                    </div>
                </div>
                <div class="bank-stats">
                    <div class="account-count">28 accounts</div>
                    <div class="bank-status status-active">Active</div>
                </div>
            </div>
            
            <div class="bank-item">
                <div class="bank-info">
                    <div class="bank-logo" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        GT
                    </div>
                    <div class="bank-details">
                        <h4>Guaranty Trust Bank</h4>
                        <p>International banking • 21 accounts</p>
                    </div>
                </div>
                <div class="bank-stats">
                    <div class="account-count">21 accounts</div>
                    <div class="bank-status status-active">Active</div>
                </div>
            </div>
            
            <div class="bank-item">
                <div class="bank-info">
                    <div class="bank-logo" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        KCB
                    </div>
                    <div class="bank-details">
                        <h4>KCB Bank Rwanda</h4>
                        <p>Regional banking • 18 accounts</p>
                    </div>
                </div>
                <div class="bank-stats">
                    <div class="account-count">18 accounts</div>
                    <div class="bank-status status-inactive">Inactive</div>
                </div>
            </div>
        </div>
        
        <div style="padding: 20px 24px; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; gap: 12px;">
            <button class="btn btn-secondary">Export Banks</button>
            <button class="btn btn-primary">Sync Accounts</button>
        </div>
    </div>

</div>
</div>
