<?php
/**
 * Created by PhpStorm.
 * User: andremonteiro
 * Date: 2019-03-24
 * Time: 19:58
 */

namespace Core;


class Controller
{
    /**
     * Controller constructor.
     * @param $globals
     */
    public function __construct($globals)
    {
        if (!count($globals)) {
            throw new ErrorException("Server problem.");
        }


    }
}