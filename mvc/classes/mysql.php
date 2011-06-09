<?php
    abstract class MySQL
    {
        private static $connection;
	private static $connected = false;
        private static $result;
	
	public function __construct() { }
 	
	public function __destuct()
	{
            if(self::$connected == true)
            {
                mysql_close(self::$connection);
            }
	}
        
	private function connect()
	{
            if(self::$connected == false)
	    {
                self::$connection = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
		mysql_select_db(MYSQL_DATABASE, self::$connection);
		mysql_set_charset(MYSQL_CHARSET, self::$connection);
		self::$connected = true;
            }
	}
			
	public function insert_ID()
	{
            return mysql_insert_id(self::$connection);
	}
	
	public function query($query)
	{
            if(!empty($query) && trim($query) != "")
            {
                self::$connect();
		self::$result = mysql_query($query, self::$connection);
	    }
        }
	
        public function fetchArray()
	{
            return mysql_fetch_array(self::$result);
	}
	
	public function fetchAssoc()
	{
            return mysql_fetch_assoc(self::$result);
	}
	
        public function count()
	{
            return mysql_num_rows(self::$result);
        }
    }
?>