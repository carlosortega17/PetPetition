<?php
namespace Adross;

use Adross\Router;
use Models\Post;
use Models\Usuario;

class App
{
    public $router;
    private $route;
    
    public function __construct()
    {
        $this->route = $_SERVER['REQUEST_URI'];
        $this->router = new Router();
    }

    public function Check()
    {
        if($this->router->req["URL"] != $this->route)
            echo "Error page not found ".$this->route;
    }

    public static function RebuildAllSchemas()
    {
        new Post(true);
        new Usuario(true);
    }
}