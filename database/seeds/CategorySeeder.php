<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Computer issues', 'unit_id' => 1],
            ['name' => 'Printer Issues', 'unit_id' => 1],
            ['name' => 'Furnitures', 'unit_id' => 2],
            ['name' => 'Electrical issues', 'unit_id' => 3],
        ];
        
        Category::insert($categories);
    }
}
