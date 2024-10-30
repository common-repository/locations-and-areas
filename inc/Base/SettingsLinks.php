<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

use \LocationsAndAreasPlugin\Base\BaseController;

class SettingsLinks extends BaseController
{

    public function register()
    {
        add_filter('plugin_action_links_' . $this->plugin, array($this, 'settings_link'));
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=locations_and_areas">Settings</a>';
        array_push($links, $settings_link);

        return $links;
    }
}
