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
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="image" class="image">
                        <div class="in">
                            <div>
                                <b>{{ date("d-m-Y",strtotime($h->tgl_izin)) }}</b> ({{ $h->status == "i" ? 'Izin' : 'Sakit' }})<br>
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
            </ul>
        @endforeach
        </div>
    </div>
    
    <div class="fab-button bottom-right" style="margin-bottom: 70px;">
        <a href="/presensi/buatizin" class="fab">
        <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection