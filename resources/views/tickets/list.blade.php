@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>{{ $assignedToMe ? 'Tickets Assigned To Me' : 'My Tickets'}}</h1>
      <div class="grid">
          <div class="grid-body py-3">
            <p class="card-title ml-n1">All tickets</p>
          </div>
          @include('tickets.tickets_list_template')
      </div>
    </div>
@endsection