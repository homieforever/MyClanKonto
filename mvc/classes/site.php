<?php
    abstract class site
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
                    Template::replace("{title}", self::$clanData['pageTitle']);
                    
                    echo Template::out();
                }
            }
            else
            {
                MySQL :: query("SELECT * FROM `inhalte` WHERE `clanid`='".self::$routerData['clanid']."' AND `template`='1' AND `templateType`='5'");
                
                if(MySQL::count() == 1)
                {
                    $row = MySQL::fetchArray();
                    Template::init(NULL, true, $row['inhalt']);
                    MySQL :: query("SELECT * FROM `inhalte` WHERE `template`='1' AND `templateType`='6'");
                    
                    if(MySQL::count())
                    {
                        Template::replace("</head>", "\n".Template::leerzeichen("<title>").'<link rel="stylesheet" type="text/css" href="http://myclankonto.net/'.self::$routerData['clanid'].'/stylecheet.css" />'."\n".Template::leerzeichen("<head>").'</head>');
                    }
                    
                    
                    Template::replaceContent("{seiteninhalt}", "pages/site/".self::$routerData['site'].".php");
                    Template::replace("{title}", self::$clanData['pageTitle']);
                    
                    echo Template::out();
                }
                else
                {
                    echo "Premium Standart";
                }
            }
        }
    }
?>