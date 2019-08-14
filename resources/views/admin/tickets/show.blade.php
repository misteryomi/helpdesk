@extends('admin.layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>Ticket #{{ $ticket->ticket_id }}</h1>


        <div class="grid">
            <div class="grid-header ">
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



    </div>
@endsection