<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

session_start();

spl_autoload_register(function (string $name) {
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $name) . '.php';
});

$method = $_SERVER['REQUEST_METHOD'];
$route = $_GET['q'] ?? '';
$router = require __DIR__ . '/src/routes/routes.php';
Echo $method;
$matched = false;

foreach ($router as $pattern => $routeConfig) {
    if (preg_match($pattern, $route, $matches)) {
        if (isset($routeConfig['methods'][$method])) {
            $matched = true;
            unset($matches[0]); // Удаляем полное совпадение
            $controllerName = $routeConfig['controller'];
            $controllerMethod = $routeConfig['methods'][$method];
            break;
        }
    }
}

if (!$matched) {
    http_response_code(404);
    require_once __DIR__ . "/templates/errors/404.php";
    die();
}

try {
    $controller = new $controllerName();
    call_user_func_array([$controller, $controllerMethod], array_values($matches));
} catch (Throwable $e) {
    http_response_code(500);
    error_log($e->getMessage());
    require_once __DIR__ . "/templates/errors/500.php";
    die();
}