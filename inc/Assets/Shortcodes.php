<?php

namespace WPChildThemeBoilerplate\Assets;

class Shortcodes
{
    private $helpers;

    public function __construct()
    {
        $this->helpers = new \WPChildThemeBoilerplate\Helpers;
    }
    
    public function autoload()
    {
        $shortcodes = $this->helpers->getFilesArray("/lib/shortcodes/");
        $fileExt = ".php";

        if (is_admin() || $shortcodes === false) return;

        foreach ($shortcodes['files'] as $shortcode) :
            if (strlen($shortcode) >= 3 && str_contains($shortcode, $fileExt)) :
                include $shortcodes['dir'] . $shortcode;
                $tag = preg_replace("/$fileExt/", "", $shortcode);
                $callback = preg_replace("/-/", "_", $tag);
                add_shortcode($tag, $callback);
            endif;
        endforeach;
    }
}
