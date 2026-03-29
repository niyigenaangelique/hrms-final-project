<div>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

.access-control-root {
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

.role-item {
    padding: 16px;
    border-bottom: 1px solid var(--glass-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.role-item:last-child {
    border-bottom: none;
}

.role-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.role-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.role-details h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px 0;
}

.role-details p {
    font-size: 12px;
    color: var(--text-secondary);
    margin: 0;
}

.role-count {
    font-size: 14px;
    font-weight: 600;
    color: #2563eb;
    background: rgba(37,99,235,0.1);
    padding: 4px 12px;
    border-radius: 20px;
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
    .access-control-root { padding: 18px 14px 100px; }
    .content-grid { grid-template-columns: 1fr; }
}
</style>

<div class="access-control-root">

    {{-- Header --}}
    <div class="g-card anim-1">
        <div class="page-header">
            <h1>Access Control Management</h1>
            <p>Manage user roles, permissions, and access rights</p>
        </div>
    </div>

    {{-- Stats Overview --}}
    <div class="content-grid anim-2">
        <div class="g-card stat-card">
            <div class="role-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                👥
            </div>
            <div class="stat-number">4</div>
            <div class="stat-label">User Roles</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="role-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                🔐
            </div>
            <div class="stat-number">28</div>
            <div class="stat-label">Permissions</div>
        </div>
        
        <div class="g-card stat-card">
            <div class="role-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                🌐
            </div>
            <div class="stat-number">156</div>
            <div class="stat-label">Active Users</div>
        </div>
    </div>

    <!-- User Roles -->
    <div class="g-card anim-2">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0;">User Roles</h3>
            <button class="btn btn-primary">Add Role</button>
        </div>
        
        <div style="max-height: 400px; overflow-y: auto;">
            <div class="role-item">
                <div class="role-info">
                    <div class="role-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
                        👑
                    </div>
                    <div class="role-details">
                        <h4>Super Admin</h4>
                        <p>Full system access and control</p>
                    </div>
                </div>
                <div class="role-count">2 users</div>
            </div>
            
            <div class="role-item">
                <div class="role-info">
                    <div class="role-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                        🛡️
                    </div>
                    <div class="role-details">
                        <h4>Admin</h4>
                        <p>Administrative access to most features</p>
                    </div>
                </div>
                <div class="role-count">8 users</div>
            </div>
            
            <div class="role-item">
                <div class="role-info">
                    <div class="role-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                        👤
                    </div>
                    <div class="role-details">
                        <h4>HR Manager</h4>
                        <p>HR and employee management access</p>
                    </div>
                </div>
                <div class="role-count">12 users</div>
            </div>
            
            <div class="role-item">
                <div class="role-info">
                    <div class="role-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                        👨‍💼
                    </div>
                    <div class="role-details">
                        <h4>Employee</h4>
                        <p>Basic employee access and self-service</p>
                    </div>
                </div>
                <div class="role-count">134 users</div>
            </div>
        </div>
        
        <div style="padding: 20px 24px; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; gap: 12px;">
            <button class="btn btn-secondary">Export Roles</button>
            <button class="btn btn-primary">Manage Permissions</button>
        </div>
    </div>

</div>
</div>
