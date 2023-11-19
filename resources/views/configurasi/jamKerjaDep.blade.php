@extends('layout.admin.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Jam Kerja Departemen
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
                        <div class="row">
                            <div class="col-12">
                            
                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::get('error'))
                                <div class="alert alert-error">
                                    {{ Session::get('error') }}
                                </div>  
                            @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="/konfig/jamKerjaDept/create" class="btn btn-primary" id="btnTambah">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                                </svg>    
                                Tambah Data</a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Cabang</th>
                                                <th>Departemen</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach ($jkdept as $j)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $j->kode_jk_dept }}</td>
                                                    <td>{{ $j->nama_cabang }}</td>
                                                    <td>{{ $j->nama_dept }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                        <form action="/konfig/jamKerjaDept/{{ $j->kode_jk_dept }}/deleteJkDept" method="POST" style="margin-left: 5px;">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sm btnEdit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3"></path>
                                                            <path d="M18 13.3l-6.3 -6.3"></path>
                                                            </svg>
                                                            </a>
                                                            <a href="/konfig/jamKerjaDept/{{ $j->kode_jk_dept }}/edit" class="btn btn-warning btn-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                <path d="M16 5l3 3"></path>
                                                                </svg>
                                                            </a>
                                                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editjkdept{{ $j->kode_jk_dept }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                                                 </svg>
                                                            </a>
                                                        </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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

@foreach ($jkdept as $j)
<div class="modal modal-blur fade" id="editjkdept{{ $j->kode_jk_dept }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">View Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="kode_cabang" id="kode_cabang" class="form-select">
                                            <option value="{{ $j->kode_cabang }}">{{ $j->nama_cabang }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                            <option value="{{ $j->kode_dept }}">{{ $j->nama_dept }}</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $setjam = DB::table('jk_dept_detail')
                                    ->join('jam_kerja', 'jk_dept_detail.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
                                    ->where('kode_jk_dept', $j->kode_jk_dept)
                                    ->get();
                                @endphp
                                @foreach ($setjam as $s)
                                    <tr>
                                        <td>{{ $s->hari }} <input type="hidden" name="hari[]" value="{{ $s->hari }}"></td>
                                        <td>
                                            <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control" @readonly(true)>
                                                <option value="{{ $s->kode_jamKerja }}">{{ $s->nama_jamKerja }}</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach                            
                            </tbody>
                        </table>
                    
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="6">Master Jam Kerja</th>
                                </tr>
                                <tr>
                                    <th>Kode Jam Kerja</th>
                                    <th>Nama</th>
                                    <th>Awal Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Akhir Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jam as $j)
                                    <tr>
                                        <td>{{ $j->kode_jamKerja }}</td>
                                        <td>{{ $j->nama_jamKerja }}</td>
                                        <td>{{ $j->awal_jam_in }}</td>
                                        <td>{{ $j->jam_masuk }}</td>
                                        <td>{{ $j->akhir_jam_in }}</td>
                                        <td>{{ $j->jam_pulang }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endforeach


@endsection

@push('myscripct')
    <script>
         $(function(){

            $("#awal_jam_in, #jam_masuk, #akhir_jam_in, #jam_pulang").mask("00:00:00");
            $("#btnTambah").click(function(){
                $("#modal-inputjamKerja").modal("show");
            });

            $(".btnEdit").click(function(e){
                var form = $(this).closest('form'); 
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah yakin ingin menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire('Data Berhasil Di Hapus !!!', '', 'success')
                } 
                })
            });


            $("#frmjamKerja").submit(function(){
                var kode_jamKerja = $("#kode_jamKerja").val();
                var nama_jamKerja = $("#frmjamKerja").find("#nama_jamKerja").val();
                var awal_jam_in = $("#frmjamKerja").find("#awal_jam_in").val();
                var jam_in = $("#frmjamKerja").find("#jam_in").val();
                var akhir_jam_in = $("#frmjamKerja").find("#akhir_jam_in").val();
                var jam_pulang = $("#frmjamKerja").find("#jam_pulang").val();

                if(kode_jamKerja==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'kode_jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_jamKerja").focus();
                    });
                    
                    return false;
                }else if(nama_jamKerja==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama_jamKerja").focus();
                    });
                    
                    return false;
                } else if(awal_jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Awal jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#awal_jam_in").focus();
                    });
                    
                    return false;
                }else if(jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Masuk Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_in").focus();
                    });
                    
                    return false;
                }else if(akhir_jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Akhir jam Masuk Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#akhir_jam_in").focus();
                    });
                    
                    return false;
                }else if(jam_pulang==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'jam_pulang Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_pulang").focus();
                    });
                    
                    return false;
                }
            });

            $("#frjamKerja").submit(function(){
                var kode_jamKerja = $("#frjamKerja").find("#kode_jamKerja").val();
                var nama_jamKerja = $("#frjamKerja").find("#nama_jamKerja").val();
                var awal_jam_in = $("#frjamKerja").find("#awal_jam_in").val();
                var jam_in = $("#frjamKerja").find("#jam_in").val();
                var akhir_jam_in = $("#frjamKerja").find("#akhir_jam_in").val();
                var jam_pulang = $("#frjamKerja").find("#jam_pulang").val();

                if(kode_jamKerja==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'kode_jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_jamKerja").focus();
                    });
                    
                    return false;
                }else if(nama_jamKerja==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama_jamKerja").focus();
                    });
                    
                    return false;
                } else if(awal_jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#awal_jam_in").focus();
                    });
                    
                    return false;
                }else if(jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_in").focus();
                    });
                    
                    return false;
                }else if(akhir_jam_in==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#akhir_jam_in").focus();
                    });
                    
                    return false;
                }else if(jam_pulang==""){
                    Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jamKerja Harus Diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_pulang").focus();
                    });
                    
                    return false;
                }
            });
        });
    </script>    
@endpush