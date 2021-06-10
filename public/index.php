<?php

session_start();

require "../vendor/autoload.php";
define("URL_BASE", "http://dev.php-mvc:8080");

use App\core\App;

$app = new App();

?>