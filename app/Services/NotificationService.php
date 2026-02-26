<?php

namespace App\Services;

use App\Models\NotificationTemplate;
use App\Models\NotificationLog;
use App\Models\NotificationSetting;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function checkAndSendAutomatedNotifications()
    {
        $this->checkPayDateReminders();
        $this->checkContractExpiryNotifications();
        $this->checkHolidayAnnouncements();
        $this->checkLeaveRequestNotifications();
        $this->checkPerformanceReviewReminders();
    }

    private function checkPayDateReminders()
    {
        // Check for upcoming pay dates (e.g., 3 days before)
        $upcomingPayDate = now()->addDays(3);
        
        $employees = Employee::where('is_active', true)->get();
        
        foreach ($employees as $employee) {
            if ($this->shouldSendNotification($employee->user_id, 'pay_date_reminders')) {
                $this->sendNotification($employee, 'pay_date_reminders', [
                    'employee_name' => $employee->full_name,
                    'pay_date' => $upcomingPayDate->format('F d, Y'),
                    'days_until' => 3,
                ]);
            }
        }
    }

    private function checkContractExpiryNotifications()
    {
        // Check for contracts expiring in 30, 14, and 7 days
        $warningPeriods = [30, 14, 7];
        
        foreach ($warningPeriods as $days) {
            $expiryDate = now()->addDays($days);
            
            $expiringContracts = Contract::where('end_date', $expiryDate->format('Y-m-d'))
                ->where('status', 'active')
                ->with('employee')
                ->get();
            
            foreach ($expiringContracts as $contract) {
                if ($this->shouldSendNotification($contract->employee->user_id, 'contract_expiry')) {
                    $this->sendNotification($contract->employee, 'contract_expiry', [
                        'employee_name' => $contract->employee->full_name,
                        'contract_type' => $contract->contract_type,
                        'expiry_date' => $contract->end_date->format('F d, Y'),
                        'days_until_expiry' => $days,
                    ]);
                }
            }
        }
    }

    private function checkHolidayAnnouncements()
    {
        // Check for holidays in the next 7 days
        $upcomingHolidays = Holiday::whereBetween('date', [now(), now()->addDays(7)])
            ->get();
        
        if ($upcomingHolidays->isNotEmpty()) {
            $employees = Employee::where('is_active', true)->get();
            
            foreach ($employees as $employee) {
                if ($this->shouldSendNotification($employee->user_id, 'holiday_announcements')) {
                    foreach ($upcomingHolidays as $holiday) {
                        $this->sendNotification($employee, 'holiday_announcements', [
                            'employee_name' => $employee->full_name,
                            'holiday_name' => $holiday->name,
                            'holiday_date' => $holiday->date->format('F d, Y'),
                            'days_until' => now()->diffInDays($holiday->date),
                        ]);
                    }
                }
            }
        }
    }

    private function checkLeaveRequestNotifications()
    {
        // Check for new leave requests that need approval
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')
            ->with('employee')
            ->get();
        
        foreach ($pendingLeaveRequests as $leaveRequest) {
            // Notify manager
            if ($leaveRequest->employee->manager) {
                if ($this->shouldSendNotification($leaveRequest->employee->manager->user_id, 'leave_requests')) {
                    $this->sendNotification($leaveRequest->employee->manager, 'leave_requests', [
                        'manager_name' => $leaveRequest->employee->manager->full_name,
                        'employee_name' => $leaveRequest->employee->full_name,
                        'leave_type' => $leaveRequest->leaveType->name,
                        'start_date' => $leaveRequest->start_date->format('F d, Y'),
                        'end_date' => $leaveRequest->end_date->format('F d, Y'),
                        'total_days' => $leaveRequest->total_days,
                    ]);
                }
            }
            
            // Notify HR department
            $hrUsers = $this->getHRUsers();
            foreach ($hrUsers as $hrUser) {
                if ($this->shouldSendNotification($hrUser->id, 'leave_requests')) {
                    $this->sendNotification($hrUser, 'leave_requests', [
                        'employee_name' => $leaveRequest->employee->full_name,
                        'leave_type' => $leaveRequest->leaveType->name,
                        'start_date' => $leaveRequest->start_date->format('F d, Y'),
                        'end_date' => $leaveRequest->end_date->format('F d, Y'),
                        'total_days' => $leaveRequest->total_days,
                    ]);
                }
            }
        }
    }

    private function checkPerformanceReviewReminders()
    {
        // Check for performance reviews due in the next 14 days
        $reviewDueDate = now()->addDays(14);
        
        $employees = Employee::where('is_active', true)->get();
        
        foreach ($employees as $employee) {
            // Check if employee has a performance review due
            $hasReviewDue = $this->isPerformanceReviewDue($employee, $reviewDueDate);
            
            if ($hasReviewDue && $this->shouldSendNotification($employee->user_id, 'performance_reviews')) {
                $this->sendNotification($employee, 'performance_reviews', [
                    'employee_name' => $employee->full_name,
                    'review_due_date' => $reviewDueDate->format('F d, Y'),
                    'days_until_review' => 14,
                ]);
            }
        }
    }

    private function shouldSendNotification($userId, $notificationType)
    {
        $setting = NotificationSetting::where('user_id', $userId)
            ->where('notification_type', $notificationType)
            ->where('is_active', true)
            ->first();
        
        if (!$setting) {
            return false;
        }
        
        return $setting->shouldSend();
    }

    private function sendNotification($recipient, $notificationType, $data = [])
    {
        $template = NotificationTemplate::where('type', $notificationType)
            ->where('is_active', true)
            ->first();
        
        if (!$template) {
            Log::warning("No template found for notification type: {$notificationType}");
            return;
        }
        
        $settings = NotificationSetting::where('user_id', $recipient->user_id ?? $recipient->id)
            ->where('notification_type', $notificationType)
            ->first();
        
        if (!$settings) {
            Log::warning("No settings found for user {$recipient->user_id} and notification type: {$notificationType}");
            return;
        }
        
        $enabledChannels = $settings->getEnabledChannels();
        
        foreach ($enabledChannels as $channel) {
            if ($channel === $template->channel) {
                $this->createNotificationLog($recipient, $template, $channel, $data);
            }
        }
    }

    private function createNotificationLog($recipient, $template, $channel, $data)
    {
        NotificationLog::create([
            'code' => 'NOT-' . uniqid(),
            'notification_template_id' => $template->id,
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient->id,
            'channel' => $channel,
            'subject' => $template->renderSubject($data),
            'content' => $template->renderContent($data),
            'status' => 'pending',
            'priority' => $this->getNotificationPriority($template->type),
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => 1, // System user
        ]);
    }

    private function getNotificationPriority($notificationType)
    {
        $priorities = [
            'contract_expiry' => 'high',
            'pay_date_reminders' => 'medium',
            'holiday_announcements' => 'low',
            'leave_requests' => 'medium',
            'performance_reviews' => 'medium',
        ];
        
        return $priorities[$notificationType] ?? 'medium';
    }

    private function isPerformanceReviewDue($employee, $dueDate)
    {
        // Check if employee has a performance review due
        // This is a simplified check - in reality, you'd check the employee's review cycle
        $lastReview = $employee->performanceReviews()
            ->where('status', 'completed')
            ->latest('review_date')
            ->first();
        
        if (!$lastReview) {
            // No previous review, assume due
            return true;
        }
        
        // Check if it's been 6 months since last review
        return $lastReview->review_date->diffInMonths($dueDate) >= 6;
    }

    private function getHRUsers()
    {
        // Get users with HR role or permissions
        // This is a simplified implementation
        return \App\Models\User::where('email', 'like', '%hr%')->get();
    }

    public function sendScheduledNotifications()
    {
        $scheduledNotifications = NotificationLog::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();
        
        foreach ($scheduledNotifications as $notification) {
            $this->processNotification($notification);
        }
    }

    private function processNotification($notification)
    {
        try {
            // Update status to processing
            $notification->status = 'processing';
            $notification->save();
            
            // Send notification based on channel
            $success = $this->sendNotificationByChannel($notification);
            
            if ($success) {
                $notification->markAsSent();
            } else {
                $notification->markAsFailed('Failed to send notification');
            }
        } catch (\Exception $e) {
            $notification->markAsFailed($e->getMessage());
            Log::error('Failed to process notification: ' . $e->getMessage());
        }
    }

    private function sendNotificationByChannel($notification)
    {
        switch ($notification->channel) {
            case 'email':
                return $this->sendEmailNotification($notification);
            case 'sms':
                return $this->sendSMSNotification($notification);
            case 'push':
                return $this->sendPushNotification($notification);
            case 'in_app':
                return $this->sendInAppNotification($notification);
            default:
                return false;
        }
    }

    private function sendEmailNotification($notification)
    {
        try {
            // Send email using Laravel's notification system
            $recipient = $notification->recipient;
            
            if ($recipient && $recipient->email) {
                // This would use Laravel's Mail or Notification system
                // For now, we'll just return true as a placeholder
                Log::info("Email notification sent to: {$recipient->email}");
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send email notification: ' . $e->getMessage());
            return false;
        }
    }

    private function sendSMSNotification($notification)
    {
        try {
            // Send SMS using SMS service
            $recipient = $notification->recipient;
            
            if ($recipient && $recipient->phone_number) {
                // This would integrate with an SMS service
                Log::info("SMS notification sent to: {$recipient->phone_number}");
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send SMS notification: ' . $e->getMessage());
            return false;
        }
    }

    private function sendPushNotification($notification)
    {
        try {
            // Send push notification using push service
            $recipient = $notification->recipient;
            
            if ($recipient) {
                // This would integrate with a push notification service
                Log::info("Push notification sent to: {$recipient->full_name}");
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send push notification: ' . $e->getMessage());
            return false;
        }
    }

    private function sendInAppNotification($notification)
    {
        try {
            // Create in-app notification
            $recipient = $notification->recipient;
            
            if ($recipient) {
                // This would create a database record for in-app notifications
                Log::info("In-app notification created for: {$recipient->full_name}");
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to create in-app notification: ' . $e->getMessage());
            return false;
        }
    }
}
