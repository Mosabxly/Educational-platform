<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'     => 'required|string|max:225',
            'email'    => 'required|email|unique:users,email',  // يجب أن يكون البريد فريد
            'password' => 'required|string|min:6|confirmed', // تأكيد كلمة المرور مطلوب
            'role'     => 'required|in:admin,student,instructor',
            'major'    => 'nullable|string|max:255', // ← هذا السطر الجديد

        ];
    }
}
