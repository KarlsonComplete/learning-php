<?php
try {
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
    });

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';


    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \Myproject\Exception\NotFoundException();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
}catch (\Myproject\Exception\DbException $e)
{
    $view = new \Myproject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
}
catch (\Myproject\Exception\NotFoundException $notFoundException)
{
    $view = new Myproject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $notFoundException->getMessage()], 404);
}

/*if(mail('karlsonfly2001@gmail.com', 'Тема письма', 'Текст письма', 'From: gafaruon@gmail.com'))
{
    echo 'Удачно';
}else
{
    echo 'Неудачно';
}*/
