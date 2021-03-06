<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\TicketsExport;

use App\User;
use App\Ticket;
use App\Status;
use Excel;

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

        $tickets = $this->ticket->latest();

        if($request->has('sort')) {
            $tickets = $this->ticket->sortData($tickets, $request);
        }

        if($request->has('export')) {
            return $this->export($tickets->get());
        }

        $statuses = $this->status->get();
        $tickets = $tickets->paginate(15);

        return view('admin.tickets.list', compact('tickets', 'statuses'));
    }    

    public function show(Ticket $ticket) {
        $conversations = $ticket->conversations()->latest()->paginate(10);
        $assignmentLog = $ticket->allAssignedTo()->latest()->get();

        return view('admin.tickets.show', compact('ticket', 'conversations', 'assignmentLog'));
    }


    
    public function reassign(Request $request, Ticket $ticket) {

        if(!$request->staff_id) 
            return response(['status' => false, 'errors' => 'Please specify a staff to re-assign ticket to!'], 422);

        $ticket->update(['assigned_to' => $request->staff_id]);
        $ticket->allAssignedTo()->create([
            'user_id' => $request->staff_id
        ]);

        return response(['status' => true, 'message' => 'Ticket status updated successfully!']);
    }    

    public function export($tickets) 
    {
        return Excel::download(new TicketsExport($tickets), 'invoices.xlsx');
    }
}
