<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages():array{
        return[
            'email.required' => 'Không được để trống email',
            'email.email' => 'Email không đúng định dạng ',
            'email.exists'=> 'Email chưa được đăng ký',
            'password.required'=>'Không được để trống password',
            'password.string'=> 'Password không phải là chuỗi',
            'password.min'=> 'Password phải trên 8 ký tự'
        ];
    }
}
