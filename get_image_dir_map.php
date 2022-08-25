<?php
require("utils/http_responder.php");
require 'middleware/basic_auth.php';
require 'utils/map_directories.php';
require "utils/env.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Content-type: application/json');
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   
    $components = parse_url($url);
    parse_str($components['query'], $results);
    $subDir = $results['subDir'] ?? null;
    if($subDir) {
        $dir = mapDirectoriesWithFiles($APP_IMG_PATH."/".$subDir);
    } else {
        $dir = mapDirectories($APP_IMG_PATH);
    }
    
    if($dir) {
        try {
            http_responder('SUCCESS', $dir);
        } catch (Exception $e) {
            http_response_code(404);
            http_responder('FAIL', 'Directories not found with error:'. $e->getMessage(), "\n");
        }
    } else {
        http_responder('FAIL', 'Directories not found');
    }
}

