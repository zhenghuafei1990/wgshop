<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|regex:/^\w{4,12}$/',
            'password' => 'required|regex:/^\S{4,12}$/',
            'repass'   => 'same:password',
        ];
    }
    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '用户名称不能为空',
            'password.required'  => '用户密码不能为空',
            'username.regex'  => '用户名称格式不正确',
            'password.regex'  => '用户密码格式不正确',
            'repass.same'   =>'两次密码不一致',
        ];
    }
}
