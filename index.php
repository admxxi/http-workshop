<?php
require_once "./vendor/autoload.php";

use HttpWorkshop\HttpRequest;
use HttpWorkshop\HttpResponse;


try {
    $http = new HttpRequest(new HttpResponse);
    $http->render($http->getData(), "json");
    exit;
} catch (ErrorException $e) {
    $http = new HttpRequest(new HttpResponse);
    $http->render([], "json");
    exit;
}
