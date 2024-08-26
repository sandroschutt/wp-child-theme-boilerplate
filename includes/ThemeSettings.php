<?php

namespace WPChildThemeBoilerplate;

use WPChildThemeBoilerplate\AdminSettings;
use WPChildThemeBoilerplate\PublicSettings;

class ThemeSettings
{
    private $public;
    private $admin;

    public function __construct()
    {
        $this->public = new PublicSettings();
        $this->admin = new AdminSettings();
        $this->activationHook();
        $this->actionHooks();
        $this->filterHooks();
    }

    public function actionHooks()
    {
        add_action('admin_enqueue_scripts', array($this->admin, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this->admin, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this->public, 'enqueueScripts'));
        add_action('wp_enqueue_scripts', array($this->public, 'enqueueStyles'));
    }

    public function filterHooks()
    {
        add_filter("script_loader_tag", array($this->public, 'addPublicModules'), 10, 3);
    }

    public function activationHook() {}
}
