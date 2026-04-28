<?php
namespace App\Http\Controllers\Api;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentInvite;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    // List all assessments
    public function index()
    {
        $assessments = Assessment::orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $assessments]);
    }

    // Create new assessment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_id' => 'required|exists:jobs,id',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $assessment = Assessment::create($validated);
        return response()->json(['success' => true, 'assessment' => $assessment], 201);
    }

    // Add question to assessment
    public function addQuestion(Request $request, $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'nullable|integer|min:0',
        ]);
        $question = $assessment->questions()->create([
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'options' => $validated['options'] ?? [],
            'correct_answer' => $validated['correct_answer'] ?? null,
            'points' => $validated['points'] ?? 0,
        ]);
        return response()->json(['success' => true, 'question' => $question]);
    }

    // Generate invitation token for a job application
    public function generateInvite(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:job_applications,id',
            'assessment_id' => 'required|exists:assessments,id',
            'expires_at' => 'nullable|date',
        ]);
        $token = Str::random(32);
        $invite = AssessmentInvite::create([
            'application_id' => $validated['application_id'],
            'assessment_id' => $validated['assessment_id'],
            'token' => $token,
            'expires_at' => $validated['expires_at'] ?? null,
        ]);
        return response()->json(['success' => true, 'token' => $token, 'invite' => $invite]);
    }

    // Retrieve assessment details for a candidate via token
    public function getByToken($token)
    {
        $invite = AssessmentInvite::where('token', $token)->firstOrFail();
        $assessment = $invite->assessment;
        $questions = $assessment->questions()->orderBy('order_num')->get();
        return response()->json([
            'success' => true,
            'assessment' => $assessment,
            'questions' => $questions,
            'invite' => $invite,
        ]);
    }

    // Submit assessment results
    public function submitResults(Request $request, $token)
    {
        $invite = AssessmentInvite::where('token', $token)->firstOrFail();
        $validated = $request->validate([
            'score' => 'required|numeric',
            'max_score' => 'required|numeric',
            'answers' => 'required|array',
            'tab_switch_count' => 'nullable|integer',
            'cheating_flags' => 'nullable|array',
        ]);
        DB::transaction(function () use ($invite, $validated) {
            $result = $invite->assessmentResult()->updateOrCreate(
                ['invite_id' => $invite->id],
                [
                    'application_id' => $invite->application_id,
                    'assessment_id' => $invite->assessment_id,
                    'score' => $validated['score'],
                    'max_score' => $validated['max_score'],
                    'percentage' => $validated['max_score'] > 0 ? ($validated['score'] / $validated['max_score'] * 100) : 0,
                    'status' => 'completed',
                    'completed_at' => now(),
                    'answers' => json_encode($validated['answers']),
                    'cheating_flags' => json_encode($validated['cheating_flags'] ?? []),
                    'tab_switch_count' => $validated['tab_switch_count'] ?? 0,
                    'passed' => ($validated['max_score'] > 0 && $validated['score'] / $validated['max_score'] * 100) >= $invite->assessment->passing_score,
                ]
            );
            $invite->update(['status' => $result->passed ? 'passed' : 'failed']);
        });
        return response()->json(['success' => true, 'message' => 'Results saved']);
    }
    
    // Generate assessment questions from job description using simple AI placeholder
    public function generateFromDescription(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'question_count' => 'nullable|integer|min:1',
        ]);
        $sentences = preg_split('/(?<=[.?!])\s+/', $validated['description']);
        $count = $validated['question_count'] ?? min(5, count($sentences));
        $questions = [];
        for ($i = 0; $i < $count && $i < count($sentences); $i++) {
            $q = trim($sentences[$i]);
            if (substr($q, -1) !== '?') {
                $q .= '?';
            }
            $questions[] = [
                'question_text' => $q,
                'question_type' => 'open',
                'options' => [],
                'correct_answer' => null,
                'points' => 1,
            ];
        }
        return response()->json(['success' => true, 'questions' => $questions]);
    }
}
?>
