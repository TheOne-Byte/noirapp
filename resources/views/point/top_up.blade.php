@extends('layouts/main')
@section('container')
    <section class="contact-us-light-lick position-relative">
        <section class="h-100 w-100" style="box-sizing: border-box; background-color: #141432">
            <style scoped>
                @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

                .content-3-3 .btn:focus,
                .content-3-3 .btn:active {
                    outline: none !important;
                }

                .content-3-3 {
                    padding: 5rem 2rem;
                }

                .content-3-3 .img-hero {
                    width: 100%;
                    margin-bottom: 3rem;
                }

                .content-3-3 .right-column {
                    width: 100%;
                }

                .content-3-3 .title-text {
                    font: 600 1.875rem/2.25rem Poppins, sans-serif;
                    margin-bottom: 2.5rem;
                    letter-spacing: -0.025em;
                }

                .content-3-3 .title-caption {
                    font: 500 1.5rem/2rem Poppins, sans-serif;
                    margin-bottom: 1.25rem;
                }

                .content-3-3 .circle {
                    font: 500 1.25rem/1.75rem Poppins, sans-serif;
                    height: 3rem;
                    width: 3rem;
                    margin-bottom: 1.25rem;
                    border-radius: 9999px;
                    background-color: #504cee;
                }

                .content-3-3 .text-caption {
                    font: 400 1rem/1.75rem Poppins, sans-serif;
                    letter-spacing: 0.025em;
                    color: #999999;
                }

                .content-3-3 .btn-learn {
                    font: 600 1rem/1.5rem Poppins, sans-serif;
                    padding: 1rem 2.5rem;
                    background-color: #504cee;
                    transition: 0.3s;
                    letter-spacing: 0.025em;
                    border-radius: 0.75rem;
                }

                .content-3-3 .btn-learn:hover {
                    background-color: #7370ff;
                    transition: 0.3s;
                }

                @media (min-width: 768px) {
                    .content-3-3 .title-text {
                        font: 600 2.25rem/2.5rem Poppins, sans-serif;
                    }
                }

                @media (min-width: 992px) {
                    .content-3-3 .img-hero {
                        width: 50%;
                        margin-bottom: 0;
                    }

                    .content-3-3 .right-column {
                        width: 50%;
                    }

                    .content-3-3 .circle {
                        margin-right: 1.25rem;
                        margin-bottom: 0;
                    }
                }
            </style>
            <div class="content-3-3 container-xxl mx-auto position-relative" style="font-family: 'Poppins', sans-serif">
                <div class="d-flex flex-lg-row flex-column align-items-center">
                    <!-- Left Column -->
                    <div class="img-hero text-center justify-content-center d-flex">
                        <img id="hero" class="img-fluid"
                            src="http://api.elements.buildwithangga.com/storage/files/2/assets/Content/Content3/Content-3-1.png"
                            alt="" />
                    </div>

                    <!-- Right Column -->
                    <div
                        class="right-column d-flex flex-column align-items-lg-start align-items-center text-lg-start text-center">
                        <form id="topUpForm">
                            @csrf
                            <h2 class="title-text text-white">Top Up Page</h2>
                            <ul style="padding: 0; margin: 0">
                                <li class="list-unstyled" style="margin-bottom: 2rem">
                                    <p class="text-caption">
                                        Poin
                                    </p>
                                    <h4
                                        class="title-caption text-white d-flex flex-lg-row flex-column align-items-center justify-content-lg-start justify-content-center">
                                        <select class="form-select" aria-label="Default select example" name="point_top_up">
                                            <option selected>Silahkan Pilih Point</option>
                                            <option value="50">50 Point</option>
                                            <option value="100">100 Point</option>
                                            <option value="150">150 Point</option>
                                            <option value="500">500 Point</option>
                                            <option value="1000">1000 Point</option>
                                        </select>
                                    </h4>

                                </li>
                                <li class="list-unstyled" style="margin-bottom: 2rem">
                                    <p class="text-caption">
                                        Metode Pembayaran
                                    </p>
                                    <h4
                                        class="title-caption text-white d-flex flex-lg-row flex-column align-items-center justify-content-lg-start justify-content-center">
                                        <select class="form-select" aria-label="Default select example"
                                            name="payment_method">
                                            <option selected>Silahkan pilih Metode pembayaran</option>
                                            <option value="bca">BCA</option>
                                            <option value="mandiri">Mandiri</option>
                                            <option value="gopay">Gopay</option>
                                        </select>
                                    </h4>
                                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                    <input type="hidden" name="status" value="paid">
                                </li>
                            </ul>
                            <button type="submit" class="btn btn-learn text-white">Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('button').click(function(e) {
            e.preventDefault(); // Prevent the form from submitting

            var pointTopUp = $('select[name="point_top_up"]').val();
            var paymentMethod = $('select[name="payment_method"]').val();

            if (pointTopUp !== 'Silahkan Pilih Point' && paymentMethod !== 'Silahkan pilih Metode pembayaran') {
                var formData = new FormData($('#topUpForm')[0]);

                $.ajax({
                    url: "{{ route('top_up') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        window.location.href = "{{ route('topup.sukses') }}";
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                alert('Please select both Point and Payment Method.');
            }
        });
    });
</script>
@endsection
