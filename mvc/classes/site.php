<?php
    abstract class site
    {   
        static private $routerData = array();
        static public $clanData = array();
        
        public function __construct() {  }
        
        public static function init()
        {
            self::$routerData = Router::getParams();
            if(!isset(self::$routerData['clanid']))
            {
                self::$routerData['clanid'] = 1;
            }
            
            self::testIfSiteExists();
            self::testIfSiteClosed();
            self::testTemplateType();
        }
        
        public static function testIfSiteExists()
        {
            MySQL :: query("SELECT * FROM `webseiten` WHERE `clanid`='".self::$routerData['clanid']."'");
            
            if(MySQL :: count() != 1)
            {
                die("SEITE EXISTIERT NICHT!");
            }
            else
                self::$clanData = MySQL :: fetchArray();
        }
        
        public static function testIfSiteClosed()
        {
            if(self::$clanData['siteBanned'])
            {
                // geschlossen von MyClanKonto
            }
            else if(self::$clanData['closedFromAdmin'])
            {
               // geschlossen vom Leader des Clans
            }
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
                    Template::init("templates/standart.html");
                    
                    Template::replace("</head>", "\n".Template::leerzeichen("<title>").'<link rel="stylesheet" type="text/css" href="http://myclankonto.net/'.self::$routerData['clanid'].'/stylecheet.css" />'."\n".Template::leerzeichen("<head>").'</head>');
                    Template::replaceContent("{seiteninhalt}", "pages/site/".self::$routerData['site'].".php");
                    
                    
                    echo Template::out();
                }
            }
            else
            {
                MySQL :: query("SELECT * FROM `inhalte` WHERE `template`='1' AND `templateType`='1'");
                
                if(MySQL::count())
                {
                    echo "HTML";
                }
                else
                {
                    echo "Premium Standart";
                }
            }
        }
    }
?>