<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketConversationRequest;
use App\Http\Resources\TicketConversationResource;

use App\TicketConversation;
use App\User;
use App\Ticket;
use App\Status;


class TicketConversationsController extends Controller
{
    private $conversation;
    private $user;
    private $status;

    function __construct(TicketConversation $conversation, Status $status) {
        $this->conversation = $conversation;
        $this->status = $status;
        // $this->user = $user;
        $this->user = User::first();
    }

    public function store(TicketConversationRequest $request, Ticket $ticket) {

        if(!$ticket->is_assigned) {
            return response([
                'status' => false, 
                'message' => "Sorry, you cannot respond to this ticket yet", 
                ], 403);    
        }

        $requestData = $request->all();
        //Check here tomorrow. If logged in user is sender, set him as sender, else receiver.
        $requestData['sender_id'] = $this->user->id;
        $requestData['receiver_id'] = $ticket->assignedTo->id;
        $requestData['ticket_id'] = $ticket->id;

        $message = $this->conversation->create($requestData);

        /**
         * process some updates on the status of the ticket
         * 
         */
        $status_id = $this->status->findStatus($this->user->id == $ticket->assignedTo->id ? 'Answered' : 'Open');
        $ticket->update(['status_id' => $status_id]);

         return response([
            'status' => true, 
            'message' => "Ticket updated successfully!", 
            'data' =>  new TicketConversationResource($message),
            'redirectsTo' => route('tickets.show', ['ticket' => $ticket->ticket_id]), 
            ]);

    }
}
