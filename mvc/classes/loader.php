<?php
    abstract class loader
    {
        public static $maps = array(); 
        
        public function addAutoLoad($function = NULL)
        {
            if($function != NULL && is_callable($function))
            {
                return spl_autoload_register($function);
            }
            else
            {
                if($function == NULL)
                {
                    return spl_autoload_register("self::dafaultLoad");
                }
                else
                {
                    throw new Exception('loader->addAutoLoad(): Es wurde ein nicht gültiger Callback angegeben.');
                }
            }
        }
        
        public function load($name)
        {
            if(isset(self::$maps[$name]))
            {
                $file = self::$maps[$name];
                
                if(file_exists(SYS_PATH . $file))
                {
                    if(file_exists(SYS_PATH . "configs/".$name.".php"))
                    {
                        require_once SYS_PATH . "configs/".$name.".php";
                    }
                    require_once SYS_PATH . $file;
                }
            }
        }
        
        public function addMap($map = null)
        {
            if($map != NULL)
            {
                 require_once SYS_PATH . "maps/".$map;
                 self::$maps = $values;
            }
            else
            {
                require_once SYS_PATH . "maps/classMap.php";
                self::$maps = $values;
            }
        }
        
        public function unsetAutoLoad($function = NULL)
        {
            if($function != NULL)
            {
                return spl_autoload_unregister($function);
            }
            return false;
        }
        
        static public function dafaultLoad($classname = NULL)
        {
            if(file_exists(SYS_PATH . "classes/".strtolower($classname).".php") & $classname != NULL)
            {
                if(file_exists(SYS_PATH . "configs/".strtolower($classname).".php"))
                {
                    require_once SYS_PATH . "configs/".strtolower($classname).".php";
                }
                require_once SYS_PATH . "classes/".strtolower($classname).".php";
            }
        }
    }
?>