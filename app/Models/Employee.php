<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * Get dep_pos_id
     * @author  Zar Ni Win
     * @create  2022/06/08
     * 
     */
    public function employeeDepPos()
    {
        return $this->belongsToMany('App\Models\DepPos','emp_dep_pos','employee_id','dep_pos_id');
    }
}
