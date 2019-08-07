<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Pending'], //Possibly remove this so tickets can start with 'open'
            ['name' => 'Open'],
            ['name' => 'Answered'],
            ['name' => 'Replied'], //When or reset to open???
            ['name' => 'Reassigned'],
            ['name' => 'Solved'],
        ];

        Status::insert($statuses);
    }
}
