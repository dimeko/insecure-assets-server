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
    $new_file_path = $APP_BASE_PATH . $subfolder . $fileName;
    $new_folder_path = $APP_BASE_PATH . $subfolder;
    header('Content-type: application/json');
    if ($fileName) {
        mkdir($new_folder_path, 0777, true);
        $new_file = file_put_contents($new_file_path, json_encode($newContent));

        http_responder('SUCCESS',['data' => $newContent,'directory' => $new_file_path]);
       
    } else {
        http_responder('FAIL','File not found');
    }
}
