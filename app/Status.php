<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function tickets() {
        return $this->hasMany(Ticket::class, 'status_id');
    }

    public function getUserTicketsStatusCount($tickets, $user_id) {
        return Self::withCount(['tickets' => function($query) use ($user_id) {
                                    $query->where('user_id', $user_id);
                                }])->get();
    }
}
