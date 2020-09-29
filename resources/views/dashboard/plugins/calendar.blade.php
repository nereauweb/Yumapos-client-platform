@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">   
@endsection

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header"> FullCalendar<a class="badge badge-danger" href="https://coreui.io/pro/">CoreUI Pro Component</a>
                  <div class="card-header-actions"><a class="card-header-action" href="https://fullcalendar.io" target="_blank"><small class="text-muted">docs</small></a></div>
                </div>
                <div class="card-body">
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('js/gcal.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
@endsection
