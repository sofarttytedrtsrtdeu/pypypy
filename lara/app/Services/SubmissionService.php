<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\User;
use App\Models\SubmissionComment;
use App\Jobs\NotifyStatusChangedJob;
use Illuminate\Support\Facades\DB;

class SubmissionService
{
    public function createSubmission(array $data, User $user)
    {
        return Submission::create([
            'contest_id' => $data['contest_id'],
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'draft',
        ]);
    }

    public function updateSubmission(Submission $submission, array $data)
    {
        if (!in_array($submission->status, ['draft', 'needs_fix'])) {
            throw new \Exception('Редактирование запрещено для текущего статуса.');
        }
        $submission->update($data);
        return $submission;
    }

    public function submit(Submission $submission)
    {
        if (!in_array($submission->status, ['draft', 'needs_fix'])) {
            throw new \Exception('Нельзя отправить работу в текущем статусе.');
        }
        // Проверяем наличие хотя бы одного attachment со статусом scanned
        $hasScanned = $submission->attachments()->where('status', 'scanned')->exists();
        if (!$hasScanned) {
            throw new \Exception('Необходимо загрузить хотя бы один проверенный файл.');
        }
        $submission->update(['status' => 'submitted']);
        // Диспатчим уведомление о смене статуса
        NotifyStatusChangedJob::dispatch($submission);
        return $submission;
    }

    public function changeStatus(Submission $submission, string $newStatus, User $user)
    {
        // Определим допустимые переходы (можно вынести в конфиг)
        $allowedTransitions = [
            'draft' => ['submitted'],
            'submitted' => ['needs_fix', 'accepted', 'rejected'],
            'needs_fix' => ['submitted', 'accepted', 'rejected'],
            'accepted' => [],
            'rejected' => [],
        ];
        if (!in_array($newStatus, $allowedTransitions[$submission->status] ?? [])) {
            throw new \Exception('Недопустимый переход статуса.');
        }
        $submission->update(['status' => $newStatus]);
        // Диспатчим уведомление
        NotifyStatusChangedJob::dispatch($submission, $user);
        return $submission;
    }

    public function addComment(Submission $submission, User $user, string $body)
    {
        return SubmissionComment::create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'body' => $body,
        ]);
    }
}