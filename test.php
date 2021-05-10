<?php
include_once('autoload.class.php');
include_once('./lib/Adross/Config.php');
use Adross\Schema;

class Usuario extends Schema
{
    public function __construct($instance)
    {
        $this->schemaname = Usuario::class;
        $this->instance = $instance;
        $this->start();
    }
    public $columns = [
        [
            "name"=>"user",
            "type"=>"VARCHAR",
            "size"=>30, 
            "nullable"=>"NULL"
        ],
        [
            "name"=>"pass",
            "type"=>"VARCHAR",
            "size"=>30,
            "nullable"=>"NULL"
        ],
        [
            "name"=>"email",
            "type"=>"VARCHAR",
            "size"=>30,
            "nullable"=>"NULL"
        ],
    ];
}

$usuario = new Usuario(new mysqli(HOST, USER, PASS, DATA));

?>