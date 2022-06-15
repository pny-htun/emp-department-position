<?php
namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Models\EmpDepPos;
use App\Classes\DBTransaction;
use App\Models\EmployeePassword;

class DeleteEmployee extends DBTransaction
{
    private $id;

    /**
     * Constructor to assign to variable
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @param   int $employeeId
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * To delete employee, employee password department, position data in `employees`, `employee_passwords` and `emp_dep_pos` tables
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @return  boolean
     */
    public function process()
    {
        Employee::where('employee_id', $this->id)->delete();
        EmployeePassword::where('employee_id', $this->id)->delete();
        EmpDepPos::where('employee_id', $this->id)->delete();

        return ['status' => true, 'error' => ''];
    }
}
