<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Submission;
use App\Models\User;
use App\Jobs\ScanAttachmentJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    public function upload(Submission $submission, User $user, UploadedFile $file)
    {
        if ($submission->attachments()->count() >= 3) {
        throw new \Exception('Нельзя загрузить более 3 файлов.');
    }

    // Для локального хранения
    $path = $file->store('submissions/' . $submission->id, 'public');
    
    $attachment = Attachment::create([
        'submission_id' => $submission->id,
        'user_id' => $user->id,
        'original_name' => $file->getClientOriginalName(),
        'mime' => $file->getMimeType(),
        'size' => $file->getSize(),
        'storage_key' => $path,
        'status' => 'pending',
    ]);

    ScanAttachmentJob::dispatch($attachment);
    return $attachment;
    }

    public function markScanned(Attachment $attachment)
    {
        $attachment->update(['status' => 'scanned', 'rejection_reason' => null]);
    }

    public function reject(Attachment $attachment, string $reason)
    {
        $attachment->update(['status' => 'rejected', 'rejection_reason' => $reason]);
    }
}