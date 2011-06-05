<?php
    abstract class Registry
    {
        private static $values = array();
        
        public function init()
        {
            if(!isset($_SESSION['_registry']))
            {
                $_SESSION['_registry'] = array();
            }
            session_start("test");
        }
        
        public static function add($key, $value, $persist = false)
        {
            if($persist)
            {
                if(!isset($_SESSION['_registry'][$key]))
                {
                    $_SESSION['_registry'][$key] = $value;
                    return true;
                }    
            }
            else
            {
                if(!isset(self::$values[$key]))
                {
                    self::$values[$key]= $value;
                    return true;
                }
            }
            return false;
        }
        
        public static function get($key)
        {
            var_dump($_SESSION);
            if(isset($_SESSION['_registry'][$key]))
            {
                 return $_SESSION['_registry'][$key];
            }
            else if(isset(self::$values[$key]))
            {
                return self::$values[$key];
            }
            return NULL;
        }
        
        public static function unadd($key)
        {
            if(isset($_SESSION['_registry'][$key]))
            {
                unset($_SESSION['_registry'][$key]);
                return true;
            }
            else if(isset(self::$values[$key]))
            {
                unset(self::$values[$key]);
                return true;
            }
            return false;    
        }
        
        public static function reset()
        {
            $_SESSION['_registry'] = array();
            self::$values = array();
            return true;
        }
    }
?>