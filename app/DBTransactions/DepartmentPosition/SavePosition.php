<?php

namespace App\DBTransactions\DepartmentPosition;

use App\Models\Position;
use App\Classes\DBTransaction;

/**
 * To save new position in `positions` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/06
 */
class SavePosition extends DBTransaction
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
	 * Save Position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/06
     * @return  array
	 */
    public function process()
    {
        Position::insert([
            'name' => $this->request->position_name,
            'created_emp' => 10001,
            'updated_emp' => 10001
        ]);
        return ['status' => true, 'error' => ''];
    }
}
