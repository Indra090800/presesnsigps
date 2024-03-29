@extends('layout.presensi')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 370px !important;
    }

    .datepicker-date-display{
        background-color: #0f3a7e !important;
    }
</style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Izin/Sakit</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/presensi/storeizin" method="POST" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" placeholder="Tanggal" id="tgl_izin" name="tgl_izin">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin/Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="Keterangan" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"    
        });

        $("#tgl_izin").change(function(){
            var tgl_izin = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/presensi/cekpengajuan',
                data: {
                    _token:"{{  csrf_token()  }}",
                    tgl_izin: tgl_izin
                },
                cache: false,
                success: function(respond){
                    if(respond==1){
                        Swal.fire({
                        title: 'Oops!',
                        text: "Tanggal Hari Ini Sudah Diisi!!",
                        icon: 'warning',
                        }).then((result) => {
                            $("#tgl_izin").val("");
                        });
                    }
                }
            });
        });

        $("#frmizin").submit(function() {
            var tglizin = $("#tgl_izin").val(); 
            var status = $("#status").val(); 
            var keterangan = $("#keterangan").val(); 

            if(tglizin == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Tanggal harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(status == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Status harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(keterangan == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Keterangan harus diisi!!",
                icon: 'warning',
                });
                return false;
            }
        });
        });

    </script>
@endpush