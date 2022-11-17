<?php

namespace Zkuyuo\Airs\Http\Requests\Menu;


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
        return [
            'parent_id' => 'required|numeric',
            'name' => 'required',
            'guard_name' => 'required',
            'is_link' => 'in:0,1',
            'uri' => 'required'
        ];
    }
}