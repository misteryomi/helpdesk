@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h5>Ticket #{{ $ticket->ticket_id }}</h5>
        <h1 class="mb-3">{{ $ticket->title }}</h1>
        <small class="text-muted mb-3">{{ $ticket->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</small><br/>

        {!! $ticket->statusBadge() !!}
        {!! $ticket->displayApprovedBadge() !!}

        @include('partials.alert')

        @if($ticket->is_assigned)
        <div class="mb-4 text-right">

            <a class="btn btn-irs goto text-white" href="#reply">Reply Ticket</a>

            @if($isOwnedByMe && !$ticket->is_approved)
             <a class="btn btn-danger text-white" href="?approve_ticket">Approve Ticket</a>
            @endif
            @if($isOwnedByMe && $ticket->status->name !== 'Solved')
             <a class="btn btn-danger text-white" href="?approve_ticket">Mark as Solved</a>
            @endif
            
        </div>
        @endif

        <div class="grid">
            <div class="grid-body">
                <div class="split-header">
                    <p class="card-title">Issue:</p>
                </div>
                <strong class="text-dark">{{ $ticket->user->name }}</strong><br/>
                <small class="text-muted mb-1">{{ $ticket->formated_date }}</small>
                <div class="col-md-12"><hr/></div>
                <p>{{ $ticket->message }}</p>
            </div>
        </div>

        <div class="grid">
            <div class="grid-body">
                <div class="row">
                    @if($conversations->count() > 0)
                        @foreach($conversations as $conversation)
                        <div class="col-sm-11 alert {{ $conversation->isSender() ? 'alert-secondary' : 'offset-md-1 text-right alert-success'}}">
                                <strong class="text-dark">{{ $conversation->user->name }}</strong><br/>
                                <small class="text-muted mb-1">{{ $conversation->formated_date }}</small>
                                <div class="col-md-12"><hr/></div>
                                <p>{{ $conversation->message }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="irs_pagination">
                    {{ $conversations->links() }}        
                </div>


            </div>     
                @if($ticket->is_assigned)
                    <div id="reply">
                    @if($assignedToMe)
                        <send-message 
                            type="staff" 
                            ticket_id="{{ $ticket->ticket_id }}"
                            submit_api_route="{{ route('api.tickets.conversation.new', ['ticket_id' => $ticket->ticket_id]) }}"
                            statuses="{{ json_encode($statuses) }}"
                            />
                    @else
                        <send-message 
                            type="owner" 
                            ticket_id="{{ $ticket->ticket_id }}"
                            submit_api_route="{{ route('api.tickets.conversation.new', ['ticket_id' => $ticket->ticket_id]) }}"                
                            />
                    @endif
                    </div>
                @endif            
        </div>

    </div>
@endsection