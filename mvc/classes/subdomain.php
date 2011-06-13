<?php
    abstract class subdomain
    {
	public function __construct() { }
	
	public static function init()
	{
            MySQL :: query("SELECT * FROM `domains` WHERE `status`='1'");

            while($row = MySQL :: fetchArray())
            {
                self::initCheck($row['domain'], $row['id']);
            }
	}
	
	public static function initCheck($domain = "myclankonto.net", $did = 1)
	{
	    $subdomain = $_SERVER['HTTP_HOST'];
	    $subdomain = preg_replace("/\.".$domain."/Usi", "", $subdomain);
	    $subdomain = preg_replace("/www\./Usi", "", $subdomain);
            $subdomain = strtolower($subdomain);

	    if($subdomain != $domain)
	    {
	        MySQL :: query("SELECT * FROM `subdomains` WHERE `domainID`='".$did."' AND `host`='".$subdomain."'");

                if(MySQL::count() == 0)
                {
                    echo "null mysql";
                    die();
                }
                else
                {
                    $row = MySQL::fetchArray();

                    if($row['status'])
                    {
                        header("Location: http://myclankonto.net/".$row['clanid']."/site/intro/");
                        die();
                    }
                    else
                    {
                        echo "pff";
                        die();
                    }
                }
	    }
	}
    }
?>