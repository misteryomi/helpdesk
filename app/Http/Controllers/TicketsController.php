<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Ticket;
use App\User;
use App\Status;

class TicketsController extends Controller
{
    private $ticket;
    private $status;
    private $user;

    function __construct(Ticket $ticket, Status $status, User $user) {
        $this->ticket = $ticket;
        $this->status = $status;
        // $this->user = $user;
        $this->user = User::first();
    }

    public function index() {
        $tickets = $this->user->tickets()->take(5)->get();
        $assignedTickets = $this->user->assignedTickets()->take(5)->get();

        //get stats of all ticket statuses
        $stats = (new \App\Status)->getUserTicketsStatusCount($tickets, $this->user->id);
        dd($stats);

        return view('tickets.summary', compact('tickets', 'assignedTickets'));
    }

    /**
     * Returns all users's created tickets or tickets assigned to them (if request()->assigned_to_me is set)
     */
    public function list() {
        $assignedToMe = request()->has('assigned_to_me')? true : false;

        $tickets = $assignedToMe ? $this->user->assignedTickets() : $this->user->tickets();
        $tickets = $tickets->latest()->paginate(15);

        return view('tickets.list', compact('assignedToMe', 'tickets'));
    }

    public function create() {
        return view('tickets.new');
    }

    public function show(Ticket $ticket) {
        //Check if this ticket is assigned to current user
        $assignedToMe = $ticket->assignedTo && ($ticket->assignedTo->id == $this->user->id);
        $conversations = $ticket->conversations()->latest()->get();
        $statuses = $assignedToMe ? $this->status->get() : [];

        return view('tickets.show', compact('ticket', 'assignedToMe', 'conversations', 'statuses'));
    }

    public function apiList($count = 'paginate') {

        switch (true) {
            case $count == 'all':
                $tickets = $this->ticket->get();
                break;
            case $count > 0:
                $tickets = $this->ticket->take($count)->get();
                break;
            
            default:
                $tickets = $this->ticket->paginate(20);
                break;
        }

        return response(['status' => true, 'data' => $tickets]);
    }


    public function store(TicketRequest $request) {

        $requestData = $request->all();
        $requestData['user_id'] = $this->user->id;

        $ticket = $this->ticket->create($requestData);

        //Generate and set a Ticket ID for the current ticket
        $ticket->ticket_id =  $ticket->id.rand(1000, 999999);
        $ticket->save();

        //Assign ticket to appropriate
        Self::assignTicketToStaff($ticket);

        return response([
                            'status' => true, 
                            'message' => "Ticket successfully created! Your ticket ID is #$ticket->ticket_id", 
                            'data' =>  new TicketResource($ticket),
                            'redirectsTo' => route('tickets.show', ['ticket' => $ticket->ticket_id]), 
                            ]);
    }

    /** 
     * Process reassignment of assigned pending tickets to another staff
     */
    public function reassignPendingTickets() {
        $unassignedTickets = Self::getUnassignedTickets();

        if($unassignedTickets->count() > 0) {
            foreach($unassignedTickets as $ticket) {
                Self::assignTicketToStaff($ticket);
            }
        }
    }

    //Retrieve assignable Staff and create an `assigned` record for specified ticket
    public static function assignTicketToStaff($ticket) {
        $assignableStaff = $ticket->unit->getAssignableStaff();

        if($assignableStaff) {
            $ticket->allAssignedTo()->create(['user_id' => $assignableStaff->id]);
            $ticket->update([
                'is_assigned' => true,
                'assigned_to' => $assignableStaff->id,                
            ]);
        }
    } 
}
