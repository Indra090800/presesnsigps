@extends('layout.admin.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Monitoring Presensi
        </h2>
        </div>
        <!-- Page title actions -->
    </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                        <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M11 15h1"></path>
                                    <path d="M12 15v3"></path>
                                    </svg>  
                                </span>
                                <input type="text" name="tanggal" value="{{ date("Y-m-d") }}" id="tanggal" class="form-control" placeholder="Tanggal Presensi" autocomplete="off">
                              </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sthiped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIK</th>
                                                <th>Nama Karyawan</th>
                                                <th>Departemen</th>
                                                <th>Jam Kerja</th>
                                                <th>Jam Masuk</th>
                                                <th>Foto Masuk</th>
                                                <th>Jam Pulang</th>
                                                <th>Foto Pulang</th>
                                                <th>Keterangan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadpresensi"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-tampilpeta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Lokasi Presensi User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadmap">
            
        </div>
    </div>
    </div>
</div>

@endsection

@push('myscripct')
    <script>
        $(function () {
            $("#tanggal").datepicker({ 
                    autoclose: true, 
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
            }).datepicker('update', new Date());

            function loadpresensi()
            {
                var tanggal = $("#tanggal").val();

                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,

                    },
                    cache: false,
                    success: function(respond){
                        $("#loadpresensi").html(respond);
                    },
                });
            }
            $("#tanggal").change(function(e){
                loadpresensi();
            });

            loadpresensi();
        });
    </script>
@endpush