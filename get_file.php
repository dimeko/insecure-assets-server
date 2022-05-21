<?php
require("utils/http_responder.php");
require 'middleware/basic_auth.php';
require 'utils/find_file.php';
require("utils/env.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   
    $components = parse_url($url);
    parse_str($components['query'], $results);
    $fileToSearch = $results['file_name'] ?? null;
    $pathToSearch = $results['file_path'] ?? null;
    
    header('Content-type: application/json');
    $file = searchJsonFile($APP_BASE_PATH, $fileToSearch);

    if($pathToSearch) {
        try {
            if(gettype(file_get_contents($APP_BASE_PATH.$pathToSearch)) == "boolean" 
            && !file_get_contents($APP_BASE_PATH.$pathToSearch)) {
                throw new Exception("File not found", 402);
            }
            http_responder('SUCCESS',json_decode(file_get_contents($APP_BASE_PATH.$pathToSearch)));
        } catch (Exception $e) {
            http_response_code(404);
            http_responder('FAIL','File not fkound with error:'. $e->getMessage(), "\n");
        }
    } else if ($file) {
        http_responder('SUCCESS',json_decode(file_get_contents($file), true));
    } else {
        http_responder('FAIL','File not fossssund');
    }
}

