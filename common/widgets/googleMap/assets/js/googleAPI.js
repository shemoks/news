/**
 * Created by oksana on 20.05.16.
 */

$(function () {
    coordinates = [];
    isDraggableMarker = false;
    mapZoom = 15;
    mapId = '';
    langId = '';
    latId = '';
    placeId = '';
    isGetUserLocation = true;

    $.fn.googleMap = function (options) {
        mapId = options.id;
        coordinates = options.coordinates;
        isDraggableMarker = options.isDraggableMarker;
        langId = options.langId;
        latId = options.latId;
        placeId = options.placeId;
        mapZoom = options.mapZoom;
        isGetUserLocation = options.isGetUserLocation;
    };

    google.maps.event.addDomListener(window, 'load', initMap);
    function initMap() {
        var lastCoordinates = coordinates && coordinates.length ? coordinates[coordinates.length - 1] : {
            lat: 49.4285400,
            lan: 32.0620700
        };
        map = new google.maps.Map(document.getElementById(mapId), {
            center: {lat: parseFloat(lastCoordinates.lat), lng: parseFloat(lastCoordinates.lan)},
            zoom: mapZoom
        });
        autocomplete = new google.maps.places.Autocomplete(document.getElementById(placeId), {
            types: ['establishment']
        });
        infoWindow = new google.maps.InfoWindow();
        if (coordinates) {
            coordinates.forEach(function (item) {
                addMarker({lat: parseFloat(item.lat), lng: parseFloat(item.lan)}, item.title);
            });
        } else {
            addMarker({lat: parseFloat(lastCoordinates.lat), lng: parseFloat(lastCoordinates.lan)});
        }
        marker.addListener('click', toggleBounce());
        geocoder = new google.maps.Geocoder();
        Geodolocation();
        AddEvents();
    }
});

function addMarker(position, title) {
    marker = new google.maps.Marker({
        map: map,
        draggable: isDraggableMarker,
        animation: google.maps.Animation.DROP,
        position: position,
        title: isDraggableMarker ? "Drag me!" : null
    });
    if (typeof title != 'undefined') {
        marker.addListener('click', function (evt) {
            infoWindow.setPosition(evt.latLng);
            infoWindow.setContent(title);
            infoWindow.open(map);
        });
    }
}

function Geodolocation() {
    google.maps.event.addListener(marker, 'dragend', function (evt) {
        map.setCenter(marker.position);
        geocoder.geocode({'latLng': evt.latLng}, function (data, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#' + placeId).val(data[0].formatted_address);
                $('#' + latId).val(evt.latLng.lat());
                $('#' + langId).val(evt.latLng.lng());
            }
        })
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            if (isGetUserLocation) {
                marker.setPosition(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
            }
            map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

function AddEvents() {
    $(document).on('focusout', '#' + placeId, function () {
        var address = $('#' + placeId).val();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var location = results[0].geometry.location;
                map.setCenter(location);
                marker.setPosition(location);
                $('#' + latId).val(location.lat());
                $('#' + langId).val(location.lng());
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    });
}
