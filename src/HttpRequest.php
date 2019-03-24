<?php

namespace HttpWorkshop;

/**
 * Class HttpRequest
 * @package HttpWorkshop
 */
class HttpRequest
{
    private $get;
    private $response;

    /**
     * HttpRequest constructor.
     * @param HttpResponse $response
     * @throws \ErrorException
     */
    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
        if (!sizeof($_GET ?? [])) {
            $this->response->setStatus(404);
//            throw new \ErrorException("", 404);
        }

        $this->get = $_GET;
    }

    /**
     *
     */
    public function getData()
    {
        $this->response->setStatus(200);
        $this->cleanArray($this->get);

        return $this->get;
    }

    /**
     * @param $data
     * @param $format
     */
    public function render($data, $format)
    {
        if (strtolower($format) === "json") {
            header('Content-Type: application/json');
            echo json_encode(["response" => "success", "status" => $this->response->getStatus(), "data" => $data]);
        }
    }

    /**
     * @param String $string
     * @return string
     */
    private function clean($string)
    {
        if (is_string($string)) {
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        }

        return "";
    }

    /**
     * @param $array
     */
    private function cleanArray($array)
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $this->cleanArray($val);
            } else {
                $array[$this->clean($key ?? "N/A")] = $this->clean($key ?? "N/A");
            }
        }
    }

    /**
     * @param $array
     */
    private function printArray($array)
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $this->printArray($val);
            } else {
                echo "[" . $this->clean($key ?? "N/A") . "] => {" . $this->clean($key ?? "N/A") . "} <br>";
            }
        }
    }
}
