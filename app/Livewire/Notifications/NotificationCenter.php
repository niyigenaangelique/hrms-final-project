<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Notification Center')]
class NotificationCenter extends Component
{
    use WithPagination;

    // ── Panel / tab state ──────────────────────────────────
    public string $activeTab    = 'center';   // center | templates | settings | history | scheduled
    public string $historyFilter= '';
    public string $historyType  = '';
    public int    $perPage      = 20;

    // ── Notification center ────────────────────────────────
    public bool   $showSend     = false;
    public string $sendTo       = 'all';      // all | department | employee
    public string $sendDeptId   = '';
    public string $sendEmpId    = '';
    public string $sendChannel  = 'in_app';   // in_app | email | sms | both
    public string $sendType     = 'general';
    public string $sendPriority = 'normal';   // low | normal | high | urgent
    public string $sendTitle    = '';
    public string $sendBody     = '';
    public string $sendSchedule = '';         // empty = send now

    // ── Template editor ────────────────────────────────────
    public bool   $showTplModal = false;
    public ?string $editTplId   = null;
    public string $tplName      = '';
    public string $tplType      = 'pay_reminder';
    public string $tplChannel   = 'email';
    public string $tplSubject   = '';
    public string $tplBody      = '';
    public bool   $tplActive    = true;

    // ── Settings ───────────────────────────────────────────
    public bool   $settPayReminder       = true;
    public int    $settPayReminderDays   = 3;
    public bool   $settContractExpiry    = true;
    public int    $settContractExpiryDays= 30;
    public bool   $settHolidayAnnounce  = true;
    public int    $settHolidayDays       = 7;
    public bool   $settLeaveApproval     = true;
    public bool   $settLeaveRejection    = true;
    public bool   $settAttendanceAlert   = false;
    public int    $settAttendanceCutoff  = 15;
    public bool   $settEmailEnabled      = true;
    public bool   $settSmsEnabled        = false;
    public bool   $settInAppEnabled      = true;
    public string $settSmsProvider       = 'twilio';
    public string $settSmsFrom           = '';
    public string $settEmailFrom         = '';

    // ── Alert config ───────────────────────────────────────
    public bool   $showAlertModal = false;
    public ?string $editAlertId   = null;
    public string $alertName      = '';
    public string $alertTrigger   = 'contract_expiry';
    public string $alertChannel   = 'in_app';
    public string $alertPriority  = 'high';
    public string $alertDaysBefore= '30';
    public bool   $alertActive    = true;

    // ── Notification types ─────────────────────────────────
    public static function notifTypes(): array
    {
        return [
            'general'          => ['label' => 'General',           'icon' => 'bell',     'color' => '#3B6FE8'],
            'pay_reminder'     => ['label' => 'Pay Reminder',      'icon' => 'money',    'color' => '#12B76A'],
            'contract_expiry'  => ['label' => 'Contract Expiry',   'icon' => 'doc',      'color' => '#F59E0B'],
            'holiday'          => ['label' => 'Holiday',           'icon' => 'sun',      'color' => '#0BB5B5'],
            'leave_update'     => ['label' => 'Leave Update',      'icon' => 'calendar', 'color' => '#7C3AED'],
            'attendance_alert' => ['label' => 'Attendance Alert',  'icon' => 'clock',    'color' => '#EF4444'],
            'payslip_ready'    => ['label' => 'Payslip Ready',     'icon' => 'doc',      'color' => '#12B76A'],
            'announcement'     => ['label' => 'Announcement',      'icon' => 'speaker',  'color' => '#6B4FDB'],
        ];
    }

    public function updatedActiveTab(): void { $this->resetPage(); }

    // ── Send notification ──────────────────────────────────
    public function openSend(): void { $this->showSend = true; }
    public function closeSend(): void { $this->showSend = false; $this->resetSendForm(); }

    public function sendNotification(): void
    {
        $this->validate([
            'sendTitle'    => 'required|string|max:255',
            'sendBody'     => 'required|string',
            'sendChannel'  => 'required',
            'sendType'     => 'required',
            'sendPriority' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $recipients = $this->resolveRecipients();
            $scheduledAt = $this->sendSchedule ? Carbon::parse($this->sendSchedule) : now();

            foreach ($recipients as $userId) {
                \App\Models\Notification::create([
                    'user_id'      => $userId,
                    'title'        => $this->sendTitle,
                    'body'         => $this->sendBody,
                    'type'         => $this->sendType,
                    'channel'      => $this->sendChannel,
                    'priority'     => $this->sendPriority,
                    'is_read'      => false,
                    'scheduled_at' => $scheduledAt,
                    'sent_at'      => $scheduledAt->lte(now()) ? now() : null,
                    'status'       => $scheduledAt->lte(now()) ? 'sent' : 'scheduled',
                    'sent_by'      => auth()->id(),
                    'metadata'     => json_encode(['to' => $this->sendTo, 'dept' => $this->sendDeptId]),
                ]);
            }
            DB::commit();
            $this->closeSend();
            $count = count($recipients);
            session()->flash('success', "Notification dispatched to {$count} recipient(s).");
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Send failed: ' . $e->getMessage());
        }
    }

    private function resolveRecipients(): array
    {
        try {
            $q = \App\Models\User::query();
            if ($this->sendTo === 'department' && $this->sendDeptId) {
                $empIds = \App\Models\Employee::where('department_id', $this->sendDeptId)->pluck('user_id');
                $q->whereIn('id', $empIds);
            } elseif ($this->sendTo === 'employee' && $this->sendEmpId) {
                $emp = \App\Models\Employee::find($this->sendEmpId);
                if ($emp) return [$emp->user_id];
            }
            return $q->pluck('id')->toArray();
        } catch (\Exception) {
            return [];
        }
    }

    private function resetSendForm(): void
    {
        $this->sendTo = 'all'; $this->sendDeptId = $this->sendEmpId = $this->sendSchedule = '';
        $this->sendChannel = 'in_app'; $this->sendType = 'general'; $this->sendPriority = 'normal';
        $this->sendTitle = $this->sendBody = '';
    }

    // ── Templates CRUD ─────────────────────────────────────
    public function openCreateTpl(): void { $this->resetTplForm(); $this->showTplModal = true; }

    public function openEditTpl(string $id): void
    {
        $t = \App\Models\NotificationTemplate::findOrFail($id);
        $this->editTplId  = $id;
        $this->tplName    = $t->name;
        $this->tplType    = $t->type;
        $this->tplChannel = $t->channel;
        $this->tplSubject = $t->subject ?? '';
        $this->tplBody    = $t->body;
        $this->tplActive  = (bool)$t->is_active;
        $this->showTplModal = true;
    }

    public function saveTpl(): void
    {
        $this->validate([
            'tplName' => 'required|string|max:255',
            'tplType' => 'required',
            'tplBody' => 'required|string',
        ]);
        try {
            $data = [
                'name'      => $this->tplName,
                'type'      => $this->tplType,
                'channel'   => $this->tplChannel,
                'subject'   => $this->tplSubject ?: null,
                'body'      => $this->tplBody,
                'is_active' => $this->tplActive,
            ];
            if ($this->editTplId) {
                \App\Models\NotificationTemplate::findOrFail($this->editTplId)->update($data);
                $msg = 'Template updated.';
            } else {
                \App\Models\NotificationTemplate::create($data);
                $msg = 'Template created.';
            }
            $this->closeTplModal();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            session()->flash('error', 'Save failed: '.$e->getMessage());
        }
    }

    public function deleteTpl(string $id): void
    {
        \App\Models\NotificationTemplate::findOrFail($id)->delete();
        session()->flash('success', 'Template deleted.');
    }

    public function toggleTpl(string $id): void
    {
        $t = \App\Models\NotificationTemplate::findOrFail($id);
        $t->update(['is_active' => !$t->is_active]);
    }

    public function closeTplModal(): void { $this->showTplModal = false; $this->resetTplForm(); }

    private function resetTplForm(): void
    {
        $this->editTplId = null;
        $this->tplName = $this->tplSubject = $this->tplBody = '';
        $this->tplType = 'pay_reminder'; $this->tplChannel = 'email'; $this->tplActive = true;
        $this->resetValidation();
    }

    // ── Alert rules ────────────────────────────────────────
    public function openCreateAlert(): void { $this->resetAlertForm(); $this->showAlertModal = true; }

    public function openEditAlert(string $id): void
    {
        $a = \App\Models\NotificationAlert::findOrFail($id);
        $this->editAlertId    = $id;
        $this->alertName      = $a->name;
        $this->alertTrigger   = $a->trigger;
        $this->alertChannel   = $a->channel;
        $this->alertPriority  = $a->priority;
        $this->alertDaysBefore= (string)($a->days_before ?? 0);
        $this->alertActive    = (bool)$a->is_active;
        $this->showAlertModal = true;
    }

    public function saveAlert(): void
    {
        $this->validate([
            'alertName'    => 'required|string|max:255',
            'alertTrigger' => 'required',
            'alertChannel' => 'required',
        ]);
        try {
            $data = [
                'name'        => $this->alertName,
                'trigger'     => $this->alertTrigger,
                'channel'     => $this->alertChannel,
                'priority'    => $this->alertPriority,
                'days_before' => (int)$this->alertDaysBefore,
                'is_active'   => $this->alertActive,
            ];
            if ($this->editAlertId) {
                \App\Models\NotificationAlert::findOrFail($this->editAlertId)->update($data);
            } else {
                \App\Models\NotificationAlert::create($data);
            }
            $this->closeAlertModal();
            session()->flash('success', 'Alert rule saved.');
        } catch (\Exception $e) {
            session()->flash('error', 'Save failed: '.$e->getMessage());
        }
    }

    public function deleteAlert(string $id): void
    {
        \App\Models\NotificationAlert::findOrFail($id)->delete();
        session()->flash('success', 'Alert rule deleted.');
    }

    public function toggleAlert(string $id): void
    {
        $a = \App\Models\NotificationAlert::findOrFail($id);
        $a->update(['is_active' => !$a->is_active]);
    }

    public function closeAlertModal(): void { $this->showAlertModal = false; $this->resetAlertForm(); }

    private function resetAlertForm(): void
    {
        $this->editAlertId = null;
        $this->alertName = ''; $this->alertDaysBefore = '30';
        $this->alertTrigger = 'contract_expiry'; $this->alertChannel = 'in_app';
        $this->alertPriority = 'high'; $this->alertActive = true;
        $this->resetValidation();
    }

    // ── Settings save ──────────────────────────────────────
    public function saveSettings(): void
    {
        try {
            $settings = [
                'pay_reminder'         => $this->settPayReminder,
                'pay_reminder_days'    => $this->settPayReminderDays,
                'contract_expiry'      => $this->settContractExpiry,
                'contract_expiry_days' => $this->settContractExpiryDays,
                'holiday_announce'     => $this->settHolidayAnnounce,
                'holiday_days'         => $this->settHolidayDays,
                'leave_approval'       => $this->settLeaveApproval,
                'leave_rejection'      => $this->settLeaveRejection,
                'attendance_alert'     => $this->settAttendanceAlert,
                'attendance_cutoff'    => $this->settAttendanceCutoff,
                'email_enabled'        => $this->settEmailEnabled,
                'sms_enabled'          => $this->settSmsEnabled,
                'in_app_enabled'       => $this->settInAppEnabled,
                'sms_provider'         => $this->settSmsProvider,
                'sms_from'             => $this->settSmsFrom,
                'email_from'           => $this->settEmailFrom,
            ];
            foreach ($settings as $key => $val) {
                \App\Models\NotificationSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_bool($val) ? ($val ? '1' : '0') : (string)$val]
                );
            }
            session()->flash('success', 'Settings saved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Save failed: '.$e->getMessage());
        }
    }

    public function markRead(string $id): void
    {
        try {
            \App\Models\Notification::where('id',$id)->update(['is_read'=>true,'read_at'=>now()]);
        } catch(\Exception){}
    }

    public function markAllRead(): void
    {
        try {
            \App\Models\Notification::where('user_id', auth()->id())->update(['is_read'=>true,'read_at'=>now()]);
        } catch(\Exception){}
    }

    public function deleteNotification(string $id): void
    {
        try { \App\Models\Notification::findOrFail($id)->delete(); } catch(\Exception){}
        session()->flash('success', 'Notification deleted.');
    }

    public function cancelScheduled(string $id): void
    {
        try {
            \App\Models\Notification::where('id',$id)->where('status','scheduled')->update(['status'=>'cancelled']);
        } catch(\Exception){}
        session()->flash('success', 'Scheduled notification cancelled.');
    }

    // ── Bulk auto-detect system notifications ──────────────
    public function runAutoDetect(): void
    {
        $sent = 0;
        try {
            // 1. Contracts expiring within configured days
            if ($this->settContractExpiry) {
                $days = $this->settContractExpiryDays;
                $expiring = \App\Models\Contract::with('employee')
                    ->whereBetween('end_date', [now(), now()->addDays($days)])
                    ->where('status', 'active')
                    ->get();
                foreach ($expiring as $c) {
                    if ($c->employee && $c->employee->user_id) {
                        $daysLeft = now()->diffInDays($c->end_date);
                        \App\Models\Notification::firstOrCreate(
                            ['user_id'=>$c->employee->user_id,'type'=>'contract_expiry','metadata->contract_id'=>$c->id],
                            [
                                'title'        => 'Contract Expiring Soon',
                                'body'         => "Your contract ({$c->code}) expires in {$daysLeft} days on ".\Carbon\Carbon::parse($c->end_date)->format('M d, Y').". Please contact HR.",
                                'type'         => 'contract_expiry',
                                'channel'      => 'in_app',
                                'priority'     => $daysLeft <= 7 ? 'urgent' : 'high',
                                'is_read'      => false,
                                'status'       => 'sent',
                                'sent_at'      => now(),
                                'sent_by'      => auth()->id(),
                                'metadata'     => json_encode(['contract_id'=>$c->id,'days_left'=>$daysLeft]),
                            ]
                        );
                        $sent++;
                    }
                }
            }

            // 2. Pay date reminders
            if ($this->settPayReminder) {
                try {
                    $paydays = \App\Models\PayrollMonth::whereBetween('end_date',[now(),now()->addDays($this->settPayReminderDays)])->get();
                    $empIds  = \App\Models\Employee::whereNotNull('user_id')->pluck('user_id');
                    foreach ($paydays as $pm) {
                        foreach ($empIds as $uid) {
                            \App\Models\Notification::firstOrCreate(
                                ['user_id'=>$uid,'type'=>'pay_reminder','metadata->month_id'=>$pm->id],
                                [
                                    'title'    => 'Payday Coming Up',
                                    'body'     => "Payroll period \"{$pm->name}\" closes on ".\Carbon\Carbon::parse($pm->end_date)->format('M d, Y').". Payslips will be processed shortly.",
                                    'type'     => 'pay_reminder',
                                    'channel'  => 'in_app',
                                    'priority' => 'normal',
                                    'is_read'  => false,
                                    'status'   => 'sent',
                                    'sent_at'  => now(),
                                    'sent_by'  => auth()->id(),
                                    'metadata' => json_encode(['month_id'=>$pm->id]),
                                ]
                            );
                            $sent++;
                        }
                    }
                } catch(\Exception){}
            }

            // 3. Upcoming holidays
            if ($this->settHolidayAnnounce) {
                try {
                    $holidays = \App\Models\Holiday::whereBetween('date',[now()->addDay(),now()->addDays($this->settHolidayDays)])->get();
                    $empIds   = \App\Models\Employee::whereNotNull('user_id')->pluck('user_id');
                    foreach ($holidays as $h) {
                        foreach ($empIds as $uid) {
                            \App\Models\Notification::firstOrCreate(
                                ['user_id'=>$uid,'type'=>'holiday','metadata->holiday_id'=>$h->id],
                                [
                                    'title'    => 'Upcoming Public Holiday',
                                    'body'     => "{$h->name} is on ".\Carbon\Carbon::parse($h->date)->format('l, M d, Y').". Offices will be closed.",
                                    'type'     => 'holiday',
                                    'channel'  => 'in_app',
                                    'priority' => 'low',
                                    'is_read'  => false,
                                    'status'   => 'sent',
                                    'sent_at'  => now(),
                                    'sent_by'  => auth()->id(),
                                    'metadata' => json_encode(['holiday_id'=>$h->id]),
                                ]
                            );
                            $sent++;
                        }
                    }
                } catch(\Exception){}
            }

            session()->flash('success', "Auto-detect complete — {$sent} notification(s) queued.");
        } catch (\Exception $e) {
            session()->flash('error', 'Auto-detect failed: '.$e->getMessage());
        }
    }

    // ── Load settings on mount ─────────────────────────────
    public function mount(): void
    {
        try {
            $s = \App\Models\NotificationSetting::pluck('value','key');
            $this->settPayReminder        = (bool)($s['pay_reminder'] ?? true);
            $this->settPayReminderDays    = (int)($s['pay_reminder_days'] ?? 3);
            $this->settContractExpiry     = (bool)($s['contract_expiry'] ?? true);
            $this->settContractExpiryDays = (int)($s['contract_expiry_days'] ?? 30);
            $this->settHolidayAnnounce    = (bool)($s['holiday_announce'] ?? true);
            $this->settHolidayDays        = (int)($s['holiday_days'] ?? 7);
            $this->settLeaveApproval      = (bool)($s['leave_approval'] ?? true);
            $this->settLeaveRejection     = (bool)($s['leave_rejection'] ?? true);
            $this->settAttendanceAlert    = (bool)($s['attendance_alert'] ?? false);
            $this->settAttendanceCutoff   = (int)($s['attendance_cutoff'] ?? 15);
            $this->settEmailEnabled       = (bool)($s['email_enabled'] ?? true);
            $this->settSmsEnabled         = (bool)($s['sms_enabled'] ?? false);
            $this->settInAppEnabled       = (bool)($s['in_app_enabled'] ?? true);
            $this->settSmsProvider        = $s['sms_provider'] ?? 'twilio';
            $this->settSmsFrom            = $s['sms_from'] ?? '';
            $this->settEmailFrom          = $s['email_from'] ?? '';
        } catch (\Exception) {}
    }

    public function render()
    {
        // ── Stats ──────────────────────────────────────────
        $totalSent    = 0; $unreadCount = 0; $scheduledCount = 0; $failedCount = 0;
        $recentNotifs = collect(); $scheduledNotifs = collect();
        $historyItems = collect(); $templates = collect(); $alertRules = collect();

        try {
            $totalSent      = \App\Models\Notification::where('status','sent')->count();
            $unreadCount    = \App\Models\Notification::where('is_read',false)->count();
            $scheduledCount = \App\Models\Notification::where('status','scheduled')->count();
            $failedCount    = \App\Models\Notification::where('status','failed')->count();

            $recentNotifs   = \App\Models\Notification::with('user')->latest()->take(12)->get();

            $scheduledNotifs= \App\Models\Notification::with('user')
                ->where('status','scheduled')
                ->where('scheduled_at','>', now())
                ->orderBy('scheduled_at')
                ->take(20)->get();

            $historyQuery = \App\Models\Notification::with('user')
                ->when($this->historyFilter, fn($q) => $q->where(fn($q2) =>
                    $q2->whereHas('user', fn($u) => $u->where('name','like',"%{$this->historyFilter}%"))
                       ->orWhere('title','like',"%{$this->historyFilter}%")
                ))
                ->when($this->historyType, fn($q) => $q->where('type', $this->historyType))
                ->orderBy('created_at','desc');
            $historyItems = $historyQuery->paginate($this->perPage);

            $templates  = \App\Models\NotificationTemplate::orderBy('name')->get();
            $alertRules = \App\Models\NotificationAlert::orderBy('name')->get();
        } catch (\Exception) {}

        // ── Dropdown data ──────────────────────────────────
        $employees   = collect();
        $departments = collect();
        try {
            $employees   = \App\Models\Employee::orderBy('first_name')->get(['id','first_name','last_name']);
            $departments = \App\Models\Department::orderBy('name')->get(['id','name']);
        } catch(\Exception){}

        $notifTypes = self::notifTypes();

        // ── Delivery breakdown ─────────────────────────────
        $channelBreakdown = [];
        try {
            $channelBreakdown = \App\Models\Notification::select('channel', DB::raw('count(*) as total'))
                ->groupBy('channel')->pluck('total','channel')->toArray();
        } catch(\Exception){}

        // ── Type breakdown for chart ───────────────────────
        $typeBreakdown = [];
        try {
            $typeBreakdown = \App\Models\Notification::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')->pluck('total','type')->toArray();
        } catch(\Exception){}

        return view('livewire.notifications.notification-center', compact(
            'totalSent','unreadCount','scheduledCount','failedCount',
            'recentNotifs','scheduledNotifs','historyItems',
            'templates','alertRules',
            'employees','departments','notifTypes',
            'channelBreakdown','typeBreakdown'
        ))->layout('components.layouts.app');
    }
}