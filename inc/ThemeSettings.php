<?php

namespace WPChild;

class ThemeSettings
{
    private $styles;
    private $scripts;

    public function __construct()
    {
        $this->styles = new \WPChild\Assets\Styles;
        $this->scripts = new \WPChild\Assets\Scripts;
        $this->activationHook();
        $this->actionHooks();
        $this->filterHooks();
        $this->includeShortcodes();
    }

    public function actionHooks()
    {
        add_action('wp_enqueue_scripts', array($this->scripts, 'enqueueScripts'));
        add_action('wp_enqueue_scripts', array($this->scripts, 'enqueuePageScripts'));
        add_action('wp_enqueue_scripts', array($this->styles, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this->styles, 'enqueuePageStyles'));
    }

    public function filterHooks()
    {
        add_filter("script_loader_tag", array($this->scripts, 'addPublicModules'), 10, 3);
    }

    public function activationHook() {}

    public function includeShortcodes() {
        $shortcodes = new \WPChild\Assets\Shortcodes;
        $shortcodes->autoInclude();
    }
}
