<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attachment;

class AttachmentPolicy
{
    public function view(User $user, Attachment $attachment)
    {
        // Владелец, жюри или админ могут скачивать
        return $user->id === $attachment->user_id || in_array($user->role, ['jury', 'admin']);
    }

    public function delete(User $user, Attachment $attachment)
    {
        // Только владелец и файл не в статусе scanned
        return $user->id === $attachment->user_id && $attachment->status !== 'scanned';
    }
}