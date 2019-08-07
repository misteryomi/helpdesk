<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketConversation extends Model
{

    protected $fillable = ['message', 'sender_id', 'receiver_id', 'ticket_id'];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
