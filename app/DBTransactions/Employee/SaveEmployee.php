<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Models\EmpDepPos;
use App\Classes\DBTransaction;
use App\Models\EmployeePassword;
use Illuminate\Support\Facades\Hash;

/**
 * To save new employee in `employees`, `employee_passwords` and `emp_dep_pos` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/09
 */
class SaveEmployee extends DBTransaction
{
    private $request;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
	 * Save Employee
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @return  array
	 */
    public function process()
    {
        $maxEmpId = Employee::max('employee_id') + 1; # get maximum id
        $employees = new Employee();
        $employees->employee_id = $maxEmpId;
        $employees->name = $this->request->name;
        $employees->email = $this->request->email;
        $employees->gender = $this->request->gender;
        $employees->created_emp = 10001;
        $employees->updated_emp = 10001;
        $employees->save(); # insert employee

        $empPassword = new EmployeePassword();
        $empPassword->employee_id = $maxEmpId;
        $empPassword->password = Hash::make($this->request->password);
        $empPassword->confirm_password = Hash::make($this->request->confirm_password);
        $empPassword->created_emp = 10001;
        $empPassword->updated_emp = 10001;
        $empPassword->save(); # insert employee password

        # check department and position id is exists or not
        if (!empty($this->request->dept_pos_id)) {

            $collections = collect($this->request->dept_pos_id);

            $empDeptPos = [];
            # prepare array to save
            $result = $collections->map(function ($value) use ($empDeptPos, $maxEmpId) {
                $empDeptPos = [
                    "employee_id" => $maxEmpId,
                    "dep_pos_id"  => $value,
                    "created_emp" => 10001,
                    "updated_emp" => 10001
                ];
                return $empDeptPos;
            });
            EmpDepPos::insert($result->all()); # insert employee department position
        }
        return ['status' => true, 'error' => ''];
    }
}
