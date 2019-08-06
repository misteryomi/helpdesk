<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    public function units() {
        return $this->hasMany(DepartmentUnit::class, 'department_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'department_id');
    }
    
}
