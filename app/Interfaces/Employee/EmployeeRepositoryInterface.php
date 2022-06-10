<?php
namespace App\Interfaces\Employee;

interface EmployeeRepositoryInterface
{
    public function getEmployeeData($search=''); // get employee data by search data
    public function getEmployeeDetail($id); // get employee detail data by employee_id
    public function checkExistEmployee($id); // check employee exist or not by employee_id
}