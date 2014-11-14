/*
    Developer: Archie Makuwa
    Date: May 2014
    Script to track location and do other js stuff for the my location plugin...
*/

jQuery(document).ready(function() {

    // Geo location - powered by Google Maps
    var map;

    function initialize() {
        var mapOptions = {
            zoom: 14
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        // Try HTML5 geolocation
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lati = position.coords.latitude;
                var longi = position.coords.longitude;

                var pos = new google.maps.LatLng(lati,longi);

                var infowindow = new google.maps.InfoWindow({
                    map: map,
                    position: pos,
                    content: 'I am here...'
                });

                map.setCenter(pos);     //center map on location


                // Do something about the coordinates || Append values to data attributes
                jQuery('#inputLat').val(lati);
                jQuery('#inputLong').val(longi);

            }, function() {
                handleNoGeolocation(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
        }

    }

    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            var content = 'Error: The Geolocation service failed.';
        } else {
            var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
            map: map,
            position: new google.maps.LatLng(60, 105),
            content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);

    }

    google.maps.event.addDomListener(window, 'load', initialize);

});