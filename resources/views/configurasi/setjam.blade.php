@extends('layout.admin.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Set Jam Kerja Karyawan
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
                <table class="table">
                    <tr>
                        <th>NIK</th>
                        <td>{{ $karyawan->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td>{{ $karyawan->nama_lengkap }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="/konfig/setJamKaryawan" method="POST">
                    @csrf
                    <input type="hidden" name="nik" value="{{ $karyawan->nik }}">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Senin <input type="hidden" name="hari[]" value="Senin"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Selasa <input type="hidden" name="hari[]" value="Selasa"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Rabu <input type="hidden" name="hari[]" value="Rabu"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kamis <input type="hidden" name="hari[]" value="Kamis"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumat <input type="hidden" name="hari[]" value="Jumat"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Sabtu <input type="hidden" name="hari[]" value="Sabtu"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr><tr>
                                <td>Minggu <input type="hidden" name="hari[]" value="Minggu"></td>
                                <td>
                                    <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-control">
                                        <option value="">Pilih / SetJam</option>
                                        @foreach ($jam as $j )
                                            <option value="{{ $j->kode_jamKerja }}">{{ $j->nama_jamKerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
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

@endsection