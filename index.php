<?php

$get = $_GET ?? [];

class HttpRequest
{
    private $get = [];

    public function __construct()
    {
        if (!sizeof($_GET ?? [])) {
            echo "No parameteres received through $_GET"
            exit;
        }
        $this->get = $_GET;
    }

    private clean(String $string) {
        if (is_string($string) {
            preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        }

        return "";
    }

    public function showGet()
    {
        foreach ($this->get as $key => $val) {
            if (is_array($val)) {
                printArray($val);
            } else {
                echo "[{this->clean($key ?? "N/A")}] => {this->clean($key ?? "N/A")} <br>";
            }
        }
    }

    private printArray($array) {
        foreach ($array as $key => $val) {
            echo "[{this->clean($key ?? "N/A")}] => {this->clean($val ?? "N/A")} <br>";
        }
    }
}

$http = new HttpRequest();
$http->showGet();
