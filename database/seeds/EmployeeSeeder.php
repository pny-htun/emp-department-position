<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->truncate();
        DB::table('employees')->insert(
            [
                'employee_id'   => 30001,
                'name'          => 'Admin',
                'email'         => 'admin@gmail.com',
                'gender'        => 1,
                'created_emp'   => 1,
                'updated_emp'   => 1
            ]
        );
    }
}
