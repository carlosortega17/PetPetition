<?php
namespace Adross;

class Schema
{
    public $schemaname;
    public $database;
    public $columns;

    public function start()
    {
        $this->database = new Database();
        $table = "CREATE TABLE IF NOT EXISTS ".$this->schemaname."(_id INT NOT NULL AUTO_INCREMENT,";
        foreach($this->columns as $col)
        {
            $extra = $col['type'] == "TIMESTAMP" ? " DEFAULT CURRENT_TIMESTAMP" : "";
            $size = isset($col['size']) ? "(".$col['size'].")" : "";
            $nullable = isset($col['nullable']) ? $col['nullable'] : " NOT NULL";
            $table .= " ".$col['name']." ".$col['type'].$size." ".$nullable.$extra.",\n"; 
        }
        $table .= " PRIMARY KEY (_id));";
        $this->database->NonQuery($table);
    }

    public function index()
    {
        return $this->database->Query("SELECT * FROM ".$this->schemaname);
    }

    public function show($id)
    {
        return $this->database->Query("SELECT * FROM ".$this->schemaname." WHERE _id = ".$id);
    }

    public function create()
    {
        
    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}