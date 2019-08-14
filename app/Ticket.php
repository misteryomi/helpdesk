<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

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
     * Returns current User assigned to this ticket
     */
    public function assignedTo() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Returns all users ever assigned to this ticket
     */
    public function allAssignedTo() {
        return $this->hasMany(TicketAssignedUser::class, 'ticket_id');
    }



    public function generateTicketId() {
        $currentTicketTodayCount = Self::whereDate('created_at', Carbon::today())->count() + 1;

        return Carbon::now()->format('dmY').sprintf("%04s", $currentTicketTodayCount); //If 0, generates 0000
    }

    
    /**
     * Get tickets that have the pending status and has been created 30 mins ago
     */
    public function getUnassignedTickets() {
        $tickets = Self::whereHas('status', function($query) {
                           $query->where('status_id', 1);
                        })
                        ->where('is_assigned', 1)
                        ->where('created_at', '<', Carbon::now()->subMinutes(30)->toDateTimeString())
                        ->get();

        return $tickets;
    }

    public function statusLabel() {
        return "<label class='badge badge-{$this->status->css_class}'>{$this->status->name}</label>";
    }

}
