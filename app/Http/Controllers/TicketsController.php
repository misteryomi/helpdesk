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
        $this->user = User::find(1);
    }

    public function index() {
        $tickets = $this->user->tickets()->take(5)->get();
        $assignedTickets = $this->user->assignedTickets()->take(5)->get();


        //get stats of all ticket statuses
        $stats = (new \App\Status)->getUserTicketsStatusStats($tickets, $this->user->id);

        return view('tickets.summary', compact('tickets', 'assignedTickets', 'stats'));
    }

    /**
     * Returns all users's created tickets or tickets assigned to them (if request()->assigned_to_me is set)
     */
    public function list() {
        $assignedToMe = request()->has('assigned_to_me')? true : false;

        $tickets = $assignedToMe ? $this->user->assignedTickets() : $this->user->tickets();
        $tickets = request()->has('pending_approval') ? $tickets->where('is_approved', 0) : $tickets;
        $tickets = $tickets->latest()->paginate(15);

        return view('tickets.list', compact('assignedToMe', 'tickets'));
    }

    public function create() {
        return view('tickets.new');
    }

    public function show(Request $request, Ticket $ticket) {
        //Check if this ticket is assigned to current user
        $assignedToMe = $ticket->assignedTo && ($ticket->assignedTo->id == $this->user->id);
        //Check if ticket is owned by current user
        $isOwnedByMe = $ticket->user_id == $this->user->id;

        if($isOwnedByMe && $request->has('approve_ticket')) {
            $this->approveTicket($ticket);
        }

        if($request->has('solved') && $assignedToMe) {
            $this->markAsSolved($ticket);
        }

        $conversations = $ticket->conversations()->latest()->paginate(10);
        $statuses = $assignedToMe ? $this->status->where('is_staff_assignable', 1)->get() : [];

        return view('tickets.show', compact('ticket', 'assignedToMe', 'conversations', 'statuses', 'isOwnedByMe'));
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

        $requestData = $request->except(['selected_user']);
        $requestData['user_id'] = $request->has('selected_user') ? $request->selected_user : $this->user->id;
        $requestData['is_approved'] = $request->has('is_on_behalf') ? false : true; //not approved as long as it is created on behalf of selected user.
        $requestData['ticket_id'] = $this->ticket->generateTicketId();

        $ticket = $this->ticket->create($requestData);

        //If user is creating on behalf of someone else, Assign ticket to self. But ticket would be pending until approved. Once approved. Set ticket to open.
        if($request->is_on_behalf === true) {
            $ticket->assignTicket($this->user->id);
        } else {
            //Assign ticket to appropriate staff
            $ticket->assignTicketToAvailableStaff();
        }


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
        $unassignedTickets = $this->ticket->getUnassignedTickets();

        if($unassignedTickets->count() > 0) {
            foreach($unassignedTickets as $ticket) {
                $this->ticket->assignTicketToAvailableStaff();
            }
        }
    }

    private function approveTicket($ticket) {
        if($this->user->id != $ticket->user_id || $ticket->is_approved) {
            return redirect()->back()->withMessage('Sorry, you can only approve your own unapproved tickets')->withAlertClass('alert-danger');
        }
        
        $ticket->update(['is_approved' => 1]);

        return redirect()->back()->withMessage('Ticket approved successfully!')->withAlertClass('alert-success');
    }

    private function markAsSolved($ticket) {
        if(!$ticket->is_approved)
            return redirect()->back()->withMessage('Only an approved ticket can be marked as solved')->withAlertClass('alert-danger');


        $status_id = $this->status->findStatus('Solved');
        $ticket->update(['status_id' => $status_id]);

        return redirect()->back()->withMessage('Ticket successfully updated!')->withAlertClass('alert-success');

    }




}
