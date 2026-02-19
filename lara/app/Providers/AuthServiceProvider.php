<?php

namespace App\Providers;

use App\Models\Submission;
use App\Models\Attachment;
use App\Policies\SubmissionPolicy;
use App\Policies\AttachmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Submission::class => SubmissionPolicy::class,
        Attachment::class => AttachmentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}