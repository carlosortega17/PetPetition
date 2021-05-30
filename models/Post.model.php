<?php
namespace Models;
use Adross\Schema;
class Post extends Schema
{
    public function __construct($force=false)
    {
        parent:: __construct();
        $this->schemaname = "Post";
        $this->columns =
        [
            [
                "name"=>"Titulo",
                "type"=>"VARCHAR",
                "size"=>255
            ],
            [
                "name"=>"Contenido",
                "type"=>"TEXT",
            ],
            [
                "name"=>"Fecha",
                "type"=>"TIMESTAMP"
            ],
            [
                "name"=>"Categoria",
                "type"=>"VARCHAR",
                "size"=>30
            ],
            [
                "name"=>"Imagen",
                "type"=>"VARCHAR",
                "size"=>255
            ],
            [
                "name"=>"Usuario",
                "type"=>"INTEGER"
            ]
        ];
        $this->foreigns = [[
            "foreign"=>[
                "model_schema_name"=> $this->table_prefix."Usuario",
                "relation_name"=>"post_to_usuario",
                "root"=>"Usuario",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]];
        $this->start($force);
    }
}