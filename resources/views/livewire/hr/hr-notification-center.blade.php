<div class="nc-local-shell">
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Sora:wght@700;800;900&display=swap');

    .nc-local-shell {
        --blue: #3B6FE8;
        --blue-2: #2755CC;
        --blue-lt: rgba(59, 111, 232, 0.08);
        --indigo: #6B4FDB;
        --indigo-lt: rgba(107, 79, 219, 0.08);
        --green: #12B76A;
        --green-lt: rgba(18, 183, 106, 0.10);
        --red: #EF4444;
        --red-lt: rgba(239, 68, 68, 0.08);
        --bg: #F8F9FE;
        --white: #FFFFFF;
        --ink: #1E293B;
        --ink2: #475569;
        --ink3: #64748B;
        --ink4: #94A3B8;
        --border: rgba(226, 232, 240, 0.8);
        --sh-sm: 0 4px 20px rgba(0, 0, 0, 0.02);
        --sh-md: 0 10px 30px rgba(59, 111, 232, 0.06);
        --r: 16px;
        --r-lg: 24px;

        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        display: grid; 
        grid-template-columns: 260px 1fr; 
        gap: 32px; 
        align-items: flex-start;
        padding: 32px 40px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ══ SIDE NAV ═════════════════════════════════════════════ */
    .nc-local-sidebar { position: sticky; top: 32px; display: flex; flex-direction: column; gap: 24px; }
    .nc-local-nav { display: flex; flex-direction: column; gap: 8px; background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 12px; box-shadow: var(--sh-sm); }
    .nc-nav-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); padding: 12px 16px 4px; letter-spacing: 0.08em; }
    .nc-nav-item {
        display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--r);
        font-size: 14px; font-weight: 700; color: var(--ink2); cursor: pointer; border: none; background: transparent; 
        font-family: 'DM Sans', sans-serif; transition: all .2s; text-align: left; width: 100%;
    }
    .nc-nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.2; opacity: 0.6; }
    .nc-nav-item:hover { background: var(--blue-lt); color: var(--blue); }
    .nc-nav-item.active { background: var(--blue); color: #fff; box-shadow: 0 8px 20px rgba(59, 111, 232, 0.25); }
    .nc-nav-item.active svg { opacity: 1; stroke: #fff; }

    /* Main Content */
    .nc-local-main { display: flex; flex-direction: column; gap: 32px; min-width: 0; }
    .nc-header { display: flex; justify-content: space-between; align-items: center; }
    .nc-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); letter-spacing: -0.5px; }

    /* Stats Grid */
    .nc-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .nc-stat-card { background: var(--white); padding: 24px; border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); }
    .nc-stat-label { font-size: 12px; font-weight: 700; color: var(--ink4); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.05em; }
    .nc-stat-val { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--ink); }

    /* Card */
    .nc-card { background: var(--white); border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--sh-sm); overflow: hidden; }
    .nc-card-hd { padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .nc-card-title { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); }

/* Table */
.nc-table { width: 100%; border-collapse: collapse; }
.nc-table th { text-align: left; padding: 14px 24px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.05em; border-bottom: 2px solid var(--border); }
.nc-table td { padding: 14px 24px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--ink2); }

/* List */
.nc-list-item { padding: 16px 24px; border-bottom: 1px solid var(--border); display: flex; gap: 16px; transition: background 0.2s; }
.nc-list-item:hover { background: #F8FAFC; }
.nc-icon-wrap { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--blue-lt); color: var(--blue); }

/* Badges */
.nc-badge { padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
.nc-badge-blue { background: #E8F1FD; color: #3B6FE8; }
.nc-badge-green { background: #E6F7F0; color: #12B76A; }
.nc-badge-red { background: #FEECEB; color: #F04438; }
.nc-badge-orange { background: #FFF4ED; color: #F79009; }

/* Buttons */
.nc-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; font-family: 'Sora', sans-serif; }
.nc-btn-primary { background: #6B4FDB; color: #fff; box-shadow: 0 4px 14px rgba(107,79,219,0.3); }
.nc-btn-primary:hover { background: #5739c9; transform: translateY(-1px); }
.nc-btn-ghost { background: var(--blue-lt); color: #6B4FDB; }
.nc-btn-sm { padding: 6px 12px; font-size: 12px; }

/* Modal */
.nc-modal-bg { position: fixed; inset: 0; background: rgba(15,22,41,0.4); backdrop-filter: blur(4px); z-index: 1000; display: flex; align-items: center; justify-content: center; }
.nc-modal { background: var(--white); border-radius: var(--r-lg); width: 100%; max-width: 650px; max-height: 90vh; overflow-y: auto; box-shadow: var(--sh-lg); border: 1px solid var(--border); }
.nc-modal-hd { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.nc-modal-body { padding: 24px; }
.nc-input { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid var(--border); background: var(--white); font-family: inherit; font-size: 14px; color: var(--ink); transition: border-color .15s; }
.nc-input:focus { border-color: var(--blue); outline: none; }
.nc-label { display: block; font-size: 12px; font-weight: 800; color: var(--ink3); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.03em; }

.form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
</style>

    <aside class="nc-local-sidebar">
        <nav class="nc-local-nav">
            <div class="nc-nav-label">Notification Hub</div>
            <button class="nc-nav-item {{ $activeTab === 'center' ? 'active' : '' }}" wire:click="$set('activeTab', 'center')">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                <span>Command Center</span>
            </button>
            <button class="nc-nav-item {{ $activeTab === 'templates' ? 'active' : '' }}" wire:click="$set('activeTab', 'templates')">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <span>Templates</span>
            </button>
            <button class="nc-nav-item {{ $activeTab === 'scheduled' ? 'active' : '' }}" wire:click="$set('activeTab', 'scheduled')">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Scheduled</span>
            </button>
            <button class="nc-nav-item {{ $activeTab === 'history' ? 'active' : '' }}" wire:click="$set('activeTab', 'history')">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>History</span>
            </button>
            
            <div class="nc-nav-label">Automation</div>
            <button class="nc-nav-item {{ $activeTab === 'settings' ? 'active' : '' }}" wire:click="$set('activeTab', 'settings')">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span>Trigger Rules</span>
            </button>
        </nav>
    </aside>

    <main class="nc-local-main">
        @if($activeTab === 'center')
            <div class="nc-header">
                <h1 class="nc-title">Notification Command Center</h1>
                <button class="nc-btn nc-btn-primary" wire:click="openSend">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Dispatch New
                </button>
            </div>

            <div class="nc-stats-grid">
                <div class="nc-stat-card">
                    <div class="nc-stat-label">Total Sent</div>
                    <div class="nc-stat-val">{{ $totalSent }}</div>
                </div>
                <div class="nc-stat-card">
                    <div class="nc-stat-label">Unread</div>
                    <div class="nc-stat-val" style="color: #F79009;">{{ $unreadCount }}</div>
                </div>
                <div class="nc-stat-card">
                    <div class="nc-stat-label">Scheduled</div>
                    <div class="nc-stat-val">{{ $scheduledCount }}</div>
                </div>
                <div class="nc-stat-card">
                    <div class="nc-stat-label">Failed</div>
                    <div class="nc-stat-val" style="color: #EF4444;">{{ $failedCount }}</div>
                </div>
            </div>

            <div class="nc-card">
                <div class="nc-card-hd">
                    <span class="nc-card-title">Recent Activity</span>
                    <button class="nc-btn nc-btn-ghost nc-btn-sm" wire:click="runAutoDetect">Run Auto-Trigger</button>
                </div>
                <div class="nc-list">
                    @foreach($recentNotifs as $notif)
                        <div class="nc-list-item">
                            <div class="nc-icon-wrap" style="background: {{ ($notifTypes[$notif->type]['color'] ?? '#3B6FE8') }}20; color: {{ $notifTypes[$notif->type]['color'] ?? '#3B6FE8' }};">
                                <i class="fas fa-{{ $notifTypes[$notif->type]['icon'] ?? 'bell' }}"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-weight: 700; font-size: 15px; color: var(--ink);">{{ $notif->title }}</div>
                                    <span class="nc-badge nc-badge-{{ $notif->priority === 'urgent' ? 'red' : ($notif->priority === 'high' ? 'orange' : 'blue') }}">
                                        {{ $notif->priority }}
                                    </span>
                                </div>
                                <div style="font-size: 13px; color: var(--ink3); margin-top: 4px;">{{ Str::limit($notif->body, 120) }}</div>
                                <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 11px; color: var(--ink4); font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em;">
                                    <span><i class="far fa-user"></i> {{ $notif->user->full_name ?? 'System' }}</span>
                                    <span><i class="far fa-clock"></i> {{ $notif->created_at->diffForHumans() }}</span>
                                    <span><i class="fas fa-paper-plane"></i> {{ ucfirst($notif->channel) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeTab === 'templates')
            <div class="nc-header">
                <h1 class="nc-title">Message Templates</h1>
                <button class="nc-btn nc-btn-primary" wire:click="openCreateTpl">Create Template</button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                @foreach($templates as $tpl)
                    <div class="nc-card" style="padding: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <div class="nc-icon-wrap">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="nc-badge nc-badge-blue">{{ $tpl->channel }}</span>
                        </div>
                        <div style="font-family: 'Sora', sans-serif; font-weight: 800; font-size: 16px; margin-bottom: 4px;">{{ $tpl->name }}</div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--ink4); text-transform: uppercase; margin-bottom: 12px;">Type: {{ $tpl->type }}</div>
                        <div style="font-size: 13px; color: var(--ink2); line-height: 1.6; height: 64px; overflow: hidden;">{{ Str::limit($tpl->body, 120) }}</div>
                        <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid var(--border); padding-top: 16px;">
                            <button class="nc-btn nc-btn-ghost nc-btn-sm" wire:click="openEditTpl('{{ $tpl->id }}')">Edit</button>
                            <button class="nc-btn nc-btn-ghost nc-btn-sm" style="color: #EF4444;" wire:click="deleteTpl('{{ $tpl->id }}')">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($activeTab === 'settings')
            <div class="nc-header">
                <h1 class="nc-title">Trigger Rules</h1>
                <button class="nc-btn nc-btn-primary" wire:click="openCreateAlert">New Alert Rule</button>
            </div>

            <div class="nc-card">
                <div class="nc-card-hd"><span class="nc-card-title">Event-Based Automation</span></div>
                <div class="nc-list">
                    @foreach($alertRules as $alert)
                        <div class="nc-list-item">
                            <div class="nc-icon-wrap">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-weight: 700; font-size: 15px;">{{ $alert->name }}</div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:click="toggleAlert('{{ $alert->id }}')" {{ $alert->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div style="font-size: 13px; color: var(--ink3); margin-top: 2px;">
                                    Trigger: <strong>{{ str_replace('_', ' ', $alert->trigger) }}</strong> 
                                    @if($alert->days_before) 
                                        — Sent <strong>{{ $alert->days_before }} days before</strong>
                                    @endif
                                </div>
                                <div style="font-size: 11px; font-weight: 700; color: var(--ink4); margin-top: 8px; text-transform: uppercase;">
                                    Channel: {{ $alert->channel }} | Priority: {{ $alert->priority }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="nc-card" style="margin-top: 24px;">
                <div class="nc-card-hd"><span class="nc-card-title">System Settings</span></div>
                <div style="padding: 24px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        <div>
                            <h3 style="font-size: 13px; font-weight: 800; color: var(--ink3); text-transform: uppercase; margin-bottom: 16px;">General Configuration</h3>
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px;">Email Delivery</div>
                                        <div style="font-size: 12px; color: var(--ink4);">Send notifications via system SMTP</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.live="settEmailEnabled">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px;">SMS Alerts</div>
                                        <div style="font-size: 12px; color: var(--ink4);">Carrier rates may apply</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.live="settSmsEnabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="nc-btn nc-btn-primary" style="width: 100%; justify-content: center;" wire:click="saveSettings">Save System Config</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Dispatch Modal -->
    @if($showSend)
        <div class="nc-modal-bg">
            <div class="nc-modal">
                <div class="nc-modal-hd">
                    <span class="nc-card-title">Dispatch New Notification</span>
                    <button wire:click="closeSend" style="background:none; border:none; cursor:pointer; color: var(--ink4);"><i class="fas fa-times"></i></button>
                </div>
                <div class="nc-modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label class="nc-label">Target Audience</label>
                            <select class="nc-input" wire:model="sendTo">
                                <option value="all">Broadcast (All Employees)</option>
                                <option value="department">By Department</option>
                                <option value="employee">Specific Individual</option>
                            </select>
                        </div>
                        <div>
                            <label class="nc-label">Delivery Channel</label>
                            <select class="nc-input" wire:model="sendChannel">
                                <option value="in_app">In-App Dashboard</option>
                                <option value="email">Email Service</option>
                                <option value="sms">SMS Text</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label class="nc-label">Notification Title</label>
                        <input type="text" class="nc-input" wire:model="sendTitle" placeholder="e.g. System Maintenance Update">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="nc-label">Content Message</label>
                        <textarea class="nc-input" wire:model="sendBody" rows="5" placeholder="Enter the full message details..."></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label class="nc-label">Priority Level</label>
                            <select class="nc-input" wire:model="sendPriority">
                                <option value="low">Low (General)</option>
                                <option value="normal">Normal</option>
                                <option value="high">High (Action Required)</option>
                                <option value="urgent">Urgent (Immediate)</option>
                            </select>
                        </div>
                        <div>
                            <label class="nc-label">Scheduled Date (Optional)</label>
                            <input type="datetime-local" class="nc-input" wire:model="sendSchedule">
                        </div>
                    </div>
                </div>
                <div style="padding: 20px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; background: #F8FAFC; border-radius: 0 0 var(--r-lg) var(--r-lg);">
                    <button class="nc-btn nc-btn-ghost" wire:click="closeSend">Discard</button>
                    <button class="nc-btn nc-btn-primary" wire:click="sendNotification">Dispatch Now</button>
                </div>
            </div>
        </div>
    @endif
</div>
