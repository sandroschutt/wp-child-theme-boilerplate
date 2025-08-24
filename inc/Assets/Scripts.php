<?php

namespace WPChild\Assets;

/**
 * Class Scripts
 *
 * Handles the registration and enqueueing of theme JavaScript files.
 *
 * @package WPChild\Assets
 */
class Scripts
{
    /**
     * @var string Base URI path to the theme's JS build directory.
     */
    private $scriptsPath;

    public function __construct()
    {
        $this->scriptsPath = get_theme_file_uri() . "/build/js/";
    }

    /**
     * Enqueue global JavaScript files.
     *
     * Loads scripts from the build/js directory and enqueues them for the frontend.
     *
     * @return void
     */
    public function enqueueScripts()
    {
        $scripts = \WPChild\Helpers::getFilesArray("/build/js/");
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

    /**
     * Enqueue page-specific JavaScript files.
     *
     * Loads scripts from build/js/pages/ and enqueues them for matching pages.
     *
     * @return void
     */
    public function enqueuePageScripts()
    {
        $scripts = \WPChild\Helpers::getFilesArray("/build/js/pages/");
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

    /**
     * Converts registered scripts into ES6 modules when needed.
     *
     * This function can be used as a filter on script tags to change
     * the type attribute to "module" for specific handles.
     *
     * @param string $tag The original script tag HTML.
     * @param string $handle The handle of the enqueued script.
     * @param string $src The source URL of the script.
     *
     * @return string Modified script tag with type="module" if applicable.
     */
    function addPublicModulesFromArray($tag, $handle, $src)
    {
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
