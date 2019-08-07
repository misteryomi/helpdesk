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
     * Override {id} binding with {ticket_id}
     * Doc here: https://laravel.com/docs/5.8/routing#route-model-binding
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('ticket_id', $value)->first() ?? abort(404);
    }

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
     * Returns the conversations on current ticket
     */
    public function conversations() {
        return $this->hasMany(TicketConversation::class, 'ticket_id');
    }

    /**
     * Returns User assigned to this ticket
     */
    public function assignedTo() {
        return $this->hasOne(TicketAssignedUser::class, 'ticket_id');
        // return $this->hasMany(TicketAssignedUser::class, 'ticket_id');
    }
}
