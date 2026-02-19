<?php

namespace App\Jobs;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyStatusChangedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $submission;
    protected $changer; // пользователь, изменивший статус

    public function __construct(Submission $submission, User $changer = null)
    {
        $this->submission = $submission;
        $this->changer = $changer;
    }

    public function handle()
    {
        // Здесь можно отправить email, запись в лог или в отдельную таблицу
        Log::info("Статус заявки #{$this->submission->id} изменён на {$this->submission->status} пользователем " . ($this->changer->name ?? 'система'));
    }
}