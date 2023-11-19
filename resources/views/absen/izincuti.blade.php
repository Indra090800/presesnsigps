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
    #keterangan{
        height: 8rem !important;
    }
</style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Izin Cuti</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/izincuti/create" method="POST" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" autocomplete="off" placeholder="Dari" id="dari" name="tgl_izin_dari">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control datepicker" autocomplete="off" placeholder="Sampai" id="sampai" name="tgl_izin_sampai">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Jumlah Hari" id="jml_hari" name="jml_hari" readonly>
                </div>
                <div class="form-group">
                    <select name="kode_cuti" id="kode_cuti" class="form-control selectmaterialize">
                        <option value="">Pilih Jenis Cuti</option>
                        @foreach ($jcuti as $j)
                            <option value="{{ $j->kode_cuti }}">{{ $j->nama_cuti }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control">
                    <input type="hidden" name="status" value="c">
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

        function loadjmlhari(){
            var dari = $('#dari').val();
            var sampai = $('#sampai').val();
            var date1 = new Date(dari);
            var date2 = new Date(sampai);

            var Difference_In_Time = date2.getTime() - date1.getTime();
            var Difference_In_Day = Difference_In_Time / (1000 * 3600 * 24);
            if(dari=="" || sampai==""){
                var jmlhari = 0;
            }else{
                var jmlhari = Difference_In_Day + 1;
            }
            $('#jml_hari').val(jmlhari + " Hari");
        }

        $('#dari, #sampai').change(function(e){
            loadjmlhari();
        });

        // $("#tgl_izin").change(function(){
        //     var tgl_izin = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: '/presensi/cekpengajuan',
        //         data: {
        //             _token:"{{  csrf_token()  }}",
        //             tgl_izin: tgl_izin
        //         },
        //         cache: false,
        //         success: function(respond){
        //             if(respond==1){
        //                 Swal.fire({
        //                 title: 'Oops!',
        //                 text: "Tanggal Hari Ini Sudah Diisi!!",
        //                 icon: 'warning',
        //                 }).then((result) => {
        //                     $("#tgl_izin").val("");
        //                 });
        //             }
        //         }
        //     });
        // });

        $("#frmizin").submit(function() {
            var dari = $('#dari').val();
            var sampai = $('#sampai').val();
            var kode_cuti = $("#kode_cuti").val();
            var keterangan = $("#keterangan").val();

            if(dari == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Tanggal dari harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(sampai == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Tanggal sampai harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(kode_cuti == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Kode cuti harus diisi!!",
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
