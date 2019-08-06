<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function unit() {
        return $this->belongsTo(DepartmentUnit::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'category_id');
    }
        
}
