<?php
namespace Models;
use Adross\Schema;

class Usuario extends Schema
{
    public function __construct($force=false)
    {
        parent:: __construct();
        $this->schemaname = "Usuario";
        $this->columns =
        [
            [
                "name"=>"Usuario",
                "type"=>"VARCHAR",
                "size"=>40
            ],
            [
                "name"=>"Clave",
                "type"=>"VARCHAR",
                "size"=>255
            ],
            [
                "name"=>"Informacion",
                "type"=>"INTEGER",
                "nullable"=>"NULL"
            ],
            [
                "name"=>"Rol",
                "type"=>"INTEGER"
            ],
            [
                "name"=>"FechaRegistro",
                "type"=>"TIMESTAMP"
            ]
        ];
        $this->foreigns = [[
            "foreign"=>[
            "model_schema_name"=> $this->table_prefix."Informacion_Usuario",
            "relation_name"=>"usuario_to_informacion_usuario",
            "root"=>"Informacion",
            "on_delete"=>"CASCADE",
            "on_update"=>"NO ACTION"]
            ],
            [
                "foreign"=>[
                "model_schema_name"=> $this->table_prefix."Rol",
                "relation_name"=>"usuario_to_rol",
                "root"=>"Rol",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]
        ];
        $this->start($force);
    }
}