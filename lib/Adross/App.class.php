<?php
namespace Adross;

use Adross\Template;

class App
{
    public $user;
    public $post;
    public $params;
    public $url;
    
    public function __construct()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $this->url = $uri;
        $this->params = explode("/", $uri);
    }

    public function get($route, $view, $context = [])
    {
        if($this->url==$route)
        {
            $path = "views/".$view.".html";
            echo new Template($path, $context);
        }
    }
}