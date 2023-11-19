@extends('layout.admin.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Edit Set Jam Kerja Departemen
        </h2>
        </div>
        <!-- Page title actions -->
    </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
    <form action="/konfig/jamKerjaDept/{{ $set->kode_jk_dept }}/editJkDept" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_cabang" id="kode_cabang" class="form-select">
                                    <option value="{{ $set->kode_cabang }}">{{ $set->nama_cabang }}</option>
                                    @foreach ($kode_cabang as $k)
                                        <option value="{{ $k->kode_cabang }}">{{ $k->nama_cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_dept" id="kode_dept" class="form-select">
                                    <option value="{{ $set->kode_dept }}">{{ $set->nama_dept }}</option>
                                    @foreach ($kode_dept as $k)
                                        <option value="{{ $k->kode_dept }}">{{ $k->nama_dept }}</option>
                                    @endforeach
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
                            @foreach ($setjam as $s)
                                <tr>
                                    <td>{{ $s->hari }} <input type="hidden" name="hari[]" value="{{ $s->hari }}"></td>
                                    <td>
                                        <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                            <option value="{{ $s->kode_jamKerja }}">{{ $s->nama_jamKerja }}</option>
                                            @foreach ($jam as $j )
                                                <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                
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
    </form>
    </div>
</div>

@endsection