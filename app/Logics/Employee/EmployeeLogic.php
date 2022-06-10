<?php
namespace App\Logics\Employee;

class EmployeeLogic
{
    /**
     * Preapare an employee department position data to save
     * @author  Zar Ni Win
     * @create  2022/06/09
     * @return  array
     */
    public function prepareEmpPosData($empId,$request)
    {
        # employee data to save
        $result = [];
        $result['employee_id'] = $empId;
        if(!empty($empId)){
            $result['employeeData']['name'] = $request->employee_name;
        }
        if(!empty($request->email)){
            $result['employeeData']['email'] = $request->email;
        }
        if(!empty($request->gender)){
            $result['employeeData']['gender'] = $request->gender;
        }
        # employee department position data to save
        if(!empty($request->dep_pos_id)){
            $depPosArr      = $request->dep_pos_id;
            $empDepPosArr   = [];
            foreach($depPosArr as $depPos){
                $empDepPos[ 'employee_id'] = $empId;
                $empDepPos[ 'dep_pos_id']  = $depPos;
                $empDepPos[ 'created_emp'] = 1000;
                $empDepPos[ 'updated_emp'] = 1000;
                array_push($empDepPosArr,$empDepPos);
            }
            $result['empDepPosData'] = $empDepPosArr;
        }
        return $result;
    }
}