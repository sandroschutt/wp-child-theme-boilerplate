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
     * @param string $fileExt File extension to look for. Will list all files if this is not set.
     *
     * @return array|bool Returns an array with keys 'files' and 'dir' if files exist or false if the directory is empty or contains no files.
     */
    public static function getFilesArray(String $path, String $fileExt = ""): array|Bool
    {
        $dir = dirname(__DIR__) . $path;
        $readFiles = scandir($dir, SCANDIR_SORT_DESCENDING);
        $readFiles = ["files" => $readFiles, "dir" => $dir];

        if ($fileExt !== "") :
            foreach ($readFiles['files'] as $key => $file) :
                if (strlen($file) <= 2 || !str_contains($file, "$fileExt")) :
                    unset($readFiles['files'][$key]);
                endif;
            endforeach;
        endif;

        if (is_array($readFiles['files'])) {
            if(count($readFiles['files']) < 1) return false;
        } else return false;

        return $readFiles;
    }

    /**
     * Automatically includes files from a specified directory.
     *
     * Scans the given directory for files matching the specified extension
     * and includes them if the current environment is not the WordPress admin.
     *
     * @param string $path Relative path from the parent directory to scan.
     * @param string $fileExt File extension to include (e.g., '.php').
     *
     * @return void
     */
    public function autoIncludeFiles(String $path, String $fileExt) : void
    {
        $files = $this->getFilesArray($path, $fileExt);
        if (is_admin() || $files === false) return;

        foreach ($files['files'] as $file) :
            if (strlen($file) >= 3 && str_contains($file, $fileExt)) :
                include $files['dir'] . $file;
            endif;
        endforeach;
    }
}
