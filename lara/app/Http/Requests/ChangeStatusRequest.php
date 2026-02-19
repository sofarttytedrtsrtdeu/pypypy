<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && in_array($this->user()->role, ['jury', 'admin']);
    }

    public function rules()
    {
        return [
            'status' => 'required|in:submitted,needs_fix,accepted,rejected',
        ];
    }
}