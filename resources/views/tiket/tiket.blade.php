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
            <div class="row">
                <div class="col-12">
                    <div id="reader" width="600px"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="/tukarkan_kupon" method="POST">
                        @csrf
                        <div class="row">
                            <label for="">Kode QR</label>
                            <input type="text" id="result" name="result" class="form-control">
                        </div>
                        <div class="row">
                            <label for="">Nama Penerima</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="row mt-2">
                            <button class="btn btn-primary w-100">Tukarkan</button>
                        </div>
                    </form>
                </div>
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
