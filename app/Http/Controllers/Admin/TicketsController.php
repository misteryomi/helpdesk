<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Ticket;
use App\Status;

class TicketsController extends Controller
{
    
    private $ticket;
    private $user;
    
    function __construct(Ticket $ticket, Status $status, User $user) {
        $this->ticket = $ticket;
        $this->status = $status;
        $this->user = User::first();
    }

    
    public function list() {
        $tickets = $this->ticket->latest()->paginate(15);

        return view('admin.tickets.list', compact('tickets'));
    }    

    public function show(Ticket $ticket) {
        $conversations = $ticket->conversations()->latest()->get();
        $statuses = $this->status->get();

        return view('admin.tickets.show', compact('ticket', 'conversations', 'statuses'));
    }


}
