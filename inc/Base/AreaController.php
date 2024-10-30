<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

use LocationsAndAreasPlugin\Base\BaseController;

class AreaController extends BaseController
{
    public $settings;

    public function register()
    {
        // Taxonomy: Area
        add_action('init', array($this, 'area_tax'));
        add_action('laa-area_add_form_fields', array($this, 'area_tax_add_custom_fields'));
        add_action('laa-area_edit_form_fields', array($this, 'area_tax_edit_custom_fields'), 10, 2);
        add_action('edited_laa-area', array($this, 'area_tax_save'));
        add_action('create_laa-area', array($this, 'area_tax_save'));
        add_action('manage_edit-laa-area_columns', array($this, 'set_custom_area_columns'));
        add_action('manage_laa-area_custom_column', array($this, 'set_custom_area_columns_data'), 10, 3); // this method has 3 attributes
    }

    /**
     * Taxonomy: Area
     */

    public static function area_tax()
    {
        $labels = array(
            'name' => __('Areas', 'locations-and-areas'),
            'singular_name' => __('Area', 'locations-and-areas'),
            'menu_name' => __('Areas', 'locations-and-areas'),
            'all_items' => __('All Areas', 'locations-and-areas'),
            'edit_item' => __('Edit Area', 'locations-and-areas'),
            'view_item' => __('Show Area', 'locations-and-areas'),
            'update_item' => __('Update Area', 'locations-and-areas'),
            'add_new_item' => __('Add new Area', 'locations-and-areas'),
            'new_item_name' => __('New Area name', 'locations-and-areas'),
            'search_items' => __('Search Areas', 'locations-and-areas'),
            'choose_from_most_used' => __('Choose from the most used Areas', 'locations-and-areas'),
            'popular_items' => __('Popular Areas', 'locations-and-areas'),
            'add_or_remove_items' => __('Add or remove Areas', 'locations-and-areas'),
            'separate_items_with_commas' => __('Separate Areas with commas', 'locations-and-areas'),
            'back_to_items' => __('Back to Areas', 'locations-and-areas'),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => false,
            'show_in_quick_edit' => false,
            'meta_box_cb' => false,
            'hierarchical' => false,
        );

        register_taxonomy('laa-area', 'laa-location', $args);
    }

    public function area_tax_add_custom_fields($term)
    {
        // Set map style
        if(get_option('laa_map_style') !== '' && get_option('laa_map_style') != null) {
            $map_style = get_option('laa_map_style');
        }else{
            $map_style = 'Esri.WorldStreetMap';
        }

        ?>
        <div class="geo-coordinates-wrap">
            <label>
                <?php echo __('Adjust Area view', 'locations-and-areas'); ?>
            </label>
            <div class="map-wrap">
                <div id="mapGetArea" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
            </div>
            <div class="input-wrap">
                <div class="latlng-wrap" style="display: none">
                    <div class="form-field form-required lat-wrap">
                        <label class="meta-label" for="lat">
                            <?php echo __('Lat', 'locations-and-areas'); ?>
                        </label>
                        <input type="text" readonly class="widefat" id="lat" name="lat" value="" aria-required="true"></input>
                    </div>
                    <div class="form-field form-required lng-wrap">
                        <label class="meta-label" for="lng">
                            <?php echo __('Lng', 'locations-and-areas'); ?>
                        </label>
                        <input type="text" readonly class="widefat" id="lng" name="lng" value="" aria-required="true"></input>
                    </div>
                    <div class="form-field form-required zoom-wrap">
                        <label class="meta-label" for="zoom">
                            <?php echo __('Zoom', 'locations-and-areas'); ?>
                        </label>
                        <input type="number" readonly min="0" max="19" class="widefat" id="zoom" name="zoom" value="" aria-required="true"></input>
                    </div>
                </div>

                <div class="geo-coordinates-hint">
                    <strong><?php echo __('How to adjust the Area view:', 'locations-and-areas'); ?></strong>
                    <ol>
                        <li><?php echo __('Use the map on the top to find your area', 'locations-and-areas'); ?></li>
                        <li><?php echo __('Zoom and move the map to find the perfect view', 'locations-and-areas'); ?></li>
                    </ol>
                </div>
            </div>

            <script>
            const lat = '';
            const lng = '';
            const zoom = '1';
            const mapStyle = '<?php echo $map_style; ?>';
            </script>

            <?php wp_enqueue_script('laa_backend_add_area_js', $this->plugin_url . 'src/js/backend-add-area.js', array('wp-polyfill', 'laa_leaflet_geosearch_js'), $this->plugin_version); ?>
        </div>

        <?php
    }

    public function area_tax_edit_custom_fields($tag, $taxonomy)
    {
        $t_id = $tag->term_id;
        $term_lat = get_term_meta($t_id, 'lat', true);
        $term_lng = get_term_meta($t_id, 'lng', true);
        $term_zoom = get_term_meta($t_id, 'zoom', true);
        
        // Set map style
        if(get_option('laa_map_style') !== '' && get_option('laa_map_style') != null) {
            $map_style = get_option('laa_map_style');
        }else{
            $map_style = 'Esri.WorldStreetMap';
        }

        ?>
        <tr class="term-latlngzoom-wrap">
            <th scope="row">
                <label for="lat"><?php echo __('Adjust Area view', 'locations-and-areas'); ?></label>
            </th>
            <td>
                <div class="form-field geo-coordinates-wrap">
                    <div class="map-wrap">
                        <div id="mapGetArea" class="leaflet-map map-style_<?php echo esc_attr($map_style); ?>"></div>
                    </div>
                    <div class="input-wrap">
                        <div class="latlng-wrap" style="display: none">
                            <div class="form-field form-required lat-wrap">
                                <label class="meta-label" for="lat">
                                    <?php echo __('Lat', 'locations-and-areas'); ?>
                                </label>
                                <input type="text" readonly class="widefat" id="lat" name="lat" value="<?php echo esc_attr($term_lat) ? esc_attr($term_lat) : ''; ?>" aria-required="true"></input>
                            </div>
                            <div class="form-field form-required lng-wrap">
                                <label class="meta-label" for="lng">
                                    <?php echo __('Lng', 'locations-and-areas'); ?>
                                </label>
                                <input type="text" readonly class="widefat" id="lng" name="lng" value="<?php echo esc_attr($term_lng) ? esc_attr($term_lng) : ''; ?>" aria-required="true"></input>
                            </div>
                            <div class="form-field form-required zoom-wrap">
                                <label class="meta-label" for="zoom">
                                    <?php echo __('Zoom', 'locations-and-areas'); ?>
                                </label>
                                <input type="number" readonly min="0" max="19" class="widefat" id="zoom" name="zoom" value="<?php echo esc_attr($term_zoom) ? esc_attr($term_zoom) : ''; ?>" aria-required="true"></input>
                            </div>
                        </div>

                        <div class="geo-coordinates-hint">
                            <strong><?php echo __('How to adjust the Area view:', 'locations-and-areas'); ?></strong>
                            <ol>
                                <li><?php echo __('Use the map on the top to find your area', 'locations-and-areas'); ?></li>
                                <li><?php echo __('Zoom and move the map to find the perfect view', 'locations-and-areas'); ?></li>
                            </ol>
                        </div>
                    </div>

                    <script>
                    const lat = '<?php echo esc_attr($term_lat) ? esc_attr($term_lat) : '0'; ?>';
                    const lng = '<?php echo esc_attr($term_lng) ? esc_attr($term_lng) : '0'; ?>';
                    const zoom = '<?php echo esc_attr($term_zoom) ? esc_attr($term_zoom) : '1'; ?>';
                    const mapStyle = '<?php echo $map_style; ?>';
                    </script>

                    <?php wp_enqueue_script('laa_backend_edit_area_js', $this->plugin_url . 'src/js/backend-edit-area.js', array('wp-polyfill', 'laa_leaflet_geosearch_js'), $this->plugin_version); ?>
                </div>
            </td>
        </tr>

        <?php

    }

    public function area_tax_save($term_id)
    {
        if (isset($_POST['lat'])) {
            // Validation
            $lat_validated = floatval(str_replace(',', '.', sanitize_text_field($_POST['lat'])));
            if(!$lat_validated) {
                $lat_validated = '';
            }

            if ($lat_validated) {
                update_term_meta($term_id, 'lat', $lat_validated);
            }
        }

        if (isset($_POST['lng'])) {
            // Validation
            $lng_validated = floatval(str_replace(',', '.', sanitize_text_field($_POST['lng'])));
            if(!$lng_validated) {
                $lng_validated = '';
            }

            if ($lng_validated) {
                update_term_meta($term_id, 'lng', $lng_validated);
            }
        }

        if (isset($_POST['zoom'])) {
            // Validation
            $zoom_validated = intval(sanitize_text_field($_POST['zoom']));
            if(!$zoom_validated) {
                $zoom_validated = '';
            }

            if ($zoom_validated) {
                update_term_meta($term_id, 'zoom', $zoom_validated);
            }
        }
    }

    public static function set_custom_area_columns($columns)
    {
        // preserve default columns
        $name = $columns['name'];
        unset($columns['description'], $columns['slug'], $columns['posts']);

        $columns['name'] = $name;
        $columns['geocoordinates'] = __('Coordinates', 'locations-and-areas');
        $columns['zoom'] = __('Zoom', 'locations-and-areas');

        return $columns;
    }

    public static function set_custom_area_columns_data($content, $column, $term_id)
    {
        $data = get_term_meta($term_id);

        $lat = isset($data['lat'][0]) ? $data['lat'][0] : '';
        $lng = isset($data['lng'][0]) ? $data['lng'][0] : '';
        $zoom = isset($data['zoom'][0]) ? $data['zoom'][0] : '';

        switch ($column) {
            case 'geocoordinates':
                echo esc_attr($lat) . ', ' . esc_attr($lng);
                break;
            case 'zoom':
                echo esc_attr($zoom);
                break;
            default:
                break;
        }
    }
}
