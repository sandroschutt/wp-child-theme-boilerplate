<?php

namespace WPChild;

class Helpers
{
    function getFilesArray(String $path): array|Bool
    {
        $dir = dirname(__DIR__) . $path;
        $readFiles = scandir($dir, SCANDIR_SORT_DESCENDING);
        if (count($readFiles) <= 2) return false;
        $readFiles = ["files" => $readFiles, "dir" => $dir];
        return $readFiles;
    }
}
