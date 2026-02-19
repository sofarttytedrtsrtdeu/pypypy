<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Contest;
use App\Services\SubmissionService;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Http\Requests\ChangeStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    protected $submissionService;

    public function __construct(SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'participant') {
            $submissions = Submission::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $submissions = Submission::with('user', 'contest')->latest()->paginate(10);
        }
        return view('submissions.index', compact('submissions'));
    }

    public function create()
    {
        $contests = \App\Models\Contest::where('is_active', true)->get();
        return view('submissions.create', compact('contests'));
    }

    public function store(StoreSubmissionRequest $request)
    {
        $submission = $this->submissionService->createSubmission($request->validated(), Auth::user());
        return redirect()->route('submissions.show', $submission)->with('success', 'Черновик создан.');
    }

    public function show(Submission $submission)
    {
        // Загружаем комментарии с пользователями и файлы
        $submission->load('comments.user', 'attachments');
        return view('submissions.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        // Политика уже проверила право на редактирование
        return view('submissions.edit', compact('submission'));
    }

    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $this->submissionService->updateSubmission($submission, $request->validated());
        return redirect()->route('submissions.show', $submission)->with('success', 'Работа обновлена.');
    }

    public function submit(Submission $submission)
    {
        try {
            $this->submissionService->submit($submission);
            return redirect()->route('submissions.show', $submission)->with('success', 'Работа отправлена на проверку.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function changeStatus(ChangeStatusRequest $request, Submission $submission)
    {
        try {
            $this->submissionService->changeStatus($submission, $request->status, Auth::user());
            return redirect()->route('submissions.show', $submission)->with('success', 'Статус изменён.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}