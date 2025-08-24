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
    private $fileExt;

    public function __construct()
    {
        $this->scriptsPath = get_theme_file_uri() . "/build/js/";
        $this->fileExt = ".min.js";
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
        $fileExt = $this->fileExt;
        $scripts = \WPChild\Helpers::getFilesArray("/build/js/", $fileExt);

        if (is_admin() || $scripts === false) return;

        foreach ($scripts['files'] as $script) :
            $handle = preg_replace("/$fileExt/", "", $script);
            wp_enqueue_script($handle, $this->scriptsPath . $script);
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
        $fileExt = $this->fileExt;
        $scripts = \WPChild\Helpers::getFilesArray("/build/js/pages/", $fileExt);

        if (is_admin() || $scripts === false) return;

        foreach ($scripts['files'] as $script) :
            $slug = preg_replace("/$fileExt/", "", $script);
            if (is_page($slug)) :
                wp_enqueue_script("page-" . $slug, $this->scriptsPath . "pages/$script");
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
        $fileExt = $this->fileExt;
        $defaultScripts = \WPChild\Helpers::getFilesArray('/build/js/', $fileExt);
        $pageScripts = \WPChild\Helpers::getFilesArray('/build/js/pages/', $fileExt);
        
        if(!$defaultScripts || !$pageScripts) return $tag;

        $scripts = array_merge($defaultScripts['files'], $pageScripts['files']);

        foreach ($scripts as $script) {
            $scriptHandle = preg_replace("/$fileExt/", "", $script);
            if ($scriptHandle === $handle) {
                $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
            }
        }

        return $tag;
    }
}
