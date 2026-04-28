<div class="ep-root">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Sora:wght@700;800&display=swap');

        .ep-root {
            --blue: #3B6FE8; --blue-2: #2755CC; --blue-lt: rgba(59, 111, 232, 0.08);
            --green: #12B76A; --green-lt: rgba(18, 183, 106, 0.10);
            --amber: #F59E0B; --amber-lt: rgba(245, 158, 11, 0.10);
            --red: #EF4444; --red-lt: rgba(239, 68, 68, 0.09);
            --bg: #F0F4FA; --white: #FFFFFF;
            --ink: #0F1629; --ink2: #2D3356; --ink3: #6B7094; --ink4: #A8ADCA;
            --border: rgba(15, 22, 41, 0.08);
            --shadow: 0 2px 12px rgba(59, 111, 232, 0.07);
            --r: 12px; --r-lg: 18px;
            font-family: 'DM Sans', -apple-system, sans-serif; background: var(--bg);
            min-height: 100vh; color: var(--ink); padding: 28px;
            display: flex; flex-direction: column; gap: 20px;
        }

        .ep-card { background: var(--white); border-radius: var(--r-lg); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
        
        .ep-toolbar { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; gap: 16px; align-items: center; }
        .ep-search { display: flex; align-items: center; gap: 10px; background: var(--bg); border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; flex: 1; max-width: 300px; }
        .ep-search input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; color: var(--ink); }
        .ep-select { background: var(--bg); border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; font-size: 13px; font-weight: 600; color: var(--ink2); outline: none; }
        
        .table-premium { width: 100%; border-collapse: collapse; }
        .table-premium th { background: #F8FAFD; padding: 12px 20px; text-align: left; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--ink4); border-bottom: 1px solid var(--border); }
        .table-premium td { padding: 14px 20px; border-bottom: 1px solid var(--border); vertical-align: middle; font-size: 13px; font-weight: 600; color: var(--ink2); }

        .ep-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--r); font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
        .ep-btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-outline { background: var(--white); color: var(--ink2); border: 1px solid var(--border); }

        .ep-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .badge-green { background: var(--green-lt); color: var(--green); }
        .badge-red { background: var(--red-lt); color: var(--red); }
        .badge-gray { background: #F1F3F5; color: #495057; }

        /* Modal */
        .ep-modal-bg { position: fixed; inset: 0; background: rgba(15, 22, 41, 0.5); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .ep-modal { background: var(--white); border-radius: var(--r-lg); width: 100%; max-width: 500px; box-shadow: 0 20px 60px rgba(15, 22, 41, 0.2); overflow: hidden; }
        .ep-modal-hd { padding: 18px 24px; border-bottom: 1px solid var(--border); background: #F9FAFB; display: flex; justify-content: space-between; align-items: center; font-weight: 800; }
        .ep-modal-body { padding: 24px; display: flex; flex-direction: column; gap: 16px; }
        .ep-modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--ink4); letter-spacing: 0.05em; }
        .form-control { background: var(--bg); border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; font-size: 13.5px; font-weight: 500; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color 0.2s; }
        .form-control:focus { border-color: var(--blue); background: #fff; }
    </style>

    <div>
        <h1 style="font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; margin-bottom: 8px;">Device Management</h1>
        <p style="color: var(--ink3); font-size: 14px; font-weight: 500;">Manage biometric devices, assign them to branches, and check sync status.</p>
    </div>

    @if(session()->has('success'))
        <div style="padding: 12px 18px; border-radius: var(--r); background: var(--green-lt); color: #087A42; font-weight: 600; font-size: 13px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="ep-card">
        <div class="ep-toolbar">
            <div style="display: flex; gap: 12px; flex: 1;">
                <div class="ep-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search devices...">
                </div>
                <select class="ep-select" wire:model.live="filterStatus">
                    <option value="">All Statuses</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
            </div>
            <button class="ep-btn btn-primary" wire:click="openModal">Add Device</button>
        </div>

        <table class="table-premium">
            <thead>
                <tr>
                    <th>Device Details</th>
                    <th>Network</th>
                    <th>Branch / Location</th>
                    <th>Status</th>
                    <th>Last Sync</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--ink);">{{ $device->name }}</div>
                            <div style="font-size: 11px; color: var(--ink4); font-weight: 800;">{{ $device->code }}</div>
                        </td>
                        <td>
                            <div>{{ $device->ip_address }}</div>
                            <div style="font-size: 11px; color: var(--ink4);">{{ $device->mac_address ?: 'No MAC' }}</div>
                        </td>
                        <td>
                            <div>{{ $device->project ? $device->project->name : 'Unassigned' }}</div>
                            <div style="font-size: 11px; color: var(--ink4);">{{ $device->location ?: 'No Specific Room' }}</div>
                        </td>
                        <td>
                            @if($device->status === 'online')
                                <span class="ep-badge badge-green">Online</span>
                            @elseif($device->status === 'offline')
                                <span class="ep-badge badge-red">Offline</span>
                            @else
                                <span class="ep-badge badge-gray">Unknown</span>
                            @endif
                        </td>
                        <td>
                            {{ $device->last_sync_at ? $device->last_sync_at->diffForHumans() : 'Never' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button class="ep-btn ep-btn-sm btn-outline" wire:click="openModal('{{ $device->id }}')">Edit</button>
                                <button class="ep-btn ep-btn-sm btn-outline" style="color:var(--red);" wire:click="delete('{{ $device->id }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if($devices->isEmpty())
                    <tr><td colspan="6" style="text-align: center; color: var(--ink4); padding: 30px;">No devices found.</td></tr>
                @endif
            </tbody>
        </table>
        
        @if($devices->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
                {{ $devices->links('pagination::simple-tailwind') }}
            </div>
        @endif
    </div>

    @if($showModal)
        <div class="ep-modal-bg" wire:click.self="closeModal">
            <div class="ep-modal">
                <div class="ep-modal-hd">
                    <span>{{ $editingId ? 'Edit' : 'Add' }} Device</span>
                    <button wire:click="closeModal" style="background:none;border:none;cursor:pointer;font-size:18px;">&times;</button>
                </div>
                <div class="ep-modal-body">
                    <div class="form-group">
                        <label>Device Name</label>
                        <input type="text" class="form-control" wire:model="name" placeholder="e.g. Main Entrance Scanner">
                        @error('name')<span style="color:var(--red);font-size:11px;">{{$message}}</span>@enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label>IP Address</label>
                            <input type="text" class="form-control" wire:model="ip_address" placeholder="192.168.1.100">
                            @error('ip_address')<span style="color:var(--red);font-size:11px;">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>MAC Address</label>
                            <input type="text" class="form-control" wire:model="mac_address" placeholder="00:1B:44:11:3A:B7">
                            @error('mac_address')<span style="color:var(--red);font-size:11px;">{{$message}}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Branch / Project</label>
                        <select class="form-control" wire:model="project_id">
                            <option value="">Select Branch</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')<span style="color:var(--red);font-size:11px;">{{$message}}</span>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label>Specific Location (Room/Door)</label>
                            <input type="text" class="form-control" wire:model="location" placeholder="e.g. Server Room">
                        </div>
                        <div class="form-group">
                            <label>Initial Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="ep-modal-footer">
                    <button class="ep-btn btn-outline" wire:click="closeModal">Cancel</button>
                    <button class="ep-btn btn-primary" wire:click="save">Save Device</button>
                </div>
            </div>
        </div>
    @endif
</div>
