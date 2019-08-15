@extends('admin.layouts.app')

@section('content')
      <div class="row">
          <div class="col-12 py-5">
            <h4>All Tickets</h4>
          </div>
      </div>
      <div class="grid">
          <div class="grid-body py-3">
            <p class="card-title ml-n1">All tickets</p>
          </div>

          @include('admin.tickets.tickets_list_template')
      </div>
@endsection