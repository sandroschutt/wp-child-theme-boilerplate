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

    public function __construct()
    {
        $this->styles = new \WPChild\Assets\Styles;
        $this->scripts = new \WPChild\Assets\Scripts;
        \WPChild\Assets\Shortcodes::autoInclude();
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
    public function actionHooks()
    {
        add_action('wp_enqueue_scripts', array($this->scripts, 'enqueueScripts'));
        add_action('wp_enqueue_scripts', array($this->scripts, 'enqueuePageScripts'));
        add_action('wp_enqueue_scripts', array($this->styles, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this->styles, 'enqueuePageStyles'));
    }

    /**
     * Register WordPress filter hooks.
     *
     * Adds filters such as script_loader_tag for module scripts.
     *
     * @return void
     */
    public function filterHooks()
    {
        /*
        * TDOD: Make this function read a modules folder in build instead of loading from array.
        * May need a complementary method in Scripts for autoincluding modules.
        */
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
