<?php

namespace WPChild;

/**
 * Class ThemeSettings
 *
 * Initializes and manages theme-related settings, including
 * styles, scripts, hooks, and shortcodes.
 *
 * @package WPChild
 */
class ThemeSettings
{
    /**
     * @var \WPChild\Assets\Styles Instance of the Styles class for managing CSS.
     */
    private $styles;

    /**
     * @var \WPChild\Assets\Scripts Instance of the Scripts class for managing JS.
     */
    private $scripts;

    private $helpers;

    public function __construct()
    {
        $this->styles = new \WPChild\Assets\Styles;
        $this->scripts = new \WPChild\Assets\Scripts;
        $this->helpers = new \WPChild\Helpers;
        $this->helpers->autoIncludeFiles("/lib/shortcodes/", ".php");
        $this->helpers->autoIncludeFiles("/lib/snippets/", ".php");
        $this->activationHook();
        $this->actionHooks();
        $this->filterHooks();
    }

    /**
     * Register WordPress action hooks.
     *
     * Hooks styles and scripts enqueue methods to 'wp_enqueue_scripts'.
     *
     * @return void
     */
    public function actionHooks() {}

    /**
     * Register WordPress filter hooks.
     *
     * Adds filters such as script_loader_tag for module scripts.
     *
     * @return void
     */
    public function filterHooks()
    {
        add_filter("script_loader_tag", array($this->scripts, 'addPublicModulesFromArray'), 10, 3);
    }

    /**
     * Theme activation hook.
     *
     * Method to execute logic when the theme is activated.
     *
     * @return void
     */
    public function activationHook() {}
}
