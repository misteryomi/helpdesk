<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Ticket;
use App\User;

class TicketsController extends Controller
{
    private $ticket;
    private $user;

    function __construct(Ticket $ticket, User $user) {
        $this->ticket = $ticket;
        // $this->user = $user;
        $this->user = User::first();
    }

    /**
     * Returns all users's created tickets or tickets assigned to them (if request()->assigned_to_me is set)
     */
    public function index() {
        $assignedToMe = request()->has('assigned_to_me')? true : false;
        $tickets = $this->user->tickets()->latest()->paginate(15);


        return view('tickets.list', compact('assignedToMe', 'tickets'));
    }

    public function create() {
        return view('tickets.new');
    }

    public function show(Ticket $ticket) {
        //Check if this ticket is assigned to current user
        $assignedToMe = $ticket->assignedTo && ($ticket->assignedTo->user_id == $this->user->id);
        $conversations = $ticket->conversations()->latest()->get();

        return view('tickets.show', compact('ticket', 'assignedToMe', 'conversations'));
    }

    public function list($count = 'paginate') {

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

        //Retrieve assignable Staff and create an `assigned` record for the ticket
        $assignableStaff = $ticket->unit->getAssignableStaff();
        if($assignableStaff) {
            $ticket->assignedTo()->create(['user_id' => $assignableStaff->id]);
            $ticket->is_assigned = true;
        }

        return response([
                            'status' => true, 
                            'message' => "Ticket successfully created! Your ticket ID is #$ticket->ticket_id", 
                            'data' =>  new TicketResource($ticket),
                            'redirectsTo' => route('tickets.show', ['ticket' => $ticket->ticket_id]), 
                            ]);
    }
}
