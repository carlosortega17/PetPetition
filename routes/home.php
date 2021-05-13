<?php
use Adross\Router;
use Models\Usuario;

$usuario = new Usuario();

$home = new Router();

$home->get("/", function($req, $res){
    global $usuario;
    $usuario->create(["atrox39","123456","cofter11@gmail.com"]);
    $res->render('index');
});

$home->post("/about", function($req, $res){
    global $usuario;
    $usuario->create(["atrox39","123456","cofter11@gmail.com"]);
    $res->render('about');
});