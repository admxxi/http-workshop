<?php
require_once "./vendor/autoload.php";

use Core\Controller;

try {
    $route = "\\Core\\Controller";
    $action = false;

    if (isset($_SERVER["PATH_INFO"])) {
        $pathInfo = $_SERVER["PATH_INFO"];
        $split_path = array_values(array_filter(explode("/", $pathInfo)));


        if (count($split_path) === 1) {
            $route = "\\Core\\Controller";
            $action = $split_path[0];
        }
        if (count($split_path) > 1) {
            $route = "\\Route\\".$split_path[0]."Controller";
            $action = $split_path[1];
        }
    }

    $controller = new Controller();
    $controller->setRoute($route);
    $controller->setAction($action);

    if (!class_exists($controller->getRoute())) {
        throw new ErrorException("Route {$controller->getRoute()} not found");
    }

    $className = $controller->getRoute();

    if ($action && class_exists($className)) {
        $routeObject = new $className();
        $controller->setRoute($route);

        if (!method_exists($routeObject, $controller->getAction())) {
            throw new ErrorException("{$controller->getRoute()}->{$controller->getAction()} Action not found");
        }

        $controller->setAction($action);
        $action_name = $controller->getAction();
        $routeObject->$action_name();
        exit;
    }

    $controller->setAction("Default");
    $controller->actionDefault();

} catch (ErrorException $e) {
    $controller->getRequest()->getResponse()->setStatus($e->getCode() ?? \Http\Response::notFound);
    $controller->render([], $e->getMessage());
}

exit;