<?php

namespace App\Http\Controllers\DepartmentPosition;

use App\Models\DepPos;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\DepartmentPositionTrait;
use App\DBTransactions\DepartmentPosition\SavePosition;
use App\DBTransactions\DepartmentPosition\DeletePosition;
use App\DBTransactions\DepartmentPosition\SaveDepartment;
use App\DBTransactions\DepartmentPosition\UpdatePosition;
use App\DBTransactions\DepartmentPosition\DeleteDepartment;
use App\DBTransactions\DepartmentPosition\UpdateDepartment;
use App\Http\Requests\DepartmentPosition\PositionValidation;
use App\Http\Requests\DepartmentPosition\DepartmentValidation;
use App\DBTransactions\DepartmentPosition\SaveDepartmentPosition;
use App\Http\Requests\DepartmentPosition\PositionDeleteValidation;
use App\Http\Requests\DepartmentPosition\PositionUpdateValidation;
use App\Interfaces\DepartmentPosition\DepartmentPositionInterface;
use App\DBTransactions\DepartmentPosition\DeleteDepartmentPosition;
use App\Http\Requests\DepartmentPosition\DepartmentDeleteValidation;
use App\Http\Requests\DepartmentPosition\DepartmentUpdateValidation;
use App\Http\Requests\DepartmentPosition\DeptPositionSaveValidation;
use App\Models\EmpDepPos;

/**
 * To manage department and position data
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/07
 */
class DepartmentPositionRegistrationController extends Controller
{
    use DepartmentPositionTrait;
    protected $deptPosRepo;

    /**
     * Constructor to assign interface to variable
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @param   interface, class
     */
    public function __construct(DepartmentPositionInterface $deptPosRepo) {
        $this->deptPosRepo = $deptPosRepo;
    }

    /**
     * Get all department names
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @return  Response object
     */
    public function getAllDepartments()
    {
        # get all department names from `departments` table
        return response()->json(['status' => 'OK', 'data' => $this->getDepartments()], 200);
    }

    /**
     * Save department
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function createDepartment(DepartmentValidation $request)
    {
        $process = new SaveDepartment($request);
        $save = $process->executeProcess();

        # check save process is success or not
        if ($save) {
            return response()->json(['status' => 'OK', 'message' => trans('messages.SS0001')], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0002')], 200);
        }
    }

    /**
     * Update department
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function updateDepartment(DepartmentUpdateValidation $request)
    {
        # check department is exists or not in `departments` table
        $isExists = Department::where('id', $request->department_id)->exists();

        # check exists or not
        if ($isExists) {
            $process = new UpdateDepartment($request);
            $update = $process->executeProcess();

            # check update process is success or not
            if ($update) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0002')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0003')], 200);
            }

        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
        }
    }

    /**
     * Delete department
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function deleteDepartment(DepartmentDeleteValidation $request)
    {
        # check department is exists or not in `departments` table
        $isExists = Department::where('id', $request->department_id)->exists();

        # check department and position pair is exists or not in `dep_pos` table
        $checkPair = DepPos::where('department_id', $request->department_id)->exists();

        if ($checkPair) { # check pair is exists or not
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0007')], 200);
        }

        # check exists or not
        if ($isExists) {
            $process = new DeleteDepartment($request);
            $delete = $process->executeProcess();

            # check delete process is success or not
            if ($delete) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0003')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0004')], 200);
            }

        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
        }
    }

    /**
     * Get all position names
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @return  Response object
     */
    public function getAllPositions()
    {
        # get all position names from `departments` table
        return response()->json(['status' => 'OK', 'data' => $this->getPositions()], 200);
    }

    /**
     * Save position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function createPosition(PositionValidation $request)
    {
        $process = new SavePosition($request);
        $save = $process->executeProcess();

        # check save process is success or not
        if ($save) {
            return response()->json(['status' => 'OK', 'message' => trans('messages.SS0001')], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0002')], 200);
        }
    }

    /**
     * Update position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function updatePosition(PositionUpdateValidation $request)
    {
        # check position is exists or not in `positions` table
        $isExists = Position::where('id', $request->position_id)->exists();

        # check exists or not
        if ($isExists) {
            $process = new UpdatePosition($request);
            $update = $process->executeProcess();

            # check update process is success or not
            if ($update) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0002')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0003')], 200);
            }

        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
        }
    }

    /**
     * Delete position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function deletePosition(PositionDeleteValidation $request)
    {
        # check position is exists or not in `positions` table
        $isExists = Position::where('id', $request->position_id)->exists();

        # check position and department pair is exists or not in `dep_pos` table
        $checkPair = DepPos::where('position_id', $request->position_id)->exists();

        if ($checkPair) { # check pair is exists or not
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0008')], 200);
        }

        # check exists or not
        if ($isExists) {
            $process = new DeletePosition($request);
            $delete = $process->executeProcess();

            # check delete process is success or not
            if ($delete) {
                return response()->json(['status' => 'OK', 'message' => trans('messages.SS0003')], 200);
            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0004')], 200);
            }

        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
        }
    }

    /**
     * Get all department and position pair
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function getDeptPosition()
    {
        # get department and postion pair
        $deptPos = $this->deptPosRepo->getDepartmentPosition();
        
        return response()->json(['status' => 'OK', 'data' => $deptPos], 200);
    }

    /**
     * Save department and position pair
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @param   Request object
     * @return  Response object
     */
    public function createDeptPosition(DeptPositionSaveValidation $request)
    {
        # check department and position pair is already existed in system
        $isExists = DepPos::where('department_id', $request->department_id)->where('position_id', $request->position_id)->exists();

        if ($isExists) { # check pair is exists or not
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0009')], 200);
        }
        # save department and position pair
        $process = new SaveDepartmentPosition($request);
        $save = $process->executeProcess();

        # check save process is success or not
        if ($save) {
            return response()->json(['status' => 'OK', 'message' => trans('messages.SS0001')], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0002')], 200);
        }
    }

    /**
     * Delete department and position pair
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @param   Request object
     * @return  Response object
     */
    public function destoryDeptPosition($id)
    {
        # check id is exists or not
        if (!empty($id)) {
            # check department and position pair is exists or not in `dep_pos` table
            $isExists = DepPos::where('id', $id)->exists();

            if ($isExists) {
                # check department and position pair is match with employee or not
                $isMatch = EmpDepPos::where('dep_pos_id', $id)->exists();

                if ($isMatch) { # check data is exists or not
                    return response()->json(['status' => 'NG', 'message' => trans('messages.SE0010')], 200);
                }

                # save department and position pair
                $process = new DeleteDepartmentPosition($id);
                $delete = $process->executeProcess();

                # check delete process is success or not
                if ($delete) {
                    return response()->json(['status' => 'OK', 'message' => trans('messages.SS0003')], 200);
                } else {
                    return response()->json(['status' => 'NG', 'message' => trans('messages.SE0004')], 200);
                }

            } else {
                return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
            }
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0006')]);
        }
    }

    /**
     * Get all positions by department id
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/09
     * @param   Request object
     * @return  Response object
     */
    public function getPositionByDepartment($id)
    {
        # check user seletcted department is exists in `departments` table or not
        $isExists = Department::where('id', $id)->exists();

        if ($isExists) { # if exists
            # get all positions by department and respone result
            return response()->json(['status' => 'OK', 'data' => $this->deptPosRepo->getPositionByDept($id)], 200);
        } else {
            return response()->json(['status' => 'NG', 'message' => trans('messages.SE0005')], 200);
        }
    }
}
