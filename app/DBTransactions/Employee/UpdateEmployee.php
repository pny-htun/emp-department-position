<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Models\EmpDepPos;
use App\Classes\DBTransaction;

class UpdateEmployee extends DBTransaction
{
    private $request, $employeeId;

    /**
     * Constructor to assign to variable
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @param   object $request, int $employeeId
     */
    public function __construct($request, $employeeId)
    {
        $this->request = $request;
        $this->employeeId = $employeeId;
    }

    /**
     * To update employee, department, position data in `employees, emp_dep_pos` tables
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @return  boolean
     */
    public function process()
    {
        $empId = $this->employeeId;
        $empRes = Employee::where('employee_id', $empId)
                            ->update([
                                'name' => $this->request->name,
                                'email' => $this->request->email,
                                'gender' => $this->request->gender,
                                'updated_emp' => 10001,
                                'updated_at' => now()
                            ]);
        # check row affected or not
        if ($empRes) {
            # delete old department and position data of employee
            EmpDepPos::where('employee_id', $empId)->delete();

            # check department and position pair is exists or not
            if (!empty($this->request->dept_pos_id)) {
                $collections = collect($this->request->dept_pos_id);

                $empDeptPos = [];
                # prepare array to save
                $result = $collections->map(function ($value) use ($empDeptPos, $empId) {
                    $empDeptPos = [
                        "employee_id" => $empId,
                        "dep_pos_id"  => $value,
                        "created_emp" => 10001,
                        "updated_emp" => 10001
                    ];
                    return $empDeptPos;
                });
                EmpDepPos::insert($result->all()); # insert employee department position
            }
            return ['status' => true, 'error' => ''];
        } else {
            return ['status' => false, 'error' => trans('messages.SE0003')];
        }
    }
}
