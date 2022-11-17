<?php

namespace Zkuyuo\Airs\Http\Requests\Permission;


use Illuminate\Foundation\Http\FormRequest;
use Zkuyuo\Airs\AdminUserFactory;

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
            'guard_name' => 'required|max:255',
            'display_name' => 'required:max:50',
            'pg_id' => 'required|numeric',
            'sequence' => 'numeric'
        ];

        return $rules;
    }
}