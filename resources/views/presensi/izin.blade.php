@extends('layout.presensi')

@section('header')

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin/Sakit</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 70px;">
        <div class="col">
        @php
            $messagesuccess = Session::get('success');
            $messageerror = Session::get('error');
        @endphp
        @if (Session::get('success'))
            <div class="alert alert-outline-success">
                {{ $messagesuccess }}
            </div>
        @else
            <div class="alert alert-outline-error">
                {{ $messageerror }}
            </div>
        @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
        @foreach ($dataizin as $h)
            {{-- <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="image" class="image">
                        <div class="in">
                            <div>
                                <b>{{ date("d-m-Y",strtotime($h->tgl_izin_dari)) }} - {{ date("d-m-Y",strtotime($h->tgl_izin_sampai)) }}</b> ({{ $h->status == "i" ? 'Izin' : 'Sakit' }})<br>
                                <small class="text-muted">{{ $h->keterangan }}</small>
                            </div>
                            @if ($h->status_approved == 0)
                                <span class="badge bg-warning">Menunggu Persetujuan HRD</span>
                            @elseif ($h->status_approved == 1)
                                <span class="badge bg-success">Disetujui HRD</span>
                            @elseif ($h->status_approved == 2)
                                <span class="badge bg-danger">Ditolak HRD</span>
                            @endif
                        </div>
                    </div>
                </li>
            </ul> --}}
            <style>
                .historycontent{
                    display: flex;
                    gap: 1px
                }
                .datapresensi{
                    margin-left: 10px
                }
                .status{
                    position: absolute;
                    right: 5px;
                }
            </style>
            @php
                if ($h->status == 'i') {
                    $status = "Izin";
                }else if ($h->status == 's') {
                    $status = "Sakit";
                }else if ($h->status == 'c') {
                    $status = "Cuti";
                }
            @endphp
            <div class="card mt-1">
                <div class="card-body">
                    <div class="historycontent">
                        <div class="iconpresensi">

                            @if ($h->status == "i")
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M9 17h6"></path>
                                    <path d="M9 13h6"></path>
                                </svg>
                            @elseif ($h->status == 's')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-medical" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M10 14l4 0"></path>
                                    <path d="M12 12l0 4"></path>
                                </svg>
                            @elseif ($h->status == 'c')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase-off" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11 7h8a2 2 0 0 1 2 2v8m-1.166 2.818a1.993 1.993 0 0 1 -.834 .182h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2"></path>
                                    <path d="M8.185 4.158a2 2 0 0 1 1.815 -1.158h4a2 2 0 0 1 2 2v2"></path>
                                    <path d="M12 12v.01"></path>
                                    <path d="M3 13a20 20 0 0 0 11.905 1.928m3.263 -.763a20 20 0 0 0 2.832 -1.165"></path>
                                    <path d="M3 3l18 18"></path>
                                </svg>
                            @endif

                        </div>
                        <div class="datapresensi">
                            <h3 style="line-height: 3px">{{ date("d-m-Y", strtotime($h->tgl_izin_dari)) }} ({{ $status }})</h3>
                            <small>{{ date("d-m-Y", strtotime($h->tgl_izin_dari)) }} s/d {{ date("d-m-Y", strtotime($h->tgl_izin_sampai)) }}</small>
                            <p>

                                {{ $h->keterangan }}
                                <br>
                                @if ($h->status = "c")
                                    <span class="badge bg-warning">{{ $h->nama_cuti }}</span>
                                @endif
                                @if (!empty($h->sid))
                                    <span style="color: blue">
                                        <ion-icon name="document-attach-outline"></ion-icon> Lihat SID
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="status">
                            @if ($h->status_approved == 0)
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($h->status_approved == 1)
                                <span class="badge bg-success">Approved</span>
                            @elseif ($h->status_approved == 2)
                                <span class="badge bg-danger">Denied</span>
                            @endif
                            <p style="margin-top: 5px; font-weight: bold;">{{ hitunghari($h->tgl_izin_dari, $h->tgl_izin_sampai) }} hari</p>
                            <a href="" class="btn btn-warning btn-sm"><ion-icon name="create-outline"></ion-icon></a> <a href="" class="btn btn-danger btn-sm"><ion-icon name="trash-outline"></ion-icon></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
        <a href="#" class="fab bg-primary" data-toggle="dropdown">
            <ion-icon name="add-outline" role="img" class="md hydrated"></ion-icon>
        </a>
        <div class="dropdown-menu">
            <a href="/izinabsen" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" aria-label="image outline" class="md hydrated"></ion-icon>
                <p>Izin Absen</p>
            </a>
            <a href="/izinsakit" class="dropdown-item bg-primary">
                <ion-icon name="medkit-outline"></ion-icon>
                <p>Sakit</p>
            </a>
            <a href="/izincuti" class="dropdown-item bg-primary">
                <ion-icon name="bag-handle-outline"></ion-icon>
                <p>Cuti</p>
            </a>
        </div>
    </div>

@endsection

