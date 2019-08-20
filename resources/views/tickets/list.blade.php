@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>{{ $assignedToMe ? 'Tickets Assigned To Me' : 'My Tickets'}}</h1>
      <div class="grid">
          <div class="grid-body py-3">
              <div class="split-header">
                  <p class="card-title ml-n1">All {{ request()->has('pending_approval') ? 'Pending' : ''   }} tickets</p>

                  @include('tickets.tickets_filter_template')
              </div>
          </div>
          @include('tickets.tickets_list_template')
      </div>
    </div>
@endsection

@include('tickets.tickets_scripts_template')