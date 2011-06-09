<?php
    abstract class MySQL
    {
        private static $connection;
	private static $connected = false;
        private static $result;
	
	public function __construct() { }
 	
	public function __destuct()
	{
            if($this->connected == true)
            {
                @mysql_close($this->connection);
            }
	}
        
	private function connect()
	{
            if($this->connected == false)
	    {
                $this->connection = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
		mysql_select_db(MYSQL_DATABASE, $this->connection);
		mysql_set_charset(MYSQL_CHARSET, $this->connection);
		$this->connected = true;
            }
	}
			
	public function insert_ID()
	{
            return mysql_insert_id($this->connection);
	}
	
	public function query($query)
	{
            if(!empty($query) && trim($query) != "")
            {
                $this->connect();
		$this->result = mysql_query($query, $this->connection);
	    }
        }
	
        public function fetchArray()
	{
            return mysql_fetch_array($this->result);
	}
	
	public function fetchAssoc()
	{
            return mysql_fetch_assoc($this->result);
	}
	
        public function count()
	{
            return mysql_num_rows($this->result);
        }
    }
?>