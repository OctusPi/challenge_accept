<?php
namespace Picpay\Challenge\core\Http\Controllers;

use Picpay\Challenge\core\Http\Controllers\Controller;
use Picpay\Challenge\core\Http\Response;

class HomeController extends Controller
{
    public function index():string
    {
        return Response::json(['message' => 'Achou!!!']);
    }
}