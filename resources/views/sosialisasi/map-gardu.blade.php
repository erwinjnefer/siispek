@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

<style>
    #map {
        width: 600px;
        height: 400px;
    }

    .icon-green
    {
    background:green;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .icon-red
    {
    background:#4B0082;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .icon-blue
    {
    background:blue;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .icon-purple
    {
    background:purple;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .icon-yellow
    {
    background:yellow;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .icon-black
    {
    background:black;
    border:5px solid rgba(255,255,255,0.5);
    color:blue;
    font-weight:bold;
    text-align:center;
    border-radius:50%;
    line-height:30px;
    }

    .custom-div-icon i.awesome {
        margin: 12px auto;
        font-size: 32px;
    }


    

</style>

@endsection
@section('content')
<div id="map" style="width:100%;height:780px;"></div>
@endsection
@section('js')
<script>
    var locations = []
    init()

    
    function init(){
        locations = @json($map_ref, JSON_PRETTY_PRINT);
        
    
        var map = L.map('map').setView([-8.721099, 117.198298], 8);
        mapLink ='<a href="http://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 18,
        }).addTo(map);

        
        for (var i = 0; i < locations.length; i++) {
            var icon = 'icon-black';
            if(locations[i].nama_rayon === 'AMPENAN'){
                icon = 'icon-black'
            }else if(locations[i].nama_rayon === 'CAKRA'){
                icon = 'icon-red'
            }else if(locations[i].nama_rayon === 'PRAYA'){
                icon = 'icon-yellow'
            }else if(locations[i].nama_rayon === 'PRINGGABAYA'){
                icon = 'icon-green'
            }else if(locations[i].nama_rayon === 'SELONG'){
                icon = 'icon-blue'
            }else if(locations[i].nama_rayon === 'TANJUNG'){
                icon = 'icon-purple'
            }
            var myIcon = L.divIcon({className: icon});
            marker = new L.marker([locations[i].koordinat_y, locations[i].koordinat_x], {icon: myIcon})
                .bindPopup(locations[i].no_gardu+'/'+locations[i].nama_penyulang+'/'+locations[i].alamat+'/'+locations[i].nama_rayon)
                .addTo(map);
        }

        
        var icon = L.divIcon({
                className: 'custom-div-icon',
                    html: "<div class='marker-pin'></div><i style='color:#FF0000 ;' class='fa fa-map-pin awesome'>",
                    iconSize: [30, 42],
                    iconAnchor: [15, 42]
                });
                
                

            // marker = new L.marker([loc[0], loc[1]], {icon: icon})
            //     .bindPopup(sos.judul+'/'+sos.lokasi)
            //     .addTo(map);
        
    }
    
    
    // var locations = [
    // ["RADEN CELL", -8.6036638,116.0755969],
    // ["LOMBOK VAGANZA", -8.587661,116.0990838],
    // ["TRANSMART LOMBOK", -8.587661,116.0990838],
    // ["TAMAN LOANG BALOQ", -8.6000811,116.0787665],
    // ["TAMAN MAKAM PAHLAWAN", -8.5812511,116.0998379]
    // ];

    
    

</script>
@endsection