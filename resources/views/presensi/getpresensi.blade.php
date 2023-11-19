@php
function selisih($jam_masuk, $jam_keluar)
{
    list($h, $m, $s) = explode(":", $jam_masuk);
    $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    list($h, $m, $s) = explode(":", $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];
    return $jml_jam . ":" . round($sisamenit2);
}
@endphp
@foreach ($presensi as $p)
@php
    $path_in = Storage::url('uploads/absensi/'.$p->foto_in);
    $path_out = Storage::url('uploads/absensi/'.$p->foto_out);
@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->nik }}</td>
        <td>{{ $p->nama_lengkap }}</td>
        <td>{{ $p->nama_dept }}</td>
        <td>{{ $p->nama_jamKerja }} : {{ $p->jam_masuk }} - {{ $p->jam_pulang }}</td>
        <td>{{ $p->jam_in }}</td>
        <td class="text-center">
            <img src="{{ url($path_in) }}" alt="" class="avatar">
        </td>
        <td>{!! $p->jam_out != null ? $p->jam_out : '<span class="badge bg-danger">Belum Absen</span>' !!}</td>
        <td class="text-center">
            @if ($p->jam_out != null)
            <img src="{{ url($path_out) }}" alt="" class="avatar">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 6l0 -3"></path>
                <path d="M16.25 7.75l2.15 -2.15"></path>
                <path d="M18 12l3 0"></path>
                <path d="M16.25 16.25l2.15 2.15"></path>
                <path d="M12 18l0 3"></path>
                <path d="M7.75 16.25l-2.15 2.15"></path>
                <path d="M6 12l-3 0"></path>
                <path d="M7.75 7.75l-2.15 -2.15"></path>
                </svg>
            @endif
        </td>
        <td>
            @if ($p->jam_in > $p->jam_masuk)
            @php
               $jam_telat = selisih($p->jam_masuk, $p->jam_in);
            @endphp
                <span class="badge bg-danger">Terlambat {{ $jam_telat }}</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td>
        <td><a href="#" class="btn btn-primary tampilpeta" id="{{ $p->id_presensi }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
            <path d="M9 4v13"></path>
            <path d="M15 7v5.5"></path>
            <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
            <path d="M19 18v.01"></path>
            </svg>
        </a></td>
    </tr>
@endforeach

<script>
    $(function(){
        $(".tampilpeta").click(function(){
            var id = $(this).attr("id")
        
            $.ajax({
                type: 'POST',
                url: '/tampilpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond){
                    $("#loadmap").html(respond);
                }
            });
            $("#modal-tampilpeta").modal("show");
        });
    });
</script>