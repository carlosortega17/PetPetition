<?php
namespace Models;
use Adross\Schema;

class Usuario extends Schema
{
    public function __construct()
    {
        $this->schemaname = "tb_usuario";
        $this->columns =
        [
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
        $this->start();
    }
}