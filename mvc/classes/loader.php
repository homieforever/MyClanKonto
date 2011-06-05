<?php
    abstract class loader
    {
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
                require_once SYS_PATH . "classes/".strtolower($classname).".php";
            }
        }
    }
?>