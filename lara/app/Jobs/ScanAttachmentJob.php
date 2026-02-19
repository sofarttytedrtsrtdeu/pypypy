<?php

namespace App\Jobs;

use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScanAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $attachment;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    public function handle(AttachmentService $attachmentService)
    {
        // Повторная проверка (на всякий случай)
        $allowedMimes = ['application/pdf', 'application/zip', 'image/png', 'image/jpeg'];
        $maxSize = 10 * 1024 * 1024; // 10 MB

        $reason = null;
        if (!in_array($this->attachment->mime, $allowedMimes)) {
            $reason = 'Недопустимый тип файла.';
        } elseif ($this->attachment->size > $maxSize) {
            $reason = 'Размер файла превышает 10 МБ.';
        }

        // Дополнительно можно проверить имя на вредоносные символы
        if (preg_match('/[^a-zA-Z0-9._-]/', $this->attachment->original_name)) {
            $reason = 'Имя файла содержит недопустимые символы.';
        }

        if ($reason) {
            $attachmentService->reject($this->attachment, $reason);
        } else {
            $attachmentService->markScanned($this->attachment);
        }
    }
}