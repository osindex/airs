<?php

namespace Zkuyuo\Airs\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
     * @author airs<zk_admin@163.com>
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|min:6|max:32',
            'password' => 'required|min:8|max:32|confirmed',
            'password_confirmation' => 'required|min:8|max:32'
        ];
    }
}