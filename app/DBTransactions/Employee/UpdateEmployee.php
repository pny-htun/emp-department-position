<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Models\EmpDepPos;
use App\Classes\DBTransaction;

class UpdateEmployee extends DBTransaction
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * To update employee, department, position data in `employees, emp_dep_pos` tables
     *
     * @author  Zar Ni Win
     * @create  2022/06/09
     * @return array
     */
    public function process()
    {
        $empRes = Employee::where('id',$this->request['employee_id'])
                            ->update($this->request['employeeData']);
        $edpSaveRes = true;
        if(!empty($this->request['empDepPosData'])){
            $edpDelRes = EmpDepPos::where('employee_id',$this->request['employee_id'])
                                    ->delete();
            
            if($edpDelRes){
                $edpSaveRes = EmpDepPos::insert($this->request['empDepPosData']);
            }                
        }        
        if(!$empRes){
            return ['status' => false, 'error' => 'Employee Update Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}