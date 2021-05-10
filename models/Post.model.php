<?php
namespace Models;
use Adross\Schema;

class Post extends Schema
{
    public function __construct()
    {
        $this->schemaname = "tb_post";
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
                "name"=>"timestamp",
                "type"=>"TIMESTAMP",
            ],
        ];
        $this->start();
    }
}