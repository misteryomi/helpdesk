@if(Session::has('message'))
    <p class="alert {{ Session::get('alert_class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif