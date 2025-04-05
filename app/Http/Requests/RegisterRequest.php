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
        return true; // Cho phép tất cả người dùng thực hiện yêu cầu này
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255', // Thêm trường last_name
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:8|max:15', // Thêm trường phone
            'address' => 'required|string|min:3|max:255', // Thêm trường address
            'password' => 'required|string|min:4|confirmed', // Sửa min:4 thành min:8
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên.',
            'last_name.required' => 'Bạn chưa nhập họ.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.email' => 'Email không hợp lệ. Ví dụ: abc@gmail.com.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
            'phone.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',
            'address.required' => 'Bạn chưa nhập địa chỉ.',
            'address.min' => 'Địa chỉ phải có ít nhất 3 ký tự.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
            'password.confirmed' => 'Mật khẩu không khớp.',
        ];
    }
}