<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Logics\Employee\EmployeeLogic;
use App\DBTransactions\Employee\SaveEmployee;
use App\DBTransactions\Employee\DeleteEmployee;
use App\DBTransactions\Employee\UpdateEmployee;
use App\Http\Requests\Employee\EmployeeInfoSaveRequest;
use App\Interfaces\Employee\EmployeeRepositoryInterface;
use App\Http\Requests\Employee\EmployeeRegisterValidation;

/**
 * To manage employee data
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
class EmployeeController extends Controller
{
    protected $employeeRepo, $empLogic;

    /**
     * Constructor to assign interface to variable
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @param   interface, class
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepo, EmployeeLogic $empLogic)
    {
        $this->employeeRepo = $employeeRepo;
        $this->empLogic     = $empLogic;
    }

    /**
     * Store a newly created resource in `system`.
     *
     * @author PhyoNaing Htun
     * @create 2022/06/08
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerEmployee(EmployeeRegisterValidation $request)
    {
        # save employee
        $process = new SaveEmployee($request);
        $save = $process->executeProcess();

        # check save process is success or not
        if ($save) {
            return response()->json(['status' => 'OK', 'message' => trans('messages.SS0001')], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0002')], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @author PhyoNaing Htun
     * @create 2022/06/08
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailEmployee($id)
    {
        # check user selected id is exists or not in `employees` table
        $checkExist = $this->employeeRepo->checkExistEmployee($id);

        if ($checkExist) {
            $data = $this->employeeRepo->getEmployeeDetail($id);
            return response()->json(['status' => 'OK', 'data' => $data], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0006')], 200);
        }
    }

    /**
     * Update the specified resource in system.
     *
     * @author PhyoNaing Htun
     * @create 2022/06/08
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(EmployeeInfoSaveRequest $request, $id)
    {
        # check user selected id is exists or not in `employees` table
        $checkEmpExist = $this->employeeRepo->checkExistEmployee($id);

        if ($checkEmpExist) {
            $process = new UpdateEmployee($request, $id);
            $result = $process->executeProcess();
            # check update process is success or not
            if ($result) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0002')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0003')], 200);
            }
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0006')], 200);
        }
    }

    /**
     * Remove the specified resource from system.
     *
     * @author PhyoNaing Htun
     * @create 2022/06/08
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployee($id)
    {
        $checkExist = $this->employeeRepo->checkExistEmployee($id);

        if ($checkExist) {        
            $process = new DeleteEmployee($id);
            $result = $process->executeProcess();
            # check save process is success or not
            if ($result) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0003')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0004')], 200);
            }
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0006')], 200);
        }
    }

    /**
     * Search employee data
     * 
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @param   Request object
     * @return  \Illuminate\Http\Response
     */
    public function searchEmployee(Request $request)
    {
        if(!empty($request->employee_id)){ // search with employee_id
            $request->employee_id = $request->employee_id - 1000; //subtract 1000 to get real employee id
        }
        $result = $this->employeeRepo->getEmployeeData($request);
        $result = $result->toArray();
        if($result['total'] > 0){
            $result['status'] = 'OK';
            return response()->json($result, 200);
        }else{
            return response()->json(['status' => 'NG', 'message' => 'Search Data Not Found!'], 200);
        }
    }
}
