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

    
    public function list(Request $request) {
        
        //If user searches for a ticket, redirect to show ticket
        if($request->ticket_id) {
            return redirect()->route('admin.tickets.show', ['ticket_id' => $request->ticket_id]);            
        }

        $tickets = $this->ticket->latest()->paginate(15);

        return view('admin.tickets.list', compact('tickets'));
    }    

    public function show(Ticket $ticket) {
        $conversations = $ticket->conversations()->latest()->paginate(10);

        return view('admin.tickets.show', compact('ticket', 'conversations'));
    }


    
    public function reassign(Request $request, Ticket $ticket) {
    
        $ticket->update(['assigned_to' => $request->staff_id]);
        $ticket->allAssignedTo()->create([
            'user_id' => $request->staff_id
        ]);

        return response(['status' => true, 'message' => 'Ticket status updated successfully!']);
    }    


}
