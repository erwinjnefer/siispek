@extends('layouts.master')
@section('css')
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPjAupse_mEy__QRexe_0wlBImq2g7a4s&callback=initialize&libraries=&v=weekly"
async
></script>
@endsection
@section('content')
<div id="googleMap" style="width:100%;height:780px;"></div>
@endsection
@section('js')
<script>
    
    
    function initialize() {
        
        var map_ref = @json($map_ref);
        var sos = @json($sos);
        
        var center = '-8.5877034,116.0990838'
        if(map_ref.length > 0){
            center = map_ref[0].koordinat
        }
        
        var map = new google.maps.Map(document.getElementById('googleMap'), {
            zoom: 15,
            center: new google.maps.LatLng(-8.5877034,116.0990838),
            mapTypeId: google.maps.MapTypeId.HYBRID
        });
        
        var infowindow = new google.maps.InfoWindow;
        
        var marker, i;
        
        var pl_db = []
        for (i = 0; i < map_ref.length; i++) { 
                // console.log(map_ref[i].koordinat_x)
            
               
                pl_db.push({lat:parseFloat(map_ref[i].koordinat_y),lng:parseFloat(map_ref[i].koordinat_x)})
                
                var iconurl = "{!! url('/') !!}"+'/circle.gif';
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(parseFloat(map_ref[i].koordinat_y),parseFloat(map_ref[i].koordinat_x)),
                    map: map,
                    // icon: iconurl,
                    label : {text: map_ref[i].no_gardu, color: "white", fontSize:"10px"},
                });
                
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent('('+map_ref[i].no_gardu+')'+map_ref[i].alamat);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            
        }

        const pl_db_flight = new google.maps.Polyline({
            path: pl_db,
            geodesic: true,
            strokeColor: "#0EB229",
            strokeOpacity: 1.0,
            strokeWeight: 3,
        });
        // pl_db_flight.setMap(map);
        
        
        var flightPlanCoordinates = [];
        for (i = 0; i < sos.length; i++) { 
            if(sos[i].koordinat != null){
                var c = sos[i].koordinat.split(',')
                // console.log(c[0])
                flightPlanCoordinates.push({lat:parseFloat(c[0]),lng:parseFloat(c[1])})
                
                
                var iconurl = "{!! url('/') !!}"+'/share.gif';
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(parseFloat(c[0]),parseFloat(c[1])),
                    map: map,
                    icon: iconurl,
                    // label : {text: sos[i].judul, color: "white", fontSize:"10px"},
                });
                
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent('('+sos[i].judul+')'+"<br>"+sos[i].koordinat);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }else{
                
            }
        }
        
        console.log(flightPlanCoordinates)
        const flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 3,
        });
        // flightPath.setMap(map);
    }
</script>
@endsection