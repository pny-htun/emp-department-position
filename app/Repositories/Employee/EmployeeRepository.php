<?php
namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\EmpDepPos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Employee\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * Get employee data
     * @author  Zar Ni Win
     * @create  2022/06/08
     * @param   Request object
     * @return  array
     */
    public function getEmployeeData($search='')
    {
        $empData = new Employee; //invoke Employee
        if(!empty($search->employee_id)){ // search with employee_id
            $empData = $empData->where('id',$search->employee_id);
        }
        if(!empty($search->employee_name)){ // search with employee_name
            $empData = $empData->where('name',$search->employee_name);
        } 
        if(!empty($search->department_id) || !empty($search->position_id)){
            if(!empty($search->department_id)){
                $empData = $empData->whereHas('employeeDepPos.department',function($query) use($search){ //search with department data
                                        $query->where('department_id',$search->department_id);
                                    });
            }
            if(!empty($search->position_id)){ 
                $empData = $empData->whereHas('employeeDepPos.position',function($query) use($search){ //search with position
                                        $query->where('position_id',$search->position_id);
                                    });
            }
        }
        $empData = $empData ->with([
                                'employeeDepPos' => function($query) use($search){ //get employee, department, position data by joint data                                
                                    $query->whereNull('emp_dep_pos.deleted_at');
                                    if(!empty($search->department_id)){ // search with department
                                        $query->where('department_id',$search->department_id);
                                    }     
                                    if(!empty($search->position_id)){// search with position
                                        $query->where('position_id',$search->position_id);
                                    }                            
                                    $query ->select('department_id','position_id')->get();
                                },
                                'employeeDepPos.department' =>function($query){ //get department data
                                    $query ->whereNull('departments.deleted_at');
                                    $query ->select('departments.id','departments.name')->get();
                                },
                                'employeeDepPos.position' =>function($query){ //get position data
                                    $query ->whereNull('positions.deleted_at');
                                    $query ->select('positions.id','positions.name')->get();
                                }
                            ]) 
                            ->select('*')                                    
                            ->selectRaw('employees.id + ? as emp_id', [1000])  //to show employee_id + 1000                       
                            ->paginate(10);
        return $empData;
    }

    /**
     * Get an employee detail data by employee id
     * 
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @param   integer $id
     * @return  array
     */
    public function getEmployeeDetail($id)
    {
        $empData = Employee::where('employee_id', $id)->select('employee_id', 'name', 'email', 'gender')->first();

        $deptPosData = EmpDepPos::leftJoin('dep_pos', 'emp_dep_pos.dep_pos_id', 'dep_pos.id')
            ->leftJoin('departments', 'dep_pos.department_id', 'departments.id')
            ->leftJoin('positions', 'dep_pos.position_id', 'positions.id')
            ->where('emp_dep_pos.employee_id', $id)
            ->select(
                'dep_pos.id as dep_pos_id',
                'departments.id as department_id',
                'departments.name as department_name',
                'positions.id as position_id',
                'positions.name as position_name'
            )->get();

        $empData->dept_pos_data = $deptPosData;
        return $empData;
    }

    /**
     * Check employee id is exists or not in `employees` table
     * 
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @param   integer $id
     * @return  boolean
     */
    public function checkExistEmployee($id)
    {
        return Employee::where('employee_id', $id)->exists();
    }
}