<?php
require("utils/http_responder.php");
require 'middleware/basic_auth.php';
require 'utils/find_file.php';
require "utils/env.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $output = shell_exec('cd '.$NPM_BASE_PATH.'&& bash prod_build_js.sh');
    http_responder('UNKNOWN', 'unknown');
}