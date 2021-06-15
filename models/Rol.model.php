<?php
namespace Models;
use Adross\Schema;

// Use this model for examples

class Rol extends Schema
{
    public function __construct($force=false)
    {
        parent::__construct();
        $this->schemaname = "Rol";
        $this->columns =
        [
            [
                "name"=>"nombre",
                "type"=>"VARCHAR",
                "size"=>30
            ]
        ];
        
        /*$this->foreigns = [[
            "foreign"=>[
                "model_schema_name"=> $this->table_prefix.'tablename',
                "relation_name"=>"SAMPLE",
                "root"=>"user",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]];*/
        $this->start($force);
    }
}