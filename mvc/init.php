<?php
    defined(SYS_PATH)  or define("SYS_PATH", dirname(__FILE__)."/");
    require_once SYS_PATH . "classes/loader.php";
    
    ini_set("display_errors", 1);
    
    Loader   :: addAutoLoad();
    Loader   :: addMap();
    Registry :: init();
    
    Router   :: addMap();
    Router   :: init();
    
    if(Router::getParams() == NULL)
    {
        Subdomain :: init();
    }
    
    $controller = Router :: getController();
    
    if($controller == 'site' OR
       $controller == 'admin' OR
       $controller == 'stylecheet')
    {
        $controller::init();
    }
    else
    {
        header("Location: http://myclankonto.net/");
    }
?>