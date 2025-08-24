<?php

namespace WPChildThemeBoilerplate;

use WPChildThemeBoilerplate\SettingsInterface;

class PublicSettings implements SettingsInterface
{
    private $stylesPath;
    private $scriptsPath;

    public function __construct()
    {
        $this->stylesPath = get_theme_file_uri() . "/build/css/";
        $this->scriptsPath = get_theme_file_uri() . "/build/js/";
        $this->themeShortcodes();
    }

    public function enqueueScripts()
    {
        $scripts = $this->getFilesArray("/build/js/");
        $fileExt = ".min.js";

        if (is_admin() || $scripts === false) return;

        if (count($scripts['files']) <= 2) return;
        foreach ($scripts['files'] as $script) :
            if (strlen($script) >= 3 && str_contains($script, $fileExt)) :
                $handle = preg_replace("/$fileExt/", "", $script);
                wp_enqueue_script($handle, $this->scriptsPath . $script);
            endif;
        endforeach;
    }

    public function enqueuePageScripts()
    {
        $scripts = $this->getFilesArray("/build/js/pages/");
        $fileExt = ".min.js";

        if (is_admin() || $scripts === false) return;

        if (count($scripts['files']) <= 2) return;
        foreach ($scripts['files'] as $script) :
            if (strlen($script) >= 3 && str_contains($script, $fileExt)) :
                $slug = preg_replace("/$fileExt/", "", $script);
                if (is_page($slug)) :
                    wp_enqueue_script("page-" . $slug, $this->scriptsPath . "pages/$script");
                endif;
            endif;
        endforeach;
    }

    public function enqueueStyles()
    {
        if (is_admin()) return;
        wp_enqueue_style('parent-style', get_parent_theme_file_uri('style.css'));

        if (is_front_page()) {
            wp_register_style('home', $this->stylesPath . 'home.min.css');
            wp_enqueue_style('home');
        }

        $styles = $this->getFilesArray("/build/css/");
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
        $styles = $this->getFilesArray("/build/css/pages/");
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

    function addPublicModules($tag, $handle, $src)
    {
        /**
         * Turns all javascript files pointed in the $scripts array into ES6 modules
         * All scripts must be registered before its handle is passed to the $scripts array
         */

        $scripts = array(
            '',
        );

        foreach ($scripts as $script) {
            if ($script === $handle) {
                $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
            }
        }

        return $tag;
    }

    function themeShortcodes()
    {
        $shortcodes = $this->getFilesArray("/lib/shortcodes/");
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

    function getFilesArray(String $path): array|Bool
    {
        $dir = dirname(__DIR__) . $path;
        $readFiles = scandir($dir, SCANDIR_SORT_DESCENDING);
        if (count($readFiles) <= 2) return false;
        $readFiles = ["files" => $readFiles, "dir" => $dir];
        return $readFiles;
    }
}
