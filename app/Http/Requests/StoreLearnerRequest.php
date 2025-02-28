<?php

namespace App\Http\Requests;

use App\Enums\PersonGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreLearnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required','string:128'],
            'last_name' => ['required','string:128'],
            'birth_date' => ['required','date'],
            'gender' => ['required',new Enum(PersonGender::class)],
        ];
    }
}
