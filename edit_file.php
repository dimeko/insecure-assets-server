<?php
require("utils/http_responder.php");
require 'middleware/basic_auth.php';
require 'utils/find_file.php';
require("utils/env.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $fileName = $data['file_name'] ?? null;
    $filePath = $data['file_path'] ?? null;
    $newContent = $data['data'];

    header('Content-type: application/json');
    $file = searchJsonFile($APP_BASE_PATH, $fileName) ?? null;

    if ($filePath) {
        try {
            if (
                gettype(file_get_contents($APP_BASE_PATH . $pathToSearch)) == "boolean"
                && !file_get_contents($APP_BASE_PATH . $pathToSearch)
            ) {
                throw new Exception("File not found", 402);
            }
            file_put_contents($APP_BASE_PATH . $filePath, json_encode($newContent));
            http_responder('SUCCESS',['data' => file_get_contents($APP_BASE_PATH . $filePath)]);
        } catch (Exception $e) {
            http_response_code(404);
            http_responder('FAIL', 'File not found with error:' . $e->getMessage(), "\n");
        }
    } else if ($file) {
        file_put_contents($file, json_encode($newContent));
        http_responder('SUCCESS',['data' => file_get_contents($file)]);
    } else {
        http_responder('FAIL','File not found');
    }
}
