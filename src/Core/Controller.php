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
    public function __construct()
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
     * @param $format
     */
    public function render($data, $format = Response::json)
    {
        $data = $data ?? [];
        $this->beforeRender();

        if ($format === Response::json) {
            $this->setContentType(Response::json);
            echo json_encode(
                [
                    "response" => "success",
                    "status"   => $this->request->getResponse()->getStatus(),
                    "data"     => $data,
                ]
            );
        }
        if ($format === Response::html) {
            $this->setContentType(Response::html);
            echo $this->getRequest()->printArray($data);
        }

        $this->afterRender();
        exit;
    }

    /**
     * @return mixed
     */
    public function getAllQueryString()
    {
        return $this->getRequest()->getQueryString();
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server): void
    {
        $this->server = $server;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route): void
    {
        $this->route = ucfirst($route);
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = "action".ucfirst($action);
    }

    public function actionDefault()
    {
        $this->actionDump();
    }

    private function afterRender()
    {
        $html = ob_get_contents();
        ob_clean();
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
    public function actionDump()
    {
        $this->render($this->getAllQueryString(), Response::json);
    }

    /**
     */
    public function notFound()
    {
        $request = new Request(new Response());
        $request->getResponse()->setStatus(Response::notFound);
        $this->render("{$this->getRoute()}->{$this->getAction()} not found");
    }

    /**
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        $this->notFound();
    }


}