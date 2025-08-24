<?php

namespace WPChildThemeBoilerplate\Assets;

class Shortcodes
{
    private $helpers;

    public function __construct()
    {
        $this->helpers = new \WPChildThemeBoilerplate\Helpers;
    }
    
    public function autoInclude()
    {
        $shortcodes = $this->helpers->getFilesArray("/lib/shortcodes/");
        $fileExt = ".php";

        if (is_admin() || $shortcodes === false) return;

        foreach ($shortcodes['files'] as $shortcode) :
            if (strlen($shortcode) >= 3 && str_contains($shortcode, $fileExt)) :
                include $shortcodes['dir'] . $shortcode;
            endif;
        endforeach;
    }
}
