<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\SubmissionService;
use App\Http\Requests\AddCommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $submissionService;

    public function __construct(SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    public function store(AddCommentRequest $request, Submission $submission)
    {
        // Проверка: может ли пользователь комментировать (участник свою, жюри любую)
        $user = Auth::user();
        if ($user->role === 'participant' && $submission->user_id !== $user->id) {
            abort(403);
        }
        $this->submissionService->addComment($submission, $user, $request->body);
        return back()->with('success', 'Комментарий добавлен.');
    }
}