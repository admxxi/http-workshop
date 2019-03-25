<?php

namespace Route;

use Core\Controller;

/**
 * Class SampleController
 */
class SampleController extends Controller
{
    public function actionTest()
    {
        $this->render("test");
    }
}