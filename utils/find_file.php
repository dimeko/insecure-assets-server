<?php
require "env.php";

function searchJsonFile($dir, $file)
{
    $ffs = scandir($dir);
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    foreach ($ffs as $ff) {
        if ($ff === $file . '.json' || (strpos($ff, '.json') !== false && $ff === $file)) {
            return $dir . '/' . $ff;
        }
        
        if (strpos($ff, '.json') === false) {
            return searchJsonFile($dir . '/' . $ff, $file);
        }
    }

    return null;
}