<?php
require "utils/http_responder.php";
require 'middleware/basic_auth.php';
require 'utils/map_directories.php';
require "utils/env.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Content-type: application/json');
    $dir = mapDirectoriesWithFiles($APP_IMG_PATH);
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

