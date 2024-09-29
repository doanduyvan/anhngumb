<?php
session_start();
define('DIR_ROOT', __DIR__);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$currentDateTime = date('H:i:s d-m-Y');
define("NOW", $currentDateTime);

$web_root = "";
$arrPath = explode('\\', DIR_ROOT);
$indexPath = array_search("htdocs", $arrPath);
$arrPath = array_slice($arrPath, $indexPath + 1);
$web_root = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . implode("/", $arrPath) . "/";
define("WEB_ROOT", $web_root);

// Nạp autoload và dotenv
include_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Khởi tạo Router
new Cores\Router();