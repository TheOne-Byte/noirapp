@extends('layouts/main')
@section('container')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2>Pilih Tanggal</h2>
            <div id="calendar"></div>
            <h3>Jadwal Tersedia:</h3>
            <div class="text-white">
            @foreach($availableTimes as $availableTime)
                {{ $availableTime->day }}: {{ $availableTime->start_time }} - {{ $availableTime->end_time }}<br>
            @endforeach
             </div>
        </div>
    </div>
</div>

<script type="module">
    import { Calendar } from '@fullcalendar/core';
    import dayGridPlugin from '@fullcalendar/daygrid';

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        events: [
          @foreach($availableTimes as $availableTime)
            {
              title: '{{ $availableTime->day }}: {{ $availableTime->start_time }} - {{ $availableTime->end_time }}',
              start: '{{ $availableTime->day }}T{{ $availableTime->start_time }}',
              end: '{{ $availableTime->day }}T{{ $availableTime->end_time }}',
            },
          @endforeach
        ]
      });

      calendar.render();
    });
  </script>
@endsection
