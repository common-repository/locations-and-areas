<?php
/**
 * @package LocationsAndAreasPlugin
 */

namespace LocationsAndAreasPlugin\Base;

class Deactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}
