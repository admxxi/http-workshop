<?php
require_once "./vendor/autoload.php";

use Http\Request;
use Http\Response;


try {
    $http = new Request(new Response);
    $http->render($http->getData(), "json");
    exit;
} catch (ErrorException $e) {
    $http = new Request(new Response);
    $http->render([], "json");
    exit;
}
