<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAssignedUser extends Model
{
    protected $fillable = ['user_id', 'ticket_id'];
}
