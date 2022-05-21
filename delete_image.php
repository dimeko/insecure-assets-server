<?php
require 'middleware/basic_auth.php';
require("utils/http_responder.php");
require("utils/env.php");

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $fileName = $data['file_to_delete'];
    unlink($fileName);
    http_responder('SUCCESS','File was deleted');
}

