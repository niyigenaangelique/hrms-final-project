<?php

use App\Livewire\Auth\EmployeeRegistration;
use App\Livewire\Employee\EmployeeContracts;
use App\Livewire\Employee\EmployeePerformance;
use App\Livewire\Employee\EmployeeDashboard;
use App\Livewire\Employee\EmployeeProfile;
use App\Livewire\Employee\EmployeeLeaveRequest;
use App\Livewire\Employee\EmployeeLeaveStatus;
use App\Livewire\Employee\EmployeeLeaveTypes;
use App\Livewire\Employee\EmployeeAttendance;
use App\Livewire\Employee\EmployeeCommunication;
use App\Livewire\Employee\EmployeeCalendar;
use App\Livewire\Employee\EmployeePayroll;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\EnhancedAdminDashboard;
use App\Livewire\LeaveAttendance\HrCommunication;
use App\Livewire\LeaveAttendance\HrLeaveManagement;
use App\Livewire\LeaveAttendance\HrCalendar;
use App\Livewire\LeaveAttendance\HrPersonalCalendar;
use App\Livewire\LeaveAttendance\HrUnifiedCalendar;
use App\Livewire\Bank\BankPage;
use App\Livewire\Contract\ContractImportData;
use App\Livewire\Contract\ContractPage;
use App\Livewire\DataImportExport;
use App\Livewire\Employee\EmployeePage;
use App\Livewire\HomePage;
use App\Livewire\LoginPage;
use App\Livewire\PasswordResetPage;
use App\Livewire\LeaveAttendance\LeaveAttendanceDashboard;
use App\Livewire\LeaveAttendance\LeaveRequestForm;
use App\Livewire\LeaveAttendance\LeaveAttendanceCalendar;
use App\Livewire\Payroll\PayrollDashboard;
use App\Livewire\PayrollEntry\PayrollEntryPage;
use App\Livewire\PayrollMonth\PayrollMonthPage;
use App\Livewire\Payroll\PayslipGenerator;
use App\Livewire\Performance\PerformanceDashboard;
use App\Livewire\Analytics\AnalyticsDashboard;
use App\Livewire\Notifications\NotificationCenter;
use App\Livewire\Analytics\ReportBuilder;
use App\Livewire\AccessControl\AccessControlDashboard;
use App\Livewire\Performance\KPIManagement;
use App\Livewire\Payroll\TaxCalculator;
use App\Livewire\Position\PositionPage;
use App\Livewire\User\UserPage;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {

    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', EmployeeRegistration::class)->name('register');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/password/reset', PasswordResetPage::class)->name('password.request');

    Route::middleware(['check.user.role:*'])->group(function () {
        Route::get('/', HomePage::class)->name('home');
        
        // Test route
        Route::get('/test-payroll', function () {
            return 'Payroll route is working!';
        })->name('test.payroll');
        
        // Employee Dashboard (for employees only)
        Route::get('/employee/dashboard', EmployeeDashboard::class)->name('employee.dashboard');
        
        // Employee Routes
        Route::get('/employee/profile', EmployeeProfile::class)->name('employee.profile');
        Route::get('/employee/profile/{id}', EmployeeProfile::class)->name('employee.profile.show');
        Route::get('/employee/contracts', EmployeeContracts::class)->name('employee.contracts');
        Route::get('/employee/leave-request', EmployeeLeaveRequest::class)->name('employee.leave.request');
        Route::get('/employee/leave-status', EmployeeLeaveStatus::class)->name('employee.leave-status');
        Route::get('/employee/leave-types', EmployeeLeaveTypes::class)->name('employee.leave-types');
        Route::get('/employee/calendar', EmployeeCalendar::class)->name('employee.calendar');
        Route::get('/employee/attendance', EmployeeAttendance::class)->name('employee.attendance');
        Route::get('/employee/communication', EmployeeCommunication::class)->name('employee.communication');
        Route::get('/employee/payroll', EmployeePayroll::class)->name('employee.payroll');
        Route::get('/employee/performance', EmployeePerformance::class)->name('employee.performance');
        
        // Admin Routes (for SuperAdmin only)
        Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/admin/enhanced-dashboard', EnhancedAdminDashboard::class)->name('admin.enhanced-dashboard');
        
        // Admin Management Routes
        Route::get('/admin/users', \App\Livewire\Admin\UserManagement::class)->name('admin.users');
        Route::get('/admin/employees', \App\Livewire\Admin\EmployeeManagement::class)->name('admin.employees');
        Route::get('/admin/permissions', \App\Livewire\Admin\PermissionManagement::class)->name('admin.permissions');
        Route::get('/admin/activity-logs', \App\Livewire\Admin\ActivityLogManagement::class)->name('admin.activity-logs');
        Route::get('/admin/security-settings', \App\Livewire\Admin\SecuritySettingsManagement::class)->name('admin.security-settings');
        Route::get('/admin/active-sessions', \App\Livewire\Admin\ActiveSessionManagement::class)->name('admin.active-sessions');
        Route::get('/admin/password-resets', \App\Livewire\Admin\PasswordResetManagement::class)->name('admin.password-resets');
        Route::get('/admin/system-configuration', \App\Livewire\Admin\SystemConfigurationManagement::class)->name('admin.system-configuration');
        Route::get('/admin/database-management', \App\Livewire\Admin\DatabaseManagement::class)->name('admin.database-management');
        Route::get('/admin/system-analytics', \App\Livewire\Admin\SystemAnalytics::class)->name('admin.system-analytics');
        
        // Test route for user creation
        Route::get('/test-user-creation', function () {
            try {
                $user = User::create([
                    'code' => 'TEST-001',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test' . time() . '@example.com',
                    'phone_number' => '1234567890',
                    'password' => Hash::make('password123'),
                    'role' => 'Employee',
                    'username' => 'testuser',
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                    'password_changed_at' => now(),
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Test user created successfully!',
                    'user_id' => $user->id,
                    'code' => $user->code,
                    'username' => $user->username,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
        
        // Test route for creating a pending leave request
        Route::get('/create-test-leave-request', function () {
            try {
                $employee = \App\Models\Employee::first();
                $leaveType = \App\Models\LeaveType::first();
                
                if (!$employee || !$leaveType) {
                    return response()->json([
                        'success' => false,
                        'error' => 'No employee or leave type found',
                    ], 500);
                }
                
                $leaveRequest = \App\Models\LeaveRequest::create([
                    'code' => 'LR-TEST-' . time(),
                    'employee_id' => $employee->id,
                    'leave_type_id' => $leaveType->id,
                    'start_date' => now()->addDays(1)->format('Y-m-d'),
                    'end_date' => now()->addDays(3)->format('Y-m-d'),
                    'total_days' => 3,
                    'reason' => 'Test leave request for approval testing',
                    'status' => \App\Enum\LeaveStatus::PENDING->value,
                    'approval_status' => \App\Enum\ApprovalStatus::Pending->value,
                    'created_by' => auth()->id(),
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Test pending leave request created successfully!',
                    'request_id' => $leaveRequest->id,
                    'status' => $leaveRequest->status,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
        Route::get('/setup-angel-brenna', function () {
            try {
                // Check if user exists
                $user = User::where('email', 'angelbrenna20@gmail.com')->first();
                
                if ($user) {
                    // Update existing user
                    $user->update([
                        'first_name' => 'Angel',
                        'last_name' => 'Brenna',
                        'role' => 'HRManager',
                        'username' => 'angelbrenna',
                        'email_verified_at' => now(),
                        'phone_verified_at' => now(),
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Angel Brenna updated successfully!',
                        'action' => 'updated',
                        'user_id' => $user->id,
                        'code' => $user->code,
                        'username' => $user->username,
                        'role' => $user->role,
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'code' => 'HRM-001',
                        'first_name' => 'Angel',
                        'last_name' => 'Brenna',
                        'username' => 'angelbrenna',
                        'email' => 'angelbrenna20@gmail.com',
                        'phone_number' => '+1234567890',
                        'password' => Hash::make('password123'),
                        'role' => 'HRManager',
                        'email_verified_at' => now(),
                        'phone_verified_at' => now(),
                        'password_changed_at' => now(),
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Angel Brenna created successfully!',
                        'action' => 'created',
                        'user_id' => $user->id,
                        'code' => $user->code,
                        'username' => $user->username,
                        'role' => $user->role,
                        'password' => 'password123',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
        
        // Test route for checking employee data
        Route::get('/test-employees', function () {
            try {
                $employees = \App\Models\Employee::with('user')->get();
                $employeeCount = \App\Models\Employee::count();
                $userCount = \App\Models\User::count();
                
                $data = [
                    'employee_count' => $employeeCount,
                    'user_count' => $userCount,
                    'employees' => []
                ];
                
                foreach ($employees as $employee) {
                    $data['employees'][] = [
                        'id' => $employee->id,
                        'first_name' => $employee->first_name,
                        'last_name' => $employee->last_name,
                        'email' => $employee->email,
                        'department' => $employee->department,
                        'has_user' => $employee->user ? true : false,
                        'user_role' => $employee->user ? $employee->user->role : null,
                    ];
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
        
        // Simple test route for employee-user relationships
        Route::get('/test-simple', function () {
            try {
                $employees = \App\Models\Employee::all();
                $result = [];
                
                foreach ($employees as $employee) {
                    $result[] = [
                        'employee_name' => $employee->first_name . ' ' . $employee->last_name,
                        'employee_id' => $employee->id,
                        'user_id' => $employee->user_id,
                        'has_user' => $employee->user_id ? true : false,
                    ];
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $result,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
        
//        users
        Route::get('/users', UserPage::class)->name('users');
        Route::get('/users/{id}', UserPage::class)->name('user');
//        positions
        Route::get('/positions', PositionPage::class)->name('positions');
        Route::get('/positions/{id}', PositionPage::class)->name('position');
//        banks
        Route::get('/banks', BankPage::class)->name('banks');
        Route::get('/banks/{id}', BankPage::class)->name('bank');
//        employees
        Route::get('/employees', EmployeePage::class)->name('employees');
        Route::get('/employees/{id}', EmployeePage::class)->name('employee');
        
        // Test route for user creation
        Route::get('/test-user-creation', function () {
            try {
                $user = User::create([
                    'code' => 'TEST-001',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test' . time() . '@example.com',
                    'phone_number' => '1234567890',
                    'password' => Hash::make('password123'),
                    'role' => 'Employee',
                    'username' => 'testuser',
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                    'password_changed_at' => now(),
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Test user created successfully!',
                    'user_id' => $user->id,
                    'code' => $user->code,
                    'username' => $user->username,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }
        });

        Route::get('/contracts', ContractPage::class)->name('contracts');
        Route::get('/contracts/{id}', ContractPage::class)->name('contract');
        Route::get('/importContracts', ContractImportData::class)->name('importContracts');

//        payroll
        Route::get('/payroll/dashboard', PayrollDashboard::class)->name('payroll.dashboard');
        Route::get('/payroll/entries', PayrollEntryPage::class)->name('payroll.entries');
        Route::get('/payroll/entries/{id}', PayrollEntryPage::class)->name('payroll.entry');
        Route::get('/payroll/months', PayrollMonthPage::class)->name('payroll.months');
        Route::get('/payroll/months/{id}', PayrollMonthPage::class)->name('payroll.month');
        Route::get('/payroll/payslip-generator', PayslipGenerator::class)->name('payroll.payslip-generator');
        Route::get('/payroll/tax-calculator', TaxCalculator::class)->name('payroll.tax-calculator');

//        leave & attendance
        Route::get('/leave-attendance/dashboard', LeaveAttendanceDashboard::class)->name('leave-attendance.dashboard');
        Route::get('/leave-attendance/requests', LeaveRequestForm::class)->name('leave-attendance.requests');
        Route::get('/leave-attendance/calendar', LeaveAttendanceDashboard::class)->name('leave-attendance.calendar');
        Route::get('/leave-attendance/hr-communication', HrCommunication::class)->name('leave-attendance.hr-communication');
        Route::get('/leave-attendance/hr-leave-management', HrLeaveManagement::class)->name('leave-attendance.hr-leave-management');
        Route::get('/leave-attendance/hr-calendar', HrUnifiedCalendar::class)->name('leave-attendance.hr-calendar');

//        performance
        Route::get('/performance/dashboard', PerformanceDashboard::class)->name('performance.dashboard');
        Route::get('/performance/kpi-management', KPIManagement::class)->name('performance.kpi-management');

//        analytics
        Route::get('/analytics/dashboard', AnalyticsDashboard::class)->name('analytics.dashboard');
        Route::get('/analytics/report-builder', ReportBuilder::class)->name('analytics.report-builder');

//        notifications
        Route::get('/notifications/center', NotificationCenter::class)->name('notifications.center');

//        access control
        Route::get('/access-control/dashboard', AccessControlDashboard::class)->name('access-control.dashboard');

//        imports
        Route::get('/imports', DataImportExport::class)->name('imports');
    });


});
