<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeePasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_passwords')->truncate();
        DB::table('employee_passwords')->insert(
            [
                'employee_id'       => 30001,
                'password'          => Hash::make('12345'),
                'confirm_password'  => Hash::make('12345'),
                'created_emp'       => 1,
                'updated_emp'       => 1
            ]
        );
    }
}
