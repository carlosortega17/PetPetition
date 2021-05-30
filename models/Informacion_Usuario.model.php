<?php
namespace Models;
use Adross\Schema;

class Informacion_Usuario extends Schema
{
    public function __construct($force=false)
    {
        parent:: __construct();
        $this->schemaname = "Informacion_Usuario";
        $this->columns =
        [
            [
                "name"=>"Nombre",
                "type"=>"VARCHAR",
                "size"=>60
            ],
            [
                "name"=>"Apellido",
                "type"=>"VARCHAR",
                "size"=>60
            ],
            [
                "name"=>"Correo",
                "type"=>"VARCHAR",
                "size"=>255
            ],
            [
                "name"=>"Fecha_Nacimiento",
                "type"=>"DATE"
            ],
            [
                "name"=>"Estado",
                "type"=>"VARCHAR",
                "size"=>40
            ],
            [
                "name"=>"Municipio",
                "type"=>"VARCHAR",
                "size"=>40
            ],
            [
                "name"=>"Numero",
                "type"=>"VARCHAR",
                "size"=>16
            ]
        ];
        $this->start($force);
    }
}