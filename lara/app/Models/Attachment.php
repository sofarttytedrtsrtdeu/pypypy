<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'submission_id', 'user_id', 'original_name', 'mime', 'size', 'storage_key', 'status', 'rejection_reason'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}