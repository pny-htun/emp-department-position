<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Employee\EmployeeRepository;
use App\Interfaces\Employee\EmployeeRepositoryInterface;
use App\Repositories\DepartmentPosition\DepartmentPositionRepository;
use App\Interfaces\DepartmentPosition\DepartmentPositionInterface;

/**
 * RepositoryServiceProvider for instantiable
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DepartmentPositionInterface::class, DepartmentPositionRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    }

}
