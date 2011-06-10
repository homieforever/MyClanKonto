<?php
    abstract class log 
    {
        private static $handle;
	private static $opend;
        
	
	public function __construct() { self::$opend = NULL; }
	
        public static function open($type)
        {
            if(self::$opend != true)
	    {
                self::$handle = fopen(SYS_PATH . "logs/" . $type . ".log.txt" , "a+");
	        self::$opend = true;
	    }
        }

	public static function write($type, $text)
	{
            self::open($type);

            $timestamp = date('d.m. H:i:s');
            $text = str_replace("\n", ' ', $text);
            $text = str_replace("\r", ' ', $text);

            fwrite(self::$handle , "[$timestamp][$type] ".utf8_decode($text)."\n");
        }
    }
?>