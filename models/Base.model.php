<?php
namespace Models;
use Adross\Schema;
use Models\Usuario;

// Use this model for examples

class Base extends Schema
{
    public function __construct($force=false)
    {
        $user = new Usuario(); // Here model do you add foreign
        $this->schemaname = "tb_posts";
        $this->columns =
        [
            [
                "name"=>"title",
                "type"=>"VARCHAR",
                "size"=>30
            ],
            [
                "name"=>"description",
                "type"=>"TEXT",
            ],
            [
                "name"=>"user",
                "type"=>"INTEGER",
                "attrib"=>"UNSIGNED"
            ],
            [
                "name"=>"timestamp",
                "type"=>"TIMESTAMP",
            ],
        ];
        
        $this->foreigns = [[
            "foreign"=>[
                "model_schema_name"=> $user->schemaname,
                "relation_name"=>"SAMPLE",
                "root"=>"user",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]];
        $this->start($force);
    }
}