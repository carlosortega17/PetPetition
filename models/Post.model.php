<?php
namespace Models;
use Adross\Schema;
use Models\Usuario;

class Post extends Schema
{
    public function __construct($force=false)
    {
        parent:: __construct();
        $user = new Usuario(); // Here model do you add foreign
        $this->schemaname = "Post";
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