@extends('layout.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Pengajuan Izin/Sakit
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

                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sthiped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Dari</th>
                                                    <th>Tanggal Sampai</th>
                                                    <th>NIK</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Jabatan</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th>Status Approved</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($pengajuan_now as $p)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $p->tgl_izin_dari }}</td>
                                                        <td>{{ $p->tgl_izin_sampai }}</td>
                                                        <td>{{ $p->nik }}</td>
                                                        <td>{{ $p->nama_lengkap }}</td>
                                                        <td>{{ $p->jabatan }}</td>
                                                        <td>
                                                            @if ($p->status == 'i')
                                                                Izin
                                                            @elseif ($p->status == 's')
                                                                Sakit
                                                            @endif
                                                        </td>
                                                        <td>{{ $p->keterangan }}</td>
                                                        <td>
                                                            @if ($p->status_approved == 0)
                                                                <a href="#" class="btn btn-warning btn-sm">Pending</a>
                                                            @elseif ($p->status_approved == 1)
                                                                <a href="#"
                                                                    class="btn btn-success btn-sm">Disetujui</a>
                                                            @elseif ($p->status_approved == 2)
                                                                <a href="#" class="btn btn-red btn-sm">Ditolak</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($p->status_approved == 0)
                                                                <a href="#" class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit{{ $p->id_izin }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-edit"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
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
                                                            @else
                                                                <a href="/batalkan/{{ $p->id_izin }}"
                                                                    class="btn btn-danger btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-edit"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"></path>
                                                                        <path
                                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                        </path>
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                        </path>
                                                                        <path d="M16 5l3 3"></path>
                                                                    </svg>Batalkan
                                                                </a>
                                                            @endif

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

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="/presensi/datapengajuan" method="GET" autocomplete="off">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-calendar" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                            </path>
                                                            <path d="M16 3v4"></path>
                                                            <path d="M8 3v4"></path>
                                                            <path d="M4 11h16"></path>
                                                            <path d="M11 15h1"></path>
                                                            <path d="M12 15v3"></path>
                                                        </svg>
                                                    </span>
                                                    <input type="text" value="{{ Request('dari') }}" name="dari"
                                                        id="dari" class="form-control" placeholder="Dari">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-calendar" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                            </path>
                                                            <path d="M16 3v4"></path>
                                                            <path d="M8 3v4"></path>
                                                            <path d="M4 11h16"></path>
                                                            <path d="M11 15h1"></path>
                                                            <path d="M12 15v3"></path>
                                                        </svg>
                                                    </span>
                                                    <input type="text" value="{{ Request('sampai') }}" name="sampai"
                                                        id="sampai" class="form-control" placeholder="Sampai">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
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
                                                    <input type="text" value="{{ Request('nik') }}" name="nik"
                                                        class="form-control" placeholder="NIK" id="nik">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                        </svg>
                                                    </span>
                                                    <input type="text" value="{{ Request('nama_lengkap') }}"
                                                        name="nama_lengkap" id="nama_lengkap" class="form-control"
                                                        placeholder="Nama Karyawan">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <select name="status_approved" id="status_approved"
                                                        class="form-select">
                                                        <option value="">Pilih Status</option>
                                                        <option value="0"
                                                            {{ Request('status_approved') === '0' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="1"
                                                            {{ Request('status_approved') == 1 ? 'selected' : '' }}>
                                                            Disetujui</option>
                                                        <option value="2"
                                                            {{ Request('status_approved') == 2 ? 'selected' : '' }}>Ditolak
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-search" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sthiped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Dari</th>
                                                    <th>Tanggal Sampai</th>
                                                    <th>NIK</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Jabatan</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th class="text-center">Status Approved</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($pengajuan as $p)
                                                    <tr>
                                                        <td>{{ $loop->iteration + $pengajuan->firstItem() - 1 }}</td>
                                                        <td>{{ $p->tgl_izin_dari }}</td>
                                                        <td>{{ $p->tgl_izin_sampai }}</td>
                                                        <td>{{ $p->nik }}</td>
                                                        <td>{{ $p->nama_lengkap }}</td>
                                                        <td>{{ $p->jabatan }}</td>
                                                        <td>
                                                            @if ($p->status == 'i')
                                                                <a href="#" class="btn btn-warning btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-off">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M11 7h8a2 2 0 0 1 2 2v8m-1.166 2.818a1.993 1.993 0 0 1 -.834 .182h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                                                                        <path
                                                                            d="M8.185 4.158a2 2 0 0 1 1.815 -1.158h4a2 2 0 0 1 2 2v2" />
                                                                        <path d="M12 12v.01" />
                                                                        <path
                                                                            d="M3 13a20 20 0 0 0 11.905 1.928m3.263 -.763a20 20 0 0 0 2.832 -1.165" />
                                                                        <path d="M3 3l18 18" />
                                                                    </svg>
                                                                    Izin</a>
                                                            @elseif ($p->status == 's')
                                                                <a href="#" class="btn btn-danger btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-device-audio-tape">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                                        <path d="M3 17l4 -3h10l4 3" />
                                                                        <circle cx="7.5" cy="9.5" r=".5"
                                                                            fill="currentColor" />
                                                                        <circle cx="16.5" cy="9.5" r=".5"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                    Sakit</a>
                                                            @elseif ($p->status == 'c')
                                                                <a href="#" class="btn btn-primary btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-luggage-off">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M10 6h6a2 2 0 0 1 2 2v6m0 4a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-10c0 -.546 .218 -1.04 .573 -1.4" />
                                                                        <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1" />
                                                                        <path d="M6 10h4m4 0h4" />
                                                                        <path d="M6 16h10" />
                                                                        <path d="M9 20v1" />
                                                                        <path d="M15 20v1" />
                                                                        <path d="M3 3l18 18" />
                                                                    </svg>
                                                                    Cuti</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $p->keterangan }}</td>
                                                        <td class="text-center">
                                                            @if ($p->status_approved == 0)
                                                                <a href="#" class="btn btn-warning btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit{{ $p->id_izin }}">Pending</a>
                                                            @elseif ($p->status_approved == 1)
                                                                <a href="#" class="btn btn-success btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit{{ $p->id_izin }}">Accepted</a>
                                                            @elseif ($p->status_approved == 2)
                                                                <a href="#" class="btn btn-red btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit{{ $p->id_izin }}">Deccepted</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $pengajuan->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($pengajuan as $p)
        <div class="modal modal-blur fade" id="edit{{ $p->id_izin }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pengajuan Izin/Sakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/presensi/uppengajuan/{{ $p->id_izin }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="status_approved" id="status_approved" class="form-select">
                                            <option value="1">Disetujui</option>
                                            <option value="2">Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-send" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 14l11 -11"></path>
                                                <path
                                                    d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                                </path>
                                            </svg>Simpan
                                        </button>
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
            $("#dari, #sampai").datepicker({
                format: 'yyyy-mm-dd'
            }).datepicker('update', new Date());
        });
    </script>
@endpush
