<?php
namespace Picpay\Challenge\Http;
use Picpay\Challenge\Security\External;

class Request
{
    public static function all(): array|null
    {
        return External::sanitize(array_merge($_POST, $_GET, $_COOKIE, $_FILES));
    }
}