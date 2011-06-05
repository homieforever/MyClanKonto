<?php
    function _classLoad($classname)
    {
        if(file_exists(SYS_PATH . "classes/".$classname.".php"))
        {
            require_once SYS_PATH . "classes/".$classname.".php";
        }
    }
?>