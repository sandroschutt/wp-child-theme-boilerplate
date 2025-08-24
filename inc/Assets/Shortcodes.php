<?php

namespace WPChild\Assets;

/**
 * Class Shortcodes
 *
 * Handles the automatic inclusion of PHP shortcode files
 * from the theme's library directory.
 *
 * @package WPChild\Assets
 */
class Shortcodes
{    
    /**
     * Automatically include all shortcode PHP files.
     *
     * Scans the /lib/shortcodes/ directory for PHP files and includes them
     * on the frontend (skips admin area). Only includes files with the
     * .php extension and file names longer than 2 characters.
     *
     * @return void
     */
    public static function autoInclude()
    {
        $shortcodes = \WPChild\Helpers::getFilesArray("/lib/shortcodes/");
        $fileExt = ".php";

        if (is_admin() || $shortcodes === false) return;

        foreach ($shortcodes['files'] as $shortcode) :
            if (strlen($shortcode) >= 3 && str_contains($shortcode, $fileExt)) :
                include $shortcodes['dir'] . $shortcode;
            endif;
        endforeach;
    }
}
