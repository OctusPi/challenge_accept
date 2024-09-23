<?php

namespace Picpay\Challenge\routes;

use Picpay\Challenge\core\Http\Response;
use Picpay\Challenge\core\Security\External;

/**
 * Class Route
 * 
 * Gerencia as rotas do sistema, permitindo o mapeamento e verificação de URIs
 * e o roteamento de requisições GET e POST.
 */
class Route
{

    /**
     * Retorna a rota atual após sanitizar a URI.
     *
     * @return object
     */
    private static function getRoute(): object
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return (object) External::sanitize(['uri' => $uri]);
    }

    /**
     * Verifica se o controller e a ação solicitados existem.
     *
     * @param string $controller Nome completo do controller.
     * @param string $action Nome do método do controller.
     * @return void
     */
    private static function checkDestiny(string $controller, string $action): void
    {
        if (!class_exists($controller) || !method_exists($controller, $action)) {
            echo Response::json(['message' => 'Destino solicitado não existe...'], 404);
            exit;
        }
    }

    /**
     * Compara a URI fornecida com a URI atual para verificar se elas correspondem.
     *
     * @param string $uri URI da rota registrada.
     * @return bool
     */
    private static function compareUri(string $uri): bool
    {
        $compare = true;
        $baseUri = explode('/:', $uri)[0];
        $serverUri = self::getRoute()->uri;

        $baseUriToArray = explode('/', $baseUri);
        $serverUriToArray = explode('/', $serverUri);

        foreach ($baseUriToArray as $k => $v) {
            if (!isset($serverUriToArray[$k]) || $serverUriToArray[$k] != $v) {
                $compare = false;
                break;
            }
        }

        return
            count(explode('/', $uri)) === count($serverUriToArray)
            && strpos($serverUri, $baseUri) === 0
            && $compare;
    }

    /**
     * Insere os parâmetros dinâmicos na superglobal $_GET.
     *
     * @param string $uri URI da rota registrada.
     * @return void
     */
    public static function insertParams(string $uri): void
    {
        $paramsUri = explode('/', $uri);
        $serverUri = explode('/', self::getRoute()->uri);

        if (count($serverUri) === count($paramsUri)) {
            foreach ($paramsUri as $key => $param) {
                if (strpos($param, ':') === 0) {
                    $_GET[str_replace(':', '', $param)] = $serverUri[$key];
                }
            }
        }
    }

    /**
     * Gerencia requisições HTTP com base no método, URI, controller e ação.
     *
     * @param string $method Método HTTP (GET ou POST).
     * @param string $uri URI da rota registrada.
     * @param string $controller Nome completo do controller.
     * @param string $action Nome do método do controller.
     * @return void
     */
    private static function handleRequest(string $method, string $uri, string $controller, string $action): void
    {
        if ($_SERVER['REQUEST_METHOD'] === $method && self::compareUri($uri)) {
            self::insertParams($uri);
            self::checkDestiny($controller, $action);

            echo (new $controller())->$action();
            exit;
        }

    }

    /**
     * Mapeia uma rota GET para um controller e ação específicos.
     *
     * @param string $uri URI da rota registrada.
     * @param string $controller Nome completo do controller.
     * @param string $action Nome do método do controller.
     * @return void
     */
    public static function get(string $uri, string $controller, string $action): void
    {
        self::handleRequest('GET', $uri, $controller, $action);
    }

    /**
     * Mapeia uma rota POST para um controller e ação específicos.
     *
     * @param string $uri URI da rota registrada.
     * @param string $controller Nome completo do controller.
     * @param string $action Nome do método do controller.
     * @return void
     */
    public static function post(string $uri, string $controller, string $action): void
    {
        self::handleRequest('POST', $uri, $controller, $action);
    }

    public static function callback(): void{
        echo Response::json(['message' => 'Destino Inexistene'], 404);
        exit;
    }
}
