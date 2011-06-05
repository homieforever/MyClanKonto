<?php
    abstract class Registry
    {
        private $values = array();
        
        public function __construct()
        {
             session_start();
             if(!isset($_SESSION['_registry']))
             {
                 $_SESSION['_registry'] = array();
             }
        }
        
        public function add($key, $value, $scope = false)
        {
            if($scope)
            {
                if(!isset($_SESSION['_registry'][$key]))
                {
                    $_SESSION['_registry'][$key] = $value;
                    return true;
                }    
            }
            else
            {
                if(!isset($this->values[$key]))
                {
                    $this->values[$key]= $value;
                    return true;
                }
            }
            return false;
        }
        
        public function get($key)
        {
            if(isset($_SESSION['_registry'][$key]))
            {
                 return $_SESSION['_registry'][$key];
            }
            elseif(isset($this->values[$key]))
            {
                return $this->values[$key];
            }
            return NULL;
        }
        
        public function unadd($key)
        {
            if(isset($_SESSION['_registry'][$key]))
            {
                unset($_SESSION['_registry'][$key]);
                return true;
            }
            elseif(isset($this->values[$key]))
            {
                unset($this->values[$key]);
                return true;
            }
            return false;    
        }
        
        public function reset()
        {
            $_SESSION['_registry'] = array();
            $this->values = array();
            return true;
        }
    }
?>