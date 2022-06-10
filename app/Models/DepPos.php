<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepPos extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dep_pos';
    /**
     * Get department of employee data
     * @author  Zar Ni Win
     * @create  2022/06/08
     * 
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id','id');
    }

    /**
     * Get position of employee data
     * @author  Zar Ni Win
     * @create  2022/06/08
     * 
     */
    public function position()
    {
        return $this->belongsTo('App\Models\Position','position_id','id');
    }

}
