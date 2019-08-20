@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>{{ $assignedToMe ? 'Tickets Assigned To Me' : 'My Tickets'}}</h1>
      <div class="grid">
          <div class="grid-body py-3">
              <div class="split-header">
                  <p class="card-title ml-n1">All {{ request()->has('pending_approval') ? 'Pending' : ''   }} tickets</p>

                  @if(request()->has('pending_approval'))
                    <a class="btn btn-primary btn-xs text-white" href="{{ route('tickets.list') }}">View All Tickets</a>
                  @else
                    <a class="btn btn-primary btn-xs text-white" href="?pending_approval">View Unapproved Tickets</a>
                  @endif
              </div>
          </div>
          @include('tickets.tickets_list_template')
      </div>
    </div>
@endsection