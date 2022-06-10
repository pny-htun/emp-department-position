<?php

namespace App\Http\Requests\DepartmentPosition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * To validate request for update function of department
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/07
 */
class DepartmentUpdateValidation extends FormRequest
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
     * @author  PhyoNaing Htun
     * @create  2022/06/06
     * @return array
     */
    public function rules()
    {
        return [
            "department_id" => "required|integer|exists:departments,id",
            "department_name" => "required|string|max:100|min:5|unique:departments,name,{$this->department_id},id,deleted_at,NULL"
        ];
    }

    /**
     * Return when validation failed
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/06
     * @return  response array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => 'NG', 'message' => $validator->errors()->all()], 422));
    }
}
