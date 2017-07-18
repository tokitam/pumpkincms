
var PumpGmapUtil = {};

PumpGmapUtil.onload = function() {
    var lat_h = document.getElementById('gmap_geo_lat');
    var lng_h = document.getElementById('gmap_geo_lng');
    var lat;
    var lng;

    if (lat_h == null) {
        lat_h = document.getElementById('geo_lat');
        lng_h = document.getElementById('geo_lng');

        if (lat_h == null) {
            return;
        }

        lat = lat_h.value;
        lng = lng_h.value;
    } else {
        lat = lat_h.innerHTML;
        lng = lng_h.innerHTML;
    }

    if (lat == '') {
        return;
    }

    document.getElementById("map").style.display = "block";
    
    var mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map'),
        mapOptions);

    myLatlng = new google.maps.LatLng(lat, lng);
    marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                //title:'shop'
    });
}

PumpGmapUtil.search_gmap = function(error_message) {
    var address = document.getElementById('gmap_address').value;

    if (address == '') {
        alert(error_message);
        return;
    }

    document.getElementById("map").style.display = "block";
    
    new PumpGmap('map', address);
}

var PumpGmap = (function(){

    return function(map_name, address) {

        
        var map;

        this.init = function() {
            var name = document.getElementById(map_name);

            this.map = new google.maps.Map(name, {
                zoom: 15,
                center: new google.maps.LatLng(147.552636,-122.654543),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            this.getLatLng(address);
        }



        this.getLatLng = function(place) {
           
            map = this.map;

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address: place,
                region: 'jp'
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var bounds = new google.maps.LatLngBounds();

                    for (var r in results) {
                        if (results[r].geometry) {

                            var latlng = results[r].geometry.location;
                            bounds.extend(latlng);
                            var address = results[r].formatted_address.replace(/^日本, /, '');
                            
                            new google.maps.InfoWindow({
                                content: address + "<br>(Lat, Lng) = " + latlng.toString()
                            }).open(map, new google.maps.Marker({
                                position: latlng,
                                map: map
                            }));
                            //alert('OK1 ' + latlng);
                            latlng = "" + latlng;
                            arr = latlng.split(",");
                            //alert('OK2');
                            var geo_lat = arr[0];
                            //alert('OK3');
                            var geo_lng = arr[1];
                            //alert('OK4');
                            geo_lat = geo_lat.replace(/(^[^0-9\.]+)|([^0-9\.]+$)/g, "");
                            geo_lng = geo_lng.replace(/(^[^0-9\.]+)|([^0-9\.]+$)/g, "");
                            //alert(' geo_lat:' + geo_lat);
                            //document.getElementById('latlng').value = latlng;
                            document.getElementById('geo_lat').value = geo_lat;
                            document.getElementById('geo_lng').value = geo_lng;
                        }
                    }
                    map.fitBounds(bounds);
                } else if (status == google.maps.GeocoderStatus.ERROR) {
                    alert("error ()");
                } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
                    alert("error (INVALID_REQUEST)");
                } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                    alert("error (REQUEST_DENIED)");
                } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
                    alert("error (REQUEST_DENIED)");
                } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
                    alert("error (UNOWN_ERROR)");
                } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                    alert("error (ZERO_RESULTS)");
                } else {
                    alert("Unknown error");
                }
            });
        }

        this.init();
        
    }

})();

