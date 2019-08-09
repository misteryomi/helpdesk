@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>{{ $assignedToMe ? 'Tickets Assigned To Me' : 'My Tickets'}}</h1>
      <div class="grid">
        <div class="grid-body">
          @include('tickets.tickets_list_template')
        </div>
      </div>
    </div>
@endsection