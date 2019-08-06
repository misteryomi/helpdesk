<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Ticket;

class TicketsController extends Controller
{
    private $ticket;

    function __construct(Ticket $ticket) {
        $this->ticket = $ticket;
    }


    public function index($count = 'paginate') {

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

    public function create() {
        //return view('tickets.new');
    }

    public function store(TicketRequest $request) {
        $ticket = $this->ticket->create($request->all());

        //Generate and set a Ticket ID for the current ticket
        $ticket->ticket_id =  $ticket->id.rand(1000, 999999);
        $ticket->save();

        //Retrieve assignable Staff and create an `assigned` record for the ticket
        $assignableStaff = $ticket->unit->getAssignableStaff();
        if($assignableStaff) {
            $ticket->assignedTo()->create(['user_id' => $assignableStaff->id]);
            $ticket->is_assigned = true;
        }

        return response(['status' => true, 'message' => "Ticket successfully created! Your ticket ID is #$ticket->ticket_id", 'data' =>  new TicketResource($ticket)], 200);
    }
}
