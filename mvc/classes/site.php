<?php
    abstract class site
    {   
        static protected $routerData = array();
        
        public function __construct() { self::$routerData = Router :: getParams(); }
        
        public function init()
        {
            if(!isset(self::$routerData['clanid']))
            {
                self::$routerData['clanid'] = 1;
            }
            
            echo "SITE CONTROLLER";
        }
    }
?>