<div class="ac-root" style="display:grid; grid-template-columns:260px 1fr; gap:32px; align-items:flex-start; padding:32px 40px; background:var(--bg); min-height:100vh;">
    <x-admin-content-styles />
    
    <aside style="position:sticky; top:32px; display:flex; flex-direction:column; gap:24px;">
        <nav class="ac-card" style="display:flex; flex-direction:column; gap:4px; padding:12px; border-radius:24px;">
            <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:var(--ink4); padding:12px 16px 4px; letter-spacing:0.08em;">Notification Hub</div>
            
            <button class="ac-btn {{ $activeTab === 'center' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="justify-content:flex-start; padding:12px 16px; border-radius:14px;" wire:click="$set('activeTab', 'center')">
                <svg viewBox="0 0 24 24" style="width:18px; margin-right:12px;"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                <span>Command Center</span>
            </button>
            <button class="ac-btn {{ $activeTab === 'templates' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="justify-content:flex-start; padding:12px 16px; border-radius:14px;" wire:click="$set('activeTab', 'templates')">
                <svg viewBox="0 0 24 24" style="width:18px; margin-right:12px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <span>Templates</span>
            </button>
            <button class="ac-btn {{ $activeTab === 'scheduled' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="justify-content:flex-start; padding:12px 16px; border-radius:14px;" wire:click="$set('activeTab', 'scheduled')">
                <svg viewBox="0 0 24 24" style="width:18px; margin-right:12px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Scheduled</span>
            </button>
            <button class="ac-btn {{ $activeTab === 'history' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="justify-content:flex-start; padding:12px 16px; border-radius:14px;" wire:click="$set('activeTab', 'history')">
                <svg viewBox="0 0 24 24" style="width:18px; margin-right:12px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>History</span>
            </button>
            
            <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:var(--ink4); padding:20px 16px 4px; letter-spacing:0.08em; border-top:1px solid var(--border); margin-top:12px;">Automation</div>
            <button class="ac-btn {{ $activeTab === 'settings' ? 'ac-btn-primary' : 'ac-btn-ghost' }}" style="justify-content:flex-start; padding:12px 16px; border-radius:14px;" wire:click="$set('activeTab', 'settings')">
                <svg viewBox="0 0 24 24" style="width:18px; margin-right:12px;"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span>Trigger Rules</span>
            </button>
        </nav>
    </aside>

    <main style="display:flex; flex-direction:column; gap:32px; min-width:0;">
        @if($activeTab === 'center')
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1 style="font-family:'Sora',sans-serif; font-size:28px; font-weight:800; color:var(--ink); letter-spacing:-0.5px;">Command Center</h1>
                <button class="ac-btn ac-btn-primary" wire:click="openSend">
                    <svg viewBox="0 0 24 24" style="width:18px; margin-right:8px; stroke:#fff; fill:none;"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Dispatch New
                </button>
            </div>

            <div class="ac-tiles">
                <div class="ac-tile">
                    <div class="at-bar" style="background:var(--blue);"></div>
                    <div class="at-ico" style="background:var(--blue-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--blue);"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg></div>
                    <div><div class="at-lbl">Total Sent</div><div class="at-val">{{ $totalSent }}</div><div class="at-sub">All time</div></div>
                </div>
                <div class="ac-tile">
                    <div class="at-bar" style="background:var(--amber);"></div>
                    <div class="at-ico" style="background:var(--amber-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--amber);"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
                    <div><div class="at-lbl">Unread</div><div class="at-val" style="color:var(--amber);">{{ $unreadCount }}</div><div class="at-sub">Awaiting attention</div></div>
                </div>
                <div class="ac-tile">
                    <div class="at-bar" style="background:var(--indigo);"></div>
                    <div class="at-ico" style="background:var(--indigo-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--indigo);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                    <div><div class="at-lbl">Scheduled</div><div class="at-val">{{ $scheduledCount }}</div><div class="at-sub">Future deliveries</div></div>
                </div>
                <div class="ac-tile">
                    <div class="at-bar" style="background:var(--red);"></div>
                    <div class="at-ico" style="background:var(--red-lt);"><svg viewBox="0 0 24 24" style="stroke:var(--red);"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                    <div><div class="at-lbl">Failed</div><div class="at-val" style="color:var(--red);">{{ $failedCount }}</div><div class="at-sub">Critical errors</div></div>
                </div>
            </div>

            <div class="ac-card">
                <div class="ac-card-hd" style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="ac-card-title">Recent Activity</span>
                    <button class="ac-btn ac-btn-ghost ac-btn-sm" wire:click="runAutoDetect">Run Auto-Trigger</button>
                </div>
                <div style="display:flex; flex-direction:column;">
                    @foreach($recentNotifs as $notif)
                        <div style="padding:16px 24px; border-bottom:1px solid var(--border); display:flex; gap:16px; transition:background 0.2s; cursor:pointer;" onmouseover="this.style.background='var(--bg2)'" onmouseout="this.style.background='transparent'">
                            <div style="width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background: {{ ($notifTypes[$notif->type]['color'] ?? '#3B6FE8') }}15; color: {{ $notifTypes[$notif->type]['color'] ?? '#3B6FE8' }}; border:1px solid {{ ($notifTypes[$notif->type]['color'] ?? '#3B6FE8') }}30;">
                                <svg viewBox="0 0 24 24" style="width:18px; stroke:currentColor; fill:none; stroke-width:2.5;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-weight: 700; font-size: 15px; color: var(--ink);">{{ $notif->title }}</div>
                                    <span class="ac-badge {{ $notif->priority === 'urgent' ? 'ab-red' : ($notif->priority === 'high' ? 'ab-amber' : 'ab-blue') }}">
                                        {{ $notif->priority }}
                                    </span>
                                </div>
                                <div style="font-size: 13px; color: var(--ink3); margin-top: 4px; line-height:1.5;">{{ Str::limit($notif->body, 120) }}</div>
                                <div style="display: flex; gap: 16px; margin-top: 12px; font-size: 11px; color: var(--ink4); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                    <span style="display:flex; align-items:center; gap:4px;"><svg viewBox="0 0 24 24" style="width:12px; stroke:currentColor;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> {{ $notif->user->full_name ?? 'System' }}</span>
                                    <span style="display:flex; align-items:center; gap:4px;"><svg viewBox="0 0 24 24" style="width:12px; stroke:currentColor;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $notif->created_at->diffForHumans() }}</span>
                                    <span style="display:flex; align-items:center; gap:4px;"><svg viewBox="0 0 24 24" style="width:12px; stroke:currentColor;"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> {{ ucfirst($notif->channel) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeTab === 'templates')
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1 style="font-family:'Sora',sans-serif; font-size:28px; font-weight:800; color:var(--ink); letter-spacing:-0.5px;">Message Templates</h1>
                <button class="ac-btn ac-btn-primary" wire:click="openCreateTpl">Create Template</button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                @foreach($templates as $tpl)
                    <div class="ac-card" style="padding: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                            <div style="width:44px; height:44px; border-radius:14px; background:var(--blue-lt); color:var(--blue); display:flex; align-items:center; justify-content:center; border:1px solid var(--blue-brd);">
                                <svg viewBox="0 0 24 24" style="width:20px; stroke:currentColor; fill:none; stroke-width:2.2;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            </div>
                            <span class="ac-badge ab-blue">{{ $tpl->channel }}</span>
                        </div>
                        <div style="font-family: 'Sora', sans-serif; font-weight: 800; font-size: 16px; margin-bottom: 4px; color:var(--ink);">{{ $tpl->name }}</div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--ink4); text-transform: uppercase; margin-bottom: 16px;">Type: {{ $tpl->type }}</div>
                        <div style="font-size: 13px; color: var(--ink2); line-height: 1.6; height: 64px; overflow: hidden;">{{ Str::limit($tpl->body, 120) }}</div>
                        <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid var(--border); padding-top: 16px;">
                            <button class="ac-btn ac-btn-ghost ac-btn-sm" style="padding:4px 12px;" wire:click="openEditTpl('{{ $tpl->id }}')">Edit</button>
                            <button class="ac-btn ac-btn-ghost ac-btn-sm" style="padding:4px 12px; color:var(--red); border-color:rgba(239,68,68,0.15);" wire:click="deleteTpl('{{ $tpl->id }}')">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($activeTab === 'settings')
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1 style="font-family:'Sora',sans-serif; font-size:28px; font-weight:800; color:var(--ink); letter-spacing:-0.5px;">Trigger Rules</h1>
                <button class="ac-btn ac-btn-primary" wire:click="openCreateAlert">New Alert Rule</button>
            </div>

            <div class="ac-card">
                <div class="ac-card-hd"><span class="ac-card-title">Event-Based Automation</span></div>
                <div style="display:flex; flex-direction:column;">
                    @foreach($alertRules as $alert)
                        <div style="padding:16px 24px; border-bottom:1px solid var(--border); display:flex; gap:16px; align-items:center;">
                            <div style="width:40px; height:40px; border-radius:12px; background:var(--bg2); display:flex; align-items:center; justify-content:center; color:var(--ink2);">
                                <svg viewBox="0 0 24 24" style="width:18px; stroke:currentColor; fill:none; stroke-width:2.2;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-weight: 700; font-size: 15px; color:var(--ink);">{{ $alert->name }}</div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-size:11px; font-weight:800; color:{{ $alert->is_active ? 'var(--green)' : 'var(--ink4)' }}; text-transform:uppercase;">{{ $alert->is_active ? 'Active' : 'Disabled' }}</span>
                                        <div style="width:36px; height:20px; background:{{ $alert->is_active ? 'var(--blue)' : 'var(--ink4)' }}; border-radius:20px; position:relative; cursor:pointer;" wire:click="toggleAlert('{{ $alert->id }}')">
                                            <div style="width:16px; height:16px; background:#fff; border-radius:50%; position:absolute; top:2px; left:{{ $alert->is_active ? '18px' : '2px' }}; transition:0.2s;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: 13px; color: var(--ink3); margin-top: 4px;">
                                    Trigger: <strong>{{ str_replace('_', ' ', $alert->trigger) }}</strong> 
                                    @if($alert->days_before) 
                                        — Sent <strong>{{ $alert->days_before }} days before</strong>
                                    @endif
                                </div>
                                <div style="font-size: 11px; font-weight: 800; color: var(--ink4); margin-top: 8px; text-transform: uppercase; letter-spacing:0.05em;">
                                    Channel: {{ $alert->channel }} | Priority: {{ $alert->priority }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="ac-card" style="margin-top: 32px;">
                <div class="ac-card-hd"><span class="ac-card-title">System Settings</span></div>
                <div style="padding: 32px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items:flex-start;">
                        <div style="display:flex; flex-direction:column; gap:24px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:14px;">
                                <div>
                                    <div style="font-weight: 800; font-size: 14px; color:var(--ink);">Email Delivery</div>
                                    <div style="font-size: 12px; color: var(--ink4);">Global SMTP enable/disable</div>
                                </div>
                                <div style="width:40px; height:22px; background:{{ $settEmailEnabled ? 'var(--blue)' : 'var(--ink4)' }}; border-radius:20px; position:relative; cursor:pointer;" wire:click="$toggle('settEmailEnabled')">
                                    <div style="width:18px; height:18px; background:#fff; border-radius:50%; position:absolute; top:2px; left:{{ $settEmailEnabled ? '20px' : '2px' }}; transition:0.2s;"></div>
                                </div>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px; background:var(--bg2); border-radius:14px;">
                                <div>
                                    <div style="font-weight: 800; font-size: 14px; color:var(--ink);">SMS Alerts</div>
                                    <div style="font-size: 12px; color: var(--ink4);">Twilio/BulkSMS Integration</div>
                                </div>
                                <div style="width:40px; height:22px; background:{{ $settSmsEnabled ? 'var(--blue)' : 'var(--ink4)' }}; border-radius:20px; position:relative; cursor:pointer;" wire:click="$toggle('settSmsEnabled')">
                                    <div style="width:18px; height:18px; background:#fff; border-radius:50%; position:absolute; top:2px; left:{{ $settSmsEnabled ? '20px' : '2px' }}; transition:0.2s;"></div>
                                </div>
                            </div>
                        </div>
                        <div style="padding:24px; background:var(--blue-lt); border-radius:16px; border:1px solid var(--blue-brd);">
                            <div style="font-size:14px; color:var(--blue); font-weight:700; line-height:1.6; margin-bottom:20px;">
                                Configuration changes apply instantly across the workforce notification engine.
                            </div>
                            <button class="ac-btn ac-btn-primary" style="width: 100%; justify-content: center;" wire:click="saveSettings">Commit Config</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Dispatch Modal -->
    @if($showSend)
        <div class="ac-modal-bg" wire:click.self="closeSend" style="display:flex; align-items:center; justify-content:center;">
            <div class="ac-card" style="width:100%; max-width:680px; box-shadow:var(--sh-lg); overflow:hidden;">
                <div style="padding:24px; background:linear-gradient(118deg, var(--blue-3) 0%, var(--blue) 100%); color:#fff; display:flex; align-items:center; justify-content:space-between;">
                    <div style="font-family:'Sora',sans-serif; font-size:18px; font-weight:800;">Dispatch Notification</div>
                    <button wire:click="closeSend" style="background:rgba(255,255,255,0.2); border:none; width:32px; height:32px; border-radius:10px; color:#fff; cursor:pointer;"><svg viewBox="0 0 24 24" style="width:16px; stroke:currentColor; fill:none; stroke-width:3;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                </div>
                <div style="padding:32px; display:flex; flex-direction:column; gap:24px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="ac-field">
                            <label>Target Audience</label>
                            <select wire:model="sendTo">
                                <option value="all">Broadcast (All Employees)</option>
                                <option value="department">By Department</option>
                                <option value="employee">Specific Individual</option>
                            </select>
                        </div>
                        <div class="ac-field">
                            <label>Delivery Channel</label>
                            <select wire:model="sendChannel">
                                <option value="in_app">In-App Dashboard</option>
                                <option value="email">Email Service</option>
                                <option value="sms">SMS Text</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="ac-field">
                        <label>Notification Title</label>
                        <input type="text" wire:model="sendTitle" placeholder="e.g. System Maintenance Update">
                    </div>

                    <div class="ac-field">
                        <label>Content Message</label>
                        <textarea wire:model="sendBody" rows="5" placeholder="Enter the full message details..."></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="ac-field">
                            <label>Priority Level</label>
                            <select wire:model="sendPriority">
                                <option value="low">Low (General)</option>
                                <option value="normal">Normal</option>
                                <option value="high">High (Action Required)</option>
                                <option value="urgent">Urgent (Immediate)</option>
                            </select>
                        </div>
                        <div class="ac-field">
                            <label>Scheduled Date (Optional)</label>
                            <input type="datetime-local" wire:model="sendSchedule">
                        </div>
                    </div>
                </div>
                <div style="padding:24px; background:var(--bg2); border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:12px;">
                    <button class="ac-btn ac-btn-ghost" wire:click="closeSend">Discard</button>
                    <button class="ac-btn ac-btn-primary" wire:click="sendNotification">Dispatch Now</button>
                </div>
            </div>
        </div>
    @endif
</div>

