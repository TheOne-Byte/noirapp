@extends('layouts/main')
<link rel="stylesheet" href="/css/order.css">

@section('container')

    <form id="scheduleForm" action="/addtocart" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="schedule_id" id="schedule_id" value=""> <!-- Tambahkan input untuk schedule_id -->
        <input type="hidden" name="temp_schedule" id="temp_schedule" value=""> <!-- Input tersembunyi untuk menyimpan jadwal sementara -->
        <table id="cart" class="table table-hover table-condensed text-white">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:40%">Schedule</th>
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
                    <td data-th="Schedule"></td> <!-- Tempat untuk menampilkan jadwal yang dipilih -->
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
                <form id="scheduleFormModal">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-primary" onclick="saveTempSchedule(event)">Save changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <script>
            function saveTempSchedule(event) {
                event.preventDefault(); // Prevent default form submission

                // Retrieve selected schedule data
                const selectedScheduleId = document.getElementById('schedule_id').value;
                const selectedDate = document.getElementById('date').value;
                const selectedTime = document.getElementById('timeSlot').value;

                // Create an object to store temporary schedule data
                const tempSchedule = {
                    schedule_id: selectedScheduleId,
                    date: selectedDate,
                    time: selectedTime
                };

                // Store temporary schedule data in localStorage
                localStorage.setItem('tempSchedule', JSON.stringify(tempSchedule));

                // Display the selected schedule below the product and price
                const scheduleCell = document.querySelector('td[data-th="Schedule"]');
                scheduleCell.innerHTML = `${selectedDate}, ${selectedTime}`;
                document.getElementById('schedule_id').value = selectedScheduleId;

                // Close the modal
                const scheduleModal = document.getElementById('scheduleModal');
                const modal = bootstrap.Modal.getInstance(scheduleModal); // Get the Bootstrap modal instance
                modal.hide(); // Close the modal
            }

            document.addEventListener('DOMContentLoaded', function() {
                const saveChangesBtn = document.querySelector('#scheduleModal button[data-bs-target="#scheduleModal"]');
                saveChangesBtn.addEventListener('click', saveTempSchedule);


            });
            let shouldPreventSubmit = true;
            function saveScheduleToDatabase() {
                const tempSchedule = localStorage.getItem('tempSchedule');
                if (tempSchedule) {
                    const scheduleData = JSON.parse(tempSchedule);
                    const dateInput = document.getElementById('date');
                    const selectedDate = new Date(dateInput.value);
                    if (!dateInput.value) {
                        shouldPreventSubmit = false;
                        event.preventDefault();
                        alert('Silakan pilih tanggal.');
                        return; // Berhenti jika tanggal kosong
                    }
                    // Mendapatkan hari-hari yang tersedia dari variabel PHP
                    const availableDays = [
                        @foreach($availableTimes as $availableTime)
                            '{{ date("D", strtotime($availableTime->day)) }}',
                        @endforeach
                    ];

                    // Mendapatkan hari yang dipilih oleh pengguna
                    const selectedDay = selectedDate.toLocaleDateString('en-US', { weekday: 'short' });

                    // Memeriksa apakah hari yang dipilih tersedia
                    if (!availableDays.includes(selectedDay)) {
                        shouldPreventSubmit = false;
                        event.preventDefault();
                        alert('Tanggal tidak tersedia. Silakan pilih tanggal lain.');
                        return; // Berhenti jika tanggal tidak tersedia
                    }
                    shouldPreventSubmit = true;
                    fetch('/schedule', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: '{{ $user->id }}',
                            date: scheduleData.date,
                            selectedTime: scheduleData.time
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Network response was not ok.');
                    })
                    .then(data => {
                        // Setel nilai dari input schedule_id dengan ID schedule yang baru dibuat
                        const scheduleId = data.id;
                        document.getElementById('schedule_id').value = scheduleId;
                        // Lakukan apa pun yang perlu dilakukan setelah penyimpanan di database, misalnya, tampilkan pesan atau lakukan aksi lain
                    })
                    .catch(error => {
                        console.error('There was an error!', error); // Handle kesalahan jika terjadi saat menyimpan jadwal
                    });
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                const continueShoppingBtn = document.querySelector('.btn-warning'); // Ganti dengan selektor yang sesuai
                continueShoppingBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    saveScheduleToDatabase(); // Panggil fungsi untuk menyimpan jadwal ke database
                    if (shouldPreventSubmit) {
                        document.getElementById('scheduleForm').submit();
                    }

            // Lanjutkan dengan aksi untuk melanjutkan belanja, misalnya, pindah ke halaman berikutnya atau lakukan yang lain

                });
            });
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
@endsection
