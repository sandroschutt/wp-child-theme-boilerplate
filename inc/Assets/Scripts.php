<?php

namespace WPChild\Assets;

class Scripts
{
    private $scriptsPath;
    private $helpers;

    public function __construct()
    {
        $this->scriptsPath = get_theme_file_uri() . "/build/js/";
        $this->helpers = new \WPChild\Helpers;
    }

    public function enqueueScripts()
    {
        $scripts = $this->helpers->getFilesArray("/build/js/");
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
        $scripts = $this->helpers->getFilesArray("/build/js/pages/");
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
