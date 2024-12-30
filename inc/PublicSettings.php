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
        $path = "/build/js/";
        $scripts = $this->readThemeDirectories($path, false);
        if (is_admin() || $scripts === null) return;

        if (count($scripts['files']) <= 2) return;
        foreach ($scripts['files'] as $script) :
            if (strlen($script) >= 3 && str_contains($script, ".js")) :
                $scriptName = preg_replace("/.js/", "", $script);
                wp_enqueue_script($scriptName, $this->scriptsPath . $script);
            endif;
        endforeach;
    }

    public function enqueuePageScripts()
    {
        $path = "/build/js/pages/";
        $scripts = $this->readThemeDirectories($path, false);
        if (is_admin() || $scripts === null) return;

        if (count($scripts['files']) <= 2) return;
        foreach ($scripts['files'] as $script) :
            if (strlen($script) >= 3 && str_contains($script, ".js")) :
                $scriptName = preg_replace("/.js/", "", $script);
                if (is_page($scriptName)) :
                    wp_enqueue_script("page-" . $scriptName, $this->scriptsPath . "pages/$script");
                endif;
            endif;
        endforeach;
    }

    public function enqueueStyles()
    {
        if (is_admin()) return;
        wp_enqueue_style('parent-style', get_parent_theme_file_uri('style.css'));

        if (is_front_page()) {
            wp_register_style('home', $this->stylesPath . 'home.css');
            wp_enqueue_style('home');
        }

        if (is_singular('post')) {
            wp_register_style('single-post', $this->stylesPath . 'single-post.css');
            wp_enqueue_style('single-post');
        }

        $path = "/build/css/";
        $styles = $this->readThemeDirectories($path, false);
        if (is_admin() || $styles === null) return;

        if (count($styles['files']) <= 2) return;
        foreach ($styles['files'] as $style) :
            if (strlen($style) >= 3 && str_contains($style, ".css")) :
                $styleName = preg_replace("/.css/", "", $style);
                wp_enqueue_style($styleName, $this->stylesPath . $style);
            endif;
        endforeach;
    }

    public function enqueuePageStyles()
    {
        $path = "/build/css/pages/";
        $styles = $this->readThemeDirectories($path, false);
        if (is_admin() || $styles === null) return;

        if (count($styles['files']) <= 2) return;
        foreach ($styles['files'] as $style) :
            if (strlen($style) >= 3 && str_contains($style, ".css")) :
                $styleName = preg_replace("/.css/", "", $style);
                if (is_page($styleName)) :
                    wp_enqueue_style("page-" . $styleName, $this->stylesPath . "pages/$style");
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
        $path = "/lib/shortcodes/";
        $shortcodes = $this->readThemeDirectories($path, true);

        if (is_admin() || $shortcodes === null) return;

        foreach ($shortcodes['files'] as $shortcode) :
            if (strlen($shortcode) >= 3 && str_contains( $shortcode, ".php" )) :
                include $shortcodes['dir'] . $shortcode;
                $shortcodeName = preg_replace("/.php/", "", $shortcode);
                $shortcodeCallback = preg_replace("/-/", "_", $shortcodeName);
                add_shortcode($shortcodeName, $shortcodeCallback);
            endif;
        endforeach;
    }

    function readThemeDirectories(String $path, Bool $php)
    {
        $dir = dirname(__DIR__) . $path;
        $files = scandir($dir, SCANDIR_SORT_DESCENDING);
        if (count($files) <= 2) return;
        $files = ["files" => $files];
        if ($php) $files['dir'] = $dir;
        return $files;
    }
}
