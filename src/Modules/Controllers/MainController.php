<?php

namespace OrkesterSample\Modules\Controllers;

class MainController extends \Orkester\MVC\MController
{
    public function main()
    {
        return $this->render('main');
    }
}
