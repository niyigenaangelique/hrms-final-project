<?php

namespace App\Livewire\Notifications;

use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\NotificationSetting;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Holiday;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('ZIBITECH | C-HRMS | Notification Center')]
class NotificationCenter extends Component
{
    use WithPagination;

    public $activeTab = 'notifications';
    public $searchTerm = '';
    public $filterStatus = 'all';
    public $filterChannel = 'all';
    public $filterPriority = 'all';
    public $selectedNotification;
    public $showTemplateEditor = false;
    public $showSettings = false;
    public $showAlertConfig = false;

    // Template Editor Properties
    public $templateName;
    public $templateType;
    public $templateChannel;
    public $templateSubject;
    public $templateContent;
    public $templateVariables = [];
    public $selectedTemplate;

    // Alert Configuration Properties
    public $alertType;
    public $alertChannel;
    public $alertRecipients = [];
    public $alertFrequency;
    public $alertMessage;
    public $alertSchedule;

    // Notification Settings Properties
    public $notificationSettings = [];

    protected $rules = [
        'templateName' => 'required|string|max:255',
        'templateType' => 'required|string|max:100',
        'templateChannel' => 'required|in:email,sms,push,in_app',
        'templateSubject' => 'required|string|max:255',
        'templateContent' => 'required|string',
        'alertType' => 'required|string|max:100',
        'alertChannel' => 'required|array',
        'alertRecipients' => 'required|array|min:1',
        'alertMessage' => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->loadNotificationSettings();
    }

    public function loadNotificationSettings()
    {
        $this->notificationSettings = NotificationSetting::where('user_id', auth()->id())
            ->get()
            ->keyBy('notification_type')
            ->toArray();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getNotifications()
    {
        $query = NotificationLog::with(['template'])
            ->orderBy('created_at', 'desc');

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterChannel !== 'all') {
            $query->where('channel', $this->filterChannel);
        }

        if ($this->filterPriority !== 'all') {
            $query->where('priority', $this->filterPriority);
        }

        return $query->paginate(20);
    }

    public function getTemplates()
    {
        return NotificationTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getUpcomingNotifications()
    {
        return NotificationLog::where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->take(10)
            ->get();
    }

    public function getRecentNotifications()
    {
        return NotificationLog::where('status', 'sent')
            ->where('sent_at', '>=', now()->subDays(7))
            ->orderBy('sent_at', 'desc')
            ->take(10)
            ->get();
    }

    public function getNotificationStats()
    {
        $total = NotificationLog::count();
        $sent = NotificationLog::where('status', 'sent')->count();
        $failed = NotificationLog::where('status', 'failed')->count();
        $pending = NotificationLog::where('status', 'pending')->count();
        $scheduled = NotificationLog::where('status', 'scheduled')->count();

        return [
            'total' => $total,
            'sent' => $sent,
            'failed' => $failed,
            'pending' => $pending,
            'scheduled' => $scheduled,
            'delivery_rate' => $total > 0 ? round(($sent / $total) * 100, 2) : 0,
        ];
    }

    public function createTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|max:255',
            'templateType' => 'required|string|max:100',
            'templateChannel' => 'required|in:email,sms,push,in_app',
            'templateSubject' => 'required|string|max:255',
            'templateContent' => 'required|string',
        ]);

        NotificationTemplate::create([
            'code' => 'TPL-' . uniqid(),
            'name' => $this->templateName,
            'type' => $this->templateType,
            'channel' => $this->templateChannel,
            'subject' => $this->templateSubject,
            'content' => $this->templateContent,
            'variables' => $this->templateVariables,
            'is_active' => true,
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'Template created successfully', 'success');
        $this->resetTemplateForm();
        $this->showTemplateEditor = false;
    }

    public function editTemplate($templateId)
    {
        $this->selectedTemplate = NotificationTemplate::find($templateId);
        if ($this->selectedTemplate) {
            $this->templateName = $this->selectedTemplate->name;
            $this->templateType = $this->selectedTemplate->type;
            $this->templateChannel = $this->selectedTemplate->channel;
            $this->templateSubject = $this->selectedTemplate->subject;
            $this->templateContent = $this->selectedTemplate->content;
            $this->templateVariables = $this->selectedTemplate->variables;
            $this->showTemplateEditor = true;
        }
    }

    public function updateTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|max:255',
            'templateType' => 'required|string|max:100',
            'templateChannel' => 'required|in:email,sms,push,in_app',
            'templateSubject' => 'required|string|max:255',
            'templateContent' => 'required|string',
        ]);

        if ($this->selectedTemplate) {
            $this->selectedTemplate->update([
                'name' => $this->templateName,
                'type' => $this->templateType,
                'channel' => $this->templateChannel,
                'subject' => $this->templateSubject,
                'content' => $this->templateContent,
                'variables' => $this->templateVariables,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('showNotification', 'Template updated successfully', 'success');
            $this->resetTemplateForm();
            $this->showTemplateEditor = false;
        }
    }

    public function deleteTemplate($templateId)
    {
        $template = NotificationTemplate::find($templateId);
        if ($template) {
            $template->delete();
            $this->dispatch('showNotification', 'Template deleted successfully', 'success');
        }
    }

    public function sendTestNotification()
    {
        // Create a test notification
        NotificationLog::create([
            'code' => 'NOT-' . uniqid(),
            'recipient_type' => 'user',
            'recipient_id' => auth()->id(),
            'channel' => 'in_app',
            'subject' => 'Test Notification',
            'content' => 'This is a test notification from the HRMS system.',
            'status' => 'sent',
            'priority' => 'low',
            'sent_at' => now(),
            'delivery_status' => 'delivered',
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'Test notification sent successfully', 'success');
    }

    public function createAlert()
    {
        $this->validate([
            'alertType' => 'required|string|max:100',
            'alertChannel' => 'required|array|min:1',
            'alertRecipients' => 'required|array|min:1',
            'alertMessage' => 'required|string|max:500',
        ]);

        // Create notifications for each recipient and channel
        foreach ($this->alertRecipients as $recipientId) {
            foreach ($this->alertChannel as $channel) {
                NotificationLog::create([
                    'code' => 'ALT-' . uniqid(),
                    'recipient_type' => 'user',
                    'recipient_id' => $recipientId,
                    'channel' => $channel,
                    'subject' => $this->alertType . ' Alert',
                    'content' => $this->alertMessage,
                    'status' => 'pending',
                    'priority' => 'high',
                    'approval_status' => \App\Enum\ApprovalStatus::Initiated,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        $this->dispatch('showNotification', 'Alert created successfully', 'success');
        $this->resetAlertForm();
        $this->showAlertConfig = false;
    }

    public function updateNotificationSettings()
    {
        foreach ($this->notificationSettings as $type => $settings) {
            NotificationSetting::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'notification_type' => $type,
                ],
                [
                    'email_enabled' => $settings['email_enabled'] ?? false,
                    'sms_enabled' => $settings['sms_enabled'] ?? false,
                    'push_enabled' => $settings['push_enabled'] ?? false,
                    'in_app_enabled' => $settings['in_app_enabled'] ?? false,
                    'frequency' => $settings['frequency'] ?? 'immediate',
                    'is_active' => $settings['is_active'] ?? true,
                    'approval_status' => \App\Enum\ApprovalStatus::Initiated,
                    'updated_by' => auth()->id(),
                ]
            );
        }

        $this->dispatch('showNotification', 'Settings updated successfully', 'success');
        $this->loadNotificationSettings();
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = NotificationLog::find($notificationId);
        if ($notification) {
            $notification->update([
                'delivery_status' => 'read',
                'updated_by' => auth()->id(),
            ]);
        }
    }

    public function deleteNotification($notificationId)
    {
        $notification = NotificationLog::find($notificationId);
        if ($notification) {
            $notification->delete();
            $this->dispatch('showNotification', 'Notification deleted successfully', 'success');
        }
    }

    public function resendNotification($notificationId)
    {
        $notification = NotificationLog::find($notificationId);
        if ($notification && $notification->status === 'failed') {
            $notification->update([
                'status' => 'pending',
                'delivery_status' => 'pending',
                'error_message' => null,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('showNotification', 'Notification queued for resend', 'success');
        }
    }

    private function resetTemplateForm()
    {
        $this->templateName = '';
        $this->templateType = '';
        $this->templateChannel = 'email';
        $this->templateSubject = '';
        $this->templateContent = '';
        $this->templateVariables = [];
        $this->selectedTemplate = null;
    }

    private function resetAlertForm()
    {
        $this->alertType = '';
        $this->alertChannel = [];
        $this->alertRecipients = [];
        $this->alertMessage = '';
        $this->alertSchedule = null;
    }

    public function render()
    {
        return view('livewire.notifications.notification-center', [
            'notifications' => $this->getNotifications(),
            'templates' => $this->getTemplates(),
            'upcomingNotifications' => $this->getUpcomingNotifications(),
            'recentNotifications' => $this->getRecentNotifications(),
            'stats' => $this->getNotificationStats(),
        ]);
    }
}
