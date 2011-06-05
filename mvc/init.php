<?php
    defined(SYS_PATH)  or define("SYS_PATH", dirname(__FILE__)."/");
    require_once SYS_PATH . "classes/loader.php";
    
    ini_set("display_errors", 1);
    
    Loader   :: addAutoLoad();
    Registry :: init();
    Router   :: init();
    Router   :: getParams();
?>