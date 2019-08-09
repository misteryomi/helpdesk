@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
    <div class="row">
              <div class="col-12 py-5">
                <h4>Dashboard</h4>
                <p class="text-gray">Welcome, 'Yomi</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                      <p>30%</p>
                    </div>
                    <p class="text-black">Pending</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_3"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                      <p>43%</p>
                    </div>
                    <p class="text-black">Open</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_4"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                      <p>23%</p>
                    </div>
                    <p class="text-black">Answered</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_1"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                      <p>75</p>
                    </div>
                    <p class="text-black">Solved</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_2"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>

      <div class="grid">
        <div class="grid-body py-3">
          <p class="card-title ml-n1">My Recently created tickets</p>
        </div>
          @php $viewMoreRoute = route('tickets.list'); @endphp
          @include('tickets.tickets_list_template')
      </div>

      <div class="grid">
        <div class="grid-body py-3">
          <p class="card-title ml-n1">Recent tickets assigned to me</p>
        </div>
          @php 
            $tickets = $assignedTickets;
            $viewMoreRoute = route('tickets.list', ['assigned_to_me' => 1]);
          @endphp
          @include('tickets.tickets_list_template')
      </div>
    </div>
@endsection