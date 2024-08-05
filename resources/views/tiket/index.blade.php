@extends('layout.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Departemen
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
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/kurban" method="GET">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" name="kode_kupon" id="kode_kupon"
                                                        value="{{ Request('kode_kupon') }}" class="form-control"
                                                        placeholder="Kode Kupon">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="text" name="nama" id="nama"
                                                        value="{{ Request('nama') }}" class="form-control"
                                                        placeholder="Nama Penerima">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg>Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Kode Kupon</th>
                                                    <th class="text-center">Nama Penerima</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kupon as $k)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $k->kode_kupon }}</td>
                                                        <td>{{ $k->nama }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <form action="/kurban/{{ $k->kode_kupon }}/delete"
                                                                    method="POST" style="margin-left: 5px;">
                                                                    @csrf
                                                                    <a class="btn btn-danger btn-sm btnEdit">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-eraser"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path>
                                                                            <path
                                                                                d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3">
                                                                            </path>
                                                                            <path d="M18 13.3l-6.3 -6.3"></path>
                                                                        </svg>
                                                                    </a>
                                                                    <a href="#" class="btn btn-warning btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editkupon{{ $k->kode_kupon }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-edit"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path>
                                                                            <path
                                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                            </path>
                                                                            <path
                                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                            </path>
                                                                            <path d="M16 5l3 3"></path>
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

    @foreach ($kupon as $k)
        <div class="modal modal-blur fade" id="editkupon{{ $k->kode_kupon }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data kupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/kurban/{{ $k->kode_kupon }}/edit" method="POST" id="frkupon"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-barcode" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                                <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                                <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                                <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                                <path d="M5 11h1v2h-1z"></path>
                                                <path d="M10 11l0 2"></path>
                                                <path d="M14 11h1v2h-1z"></path>
                                                <path d="M19 11l0 2"></path>
                                            </svg>
                                        </span>
                                        <input type="text" value="{{ $k->kode_kupon }}" name="kode_kupon"
                                            class="form-control" placeholder="Kode " id="kode_kupon" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-building" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 21l18 0"></path>
                                                <path d="M9 8l1 0"></path>
                                                <path d="M9 12l1 0"></path>
                                                <path d="M9 16l1 0"></path>
                                                <path d="M14 8l1 0"></path>
                                                <path d="M14 12l1 0"></path>
                                                <path d="M14 16l1 0"></path>
                                                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>
                                            </svg>
                                        </span>
                                        <input type="text" value="{{ $k->nama }}" name="nama" id="nama"
                                            class="form-control" placeholder="Nama Departemen">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-send" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 14l11 -11"></path>
                                                <path
                                                    d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                                </path>
                                            </svg>
                                            Edit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('myscripct')
    <script>
        $(function() {
            $("#btnTambah").click(function() {
                $("#modal-inputkupon").modal("show");
            });

            $(".btnEdit").click(function(e) {
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


            $("#frmkupon").submit(function() {
                var kode_kupon = $("#kode_kupon").val();
                var nama = $("#frmkupon").find("#nama").val();

                if (kode_kupon == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'kode_kupon Harus Diisi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_kupon").focus();
                    });

                    return false;
                } else if (nama == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama Departemen Harus Diisi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama").focus();
                    });

                    return false;
                }
            });

            $("#frkupon").submit(function() {
                var kode_kupon = $("#frkupon").find("#kode_kupon").val();
                var nama = $("#frkupon").find("#nama").val();

                if (kode_kupon == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'kode_kupon Harus Diisi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_kupon").focus();
                    });

                    return false;
                } else if (nama == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama Departemen Harus Diisi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama").focus();
                    });

                    return false;
                }
            });
        });
    </script>
@endpush
