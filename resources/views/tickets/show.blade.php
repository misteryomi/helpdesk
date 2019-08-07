@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>Ticket #{{ $ticket->ticket_id }}</h1>
        <div class="mb-4 text-right">
            <a class="btn btn-irs text-white" href="#">Reply Ticket</a>
        </div>
        <div class="grid">
            <div class="grid-header">
                {{ $ticket->title }}
            </div>
            <div class="grid-body">
                <p>{{ $ticket->message }}</p>
            </div>     
        </div>
        <hr/>

        @if($conversations->count() > 0)
            @foreach($conversations as $conversation)
            <div class="grid">
                <div class="grid-header">
                    RE: {{ $ticket->title }}
                </div>
                <div class="grid-body">
                    <p>{{ $conversation->message }}</p>
                </div>     
            </div>
            @endforeach
        @endif

        @if($assignedToMe)
            <send-message 
                type="staff" 
                ticket_id="{{ $ticket->ticket_id }}"
                submit_api_route="{{ route('api.ticket.conversation.new', ['ticket_id' => $ticket->ticket_id]) }}"
                />
        @else
            <send-message 
                type="owner" 
                ticket_id="{{ $ticket->ticket_id }}"
                submit_api_route="{{ route('api.ticket.conversation.new', ['ticket_id' => $ticket->ticket_id]) }}"                
                />
        @endif

    </div>
@endsection