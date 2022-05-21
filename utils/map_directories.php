<?php
require "env.php";

function mapDirectories($dir)
{  
    $ffs = scandir($dir);

    return array_values(array_filter($ffs, function($ff) {
        return !str_contains($ff,".");
    }));
}

function mapDirectoriesWithFiles($dir)
{  
    $fileInfo     = scandir($dir);
    $allFileLists = [];

    foreach ($fileInfo as $folder) {
        if ($folder !== '.' && $folder !== '..') {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $folder) === true) {
                $allFileLists[$folder] = mapDirectoriesWithFiles($dir . DIRECTORY_SEPARATOR . $folder);
            } else {
                $allFileLists[] = $folder;
            }
        }
    }

    return $allFileLists;
}