<?php

namespace Osi\Airs\Http\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'guard_name' => 'required|max:255'
        ];

        return $rules;
    }
}