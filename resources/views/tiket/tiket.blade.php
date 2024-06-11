@extends('layout.presensi')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Penukaran Tiket</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-outline-success">
                    {{ $messagesuccess }}
                </div>
            @else
                <div class="alert alert-outline-error">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div id="reader" width="600px"></div>
                </div>
                <input type="text" id="result" name="result">
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            $('#result').val(decodedText);
            let id = decodedText;
            html5QrcodeScanner.clear().then(_ => {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({

                    url: "{{ route('validasi') }}",
                    type: 'POST',
                    data: {
                        _methode: "POST",
                        _token: CSRF_TOKEN,
                        qr_code: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            alert('berhasil');
                        } else {
                            alert('gagal');
                        }

                    }
                });
            }).catch(error => {
                alert('something wrong');
            });
        }

        function onScanFailure(error) {
            // console.warn(`Scanning failed: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            false
        )

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@endpush
