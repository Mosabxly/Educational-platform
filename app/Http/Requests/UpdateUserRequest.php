<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   
    
    public function rules(): array
    {

        $id = $this->route('id');
        return [
            'name' => 'sometimes|required|string|max:100|min:10',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|required|string|min:6',
            'role' => 'sometimes|required|in:admin,student,instructor',
            'major' => 'sometimes|nullable|string|max:100',

        ];
    }
}
