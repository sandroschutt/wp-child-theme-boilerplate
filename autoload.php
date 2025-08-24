<?php
function WPChildThemeBoilerplateAutoload($class) {
    $prefix   = 'WPChildThemeBoilerplate\\';
    $baseDirs = [
        __DIR__ . '/',
        __DIR__ . '/inc/',
        __DIR__ . '/lib/',
    ];

    $len = strlen($prefix);

    // Only load classes within our namespace
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $relative_path  = str_replace('\\', '/', $relative_class) . '.php';

    // Loop through each base directory and require if found
    foreach ($baseDirs as $base_dir) {
        $file = $base_dir . $relative_path;

        if (file_exists($file)) {
            require $file;
            return; // Stop after finding the class
        }
    }
}

spl_autoload_register('WPChildThemeBoilerplateAutoload');

