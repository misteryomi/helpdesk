<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Department;

class DepartmentsController extends Controller
{
    public function __invoke() {
        $departments = Department::with('units', 'units.categories')->get();
        
        return response(['status' => true, 'data' => $departments]);
    }
}
