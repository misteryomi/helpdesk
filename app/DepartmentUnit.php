<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentUnit extends Model
{

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function categories() {
        return $this->hasMany(Category::class, 'unit_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'unit_id');
    }

    /**
     * Retrieves all staff of current unit
     */
    public function staff() {
        return $this->hasManyThrough(User::class, UserUnit::class, 'unit_id', 'id', 'id', 'user_id');
    }

    /**
     * Get assignable staff in the current unit
     */
    public function getAssignableStaff() {
        /**
         * Get all members of this unit, retrieve and count all tickets they've been assigned to,
         * And order by the count of their assignments. Then return the staff with the least number 
         * of assigned tickets.
         */

        $assignable = $this->staff()->withCount('assignedTo')->orderBy('assigned_to_count')->first();

        return $assignable;
    }
}
