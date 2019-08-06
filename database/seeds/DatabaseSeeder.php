<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            DepartmentSeeder::class,
            DepartmentUnitSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
