@extends('admin.layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h5>Ticket #{{ $ticket->ticket_id }}</h5>
        <h1 class="mb-3">{{ $ticket->title }}</h1>
        <small class="text-muted mb-3">{{ $ticket->formated_date }}</small><br/>
        {!! $ticket->statusBadge() !!}

        <div class="row">
            <div class="col-md-8">
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
                            <div class="col-sm-11 alert alert-secondary">
                                <strong class="text-dark">{{ $ticket->user->name }}</strong><br/>
                                <small class="text-muted mb-1">{{ $ticket->formated_date }}</small>
                                <div class="col-md-12"><hr/></div>
                                <p>{{ $ticket->message }}</p>
                            </div>

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
            
                </div>

            </div>

            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-body">
                       <p class="card-title mb-4">Reassign Ticket</p>
                            <reassign-ticket 
                                dept_api_route="{{ route('api.departments.list') }}"
                                submit_api_route="{{ route('admin.tickets.reassign', ['ticket' => $ticket->ticket_id]) }}"                    
                            />
                    </div>
                </div>

                <div class="grid">
                  <div class="grid-body">
                    <div class="split-header">
                      <p class="card-title">Assignment Log</p>
                      dkdkd
                    </div>
                    <div class="vertical-timeline-wrapper">
                      <div class="timeline-vertical dashboard-timeline">
                          @if($assignmentLog->count() > 0) 
                            @foreach($assignmentLog as $assignment) 
                                <div class="activity-log">
                                    <p class="log-name">{{ $assignment->user->name }}</p>
                                    <div class="log-details"><small class="text-muted">{{ $assignment->formated_date }}</small></div>
                                </div>
                            @endforeach
                          @endif
                      </div>
                    </div>
                  </div>
                </div>


            </div>
        </div>

    </div>
@endsection