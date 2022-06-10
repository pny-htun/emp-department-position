<?php

namespace App\DBTransactions\DepartmentPosition;

use App\Models\DepPos;
use App\Classes\DBTransaction;

/**
 * To save new department in `departments` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/06
 */
class SaveDepartmentPosition extends DBTransaction
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
	 * Save Department and Position Pair
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @return  array
	 */
    public function process()
    {
        DepPos::insert([
            'department_id' => $this->request->department_id,
            'position_id' => $this->request->position_id,
            'created_emp' => 10001,
            'updated_emp' => 10001
        ]);
        return ['status' => true, 'error' => ''];
    }
}
