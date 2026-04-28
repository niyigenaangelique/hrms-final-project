<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ExternalRecruitmentController extends Controller
{
    /**
     * Store a hired employee from the external AI recruitment system.
     */
    public function store(Request $request)
    {
        // 1. Basic Token Authentication
        $token = $request->header('X-Recruitment-Token');
        $expectedToken = SystemSetting::getSetting('recruitment_api_token', 'talentflow_secret_token_123');

        if (!$token || $token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized Access. Invalid token.'], 401);
        }

        // 2. Validation
        $validated = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'          => 'required|email|unique:users,email|unique:employees,email',
            'phone_number'   => 'nullable|string|max:30',
            'national_id'    => 'nullable|string|max:50',
            'gender'         => 'nullable|in:male,female,other',
            'birth_date'     => 'nullable|date',
            'department_id'  => 'nullable|exists:departments,id',
            'department_name'=> 'nullable|string|max:150',
            'position_id'    => 'nullable|exists:positions,id',
            'position_title' => 'nullable|string|max:150',
            'basic_salary'   => 'nullable|numeric',
            'join_date'      => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            // 3. Resolve Department/Position dynamically if names are provided.
            $departmentId = $validated['department_id'] ?? null;
            if (!$departmentId && !empty($validated['department_name'])) {
                $departmentId = $this->resolveOrCreateDepartment($validated['department_name']);
            }

            $positionId = $validated['position_id'] ?? null;
            if (!$positionId && !empty($validated['position_title'])) {
                $positionId = $this->resolveOrCreatePosition($validated['position_title'], $validated['basic_salary'] ?? null);
            }

            // 3. Create User Account
            $userCode = $this->generateUserCode();
            $password = Str::random(10); // Generate random password
            
            $user = User::create([
                'code'         => $userCode,
                'first_name'   => $validated['first_name'],
                'last_name'    => $validated['last_name'],
                'username'     => $this->generateUsername($validated['first_name'], $validated['last_name']),
                'email'        => $validated['email'],
                'phone_number' => $validated['phone_number'] ?? null,
                'password'     => Hash::make($password),
                'role'         => User::ROLE_EMPLOYEE,
                'is_active'    => true,
            ]);

            // 4. Create Employee Record
            $employeeCode = $this->generateEmployeeCode();
            $employee = Employee::create([
                'user_id'         => $user->id,
                'code'            => $employeeCode,
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'email'           => $validated['email'],
                'phone_number'    => $validated['phone_number'] ?? null,
                'national_id'     => $validated['national_id'] ?? null,
                'gender'          => $validated['gender'] ?? 'other',
                'birth_date'      => $validated['birth_date'] ?? null,
                'department_id'   => $departmentId,
                'position_id'     => $positionId,
                'basic_salary'    => $validated['basic_salary'] ?? 0,
                'join_date'       => $validated['join_date'] ?? now()->format('Y-m-d'),
                'is_active'       => true,
                'approval_status' => 'approved',
            ]);

            DB::commit();

            Log::info("External Recruitment: Hired {$user->full_name} via API.");

            return response()->json([
                'message' => 'Employee successfully integrated.',
                'data' => [
                    'user_id'       => $user->id,
                    'employee_id'   => $employee->id,
                    'employee_code' => $employee->code,
                    'temp_password' => $password, // Return this so Python can email it to the user
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("External Recruitment Failure: " . $e->getMessage());
            return response()->json([
                'message' => 'Integration failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateUserCode()
    {
        $last = User::orderBy('created_at', 'desc')->first();
        $n = $last ? ((int) substr($last->code, 4)) + 1 : 1;
        return 'USR-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function generateEmployeeCode()
    {
        $last = Employee::orderBy('created_at', 'desc')->first();
        $n = $last ? ((int) substr($last->code, 4)) + 1 : 1;
        return 'EMP-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function generateUsername($first, $last)
    {
        $base = strtolower($first . '.' . $last);
        $username = $base;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }
        return $username;
    }

    private function resolveOrCreateDepartment(string $departmentName): string
    {
        $name = trim($departmentName);
        $existing = Department::where('name', $name)->first();
        if ($existing) {
            return $existing->id;
        }

        $last = Department::orderBy('created_at', 'desc')->first();
        $next = 1;
        if ($last && !empty($last->code)) {
            $parts = explode('-', $last->code);
            $num = (int) end($parts);
            $next = $num + 1;
        }
        $code = 'DEP-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);

        $department = Department::create([
            'code' => $code,
            'name' => $name,
            'description' => 'Auto-created from external recruitment integration',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        return $department->id;
    }

    private function resolveOrCreatePosition(string $positionTitle, $basicSalary = null): string
    {
        $title = trim($positionTitle);
        $existing = Position::where('name', $title)->first();
        if ($existing) {
            return $existing->id;
        }

        $last = Position::orderBy('created_at', 'desc')->first();
        $next = 1;
        if ($last && !empty($last->code)) {
            $parts = explode('-', $last->code);
            $num = (int) end($parts);
            $next = $num + 1;
        }
        $code = 'POS-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);

        $salary = is_numeric($basicSalary) ? (float) $basicSalary : 0;

        $position = Position::create([
            'code' => $code,
            'name' => $title,
            'description' => 'Auto-created from external recruitment integration',
            'minimum_pay' => $salary,
            'maximum_pay' => $salary,
            'is_locked' => false,
            'approval_status' => 'approved',
        ]);

        return $position->id;
    }
}
