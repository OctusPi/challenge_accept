<?php
namespace Picpay\Challenge\core\Http;

use Picpay\Challenge\core\Security\External;

class Request
{
    public static function all(): array|null
    {
        return External::sanitize(array_merge($_POST, $_GET, $_COOKIE, $_FILES));
    }

    public static function any(array $params): array
    {
        $paramsFlipped = array_flip($params);

        return array_filter(
            self::all(),
            fn($value, $key) => array_key_exists($key, $paramsFlipped),
            ARRAY_FILTER_USE_BOTH
        );
    }
}

