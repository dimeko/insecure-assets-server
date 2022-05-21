<?php
namespace Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$APP_BASE_PATH = $_ENV['DB_PATH'];
$APP_IMG_PATH =  $_ENV['IMG_PATH'];
$NPM_BASE_PATH = $_ENV['NPM_PATH'];