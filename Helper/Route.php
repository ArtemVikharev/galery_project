<?php

class Route
{
    static function splitURL()
    {
        if (!isset($_GET['route'])) {
            self::main();
        }

        if (empty($_GET['route'])) {
            self::main();
        }

        $urlParamsArray = explode('/', $_GET['route']);

        if (count($urlParamsArray) != 2) {
            self::error();
        }

        $controller = ucfirst($urlParamsArray[0]) . "Controller";
        $action = $urlParamsArray[1] . "Action";

        if (!file_exists("Controller/$controller.php")) {
            self::error();
        }

        require_once "Controller/$controller.php";

        if (!method_exists($controller, $action)) {
            self::error();
        }

        $controller = new $controller();
        $controller->$action();
    }

    static function error()
    {
        require_once "Controller/MainController.php";
        $controller = new MainController();
        $controller->errorAction();
        die();
    }

    static function main()
    {
        require_once "Controller/MainController.php";
        $controller = new MainController();
        $controller->indexAction();
        die();
    }
}
