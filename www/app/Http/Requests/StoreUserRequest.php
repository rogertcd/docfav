<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'birth_date' => 'required|date_format:Y-m-d|before:2015-12-31',
            'gender' => 'required|min:1|max:1|in:M,F,m,f',
        ];
    }
}
