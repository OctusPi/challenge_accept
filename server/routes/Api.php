<?php
namespace Picpay\Challenge\routes;
use Picpay\Challenge\core\Http\Response;
use Picpay\Challenge\core\Security\External;
use stdClass;

class Api
{
    private static string $namespace = 'Picpay\\Challenge\\core\\Http\\Controllers\\'; 

    private static function getRoute(): object
    {
        return (object) External::sanitize(['uri' => $_SERVER['REQUEST_URI']]);
    }

    public static function go(?string $destiny = null, ?string $action = null, ?array $params = null): string
    {
        $uri = explode('/', self::getRoute()->uri);
        $controller = is_null($destiny) ? self::$namespace.($uri[0] ?? '') : self::$namespace.$destiny();

        if(class_exists($controller)){
            $controller = new $controller($params);
            $action  = is_null($action) ? $uri[1] ?? '' : $action;

            if(method_exists($controller, $action)){
                return $controller->$action();
            }
        }

        return Response::json(['alert' => 'Destino não localizado...'],404);
    }
}