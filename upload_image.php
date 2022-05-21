<?php
require("utils/http_responder.php");
require 'middleware/basic_auth.php';
require "utils/env.php";

$allowedExtensions = array('jpg', 'png', 'jpeg');
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "POST" && !is_uploaded_file($_FILES['file_to_upload']['name'])) {
    if (
        !isset($_FILES['file_to_upload']['error']) ||
        is_array($_FILES['file_to_upload']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    $imageName=$_FILES["file_to_upload"]["name"];
    $imagesPath = $APP_IMG_PATH;
    $imagesFolderPath = $_POST['category'] ?? '';
    $target_file = $imagesPath.'/'.$imagesFolderPath.'/'.basename($imageName);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($_FILES["file_to_upload"]["tmp_name"]);
    if($check !== false) {
        
        $uploadOk = 1;
    } else {
        http_responder('FAIL', "File is not an image.");
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file) && $uploadOk !== 0) {
        http_responder('FAIL', "Sorry, file already exists.");
        $uploadOk = 0;
    }

    if(!in_array($imageFileType, $allowedExtensions, true) && $uploadOk !== 0) {
        http_responder('FAIL',  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        http_responder('FAIL', "Sorry, your file was not uploaded.");
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file) && $uploadOk === 1) {
            chmod($target_file, 0777);
            http_responder('SUCCESS', "File is an image - " . $check["mime"] . ". Image name is: ". $imageName);
        } else {
            http_responder('FAIL', "Sorry, there was an error uploading your file.");
        }
    }
} else {
    http_responder('FAIL', "Request method not right.");
}
