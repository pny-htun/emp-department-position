<?php

namespace App\Repositories\DepartmentPosition;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\DepartmentPosition\DepartmentPositionInterface;

/**
 * To access `dept_pos` table
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
class DepartmentPositionRepository implements DepartmentPositionInterface 
{
    /**
     * Get all department and position pairs
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @return  Response object
     */
    public function getDepartmentPosition()
    {
        $pairs = DB::table('dep_pos')
                    ->join('departments', 'dep_pos.department_id', 'departments.id')
                    ->join('positions', 'dep_pos.position_id', 'positions.id')
                    ->select('dep_pos.id', 'departments.name as department_name', 'positions.name as position_name')
                    ->orderBy('departments.name')
                    ->paginate(20);
        return $pairs;
    }

    /**
     * Get all positions by department id
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @return  Response object
     */
    public function getPositionByDept($id)
    {
        $data = DB::table('dep_pos')
                    ->join('departments', 'dep_pos.department_id', 'departments.id')
                    ->join('positions', 'dep_pos.position_id', 'positions.id')
                    ->where('departments.id', $id)
                    ->where([
                        ['dep_pos.deleted_at', null],
                        ['departments.deleted_at', null],
                        ['positions.deleted_at', null],
                    ])
                    ->select(
                        'dep_pos.id as dept_pos_id',
                        'departments.id as department_id',
                        'departments.name as department_name',
                        'positions.id as position_id',
                        'positions.name as position_name',
                    )->get();
        return $data;
    }
}
