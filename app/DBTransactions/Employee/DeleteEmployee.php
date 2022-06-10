<?php
namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;

class DeleteEmployee extends DBTransaction
{
    private $request;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function process()
    {
        $result = Employee::where('id',$this->request)->delete();
        if(!$result){
            return ['status' => false, 'error' => 'Employee Delete Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}