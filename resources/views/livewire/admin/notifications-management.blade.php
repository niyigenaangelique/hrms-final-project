<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.notifications-root {
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
    background: transparent;
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

.notification-item {
    padding: 16px;
    border-bottom: 1px solid var(--glass-border);
    display: flex;
    align-items: center;
    gap: 12px;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.notification-message {
    font-size: 12px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.notification-time {
    font-size: 11px;
    color: var(--text-tertiary);
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

@media (max-width: 768px) {
    .notifications-root { padding: 18px 14px 100px; }
    .content-grid { grid-template-columns: 1fr; }
}
</style>

<div class="notifications-root">

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="page-header">
            <h1>Notifications Management</h1>
            <p>Manage system notifications and alerts</p>
        </div>
    </div>

    {{-- Stats Overview --}}
    <div class="content-grid anim-2">
        <div class="g-card stat-card">
            <div class="notification-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                🔔
            </div>
            <div class="stat-number">24</div>
            <div class="stat-label">Total Notifications</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="notification-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                ✅
            </div>
            <div class="stat-number">18</div>
            <div class="stat-label">Delivered</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="notification-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                ⏰
            </div>
            <div class="stat-number">6</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <!-- Recent Notifications -->
    <div class="g-card anim-2">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--glass-border);">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0;">Recent Notifications</h3>
        </div>
        
        <div style="max-height: 400px; overflow-y: auto;">
            <div class="notification-item">
                <div class="notification-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                    📧
                </div>
                <div class="notification-content">
                    <div class="notification-title">Payroll Processed</div>
                    <div class="notification-message">Monthly payroll has been successfully processed for all employees</div>
                    <div class="notification-time">2 hours ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                    ✅
                </div>
                <div class="notification-content">
                    <div class="notification-title">System Update Complete</div>
                    <div class="notification-message">System has been updated to the latest version successfully</div>
                    <div class="notification-time">5 hours ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                    ⚠️
                </div>
                <div class="notification-content">
                    <div class="notification-title">Backup Required</div>
                    <div class="notification-message">System backup is scheduled for tonight at 11:00 PM</div>
                    <div class="notification-time">1 day ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
                    🚨
                </div>
                <div class="notification-content">
                    <div class="notification-title">Security Alert</div>
                    <div class="notification-message">Multiple failed login attempts detected from unknown IP</div>
                    <div class="notification-time">2 days ago</div>
                </div>
            </div>
        </div>
        
        <div style="padding: 20px 24px; border-top: 1px solid var(--glass-border); display: flex; justify-content: center;">
            <button class="btn btn-primary">View All Notifications</button>
        </div>
    </div>

</div>
</div>
