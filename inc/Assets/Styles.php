<?php

namespace WPChild\Assets;

/**
 * Class Styles
 *
 * Handles the registration and enqueueing of theme CSS styles.
 *
 * @package WPChild\Assets
 */
class Styles
{
    /**
     * @var string Base URI path to the theme's CSS build directory.
     */
    private $stylesPath;

    private $fileExt;

    public function __construct()
    {
        $this->stylesPath = get_theme_file_uri() . "/build/css/";
        $this->fileExt = ".min.css";
    }

    /**
     * Enqueue global and front-page specific CSS styles.
     *
     * Enqueues the parent theme style, front page style, 
     * and additional styles found in the theme's build/css directory.
     *
     * @return void
     */
    public function enqueueStyles()
    {
        if (is_admin()) return;
        wp_enqueue_style('parent-style', get_parent_theme_file_uri('style.css'));

        if (is_front_page()) {
            wp_register_style('home', $this->stylesPath . 'home.min.css');
            wp_enqueue_style('home');
        }

        $fileExt = $this->fileExt;
        $styles = \WPChild\Helpers::getFilesArray("/build/css/", $fileExt);

        if (is_admin() || $styles === false) return;

        foreach ($styles['files'] as $style) :
            $handle = preg_replace("/$fileExt/", "", $style);
            wp_enqueue_style($handle, $this->stylesPath . $style);
        endforeach;
    }

    /**
     * Enqueue page-specific CSS styles.
     *
     * Loads styles from build/css/pages/ and enqueues them for matching pages.
     *
     * @return void
     */
    public function enqueuePageStyles()
    {
        $fileExt = $this->fileExt;
        $styles = \WPChild\Helpers::getFilesArray("/build/css/pages/", $fileExt);

        if (is_admin() || $styles === false) return;

        foreach ($styles['files'] as $style) :
            $slug = preg_replace("/$fileExt/", "", $style);
            $page = preg_replace("/page-/", "", $slug);
            if (is_page($page)) :
                wp_enqueue_style("page-" . $page, $this->stylesPath . "pages/$style");
            endif;
        endforeach;
    }
}
