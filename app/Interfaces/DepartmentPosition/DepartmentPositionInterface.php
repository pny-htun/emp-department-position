<?php

namespace App\Interfaces\DepartmentPosition;


/**
 * DepartmentPosition Interface
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
interface DepartmentPositionInterface
{
    # get all department and positon pairs//PhyoNaing Htun
    public function getDepartmentPosition();
    # get all positions by department id//PhyoNaing Htun
    public function getPositionByDept($id);
}