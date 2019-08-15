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
            ['name' => 'Pending', 'css_class' => 'warning', 'is_user_assignable' => 1], //Possibly remove this so tickets can start with 'open'
            ['name' => 'Open', 'css_class' => 'info', 'is_user_assignable' => 1], //Open only if has an history of answered but user made a response awaiting another answer
            ['name' => 'Answered', 'css_class' => 'danger', 'is_staff_assignable' => 1],
            // ['name' => 'Replied', 'css_class' => 'primary', 'is_user_assignable' => 1], //When or reset to open???
            ['name' => 'Reassigned', 'css_class' => 'dark', 'is_admin_assignable' => 1],
            ['name' => 'Solved', 'css_class' => 'success', 'is_staff_assignable' => 1],
        ];

        Status::insert($statuses);
    }
}
