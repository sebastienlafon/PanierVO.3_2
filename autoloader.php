<?php

function __autoload($class_name){
    
    require 'class/'.$class_name.'.php';  
}

?>
