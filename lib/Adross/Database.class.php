<?php
namespace Adross;
// libs
use mysqli;
include_once('Config.php');
class Database
{
    public $instance;
    public function __construct()
    {
        $temp = new mysqli(HOST, USER, PASS);
        $temp->query('CREATE DATABASE IF NOT EXISTS '.DATA);
        $this->instance = new mysqli(HOST, USER, PASS, DATA);
    }

    public function NonQuery($text)
    {
        $this->instance->query($text);
        return $this->instance->affected_rows != -1 ? true : false;
    }

    public function Query($text)
    {
        $fetch = [];
        $temp = $this->instance->query($text);
        while($res = $temp->fetch_assoc())
        {
            $fetch[] = $res;
        }
        return $fetch;
    }
}