<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'Engineering'],
            ['name' => 'Finance'],
            ['name' => 'Management'],
        ];

        Department::insert($departments);
    }
}
