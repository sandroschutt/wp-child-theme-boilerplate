<?php

namespace WPChild\Assets;

class Styles
{
    private $stylesPath;
    private $helpers;

    public function __construct()
    {
        $this->stylesPath = get_theme_file_uri() . "/build/css/";
        $this->helpers = new \WPChild\Helpers;
    }

    public function enqueueStyles()
    {
        if (is_admin()) return;
        wp_enqueue_style('parent-style', get_parent_theme_file_uri('style.css'));

        if (is_front_page()) {
            wp_register_style('home', $this->stylesPath . 'home.min.css');
            wp_enqueue_style('home');
        }

        $styles = $this->helpers->getFilesArray("/build/css/");
        $fileExt = ".min.css";

        if (is_admin() || $styles === false) return;

        if (count($styles['files']) <= 2) return;
        foreach ($styles['files'] as $style) :
            if (strlen($style) >= 3 && str_contains($style, "$fileExt")) :
                $handle = preg_replace("/$fileExt/", "", $style);
                wp_enqueue_style($handle, $this->stylesPath . $style);
            endif;
        endforeach;
    }

    public function enqueuePageStyles()
    {
        $styles = $this->helpers->getFilesArray("/build/css/pages/");
        $fileExt = ".min.css";

        if (is_admin() || $styles === false) return;

        if (count($styles['files']) <= 2) return;
        foreach ($styles['files'] as $style) :
            if (strlen($style) >= 3 && str_contains($style, $fileExt)) :
                $slug = preg_replace("/$fileExt/", "", $style);
                $page = preg_replace("/page-/", "", $slug);
                if (is_page($page)) :
                    wp_enqueue_style("page-" . $page, $this->stylesPath . "pages/$style");
                endif;
            endif;
        endforeach;
    }
}
