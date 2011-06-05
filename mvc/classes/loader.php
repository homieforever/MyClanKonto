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
                throw new Exception('loader->addAutoLoad(): Es wurde ein nicht gültiger Callback angegeben.');
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
    }
?>