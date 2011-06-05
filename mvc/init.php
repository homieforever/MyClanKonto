<?php
    defined(SYS_PATH)  or define("SYS_PATH", dirname(__FILE__)."/");
    require_once SYS_PATH . "classes/loader.php";
    
    Loader::addAutoLoad();

    Registry::add();
?>