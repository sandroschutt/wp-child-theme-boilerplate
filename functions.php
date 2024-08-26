<?php

/**
 * Theme settings are handled by the ThemeSettings class.
 * Admin logic, javascript and styles are handled by AdminSettings class.
 * Admin logic, javascript and styles are handled by AdminSettings class.
 */

require dirname(__FILE__) . "/includes/autoload.php";

$themeSettings = new WPChildThemeBoilerplate\ThemeSettings();

add_filter('wp_lazy_loading_enabled', '__return_false');
