<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * The URI that users should be redirected to if validation fails.
     *
     * @var string
     */
//    protected $redirect = '';

    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
//    protected $redirectRoute = '';

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
            'name' => ['required', 'min:2', 'max:50'],
            'last_name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'password' => 'sometimes',
            'birth_date' => 'required|date_format:Y-m-d|before:2015-12-31',
            'gender' => 'required|min:1|max:1|in:M,F,m,f',
        ];
    }
}
