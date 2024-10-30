document.addEventListener('DOMContentLoaded', function(e) {
  
  const map = L.map(map_el, {
    gestureHandling: true,
  });
  const mapWidth = document.getElementById(map_el).offsetWidth;
  const zoomOffset = 1.5;

  // Render map
  (function (){
    //adjust zoom relative to map width 570
    let mapZoom = mapWidth / 570 + start_zoom - zoomOffset;
    mapZoom = mapZoom > 20 ? 20 : mapZoom < 0 ? 0 : mapZoom
    
    // Center map
    map.setView([start_lat, start_lng], start_zoom);

    // Set map style
    if(mapStyle == 'Custom1') {
      L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    }else if(mapStyle == 'Custom2') {
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    }else if(mapStyle == 'Custom3') {
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        tileSize: 512,
        zoomOffset: -1
      }).addTo(map);
    }else {
      // Default
      L.tileLayer.provider(mapStyle).addTo(map);
    }

    // Render locations
    let markers;
    if(laa_disable_cluster) {
      markers = L.layerGroup();
    }else{
      markers = L.markerClusterGroup({
        showCoverageOnHover: false,
        removeOutsideVisibleBounds: false,
        maxClusterRadius: 40
      });
    }

    // Marker Icon
    let markerIcon = L.icon({
      iconUrl: marker_icon_url,
      iconSize: [26, 41],
      iconAnchor: [13, 41],
      popupAnchor: [0, -25],
      shadowUrl: marker_shadow_url,
      shadowSize: [41, 41],
      shadowAnchor: [13, 41]
    });

    for (let i = 0; i < locations.length; i++) {
      let marker = L.marker([locations[i].lat, locations[i].lng], {icon: markerIcon});
      marker.bindPopup(locations[i].content);
      markers.addLayer(marker);
    }

    map.addLayer(markers);

  })();

  // Event: Change Area
  document.querySelectorAll('.change_location').forEach(function(btn) {
    btn.onclick = function(event) {
      let el = event.currentTarget;
      let mapLat = parseFloat(el.getAttribute('data-lat'));
      let mapLng = parseFloat(el.getAttribute('data-lng'));
      mapZoom = parseInt(el.getAttribute('data-zoom'));

      //adjust zoom relative to map width 570
      mapZoom = mapWidth / 570 + mapZoom - zoomOffset;
      mapZoom = mapZoom > 20 ? 20 : mapZoom < 0 ? 0 : mapZoom

      document.querySelectorAll('.change_location').forEach(function(el) {
        el.classList.remove('active');
      });
      el.classList.add('active');

      
      map.flyTo([mapLat, mapLng], mapZoom);
    };
  });

  // [PRO] Event: "Add location" Button click
  if(document.getElementById('open-add-location-overlay') != null) {
    //init map
    const map2 = L.map('mapGetLocation', {
      gestureHandling: true
    });

    // Activate Map inside overlay
    (function (){

      let markerIsVisible = false;
    
      // Set map style
      if(mapStyle == 'Custom1') {
        L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      }else if(mapStyle == 'Custom2') {
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      }else if(mapStyle == 'Custom3') {
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}.png').addTo(map2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
          tileSize: 512,
          zoomOffset: -1
        }).addTo(map2);
      }else {
        // Default
        L.tileLayer.provider(mapStyle).addTo(map2);
      }
    
      const search = new GeoSearch.GeoSearchControl({
          style: 'bar',
          showMarker: false,
          provider: new GeoSearch.OpenStreetMapProvider(),
      });
      map2.addControl(search);
    
      //define marker
    
      // Marker Icon
      let markerIcon = L.icon({
        iconUrl: marker_icon_url,
        iconSize: [26, 41],
        iconAnchor: [13, 41],
        popupAnchor: [0, -25],
        shadowUrl: marker_shadow_url,
        shadowSize: [41, 41],
        shadowAnchor: [13, 41]
      });
    
      let locationMarker = L.marker([0, 0], {icon: markerIcon}, {
          'draggable': true
      });
      
      //initial map view
      map2.setView([start_lat, start_lng], start_zoom);
    
      //Event: click on map to set marker
      map2.on('click', function(e) {
          locationMarker.setLatLng(e.latlng);
    
          if(!markerIsVisible) {
              locationMarker.addTo(map2);
              markerIsVisible = true;
          }
    
          setLocationLatLng(e.latlng);
      });
    
      //Event: drag marker
      locationMarker.on('dragend', function(e) {
          setLocationLatLng(e.target.getLatLng());
      });
      
      //set lat & lng input fields
      function setLocationLatLng(markerLatLng) {
          console.log(markerLatLng);
    
          jQuery('#laa_location_lat').val(markerLatLng.lat);
          jQuery('#laa_location_lng').val(markerLatLng.lng);
      }  
    
    })();

    document.getElementById('open-add-location-overlay').addEventListener('click', function(event) {
      
      // show overlay
      document.getElementById('add-location-overlay').classList.add('active');

      //reposition map
      map2.invalidateSize();
      map2.setView([start_lat, start_lng], start_zoom);
    });

    // Event: close "Add location" overlay
    if(document.getElementById('close-add-location-overlay') != null) {
      document.getElementById('close-add-location-overlay').addEventListener('click', function(event) {
        document.getElementById('add-location-overlay').classList.remove('active');
      });
    }

    // Event: add another location
    document.getElementById('laa_add_another_location').addEventListener('click', function() {
      document.getElementById('laa_add_location').style.display = 'block';
      document.getElementById('laa_add_location_error').style.display = 'none';
      document.getElementById('laa_add_location_thankyou').style.display = 'none';

      //reposition map
      map2.invalidateSize();
      map2.setView([start_lat, start_lng], start_zoom);

      //reset media previews
      document.getElementById('laa_location_image').nextElementSibling.textContent = '';
    });

    document.getElementById('laa_location_image').addEventListener('change', updatePreview);

    function updatePreview() {
      this.nextElementSibling.textContent = this.files[0].name;
    }
  }

});