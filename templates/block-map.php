<?php

// Settings
$laa_disable_cluster = ( get_option( 'laa_disable_cluster' ) ? 'true' : 'false' );
$laa_disable_gmaps_link = ( get_option( 'laa_disable_gmaps_link' ) ? true : false );
$map_style = get_option( 'laa_map_style', 'Esri.WorldStreetMap' );
$marker_icon = get_option( 'laa_marker_icon', 'default' );
$layout_style = get_option( 'laa_layout_style', 'layout-1' );
$use_settings_start_location = false;
$locations = get_posts( array(
    'post_type'      => 'laa-location',
    'posts_per_page' => -1,
    'fields'         => 'ids',
) );
$locations_list = array();
foreach ( $locations as $post_id ) {
    // Prepare data
    $location_meta = get_post_meta( $post_id, '_laa_location_key', true );
    $name = str_replace( "'", "\\'", htmlentities( get_the_title( $post_id ) ) );
    $address = ( isset( $location_meta['address'] ) ? str_replace( "'", "\\'", preg_replace( '/\\r|\\n/', '', $location_meta['address'] ) ) : '' );
    $text = ( isset( $location_meta["text"] ) ? str_replace( "'", "\\'", str_replace( array( "\r\n", "\r", "\n" ), "<br>", $location_meta["text"] ) ) : '' );
    $image = get_post_meta( $post_id, '_laa_location_image', true );
    if ( !isset( $location_meta['lat'] ) && !isset( $location_meta['lng'] ) ) {
        continue;
    }
    $geolocation = array(
        'lat' => $location_meta['lat'],
        'lng' => $location_meta['lng'],
    );
    // collect locations for JS use
    $locations_list[] = array(
        'post_id' => $post_id,
        'name'    => $name,
        'address' => $address,
        'lat'     => $geolocation['lat'],
        'lng'     => $geolocation['lng'],
        'text'    => $text,
        'image'   => $image,
    );
}
$areas = get_terms( array(
    'taxonomy'   => 'laa-area',
    'hide_empty' => false,
    'meta_query' => array(
    'relation' => 'AND',
    array(
    'key'     => 'lat',
    'compare' => 'EXISTS',
),
    array(
    'key'     => 'lng',
    'compare' => 'EXISTS',
),
    array(
    'key'     => 'zoom',
    'compare' => 'EXISTS',
),
),
) );
// Set focus for map init

if ( isset( $block_attributes['lat'] ) && isset( $block_attributes['long'] ) && isset( $block_attributes['zoom'] ) ) {
    //get from shortcode attributes
    $start_lat = str_replace( ',', '.', $block_attributes['lat'] );
    $start_lng = str_replace( ',', '.', $block_attributes['long'] );
    $start_zoom = str_replace( ',', '.', $block_attributes['zoom'] );
} elseif ( get_option( 'laa_start_lat' ) !== '' && get_option( 'laa_start_lat' ) != null && (get_option( 'laa_start_lng' ) !== '' && get_option( 'laa_start_lng' ) != null) && (get_option( 'laa_start_zoom' ) !== '' && get_option( 'laa_start_zoom' ) != null) ) {
    //get from settings
    $use_settings_start_location = true;
    $start_lat = get_option( 'laa_start_lat' );
    $start_lng = get_option( 'laa_start_lng' );
    $start_zoom = get_option( 'laa_start_zoom' );
} elseif ( count( $areas ) > 0 ) {
    //get from first area
    $start_lat = get_term_meta( $areas[0]->term_id, 'lat', true );
    $start_lng = get_term_meta( $areas[0]->term_id, 'lng', true );
    $start_zoom = get_term_meta( $areas[0]->term_id, 'zoom', true );
} elseif ( count( $locations_list ) > 0 ) {
    //get from first location
    $start_lat = $locations_list[0]['lat'];
    $start_lng = $locations_list[0]['lng'];
    $start_zoom = '5';
} else {
    //default
    $start_lat = '0';
    $start_lng = '0';
    $start_zoom = '1';
}

$i = 0;
// BUGFIX: resolves issue with non-unique ids when caching inline js with 3rd party plugins
// todo: allow multiple maps/shortcodes on same site
//$unique_id = uniqid();
$unique_id = 20210624;
?>

<div class="locations-and-areas">

  <?php 
?>
  
  <div class="box-wrap <?php 
echo  $layout_style ;
?> <?php 
if ( get_option( 'laa_disable_areas' ) ) {
    ?>no-areas<?php 
}
?>">
    <?php 

if ( count( $areas ) > 0 && !get_option( 'laa_disable_areas' ) ) {
    ?>
    <nav>
      <div class="laa-tabs" id="nav-tab-<?php 
    echo  $unique_id ;
    ?>" role="tablist">
        <?php 
    foreach ( $areas as $area ) {
        ?>

          <?php 
        $i++;
        $name = $area->name;
        $t_id = $area->term_id;
        $term_lat = get_term_meta( $t_id, 'lat', true );
        $term_lng = get_term_meta( $t_id, 'lng', true );
        $term_zoom = get_term_meta( $t_id, 'zoom', true );
        ?>
          <div class="nav-item nav-link <?php 
        echo  ( $i == 1 && !$use_settings_start_location ? 'active' : '' ) ;
        ?> change_location" data-lat="<?php 
        echo  esc_attr( $term_lat ) ;
        ?>" data-lng="<?php 
        echo  esc_attr( $term_lng ) ;
        ?>" data-zoom="<?php 
        echo  esc_attr( $term_zoom ) ;
        ?>" data-toggle="tab"><?php 
        echo  esc_html( $name ) ;
        ?></div>

        <?php 
    }
    ?>
      </div>
    </nav>
    <?php 
}

?>

    <div class="map-wrap">
      <div id="map-<?php 
echo  $unique_id ;
?>" class="leaflet-map map-style_<?php 
echo  esc_attr( $map_style ) ;
?>"></div>
      
      <?php 
?>

      <script>
      //VARS
      var map_el = 'map-<?php 
echo  $unique_id ;
?>';
      var marker_icon_url = '<?php 
echo  esc_url( $this->plugin_url ) ;
?>src/leaflet/images/marker-icon_<?php 
echo  esc_attr( $marker_icon ) ;
?>-2x.png';
      var marker_shadow_url = '<?php 
echo  esc_url( $this->plugin_url ) ;
?>src/leaflet/images/marker-shadow.png';

      if(document.getElementById(map_el)) {

        var mapStyle = '<?php 
echo  esc_attr( $map_style ) ;
?>';
        var laa_disable_cluster = <?php 
echo  $laa_disable_cluster ;
?>;
        var locations = [];

        <?php 
foreach ( $locations_list as $location ) {
    ?>
          <?php 
    $img_tag = ( $location['image'] ? '<div class="laa_location_image" style="background-image: url(' . esc_url_raw( $location['image'] ) . ')"></div>' : '' );
    $address_tag = ( $location['address'] && !get_option( 'laa_hide_address' ) ? esc_attr( $location['address'] ) : '' );
    if ( !$laa_disable_gmaps_link && $address_tag ) {
        $address_tag = '<a title="' . __( 'go to Google Maps', 'locations-and-areas' ) . '" href="https://www.google.com/maps/search/?api=1&amp;query=' . esc_attr( $location["lat"] ) . '%2C' . esc_attr( $location["lng"] ) . '" target="_blank">' . $address_tag . '</a>';
    }
    $address_tag = ( $address_tag ? '<div class="laa_location_address">' . $address_tag . '</div>' : '' );
    ?>

          locations.push(
            {
              lat: '<?php 
    echo  esc_attr( $location["lat"] ) ;
    ?>',
              lng: '<?php 
    echo  esc_attr( $location["lng"] ) ;
    ?>',
              content: '<?php 
    echo  $img_tag ;
    ?><div class="laa_location_text"><?php 
    echo  $address_tag ;
    ?><h3 class="laa_location_name"><?php 
    echo  esc_attr( $location["name"] ) ;
    ?></h3><div><?php 
    echo  wp_kses_post( $location['text'] ) ;
    ?></div></div>',
            }
          );

        <?php 
}
?>

        var start_lat = '<?php 
echo  esc_attr( $start_lat ) ;
?>';
        var start_lng = '<?php 
echo  esc_attr( $start_lng ) ;
?>';
        var start_zoom = '<?php 
echo  esc_attr( $start_zoom ) ;
?>';
      }

      </script>
    </div>

  </div>
</div>