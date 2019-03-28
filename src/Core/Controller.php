<?php
/**
 * Created by PhpStorm.
 * User: andremonteiro
 * Date: 2019-03-24
 * Time: 19:58
 */

namespace Core;


use ErrorException;
use Http\Request;
use Http\Response;

/**
 * Class Controller
 * @package Core
 */
class Controller
{
    private $server;
    private $request;
    private $route;
    private $action;

    /**
     * Controller constructor.
     * @throws \ErrorException
     */
    function __construct()
    {
        if (!count($_SERVER)) {
            throw new ErrorException("Server problem.");
        }


        $this->setRequest(new Request(new Response));
        $this->setServer($_SERVER);


//            $className = $this->getRoute();
//
//            if (get_class($className) === get_class($this)) {
//                call_user_func($this->getAction());
//            }
//
//            if (method_exists($routeObject, $this->getAction())) {
//                call_user_func($routeObject, $this->getAction());
//            }


    }

    /**
     * @param $data
     * @param string $message
     * @param string $format
     */
    function render($data, $message, $format = Response::json)
    {
        $data = $data ?? false;
        $message = $message ?? false;
        $response = [];
        $output = "";
        $this->beforeRender();

        $response["status"] = $this->getRequest()->getResponse()->getStatus();
        $response["data"] = $data;
        $response["message"] = $message;
        $response["response"] = "success";

        if ($response["status"] > 400) {
            $response["response"] = "error";
        }

        if ($response["status"] > 500) {
            $response["response"] = "server error";
        }

        if ($format === Response::json) {
            $this->setContentType(Response::json);
            $output = json_encode($response);
        }
        if ($format === Response::html) {
            $this->setContentType(Response::html);
            $output = print_r($response, true);
        }

        echo $output;
        $this->afterRender();
        exit;
    }


    /**
     * @return mixed
     */
    function getAllQueryString()
    {
        return $this->getRequest()->getQueryString();
    }

    /**
     * @return mixed
     */
    function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    function setServer($server): void
    {
        $this->server = $server;
    }

    /**
     * @return mixed
     */
    function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    function setRoute($route): void
    {
        $this->route = ucfirst($route);
    }

    /**
     * @return mixed
     */
    function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    function setAction(
        $action
    ): void
    {
        $this->action = "action".ucfirst($action);
    }


    function actionDefault()
    {
        $this->actionDump();
    }

    private function afterRender()
    {
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }

    private function beforeRender()
    {
        ob_start();
    }

    /**
     * @param $format
     */
    private function setContentType($format)
    {
        if (isset($this->getRequest()->getResponse()::contentTypeCollection[$format])) {
            header($this->getRequest()->getResponse()::contentTypeCollection[$format]);
        }
    }

    /**
     *
     */

    function actionDump()
    {
        $this->render($this->getAllQueryString(), "", Response::json);
    }

    /**
     */

    function notFound()
    {
        $request = new Request(new Response());
        $request->getResponse()->setStatus(Response::notFound);
        $this->render([], "{$this->getRoute()}->{$this->getAction()} not found");
    }

    /**
     * @param $method
     * @param $args
     */

    function __call($method, $args)
    {
        $this->notFound();
    }


}