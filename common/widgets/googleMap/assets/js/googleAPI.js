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
        mapCenter = options.mapCenter;
    };

    google.maps.event.addDomListener(window, 'load', initMap);
    function initMap() {
        var lastCoordinates = coordinates && coordinates.length ? coordinates[coordinates.length-1] : {
            lat: 49.4285400,
            lan: 32.0620700
        };
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat(lastCoordinates.lat), lng: parseFloat(lastCoordinates.lan)},
            zoom: mapZoom
        });
        if (coordinates) {
            coordinates.forEach(function (item) {
                marker = new google.maps.Marker({
                    map: map,
                    draggable: isDraggableMarker,
                    animation: google.maps.Animation.DROP,
                    position: {lat: parseFloat(item.lat), lng: parseFloat(item.lan)},
                    title: isDraggableMarker ? "Drag me!" : null
                });
            });
        } else {
            marker = new google.maps.Marker({
                map: map,
                draggable: isDraggableMarker,
                animation: google.maps.Animation.DROP,
                position: {lat: parseFloat(lastCoordinates.lat), lng: parseFloat(lastCoordinates.lan)},
                title: isDraggableMarker ? "Drag me!" : null
            });
        }
        marker.addListener('click', toggleBounce());
        Geodolocation();
        AddEvents();
    }
});

function Geodolocation() {
    geocoder = new google.maps.Geocoder();
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
    $(document).on('focusout', '#' + placeId, function (evt) {
        var address = ('#' + placeId).value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('#' + latId).value = evt.latLng.lat();
                $('#' + langId).value = evt.latLng.lng();
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    });
}

//// Sets the map on all markers in the array.
//function setMapOnAll(map) {
//    for (var i = 1; i < markers.length; i++) {
//        markers[i].setMap(map);
//    }
//}
//// Removes the markers from the map, but keeps them in the array.
//function clearMarkers() {
//    setMapOnAll(null);
//}
//
//// Shows any markers currently in the array.
//function showMarkers() {
//    setMapOnAll(map);
//}
//
//// Deletes all markers in the array by removing references to them.
//function deleteMarkers() {
//    clearMarkers();
//    // markers = [];
//}
