<?php
namespace Models;
use Adross\Schema;
class Comentario extends Schema
{
    public function __construct($force=false)
    {
        parent::__construct();
        $this->schemaname = "Comentario";
        $this->columns =
        [
            [
                "name"=>"Usuario",
                "type"=>"INTEGER"
            ],
            [
                "name"=>"Post",
                "type"=>"INTEGER"
            ],
            [
                "name"=>"Contenido",
                "type"=>"TEXT"
            ],
            [
                "name"=>"FechaHora",
                "type"=>"TIMESTAMP"
            ],
        ];
        $this->foreigns = [
            ["foreign"=>[
                "model_schema_name"=> $this->table_prefix."Usuario",
                "relation_name"=>"comentario_to_usuario",
                "root"=>"Usuario",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ],
            ["foreign"=>[
                "model_schema_name"=> $this->table_prefix."Post",
                "relation_name"=>"comentario_to_post",
                "root"=>"Post",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]
        ];
        $this->start($force);
    }
}