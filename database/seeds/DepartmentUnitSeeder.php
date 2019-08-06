<?php

use Illuminate\Database\Seeder;
use App\DepartmentUnit;

class DepartmentUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['name' => 'IT', 'department_id' => 1],
            ['name' => 'OT & T', 'department_id' => 1],
            ['name' => 'Assistant Finance', 'department_id' => 2],
            ['name' => 'Sub Management', 'department_id' => 3],
        ];
        
        DepartmentUnit::insert($units);
    }
}
