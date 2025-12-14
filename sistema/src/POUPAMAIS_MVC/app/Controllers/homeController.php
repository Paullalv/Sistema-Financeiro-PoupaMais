<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $path_to_view = __DIR__ . "/../Views/home/index.php";

        require $path_to_view;
    }
}
