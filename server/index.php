<?php
require_once "vendor/autoload.php";

use Picpay\Challenge\routes\Route;
use Picpay\Challenge\core\Http\Controllers\HomeController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Route::get('/sas/:id', HomeController::class, 'index');
Route::callback();