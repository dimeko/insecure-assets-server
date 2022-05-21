<?php
require 'middleware/basic_auth.php';
require 'utils/find_file.php';
require("utils/http_responder.php");
require("utils/env.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $fileName = $data['file_name'];
    $subfolder = $data['subfolder'] === "" ? "/" : $data['subfolder'];
    $newContent = $data['data'];

    header('Content-type: application/json');
    if ($fileName) {
        file_put_contents($APP_BASE_PATH . $subfolder . $fileName, json_encode($newContent));
        http_responder('SUCCESS',['data' => $newContent,'directory' => $APP_BASE_PATH . $subfolder]);
       
    } else {
        http_responder('FAIL','File not found');
    }
}
