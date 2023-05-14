@if ($histori->isEmpty())
<div class="alert alert-outline-warning">
    <p>Data Absensi Belum Ada</p>
</div>
@endif
@foreach ($histori as $h)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{ date("d-m-Y",strtotime($h->tgl_presensi)) }}</b><br>
                    </div>
                    <span class="badge {{ $h->jam_in < "07:00" ? "bg-success" : "bg-danger"}}">{{ $h->jam_in }}</span>
                    <span class="badge bg-primary">{{ $h->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach