<div class="wrap">
<h1>Locations and Areas</h1>

<form method="post" action="options.php">
    <?php 
settings_fields( 'locations-and-areas-settings-group' );
?>
    <?php 
do_settings_sections( 'locations-and-areas-settings-group' );
?>
    <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <?php 
echo  __( 'Map Style', 'locations-and-areas' ) ;
?>
            <?php 

if ( laa_fs()->is_not_paying() ) {
    ?>
              <br><a href="<?php 
    echo  laa_fs()->get_upgrade_url() ;
    ?>"><?php 
    echo  __( 'Upgrade to PRO to get all the map styles!', 'locations-and-areas' ) ;
    ?></a>
            <?php 
}

?>
          </th>
          <td>
            <div class="map_styles">
            <?php 
$map_style = ( get_option( 'laa_map_style' ) ? get_option( 'laa_map_style' ) : 'Esri.WorldStreetMap' );
$items = $this->map_styles;
//pro map styles
$pro_items = $this->pro_map_styles;
foreach ( $items as $val => $label ) {
    $selected = ( $map_style == $val ? 'checked' : '' );
    echo  "<label class='{$selected}'><div class='map_style_preview' data-style='{$val}'></div><input type='radio' name='laa_map_style' {$selected} value='{$val}'></label>" ;
}
?>

            <?php 
?>

            <?php 

if ( !laa_fs()->is_plan( 'pro' ) ) {
    ?>

              <?php 
    foreach ( $pro_items as $val => $label ) {
        echo  "<label class='pro pro-only'><div class='map_style_preview' data-style='{$val}'></div></label>" ;
    }
    ?>

            <?php 
}

?>

            </div>

          </td>
        </tr>

        <tr valign="top">
          <th scope="row">
            <?php 
echo  __( 'Marker Icon', 'locations-and-areas' ) ;
?>
            <?php 

if ( laa_fs()->is_not_paying() ) {
    ?>
              <br><a href="<?php 
    echo  laa_fs()->get_upgrade_url() ;
    ?>"><?php 
    echo  __( 'Upgrade to PRO to get all the icon styles!', 'locations-and-areas' ) ;
    ?></a>
            <?php 
}

?>
          </th>
          <td>
            <div class="marker_icons">
              <?php 
$marker_icon = get_option( 'laa_marker_icon', 'default' );
$items = $this->marker_icons;
//pro marker icons
$pro_items = $this->pro_marker_icons;
foreach ( $items as $val ) {
    $selected = ( $marker_icon == $val ? 'checked' : '' );
    echo  "<label class='{$selected}'><div class='marker_icon_preview' data-style='{$val}'></div><input type='radio' name='laa_marker_icon' {$selected} value='{$val}'></label>" ;
}
?>

              <?php 
?>

              <?php 

if ( !laa_fs()->is_plan( 'pro' ) ) {
    ?>

                <?php 
    foreach ( $pro_items as $val ) {
        echo  "<label class='pro pro-only'><div class='marker_icon_preview' data-style='{$val}'></div></label>" ;
    }
    ?>

              <?php 
}

?>

            </div>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><?php 
echo  __( 'Layout', 'locations-and-areas' ) ;
?></th>
          <td>
          <?php 
$layout_style = get_option( 'laa_layout_style' );
$items = array(
    'layout-1' => __( 'Areas as top navigation', 'locations-and-areas' ),
    'layout-2' => __( 'Areas as sidebar', 'locations-and-areas' ),
);
echo  "<select id='laa_layout_style' name='laa_layout_style'>" ;
foreach ( $items as $value => $label ) {
    $selected = ( $layout_style == $value ? 'selected="selected"' : '' );
    echo  "<option value='{$value}' {$selected}>{$label}</option>" ;
}
echo  "</select>" ;
?>
          </td>
        </tr>

        <tr valign="top">
          <?php 
$laa_enable_frontend_location_adding = get_option( 'laa_enable_frontend_location_adding' );
?>
          <th scope="row">
            <?php 
echo  __( 'Users can submit locations for review', 'locations-and-areas' ) ;
?>
            <span class="laa-pro">PRO</span>
          </th>
          <td>
            <label>
              <?php 
?>
              
              <?php 
if ( !laa_fs()->is_plan( 'pro' ) ) {
    ?>
                <input type="checkbox" disabled>
              <?php 
}
?>
              
              <?php 
echo  __( 'This adds a "+"-Icon in the top right corner of the map. By clicking it your visitors will see a popup form where they can submit a new location proposal. The location will be not be public (status "pending") until you decide to publish it.', 'locations-and-areas' ) ;
?>
              
              <?php 

if ( laa_fs()->is_not_paying() ) {
    ?>
                <a href="<?php 
    echo  laa_fs()->get_upgrade_url() ;
    ?>"><?php 
    echo  __( 'Upgrade to PRO to enable your visitors to make location proposals!', 'locations-and-areas' ) ;
    ?></a>
              <?php 
}

?>
            </label>
          </td>
        </tr>

        <?php 
?>

        <tr valign="top">
          <?php 
$laa_disable_areas = get_option( 'laa_disable_areas' );
?>
          <th scope="row"><?php 
echo  __( 'Don\'t show Areas', 'locations-and-areas' ) ;
?></th>
          <td>
            <input type="checkbox" name="laa_disable_areas" id="laa_disable_areas" <?php 
echo  ( $laa_disable_areas ? 'checked' : '' ) ;
?>>
          </td>
        </tr>

        <tr valign="top">
          <?php 
$laa_hide_address = get_option( 'laa_hide_address' );
?>
          <th scope="row"><?php 
echo  __( 'Don\'t show Address', 'locations-and-areas' ) ;
?></th>
          <td>
            <input type="checkbox" name="laa_hide_address" id="laa_hide_address" <?php 
echo  ( $laa_hide_address ? 'checked' : '' ) ;
?>>
          </td>
        </tr>

        <tr valign="top">
          <?php 
$laa_disable_gmaps_link = get_option( 'laa_disable_gmaps_link' );
?>
          <th scope="row"><?php 
echo  __( 'Don\'t link address to Google Maps', 'locations-and-areas' ) ;
?></th>
          <td>
            <input type="checkbox" name="laa_disable_gmaps_link" id="laa_disable_gmaps_link" <?php 
echo  ( $laa_disable_gmaps_link ? 'checked' : '' ) ;
?>>
          </td>
        </tr>

        <tr valign="top">
          <?php 
$laa_disable_cluster = get_option( 'laa_disable_cluster' );
?>
          <th scope="row"><?php 
echo  __( 'Don\'t group markers that are close to each other (Clustering). ', 'locations-and-areas' ) ;
?></th>
          <td>
            <input type="checkbox" name="laa_disable_cluster" id="laa_disable_cluster" <?php 
echo  ( $laa_disable_cluster ? 'checked' : '' ) ;
?>>
          </td>
        </tr>

        <tr class="top">
          <th scope="row">
            <label for="lat"><?php 
echo  __( 'Initial Map Focus', 'locations-and-areas' ) ;
?></label>
          </th>
          <td>
            <?php 
$start_lat = get_option( 'laa_start_lat' );
$start_lng = get_option( 'laa_start_lng' );
$start_zoom = get_option( 'laa_start_zoom' );
?>
            <div class="form-field geo-coordinates-wrap">
                <div class="map-wrap">
                    <div id="mapGetArea" class="leaflet-map map-style_<?php 
echo  esc_attr( $map_style ) ;
?>"></div>
                </div>
                <div class="input-wrap">
                    <div class="latlng-wrap" style="display: none">
                        <div class="form-field lat-wrap">
                            <label class="meta-label" for="lat">
                                <?php 
echo  __( 'Lat', 'locations-and-areas' ) ;
?>
                            </label>
                            <input type="text" readonly class="widefat" id="laa_start_lat" name="laa_start_lat" value="<?php 
echo  ( esc_attr( $start_lat ) ? esc_attr( $start_lat ) : '' ) ;
?>"></input>
                        </div>
                        <div class="form-field lng-wrap">
                            <label class="meta-label" for="lng">
                                <?php 
echo  __( 'Lng', 'locations-and-areas' ) ;
?>
                            </label>
                            <input type="text" readonly class="widefat" id="laa_start_lng" name="laa_start_lng" value="<?php 
echo  ( esc_attr( $start_lng ) ? esc_attr( $start_lng ) : '' ) ;
?>"></input>
                        </div>
                        <div class="form-field zoom-wrap">
                            <label class="meta-label" for="zoom">
                                <?php 
echo  __( 'Zoom', 'locations-and-areas' ) ;
?>
                            </label>
                            <input type="number" readonly min="0" max="19" class="widefat" id="laa_start_zoom" name="laa_start_zoom" value="<?php 
echo  ( esc_attr( $start_zoom ) ? esc_attr( $start_zoom ) : '' ) ;
?>"></input>
                        </div>
                    </div>

                    <div class="geo-coordinates-hint">
                        <strong><?php 
echo  __( 'How to adjust the initial view:', 'locations-and-areas' ) ;
?></strong>
                        <ol>
                            <li><?php 
echo  __( 'Use the map on the left to find your spot', 'locations-and-areas' ) ;
?></li>
                            <li><?php 
echo  __( 'Zoom and move the map to find the perfect view', 'locations-and-areas' ) ;
?></li>
                        </ol>
                    </div>
                </div>

                <script>
                const lat = '<?php 
echo  ( esc_attr( $start_lat ) ? esc_attr( $start_lat ) : '0' ) ;
?>';
                const lng = '<?php 
echo  ( esc_attr( $start_lng ) ? esc_attr( $start_lng ) : '0' ) ;
?>';
                const zoom = '<?php 
echo  ( esc_attr( $start_zoom ) ? esc_attr( $start_zoom ) : '1' ) ;
?>';
                const mapStyle = '<?php 
echo  $map_style ;
?>';
                </script>

                <?php 
wp_enqueue_script(
    'laa_backend_settings_js',
    $this->plugin_url . 'src/js/backend-settings.js',
    array( 'wp-polyfill', 'laa_leaflet_geosearch_js' ),
    $this->plugin_version
);
?>
                
            </div>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><?php 
echo  __( 'Place the shortcode anywhere in your content or integrate it within your theme template with PHP', 'locations-and-areas' ) ;
?></th>
          <td>
            <strong>Shortcode:</strong><br><br>
            <code>[locations-and-areas-map]</code><br><br>
            <strong><?php 
echo  __( 'you can also override the initial map focus with shortcode attributes:', 'locations-and-areas' ) ;
?></strong><br><br>
            <code>[locations-and-areas-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13"]</code><br><br>
            <strong>PHP:</strong><br><br>
            <code>&lt;?php echo do_shortcode('[locations-and-areas-map]'); ?&gt;</code>
          </td>
        </tr>
    </table>

    <?php 
submit_button();
?>

</form>
</div>