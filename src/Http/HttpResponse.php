<?php

namespace Workshop;

/**
 * Class HttpResponse
 * @package HttpWorkshop
 */
class Response
{
    const statusCollection = [
        200 => "HTTP/1.1 200 Success",
        404 => "HTTP/1.1 404 Not Found",
    ];

    private $statusCode = [];

    public function __construct()
    {

    }

    /**
     * @param Integer $status
     */
    public function setStatus($status)
    {
        if (in_array($status, HttpResponse::statusCollection)) {
            header(HttpResponse::statusCollection[$status]);
            $this->statusCode = $status;
        }
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->statusCode;
    }
}
