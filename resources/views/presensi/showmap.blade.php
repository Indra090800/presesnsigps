<style>
    #map { height: 250px; }
</style>

<div id="map"></div>

<script>
    var lokasi = "{{ $presensi->lokasi_in }}";
    var lok = lokasi.split(",");
    var map = L.map('map').setView([lok[0], lok[1]], 18);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lok[0], lok[1]]).addTo(map);
    var circle = L.circle([lok[0], lok[1]], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 20
    }).addTo(map);
    var popup = L.popup()
    .setLatLng([lok[0], lok[1]])
    .setContent("{{ $presensi->nama_lengkap }}")
    .openOn(map);
</script>