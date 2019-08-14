<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Ticket;

class DashboardController extends Controller
{
    
    private $ticket;
    private $user;
    
    function __construct(Ticket $ticket, User $user) {
        $this->ticket = $ticket;
        // $this->user = $user;
        $this->user = User::first();
    }

    
    public function index() {
        $tickets = $this->ticket->take(5)->get();

        //get stats of all ticket statuses
        $stats = (new \App\Status)->getUserTicketsStatusStats($tickets);

        return view('admin.dashboard', compact('tickets', 'stats'));
    }
    
    
}
