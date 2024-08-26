<?php

namespace WPChildThemeBoilerplate;

use WPChildThemeBoilerplate\SettingsInterface;

class PublicSettings implements SettingsInterface
{
    private $stylesPath;
    private $scriptsPath;

    public function __construct()
    {
        $this->stylesPath = get_theme_file_uri() . "/assets/sass/build/";
        $this->scriptsPath = get_theme_file_uri() . "/assets/javascript/";
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('theme-setup', $this->scriptsPath . 'theme-setup.js');
    }

    public function enqueueStyles()
    {
        wp_enqueue_style('parent-style', get_parent_theme_file_uri('style.css'));

        if (is_front_page()) {
            wp_register_style('home', $this->stylesPath . 'home.css');
            wp_enqueue_style('home');
        }

        if (is_singular('post')) {
            wp_register_style('single-post', $this->stylesPath . 'single-post.css');
            wp_enqueue_style('single-post');
        }
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
}
