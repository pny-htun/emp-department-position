<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\DBTransactions\Employee\SaveEmployee;
use App\Logics\Employee\EmployeeLogic;
use App\DBTransactions\Employee\DeleteEmployee;
use App\DBTransactions\Employee\UpdateEmployee;
use App\Http\Requests\Employee\EmployeeInfoSaveRequest;
use App\Interfaces\Employee\EmployeeRepositoryInterface;
use App\Http\Requests\Employee\EmployeeRegisterValidation;

class EmployeeController extends Controller
{
    protected $employeeRepo, $empLogic;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailEmployee($id)
    {
        $empId = $id - 1000; //subtract 1000 to get real employee id
        $checkExist = $this->employeeRepo->checkExistEmployee($empId);

        if($checkExist){
            $data = $this->employeeRepo->getEmployeeDetail($empId);
            return response()->json(['status' => 'OK', 'data' => $data], 200);
        }else{
            return response()->json(['status' => 'NG', 'message' => 'Employee ID '.$id.' Data Not Found!'], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(EmployeeInfoSaveRequest $request, $id)
    {
        $empId = $id - 1000; //subtract 1000 to get real employee id
        $checkEmpExist      = $this->employeeRepo->checkExistEmployee($empId);
        $checkDepPosExist   = $this->employeeRepo->checkExistDepPos($empId);
        if($checkEmpExist && $checkDepPosExist){     
            $updateData = $this->empLogic->prepareEmpPosData($empId,$request);
            $process    = new UpdateEmployee($updateData);
            $result     = $process->executeProcess();
            # check update process is success or not
            if ($result) {
                return response()->json(['status' => 'OK', 'message' => 'Successfully Updated!'], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => 'Fail to update!'], 200);
            }
        }else{
            return response()->json(['status' => 'NG', 'message' => 'Employee ID '.$id.' Data Not Found!'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployee($id)
    {
        $empId = $id - 1000; //subtract 1000 to get real employee id
        $checkExist = $this->employeeRepo->checkExistEmployee($empId);
        if($checkExist){        
            $process    = new DeleteEmployee($empId);
            $result     = $process->executeProcess();
            # check save process is success or not
            if ($result) {
                return response()->json(['status' => 'OK', 'message' => 'Successfully Deleted!'], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => 'Fail to delete!'], 200);
            }
        }else{
            return response()->json(['status' => 'NG', 'message' => 'Employee ID '.$id.' Data Not Found!'], 200);
        }
    }

    /**
     * Search employee data
     * @author  Zar Ni Win
     * @create  2022/06/08
     * @param   Request object
     * @return \Illuminate\Http\Response
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
