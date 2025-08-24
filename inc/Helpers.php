<?php

namespace WPChild;

/**
 * Class Helpers
 *
 * Provides utility functions for file operations and other helper methods.
 *
 * @package WPChild
 */
class Helpers
{
    /**
     * Get an array of files from a specified directory.
     *
     * Reads the contents of a directory and returns an array containing
     * the file names and the full directory path. Returns false if the
     * directory is empty or only contains system entries.
     *
     * @param string $path Relative path from the parent directory to scan.
     *
     * @return array|bool Returns an array with keys 'files' and 'dir' if files exist or false if the directory is empty or contains no files.
     */
    public static function getFilesArray(String $path): array|Bool
    {
        $dir = dirname(__DIR__) . $path;
        $readFiles = scandir($dir, SCANDIR_SORT_DESCENDING);
        if (count($readFiles) <= 2) return false;
        $readFiles = ["files" => $readFiles, "dir" => $dir];
        return $readFiles;
    }
}
