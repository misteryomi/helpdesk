<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function tickets() {
        return $this->hasMany(Ticket::class, 'status_id');
    }

    /**
     * Returns each status ticket_count for specified user
     */
    public function getUserTicketsStatusCount($tickets, $user_id) {

        if(!is_null($user_id)) {
            $stats = Self::withCount(['tickets' => function($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }])->get();
        } else {
            $stats = Self::withCount('tickets')->get();
        }

        return $stats;
    }
    
    public function getUserTicketsStatusStats($tickets, $user_id = NULL) {
        $stats = [];

        $statuses = $this->getUserTicketsStatusCount($tickets, $user_id);

        foreach($statuses as $status) {
            $stats[$status->name] = $status->tickets_count;
        }

        return $stats;
    }
}
