<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends UserRequest
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
        // Verkrijg het id van de huidige gebruiker via route model binding of route parameter
        $userId = $this->route('user') ? $this->route('user')->id : $this->route('id');

        return array_merge(parent::rules(), [
            'email'    => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|min:6',
        ]);
    }
    public function messages()
    {
        return array_merge(parent::messages(), [
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.min' => 'Het wachtwoord moet minimaal :min tekens bevatten.',
        ]);
    }
}
