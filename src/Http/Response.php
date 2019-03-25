<?php

namespace Http;

/**
 * Class HttpResponse
 * @package HttpWorkshop
 */
class Response
{
    const notFound = 404;
    const success = 200;
    const statusCollection = [
        200 => "HTTP/1.1 200 Success",
        404 => "HTTP/1.1 404 Not Found",
    ];

    const json = "json";
    const html = "html";
    const contentTypeCollection = [
        "json" => 'Content-Type: application/json',
        "html" => 'Content-Type: text/html',
    ];

    private $statusCode = [];

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function getContentTypeCollection()
    {
        return self::contentTypeCollection;
    }


    /**
     * @param Integer $status
     * @return int
     */
    public function setStatus($status)
    {
        if (isset(Response::statusCollection[$status])) {
            header(Response::statusCollection[$status]);

            return $this->statusCode = $status;
        }
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->statusCode;
    }

    public function notFound()
    {
        $this->setStatus(self::notFound);
    }
}
