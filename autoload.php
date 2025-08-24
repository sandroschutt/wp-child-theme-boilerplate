<?php
/**
 * Autoload function for WPChild namespace classes.
 *
 * This function automatically loads class files within the WPChild namespace.
 * It searches through predefined base directories for the class file,
 * using the PSR-4 autoloading standard approach.
 *
 * @param string $class Fully qualified class name to be loaded.
 *
 * @return void Returns nothing. Includes the class file if found.
 */
function WPChildAutoload($class) {
    $prefix   = 'WPChild\\';
    $baseDirs = [
        __DIR__ . '/',
        __DIR__ . '/inc/',
        __DIR__ . '/lib/',
    ];

    $len = strlen($prefix);

    // Only attempt to load classes in the WPChild namespace
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Remove the namespace prefix and convert to file path
    $relative_class = substr($class, $len);
    $relative_path  = str_replace('\\', '/', $relative_class) . '.php';

    // Search each base directory for the class file
    foreach ($baseDirs as $base_dir) {
        $file = $base_dir . $relative_path;

        if (file_exists($file)) {
            require $file;
            return;
        }
    }
}

spl_autoload_register('WPChildAutoload');

