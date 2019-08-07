<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketConversationRequest;
use App\Http\Resources\TicketConversationResource;

use App\TicketConversation;
use App\User;
use App\Ticket;

class TicketConversationsController extends Controller
{
    private $conversation;
    private $user;

    function __construct(TicketConversation $conversation, User $user) {
        $this->conversation = $conversation;
        // $this->user = $user;
        $this->user = User::first();
    }

    public function store(TicketConversationRequest $request, Ticket $ticket) {

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

         return response([
            'status' => true, 
            'message' => "Ticket updated successfully!", 
            'data' =>  new TicketConversationResource($message),
            'redirectsTo' => route('tickets.show', ['ticket' => $ticket->ticket_id]), 
            ]);

    }
}
