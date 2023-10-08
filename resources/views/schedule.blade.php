@extends('layouts/main')
@section('container')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2>Pilih Tanggal</h2>
            <form id="scheduleForm" action="/save_schedule" method="post">
                @csrf
                <input type="text" id="datepicker">
                <h3>Available Times:</h3>
                <ul class="text-white">
                    @foreach($availableTimes as $availableTime)
                        @php
                            $startTime = strtotime($availableTime->start_time);
                            $endTime = strtotime($availableTime->end_time);
                            $day = $availableTime->day;
                        @endphp

                        <li>
                            {{ date('H:i', $startTime) }} - {{ date('H:i', $endTime) }}
                            ({{ date('l', strtotime($day)) }})
                        </li>
                    @endforeach
                </ul>
                <h3>Pilih Waktu</h3>
                <select id="timeSlot">
                    @foreach($availableTimes as $availableTime)
                        @php
                            $startTime = strtotime($availableTime->start_time);
                            $endTime = strtotime($availableTime->end_time);
                        @endphp
                        @for ($i = $startTime; $i < $endTime; $i += 7200)
                            @php
                                $timeStart = date("H:i", $i);
                                $timeEnd = date("H:i", $i + 7200);
                            @endphp
                            <option value="{{ $timeStart }}">{{ $timeStart }} - {{ $timeEnd }}</option>
                        @endfor
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary mt-3" id="submitBtn">Submit</button>
                <input type="hidden" id="selectedDate" name="selectedDate">
                <input type="hidden" id="selectedTime" name="selectedTime">
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        var selectedDate = document.getElementById('datepicker').value;
        var selectedTime = document.getElementById('timeSlot').value;

        // Validasi format tanggal dd/mm/yyyy
        var dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
        if (!selectedDate.match(dateRegex)) {
            alert("Format tanggal harus dd/mm/yyyy");
            return;
        }

        // Cek apakah tanggal adalah hari yang tersedia
        var availableDates = {!! json_encode($availableDates) !!};
        var selectedDay = new Date(selectedDate).toLocaleDateString('en-US', { weekday: 'long' });

        if (!availableDates.includes(selectedDay.toLowerCase())) {
            alert("Tanggal tidak tersedia");
            return;
        }

        document.getElementById('selectedDate').value = selectedDate;
        document.getElementById('selectedTime').value = selectedTime;

        document.getElementById('scheduleForm').submit();
    });
</script>
@endsection
