<?php

namespace App\Traits;

use App\Models\Position;
use App\Models\Department;

trait DepartmentPositionTrait
{
    /**
     * Get all department names
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @return  Response object
     */
    public function getDepartments()
    {
        # get all department names from `departments` table
        return Department::select('id as department_id', 'name as department_name')->get();
    }

    /**
     * Get all position names
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/07
     * @return  Response object
     */
    public function getPositions()
    {
        # get all position names from `positions` table
        return Position::select('id as position_id', 'name as position_name')->get();
    }
}
