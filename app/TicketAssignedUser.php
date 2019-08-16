<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAssignedUser extends Model
{
    use ModelTrait;

    protected $fillable = ['user_id', 'ticket_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
