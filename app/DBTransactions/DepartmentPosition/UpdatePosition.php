<?php

namespace App\DBTransactions\DepartmentPosition;

use App\Models\Position;
use App\Classes\DBTransaction;

/**
 * To update position in `positions` table
 *
 * @author  PhyoNaing Htun
 * @create  2022/06/06
 */
class UpdatePosition extends DBTransaction
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
	 * Update Position
     *
     * @author  PhyoNaing Htun
     * @create  2022/06/06
     * @return  array
	 */
    public function process()
    {
        $affected = Position::where('id', $this->request->position_id)
                            ->update([
                                'name' => $this->request->position_name,
                                'updated_emp' => 10001,
                                'updated_at' => now()
                            ]);

        # check row is affected or not
        if (!$affected) {
            return ['status' => false, 'error' => 'Update Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
