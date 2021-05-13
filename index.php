<?php
include_once('autoload.class.php');
use Adross\App;
use Models\Post;
use Models\Usuario;

// Models
$usuario = new Usuario();
$post = new Post();
$app = new App();

// Routes
include_once('./routes/home.php');

// Verify login
$verifySession = function(){
    if(!isset($_SESSION['user']))
    {
        global $app;
        $app->router->redirect('/auth/dashboard');
    }
};

// Routes

$app->router->get('/about', function($req, $res){
    $res->render('about', ["title"=>"About"]);
});

$app->router->get('/user/login', function($req, $res){
    $res->render('user/login', ["title"=>"About"]);
});

$app->router->post('/test', function ($req, $res){
    print_r($req);
});

$app->Check();
?>