<?php
namespace Adross;

class Schema
{
    public $schemaname;
    public $database;
    public $columns;
    public $foreigns;
    private $table_prefix = "tb_";

    public function start()
    {
        $this->schemaname = $this->table_prefix.$this->schemaname;
        $this->database = new Database();
        if(isset(func_get_args()[0])){
            if(func_get_args()[0]){ 
                $this->database->NonQuery("DROP TABLE IF EXISTS ".$this->schemaname);
                echo "\n\t- rebuilding success for ".$this->schemaname."\n\n";
            }
        }
        $table = "CREATE TABLE IF NOT EXISTS ".$this->schemaname."(_id INT NOT NULL AUTO_INCREMENT,";
        foreach($this->columns as $col)
        {
            $attrib = isset($col['attrib']) ? " ".$col['attrib'] : "";
            $extra = $col['type'] == "TIMESTAMP" ? " DEFAULT CURRENT_TIMESTAMP" : "";
            $size = isset($col['size']) ? "(".$col['size'].")" : "";
            $nullable = isset($col['nullable']) ? $col['nullable'] : " NOT NULL";
            $table .= " ".$col['name']." ".$col['type'].$size.$attrib." ".$nullable.$extra.",\n";
        }
        $table .= " PRIMARY KEY (_id));";
        $this->database->NonQuery($table);
        if(isset($this->foreigns)){
            foreach($this->foreigns as $foreignkey)
            {
                foreach($foreignkey as $keys){
                    $addforeign = "ALTER TABLE `".$this->schemaname."`";
                    $addforeign .= " ADD CONSTRAINT `".$keys['relation_name']."`";
                    $addforeign .= " FOREIGN KEY (`".$keys['root']."`) REFERENCES `".$keys['model_schema_name']."`(`_id`)";
                    $addforeign .= " ON DELETE ".$keys['on_delete'];
                    $addforeign .= " ON UPDATE ".$keys['on_update'].";";
                    $this->database->NonQuery($addforeign);
                }
            }
        }
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