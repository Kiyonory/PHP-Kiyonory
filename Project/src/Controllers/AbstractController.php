<?php

namespace src\Controllers;

use src\View\View;

abstract class AbstractController
{
    protected $view;
    protected $db;

    public function __construct()
    {
        $this->view = new View();
    }
}