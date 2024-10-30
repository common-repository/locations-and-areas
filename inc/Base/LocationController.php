<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

use LocationsAndAreasPlugin\Base\BaseController;

class LocationController extends BaseController
{
    public $settings;

    public function register()
    {
        // CPT: Location
        add_action('init', array($this, 'location_cpt'));
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save_custom_fields'));
        add_action('manage_laa-location_posts_columns', array($this, 'set_custom_location_columns'));
        add_action('manage_laa-location_posts_custom_column', array($this, 'set_custom_location_columns_data'), 10, 2); // this method has 2 attributes
        add_action('admin_menu', array($this, 'add_pending_counter_to_menu'));
    }

    /**
     * CPT: Location
     */

    public static function location_cpt()
    {
        $labels = array(
            'name' => __('Locations', 'locations-and-areas'),
            'singular_name' => __('Location', 'locations-and-areas'),
            'add_new' => __('Add location', 'locations-and-areas'),
            'add_new_item' => __('Add new location', 'locations-and-areas'),
            'edit_item' => __('Edit location', 'locations-and-areas'),
            'new_item' => __('New location', 'locations-and-areas'),
            'all_items' => __('All locations', 'locations-and-areas'),
            'view_item' => __('View location', 'locations-and-areas'),
            'search_items' => __('Search locations', 'locations-and-areas'),
            'not_found' => __('No locations found', 'locations-and-areas'),
            'not_found_in_trash' => __('No location in trash', 'locations-and-areas'),
            'parent_item_colon' => '',
            'menu_name' => __('Locations and Areas', 'locations-and-areas'),
        );
        $args = array(
            'labels' => $labels,
            'description' => __('Location', 'locations-and-areas'),
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-store',
            'supports' => array('title'),
        );

        register_post_type('laa-location', $args);
    }

    public function add_meta_box()
    {
        add_meta_box(
            'location_customfields',
            __('Location', 'locations-and-areas'),
            array($this, 'render_customfields_box'),
            'laa-location',
            'normal'
        );
    }

    public function render_customfields_box($post)
    {
        wp_nonce_field('laa_location', 'laa_location_nonce');

        $data = get_post_meta($post->ID, '_laa_location_key', true);

        $address = isset($data['address']) ? $data['address'] : '';
        $lat = isset($data['lat']) ? $data['lat'] : '';
        $lng = isset($data['lng']) ? $data['lng'] : '';
        $text = isset($data['text']) ? $data['text'] : '';
        $image = get_post_meta($post->ID, '_laa_location_image', true);
        $has_image = (isset($image) && $image != '')? 'has-image' : '';
        $image_tag = ($has_image)? '<img src="'.esc_attr($image).'" style="width: 100%;">' : '';

        // Set map style
        if(get_option('laa_map_style') !== '' && get_option('laa_map_style') != null) {
            $map_style = get_option('laa_map_style');
        }else{
            $map_style = 'Esri.WorldStreetMap';
        }

        $marker_icon = get_option('laa_marker_icon', 'default');

        // TODO: Move to template
        ?>

        <div class="section geo-coordinates-wrap">
            <div class="map-wrap">
                <div id="mapGetLocation" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
            </div>
            <div class="input-wrap">
                <div class="geo-coordinates-hint">
                    <div class="hint"><?php echo __('Click on the map to set a location marker or <a href="#" id="showLatLngInputs">edit GPS coordinates manually</a>.', 'locations-and-areas'); ?></div>

                    <div class="latlng-wrap" id="latLngInputs" style="display: none;">
                        <div class="hint"><?php echo __('Edit GPS coordinates manually:', 'locations-and-areas'); ?></div>
                        <div>
                            <div>
                                <label class="meta-label" for="laa_location_lat">
                                    <?php echo __('Lat', 'locations-and-areas'); ?>
                                </label>
                                <input type="text" class="widefat" id="laa_location_lat" name="laa_location_lat" value="<?php echo esc_attr($lat); ?>"></input>
                            </div>
                            <div>
                                <label class="meta-label" for="laa_location_lng">
                                    <?php echo __('Lng', 'locations-and-areas'); ?>
                                </label>
                                <input type="text" class="widefat" id="laa_location_lng" name="laa_location_lng" value="<?php echo esc_attr($lng); ?>"></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
            const lat = '<?php echo esc_attr($lat); ?>';
            const lng = '<?php echo esc_attr($lng); ?>';
            const zoom = '13';
            const mapStyle = '<?php echo $map_style; ?>';
            const marker_icon_url = '<?php echo $this->plugin_url; ?>src/leaflet/images/marker-icon_<?php echo $marker_icon; ?>-2x.png';
            const marker_shadow_url = '<?php echo $this->plugin_url; ?>src/leaflet/images/marker-shadow.png';
            </script>

            <?php wp_enqueue_script('laa_backend_location_js', $this->plugin_url . 'src/js/backend-location.js', array('wp-polyfill', 'laa_leaflet_geosearch_js'), $this->plugin_version); ?>
        </div>

        <div class="section">
            <label class="meta-label" for="laa_location_address">
                <?php echo __('Address', 'locations-and-areas'); ?>
            </label>
            <input type="text" class="widefat" id="laa_location_address" name="laa_location_address" value="<?php echo esc_attr($address); ?>"></input>
        </div>

        <div class="section">
          <label class="meta-label" for="laa_location_image"><?php echo __('Image', 'locations-and-areas'); ?></label>
          <table>
            <tr>
              <td><a href="#" class="laa_upload_image_button button button-secondary"><?php echo __('Upload Image', 'locations-and-areas'); ?></a></td>
              <td><input type="hidden" class="widefat" id="laa_location_image" name="laa_location_image" value="<?php echo esc_attr($image); ?>"></input></td>
            </tr>
          </table>
          <div id="laa_location_image_preview" class="<?php echo $has_image; ?>"><?php echo $image_tag; ?></div>
        </div>

        <div class="section">
            <label class="meta-label" for="laa_location_text">
                <?php echo __('Text', 'locations-and-areas'); ?>
            </label>
            <?php wp_editor($text, 'laa_location_text'); ?>
        </div>

        <?php
        
    }

    public static function save_custom_fields($post_id)
    {
        // Dont save without nonce
        if (!isset($_POST['laa_location_nonce'])) {
            return $post_id;
        }

        // Dont save if nonce is incorrect
        $nonce = $_POST['laa_location_nonce'];
        if (!wp_verify_nonce($nonce, 'laa_location')) {
            return $post_id;
        }

        // Dont save if wordpress just auto-saves
        if (defined('DOING AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Dont save if user is not allowed to do
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // Validation
        $lat_validated = floatval(str_replace(',', '.', sanitize_text_field($_POST['laa_location_lat'])));
        if(!$lat_validated) {
            $lat_validated = '';
        }

        $lng_validated = floatval(str_replace(',', '.', sanitize_text_field($_POST['laa_location_lng'])));
        if(!$lng_validated) {
            $lng_validated = '';
        }

        $data = array(
            'address' => sanitize_text_field($_POST['laa_location_address']),
            'lat' => $lat_validated,
            'lng' => $lng_validated,
            'text' => wp_kses_post($_POST['laa_location_text']),
        );
        update_post_meta($post_id, '_laa_location_key', $data);

        // validate & store image seperately (to avoid serialized URLs [bad for search & replace due to domain change])
        $data_image = esc_url_raw($_POST['laa_location_image']);
        update_post_meta($post_id, '_laa_location_image', $data_image);
    }

    public static function set_custom_location_columns($columns)
    {
        // preserve default columns
        $title = $columns['title'];
        $date = $columns['date'];
        unset($columns['title'], $columns['date']);

        $columns['title'] = $title;
        $columns['text'] = __('Text', 'locations-and-areas');
        $columns['address'] = __('Address', 'locations-and-areas');
        $columns['geocoordinates'] = __('Coordinates', 'locations-and-areas');
        $columns['date'] = $date;

        return $columns;
    }

    public static function set_custom_location_columns_data($column, $post_id)
    {
        $data = get_post_meta($post_id, '_laa_location_key', true);

        $text = isset($data['text']) ? $data['text'] : '';
        $address = isset($data['address']) ? $data['address'] : '';
        $lat = isset($data['lat']) ? $data['lat'] : '';
        $lng = isset($data['lng']) ? $data['lng'] : '';

        switch ($column) {
            case 'text':
                echo esc_html($text);
                break;
            case 'address':
                echo esc_html($address);
                break;
            case 'geocoordinates':
                echo esc_attr($lat) . ', ' . esc_attr($lng);
                break;
            default:
                break;
        }
    }

    public function add_pending_counter_to_menu()
    {
        global $menu;
        $count = count(get_posts(array(
            'post_type' => 'laa-location',
            'post_status' => 'pending',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ))); 
        
        $menu_item = wp_list_filter(
            $menu,
            array( 2 => 'edit.php?post_type=laa-location' ) // 2 is the position of an array item which contains URL, it will always be 2!
        );
    
        if ( ! empty( $menu_item )  && $count >= 1) {
            $menu_item_position = key( $menu_item ); // get the array key (position) of the element
            $menu[ $menu_item_position ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
        }
    }
}
