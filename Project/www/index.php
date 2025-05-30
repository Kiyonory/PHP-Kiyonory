<?php

spl_autoload_register(function(string $className){
    $className = str_replace('\\', '/', $className);
    require(dirname(__DIR__).'/'.$className.'.php');
});

use src\Services\Db;
use src\Controllers\MainController;
use src\Controllers\ArticleController;
use src\Controllers\CommentController;

Db::getInstance();

$uri = $_SERVER['REQUEST_URI'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);

if (strpos($uri, $basePath) === 0) {
    $route = substr($uri, strlen($basePath));
} else {
    $route = $uri;
}

$route = strtok($route, '?');

if ($route === '/index.php' || $route === '') {
    $route = '/';
}

$patterns = require(__DIR__ . '/route.php');
$findRoute = false;

foreach($patterns as $pattern => $controllerAndAction){
    if(preg_match($pattern, $route, $matches)){
        $findRoute = true;
        unset($matches[0]);
        $controllerName = $controllerAndAction[0];
        $action = $controllerAndAction[1];

        if (!class_exists($controllerName)) {
            echo 'Ошибка: Класс контроллера '. $controllerName . ' не найден.';
            exit();
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $action)) {
             echo 'Ошибка: Метод действия '. $action . ' в контроллере '. $controllerName . ' не найден.';
            exit();
        }

        $postRoutes = [
            '~^/article/store$~',
            '~^/article/(\d+)/update$~',
            '~^/article/(\d+)/delete$~',
            '~^/article/rate$~',
            '~^/comment/store$~',
            '~^/comment/delete$~'
        ];

        if (in_array($pattern, $postRoutes) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
             header('HTTP/1.1 405 Method Not Allowed');
             echo 'Метод не разрешен';
             exit();
        }

        $controller->$action(...$matches);
        break;
    }
}

if (!$findRoute) {
    header('HTTP/1.1 404 Not Found');
    echo 'Страница не найдена';
}

