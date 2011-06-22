<?php
    abstract class stylecheet
    {   
        static private$routerData = array();
        static public $clanData = array();
        
        public function __construct() {  }
        
        public static function init()
        {
            self::$routerData = Router::getParams();
            if(!isset(self::$routerData['clanid']))
            {
                self::$routerData['clanid'] = 1;
            }
            
            if(!isset(self::$routerData['site']))
            {
                self::$routerData['site'] = "news";
            }
            
            if(self::testIfSiteExists())
            {
                if(!self::testIfSiteClosed())
                {
                    self::testTemplateType();
                }
            }
        }
        
        public static function testIfSiteExists()
        {
            MySQL :: query("SELECT * FROM `webseiten` WHERE `clanid`='".self::$routerData['clanid']."'");
            
            if(MySQL :: count() != 1)
            {
                return false;
            }
            else
            {
                self::$clanData = MySQL :: fetchArray();
                return true;
            }
        }
        
        public static function testIfSiteClosed()
        {
            if(self::$clanData['siteBanned'])
            {
                return true;
            }
            else if(self::$clanData['closedFromAdmin'])
            {
               return true;
            }
            return false;
        }
        
        private static function testTemplateType()
        {
            if(self::$clanData['premiumBis'] < time())
            {
                if(!empty(self::$clanData['useStandartDesign']))
                {
                    echo "Eigenes Standart Design ";
                }
                else
                {
                    Template::init("templates/standart_stylecheet.css");
                    
                    Template::replace("{header_height}", self::$clanData['designset_headerheight']);
                    
                    Template::set("Content-Type: text/css");
                    
                    echo Template::out();
                }
            }
            else
            {
                MySQL :: query("SELECT * FROM `inhalte` WHERE `template`='1' AND `templateType`='5'");
                
                if(MySQL::count())
                {
                    MySQL :: query("SELECT * FROM `inhalte` WHERE `template`='1' AND `templateType`='6'");
                    
                    if(MySQL::count())
                    {
                        $row = MySQL::fetchArray();
                        Template::init(NULL, true, $row['inhalt']);
                        
                        Template::replace("{header_height}", self::$clanData['designset_headerheight']);
                        
                        Template::set("Content-Type: text/css");
                        
                        echo Template::out();
                    }
                }
                else
                {
                    echo "Premium Standart";
                }
            }
        }
    }
?>