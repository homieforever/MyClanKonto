<?php
    abstract class SiteData
    {
        public function __construct() {  }
        
        /*
         * siteExists test is Exists the Page with the numeric $siteId
         * numeric $siteId
         */
        
        public static function siteExists($siteId = NULL)
        {
            if($siteId == NULL)
            {
                throw new Exeption("siteData::siteExists() haven't become an Siteid.");
            }
            else
            {
                MySQL :: query("SELECT `clanid` FROM `webseiten` WHERE `clanid`='".$siteId."'");
                
                if(MySQL :: count() != 1)
                {
                    return array("success" => false, "error" => "Die Webseite mit der ID ".$siteId." existiert nicht.");
                }
                else
                {
                    return array("success" => true);
                }
            }
        }
        
        /*
         * getSiteData select the Site Data with the numeric $siteId
         * numeric $siteId
         */
        
        public static function getSiteData($siteId = NULL)
        {
            if($siteId == NULL)
            {
                throw new Exeption("siteData::getSiteData() haven't become an Siteid.");
            }
            else
            {
                MySQL :: query("SELECT * FROM `webseiten` WHERE `clanid`='".$siteId."'");
                
                if(MySQL :: count() != 1)
                {
                    return array("success" => false, "error" => "Die Webseite mit der ID ".$siteId." existiert nicht.");
                }
                else
                {
                    return array("success" => true, "data" => MySQL::fetchArray());
                }
            }
        }
    }
?>