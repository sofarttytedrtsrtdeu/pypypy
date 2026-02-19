<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['contest_id', 'user_id', 'title', 'description', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(SubmissionComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}