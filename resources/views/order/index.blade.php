@extends('layouts/main')
<link rel="stylesheet" href="/css/order.css" >

@section('container')
    <form action="/addtocart" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="schedule_id" id="schedule_id" value=""> <!-- Tambahkan input untuk schedule_id -->
        <table id="cart" class="table table-hover table-condensed text-white">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $user->role->name }}</h4>
                                <p>{{ $user->username }}</p>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $user->price }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="submit" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</button></td>
                    <td colspan="2" class="hidden-xs"></td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        Schedule
                    </button>
                    <input type="hidden" name="price" id="price" value="{{ $user->price }}">
                </tr>
            </tfoot>
        </table>
    </form>

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="scheduleForm" action="/schedule" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">
                        <h5>Your Schedules:</h5>
                        @if($schedules->isNotEmpty())
                            <ul>
                                @foreach($schedules as $schedule)
                                    <li>
                                        Date: {{ $schedule->date }},
                                        Time: {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        <button type="button" class="btn btn-success" onclick="setScheduleId({{ $schedule->id }})">Use this schedule</button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No schedules available.</p>
                        @endif
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="selectedTime">Time</label>
                            <select id="timeSlot" class="form-control" name="selectedTime">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setScheduleId(scheduleId) {
            document.getElementById('schedule_id').value = scheduleId;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scheduleForm');
            form.addEventListener('submit', function(event) {
                const dateInput = document.getElementById('date');
                const selectedDate = new Date(dateInput.value);

                const availableDays = [@foreach($availableTimes as $availableTime) '{{ date("D", strtotime($availableTime->day)) }}', @endforeach];

                const selectedDay = selectedDate.toLocaleDateString('en-US', { weekday: 'short' });

                if (!availableDays.includes(selectedDay)) {
                    event.preventDefault();
                    alert('Tanggal tidak tersedia. Silakan pilih tanggal lain.');
                }
            });
        });
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
@endsection
