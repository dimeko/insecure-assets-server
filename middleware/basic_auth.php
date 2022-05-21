<?php
require_once(__DIR__.'/../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = ($user === $_ENV['AUTH_USER'] && $pass ===  $_ENV['AUTH_PASSWD']);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="My Realm"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
}