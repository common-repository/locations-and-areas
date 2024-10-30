(function(){
  const map = L.map('mapGetArea', {
      scrollWheelZoom: false
  });

  // map style selector
  jQuery('.map_styles input[type=radio]').on('change', function(e) {
    jQuery('.map_styles label').removeClass('checked');
    jQuery(this).parent('label').addClass('checked');
  });

  // marker icon selector
  jQuery('.marker_icons input[type=radio]').on('change', function(e) {
    jQuery('.marker_icons label').removeClass('checked');
    jQuery(this).parent('label').addClass('checked');
  });

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

  const search = new GeoSearch.GeoSearchControl({
      style: 'bar',
      showMarker: false,
      provider: new GeoSearch.OpenStreetMapProvider(),
  });
  map.addControl(search);

  map.setView([lat, lng], zoom);

  // set Area view by move/zoom
  map.on('move', function(e) {
      setAreaLatLngZoom(map.getCenter(), map.getZoom());
  });

  //set lat & lng & zoom input fields
  function setAreaLatLngZoom(mapCenterLatLng, mapZoom) {
      jQuery('#laa_start_lat').val(mapCenterLatLng.lat);
      jQuery('#laa_start_lng').val(mapCenterLatLng.lng);
      jQuery('#laa_start_zoom').val(mapZoom);
  }

  //toggle thankyou text fields
  jQuery('#laa_enable_frontend_location_adding').on('change', function(e) {
    if(this.checked) {
      jQuery('#wrap_thankyou_texts').fadeIn();
    }else{
      jQuery('#wrap_thankyou_texts').fadeOut();
    }
  });

})();