import $ from 'jquery';

import L from 'leaflet';

let contact = {

    load(){

        if ( wp_data.options.maps_provider == 'google' && $('#contact-map').length > 0 ) {
            $.getScript("https://maps.googleapis.com/maps/api/js?key=" + wp_data.options.maps_google_api_key, function () {
                contact.loaded();
            });
        }else if (wp_data.options.maps_provider == 'openstreetmap'){
            contact.loaded();
        }

    },

    loaded() {

        $(document).ready(function () {

            if ( $('#contact-map').length > 0 ){

                if (wp_data.options.maps_provider == 'google'){
                    google_new_map( $('#contact-map') );
                }else if(wp_data.options.maps_provider == 'openstreetmap'){
                    osm_new_map( $('#contact-map') );
                }
            }

        });

        // Create a map with Leaflet (OpenStreetMap)
        function osm_new_map ( $el ){
            let map = L.map($el.attr('id')).setView([$el.attr('data-center-lat'), $el.attr('data-center-lng')], 13);

            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);

            let $markers = $el.find('.marker');
            let bounds = [];

            let pinIcon = L.icon({
                iconUrl: wp_data.images_path + 'pin.png',
                iconSize:     [40, 50],
                iconAnchor:   [20, 50],
                popupAnchor:  [0, -55]
            });

            if (wp_data.options.maps_pin !== false){
                pinIcon = L.icon({
                    iconUrl: wp_data.options.maps_pin,
                    iconSize:     [wp_data.options.maps_pin_width, wp_data.options.maps_pin_height],
                    iconAnchor:   [Math.round(wp_data.options.maps_pin_width / 2), wp_data.options.maps_pin_height],
                    popupAnchor:  [0, -5 - wp_data.options.maps_pin_height]
                });
            }

            $markers.each(function(){
                let marker_position = [$(this).attr('data-lat'), $(this).attr('data-lng')];
                bounds.push(marker_position);
                let marker = L.marker(marker_position, {icon: pinIcon}).addTo(map);

                if ($(this).html() !== ''){
                    marker.bindPopup($(this).html());
                }
            });

            map.fitBounds(bounds);
            map.scrollWheelZoom.disable();
        }

        // Create a Google Map
        function google_new_map( $el ) {

            let $markers = $el.find('.marker');

            try{

                let styles = [];
                if (wp_data.options.maps_snazzy !== ''){
                    styles = JSON.parse(wp_data.options.maps_snazzy);
                }

                let args = {
                    zoom		: 16,
                    center		: new google.maps.LatLng($el.attr('data-center-lat'), $el.attr('data-center-lng')),
                    mapTypeId	: google.maps.MapTypeId.ROADMAP,
                    styles      : styles,
                };

                let map = new google.maps.Map( $el[0], args);

                // Default Icon
                let icon = {
                    url: wp_data.images_path + 'pin.png',
                    size: new google.maps.Size(40, 50),
                    scaledSize: new google.maps.Size(40, 50),
                    anchor: new google.maps.Point(20, 50)
                };

                // Custom Icon
                if (wp_data.options.maps_pin !== false){
                    icon = {
                        url: wp_data.options.maps_pin,
                        size: new google.maps.Size(wp_data.options.maps_pin_width, wp_data.options.maps_pin_height),
                        scaledSize: new google.maps.Size(wp_data.options.maps_pin_width, wp_data.options.maps_pin_height),
                        anchor: new google.maps.Point(Math.round(wp_data.options.maps_pin_width / 2), wp_data.options.maps_pin_height)
                    };
                }

                map.markers = [];
                $markers.each(function(){
                    google_add_marker( $(this), map, icon );
                });

                google_center_map( map );

                return map;
            }catch (e) {
                console.warn('Cannot add map yet.');
            }

        }

        function google_add_marker( $marker, map, icon ) {

            try{
                let latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

                // create marker
                let marker = new google.maps.Marker({
                    position	: latlng,
                    map			: map,
                    icon        : icon,
                });

                // add to array
                map.markers.push( marker );

                // if marker contains HTML, add it to an infoWindow
                if( $marker.html() )
                {
                    // create info window
                    let infowindow = new google.maps.InfoWindow({
                        content		: $marker.html()
                    });

                    // show info window when marker is clicked
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open( map, marker );
                    });
                }
            }catch (e) {
                console.warn('Cannot add markers yet.');
            }
        }

        function google_center_map( map ) {

            try{
                let bounds = new google.maps.LatLngBounds();

                // loop through all markers and create bounds
                $.each( map.markers, function( i, marker ){

                    let latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

                    bounds.extend( latlng );

                });

                // only 1 marker?
                if( map.markers.length === 1 )
                {
                    // set center of map
                    map.setCenter( bounds.getCenter() );
                    map.setZoom( 16 );
                }
                else
                {
                    // fit to bounds
                    map.fitBounds( bounds );
                }
            }catch (e) {
                console.warn('Cannot center map.');
            }

        }

    }
};

export default contact;