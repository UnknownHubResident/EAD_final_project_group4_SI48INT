<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScholarshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'scholar_provider']);
    }

    public function rules(): array
    {   
        $scholarship = $this->route('scholarship');

        $scholarshipid = $scholarship ? $scholarship->id : null;

        return [
            'title' => 'required|string|max:255|unique:scholarships,title,' . $scholarshipid,
            'provider' => 'nullable|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'delete_image' => 'nullable|boolean',
        ];
    }
}
