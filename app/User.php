<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns tickets owned by this user
     */
    public function tickets() {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    /**
     * Get users's assigned Tickets
     */
    public function assignedTickets() {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    // /**
    //  * 
    //  */
    public function assignedTo() {
        return $this->hasMany(TicketAssignedUser::class, 'user_id');
    }


    /**
     * Returns unit this user belongs to
     */
    public function unit() {
        return $this->belongsTo(DepartmentUnit::class);
    }
}
