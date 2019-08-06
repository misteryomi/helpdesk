<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    //Ticket Priorities
    const PRIORITY_HIGH = 'HIGH';
    const PRIORITY_MEDIUM = 'MEDIUM';
    const PRIORITY_LOW = 'LOW';


    /**
     * Returns owner of this ticket
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns category this ticket belongs to
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns unit this ticket belongs to
     */
    public function unit() {
        return $this->belongsTo(DepartmentUnit::class);
    }

    /**
     * Returns department this ticket belongs
     */
    public function department() {
        return $this->belongsTo(Department::class);
    }

    /**
     * Returns this ticket's current status
     */
    public function status() {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * Returns Users assigned to this ticket
     */
    public function assignedTo() {
        return $this->hasMany(TicketAssignedUser::class, 'ticket_id');
    }
}
