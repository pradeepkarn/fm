<?php 
spl_autoload_register('myAutoLoader');

function myAutoLoader($className){
    $path = RPATH ."/classes/";
    $extension = ".class.php";
    $fullPath = $path . $className . $extension;
    
    include_once $fullPath;
    
    if(!file_exists($fullPath)){
        return false;
    }
}

?>