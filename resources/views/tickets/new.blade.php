@extends('layouts.app')

@section('content')
    <div class="doc-content-section-inner">
        <h1>Create a new ticket</h1>

            <create-ticket 
                dept_api_route="{{ route('api.departments.list') }}"
                submit_api_route="{{ route('api.tickets.new') }}"
                />
    </div>
@endsection
