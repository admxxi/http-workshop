<?php

namespace Http;

/**
 * Class HttpRequest
 * @package HttpWorkshop
 */
class Request
{
    private $get;
    private $response;

    /**
     * HttpRequest constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        if (!sizeof($_GET ?? [])) {
            $this->response->setStatus(404);
        }

        $this->get = $_GET;
    }

    /**
     *
     */
    public function getQueryString()
    {
        $this->response->setStatus(200);
        $this->filter($this->get);

        return $this->get;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param String $string
     * @return string
     */
    public static function clean($string)
    {
        if (is_string($string)) {
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        }

        return "";
    }

    /**
     * @param $array
     */
    private function filter($array)
    {
        foreach ($array as $key => $val) {
            $this->get[$key] = $this->clean(filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING));
        }
    }

    /**
     * @param $array
     * @return bool
     */
    public static function printArray($array)
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                self::printArray($val);
            } else {
                echo "[".self::clean($key ?? "N/A")."] => {".self::clean($key ?? "N/A")."} <br>";
            }
        }

        return true;
    }
}
