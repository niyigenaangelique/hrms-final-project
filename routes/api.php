<?php

use App\Http\Controllers\Api\AssessmentController;
use App\Http\Controllers\Api\ExternalRecruitmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Department;
use App\Models\Position;
use App\Models\Shift;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/attendances', [AttendanceController::class, 'index']);
Route::post('/assessments/generate-questions', [AssessmentController::class, 'generateFromDescription']);

// External AI Recruitment Integration
Route::post('/external-recruitment/hire', [ExternalRecruitmentController::class, 'store']);

// HRMS metadata for recruitment portal (token-protected)
Route::get('/external-recruitment/metadata', function (Request $request) {
    $token = (string) $request->header('X-Recruitment-Token', '');
    if ($token === '' || !hash_equals((string) env('TALENTFLOW_HRMS_TOKEN', ''), $token)) {
        return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
    }

    $departments = Department::query()->orderBy('name')->get(['id','name'])->toArray();
    $positions   = Position::query()->orderBy('name')->get(['id','name'])->toArray();
    $shifts      = Shift::query()->orderBy('name')->get(['id','name'])->toArray();

    return response()->json([
        'success' => true,
        'departments' => $departments,
        'positions'   => $positions,
        'shifts'      => $shifts,
    ]);
});
