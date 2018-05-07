<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map, #pano {
        float: left;
        height: 100%;
        width: 45%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div id="pano"></div>
    <div id="infowindow-content">
      <img id="place-icon" src="" height="16" width="16">
      <span id="place-name"  class="title"></span><br>
      <span id="place-id"></span><br>
      <span id="place-address"></span>
    </div>
    <script>
      var map;
      function initMap() {
          var myLatlng = {lat: 13.2724, lng: 100.9234};
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 13.2724, lng: 100.9234},
          zoom: 18
        });

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Click to zoom'
        });

        
        marker.addListener('click', function() {
          map.setZoom(18);
          map.setCenter(marker.getPosition());
        });

        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
              position: myLatlng,
              pov: {
                heading: 34,
                pitch: 10
              }
            });
        map.setStreetView(panorama);

        var ctaLayer = new google.maps.KmlLayer({
          url: '',
          map: map
        });

        var clickHandler = new ClickEventHandler(map, myLatlng);
      }


      /**
       * @constructor
       */
      var ClickEventHandler = function(map, origin) {
        this.origin = origin;
        this.map = map;
        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(map);
        this.placesService = new google.maps.places.PlacesService(map);
        this.infowindow = new google.maps.InfoWindow;
        this.infowindowContent = document.getElementById('infowindow-content');
        this.infowindow.setContent(this.infowindowContent);

        // Listen for clicks on the map.
        this.map.addListener('click', this.handleClick.bind(this));
      };

      ClickEventHandler.prototype.handleClick = function(event) {
        console.log('You clicked on: ' + event.latLng);
        // If the event has a placeId, use it.
        if (event.placeId) {
          console.log('You clicked on place:' + event.placeId);

          // Calling e.stop() on the event prevents the default info window from
          // showing.
          // If you call stop here when there is no placeId you will prevent some
          // other map click event handlers from receiving the event.
          event.stop();
          this.calculateAndDisplayRoute(event.placeId);
          this.getPlaceInformation(event.placeId);
        }
      };

      ClickEventHandler.prototype.calculateAndDisplayRoute = function(placeId) {
        var me = this;
        this.directionsService.route({
          origin: this.origin,
          destination: {placeId: placeId},
          travelMode: 'WALKING'
        }, function(response, status) {
          if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };

      ClickEventHandler.prototype.getPlaceInformation = function(placeId) {
        var me = this;
        this.placesService.getDetails({placeId: placeId}, function(place, status) {
          if (status === 'OK') {
            me.infowindow.close();
            me.infowindow.setPosition(place.geometry.location);
            me.infowindowContent.children['place-icon'].src = place.icon;
            me.infowindowContent.children['place-name'].textContent = place.name;
            me.infowindowContent.children['place-id'].textContent = place.place_id;
            me.infowindowContent.children['place-address'].textContent =
                place.formatted_address;
            me.infowindow.open(me.map);
          }
        });
      };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnckJfCM0a0gmuUUpvzrmUHZgqavIZIkk&libraries=places&callback=initMap"
    async defer></script>
  </body>
</html>