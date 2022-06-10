<?php

namespace App\DBTransactions\DepartmentPosition;

use App\Models\DepPos;
use App\Classes\DBTransaction;

/**
 * To delete department and position pair from `dep_pos` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
class DeleteDepartmentPosition extends DBTransaction
{
    private $id;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
	 * Delete Department and Position Pair
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/08
     * @return  array
	 */
    public function process()
    {
        DepPos::where('id', $this->id)->delete();
        return ['status' => true, 'error' => ''];
    }
}
