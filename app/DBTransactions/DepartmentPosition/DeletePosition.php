<?php

namespace App\DBTransactions\DepartmentPosition;

use App\Models\Position;
use App\Classes\DBTransaction;

/**
 * To delete position in `positions` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/06
 */
class DeletePosition extends DBTransaction
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
	 * Delete Position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/06
     * @return  array
	 */
    public function process()
    {
        $affected = Position::where('id', $this->request->position_id)->delete();

        # check row is affected or not
        if (!$affected) {
            return ['status' => false, 'error' => 'Delete Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
