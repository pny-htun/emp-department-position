<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * To validate the request for save function of employee
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/09
 */
class EmployeeRegisterValidation extends FormRequest
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
     * @create  2022/06/09
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:100",
            "email" => "required|email|unique:employees,email|max:200",
            "gender" => "required|integer|max:2",
            "password" => "required|max:100",
            "confirm_password" => "required|same:password|max:100"
        ];
    }

    /**
     * Return when validation failed
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @return  response array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => 'NG', 'message' => $validator->errors()->all()], 422));
    }
}
