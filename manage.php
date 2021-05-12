<?php
include_once('./autoload.class.php');
use Adross\App;
if(isset($argv[1]))
{
    switch($argv[1]){
        case "rebuild_all":
            App::RebuildAllSchemas();
        break;
    }
}