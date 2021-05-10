<?php
include_once('autoload.class.php');
use Adross\App;
use Models\Post;
use Models\Usuario;

// Models
$usuario = new Usuario();

$app = new App();

$app->get('/', 'index', ["title"=>"Bienvenido", "usuario"=>$usuario->index()]);
$app->get('/home', 'index');
$app->get('/about', 'about');
$app->get('/auth', 'auth/index');
$app->get('/auth/logged', 'auth/dashboard');

?>