<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Attachment;
use App\Services\AttachmentService;
use App\Http\Requests\UploadAttachmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller  // Убедитесь, что наследуется от Controller
{
    protected $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function upload(UploadAttachmentRequest $request, Submission $submission)
    {
        if (Auth::id() !== $submission->user_id || !in_array($submission->status, ['draft', 'needs_fix'])) {
            abort(403);
        }

        try {
            $attachment = $this->attachmentService->upload($submission, Auth::user(), $request->file('file'));
            return back()->with('success', 'Файл загружен, запущена проверка.');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => $e->getMessage()]);
        }
    }

    public function download(Attachment $attachment)
    {
        // Используем Gate или Policy напрямую вместо authorize()
        if (Auth::user()->cannot('view', $attachment)) {
            abort(403);
        }
        
        // Для локального хранилища
        return Storage::disk('public')->download($attachment->storage_key, $attachment->original_name);
    }

    public function destroy(Attachment $attachment)
    {
        if (Auth::user()->cannot('delete', $attachment)) {
            abort(403);
        }
        
        Storage::disk('public')->delete($attachment->storage_key);
        $attachment->delete();
        
        return back()->with('success', 'Файл удалён.');
    }

    public function checkStatus(Attachment $attachment)
    {
        if (Auth::user()->cannot('view', $attachment)) {
            abort(403);
        }
        
        return response()->json([
            'status' => $attachment->status,
            'rejection_reason' => $attachment->rejection_reason
        ]);
    }
}