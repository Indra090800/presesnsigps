@extends('layout.admin.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Jam Kerja
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
                                <a href="#" class="btn btn-primary" id="btnTambah">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                                </svg>    
                                Tambah Data</a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/jamKerja" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_jamKerja" id="nama_jamKerja" value="{{ Request('nama_jamKerja') }}"  class="form-control" placeholder="Nama jamKerja">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                                <th class="text-center">Kode Jam Kerja</th>
                                                <th class="text-center">Nama Jam Kerja</th>
                                                <th class="text-center">Awal Jam Masuk</th>
                                                <th class="text-center">Jam Masuk</th>
                                                <th class="text-center">Akhir Jam Masuk</th>
                                                <th class="text-center">Jam Pulang</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jam_kerja as $j)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $j->kode_jamKerja }}</td>
                                                    <td class="text-center">{{ $j->nama_jamKerja }}</td>
                                                    <td class="text-center">{{ $j->awal_jam_in }}</td>
                                                    <td class="text-center">{{ $j->jam_masuk }}</td>
                                                    <td class="text-center">{{ $j->akhir_jam_in }}</td>
                                                    <td class="text-center">{{ $j->jam_pulang }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <form action="/jamKerja/{{ $j->kode_jamKerja }}/delete" method="POST" style="margin-left: 5px;">
                                                                @csrf
                                                                <a class="btn btn-danger btn-sm btnEdit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3"></path>
                                                                <path d="M18 13.3l-6.3 -6.3"></path>
                                                                </svg>
                                                                </a>
                                                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editjamKerja{{ $j->kode_jamKerja }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
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

<div class="modal modal-blur fade" id="modal-inputjamKerja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Tambah Data Jam Kerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/addjamKerja" method="POST" id="frmjamKerja">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" name="kode_jamKerja" class="form-control" placeholder="Kode jamKerja" id="kode_jamKerja">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" name="nama_jamKerja" id="nama_jamKerja" class="form-control" placeholder="Nama jamKerja">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13"></path>
                                    <path d="M9 4v13"></path>
                                    <path d="M15 7v13"></path>
                                 </svg>  
                            </span>
                            <input type="text" name="awal_jam_in" id="awal_jam_in" class="form-control" placeholder="Awal Jam Masuk C: 00:00:00">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-current-location" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0"></path>
                                    <path d="M12 2l0 2"></path>
                                    <path d="M12 20l0 2"></path>
                                    <path d="M20 12l2 0"></path>
                                    <path d="M2 12l2 0"></path>
                                 </svg> 
                            </span>
                            <input type="text" name="jam_in" id="jam_in" class="form-control" placeholder="Jam Masuk C: 00:00:00">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-flightradar24" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M12 12m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                                    <path d="M8.5 20l3.5 -8l-6.5 6"></path>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                 </svg> 
                            </span>
                            <input type="text" name="akhir_jam_in" id="akhir_jam_in" class="form-control" placeholder="Akhir Jam Masuk C: 00:00:00">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    <path d="M15 6h6m-3 -3v6"></path>
                                 </svg> 
                            </span>
                            <input type="text" name="jam_pulang" id="jam_pulang" class="form-control" placeholder="jam_pulang C: 00:00:00">
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 14l11 -11"></path>
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                </svg>    
                            Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

@foreach ($jam_kerja as $k)
<div class="modal modal-blur fade" id="editjamKerja{{ $k->kode_jamKerja }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data jamKerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/jamKerja/{{ $k->kode_jamKerja }}/edit" method="POST" id="frjamKerja" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" value="{{ $k->kode_jamKerja }}" name="kode_jamKerja" class="form-control" placeholder="Kode " id="kode_jamKerja" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" value="{{ $k->nama_jamKerja }}" name="nama_jamKerja" id="nama_jamKerja" class="form-control" placeholder="Nama jamKerja">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13"></path>
                                    <path d="M9 4v13"></path>
                                    <path d="M15 7v13"></path>
                                 </svg>  
                            </span>
                            <input type="text" value="{{ $k->awal_jam_in }}" name="awal_jam_in" id="awal_jam_in" class="form-control" placeholder="Awal jamKerja">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-current-location" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0"></path>
                                    <path d="M12 2l0 2"></path>
                                    <path d="M12 20l0 2"></path>
                                    <path d="M20 12l2 0"></path>
                                    <path d="M2 12l2 0"></path>
                                 </svg> 
                            </span>
                            <input type="text" value="{{ $k->jam_masuk }}" name="jam_in" id="jam_in" class="form-control" placeholder="Jam Masuk">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-flightradar24" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M12 12m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                                    <path d="M8.5 20l3.5 -8l-6.5 6"></path>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                 </svg> 
                            </span>
                            <input type="text" value="{{ $k->akhir_jam_in }}" name="akhir_jam_in" id="akhir_jam_in" class="form-control" placeholder="akhir_jam_in">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    <path d="M15 6h6m-3 -3v6"></path>
                                 </svg> 
                            </span>
                            <input type="text" value="{{ $k->jam_pulang }}" name="jam_pulang" id="jam_pulang" class="form-control" placeholder="jam_pulang">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 14l11 -11"></path>
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
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