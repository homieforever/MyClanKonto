<?php
    defined(SYS_PATH)  or define("SYS_PATH", dirname(__FILE__)."/");
 
    require_once SYS_PATH . "functions/basic.php";
    require_once SYS_PATH . "classes/loader.php";
    
    Loader::addAutoLoad("_classLoad");

    Registry::add();
?>