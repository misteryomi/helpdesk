@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>{{ $assignedToMe ? 'Tickets Assigned To Me' : 'My Tickets'}}</h1>

        @if($tickets->count() < 1)
         <p>{{ $assignedToMe ? 'Tickets Assigned To Me' : `You have created no ticket yet. <a href="#"><strong>Create your first ticket</strong></a>`}}</p>
        @else 

          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ticket ID</th>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Date Created</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @php $count = 1; @endphp
                 @foreach($tickets as $ticket)
                  @php $count = ($tickets ->currentpage()-1) * $tickets ->perpage() + $loop->index + 1; @endphp
                  <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $ticket->ticket_id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->unit->name }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>
                      <label class="badge badge-warning">In progress</label>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <div class="irs_pagination">
          {{ $tickets->links() }}
          </div>
        @endif
      
    </div>
@endsection