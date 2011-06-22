<?php
    abstract class template
    {
        private static $template;
        private static $templateZeilen;
        
        public static function init($fileName = NULL, $parseZeilen = true, $fileContent = NULL)
        {
            if($fileName != NULL)
            {
                self::$template = self::loadFile($fileName);
            }
            else
            {
                self::$template = $fileContent;
            }
            
            if($parseZeilen)
            {
                self::explodeTemplateZeilen();
            }
        }
        
        public static function loadFile($name)
        {
            if(file_exists(SYS_PATH . $name))
            {
                return file_get_contents(SYS_PATH . $name);
            }
            else
            {
                Log :: write("file", SYS_PATH . $name . " dosen't exists.");
            }
        }
        
        public static function set($data)
        {
            header($data);
        }
        
        public static function explodeTemplateZeilen()
        {
            self::$templateZeilen = str_replace(array("\r\n", "\r"), "\n", self::$template);
            self::$templateZeilen = explode("\n", self::$templateZeilen); 
        }
        
        public static function sucheInZeilen($name = NULL)
        {
            $i = 0;
            $found = false;
            
            foreach(self::$templateZeilen as $wert)
            {
                if(preg_match("/$name/Usi", $wert))
                {
                    $found = true;
                }
                
                if($found)
                {
                    break;
                }
                $i++;
            }
            
            if($found)
            {
                return self::$templateZeilen[$i];
            }
            else
            {
                return NULL;
            }
        }
        
        public static function leerzeichen($name)
        {
            $zeilenSuche = self::sucheInZeilen($name); 
            $anzahl = substr_count($zeilenSuche, ' ');
            $leerzeichen = "";
                    
            $i = 0;
            while($i<$anzahl)
            {
                $leerzeichen .= " ";
                $i++;
            }
            
            return $leerzeichen;
        }
        
        public static function replaceContent($name = NULL, $contentFile = NULL)
        {
            if($name != NULL && $contentFile != NULL)
            {
                if(preg_match("/$name/Usi", self::$template))
                {
                    ob_start();
                    if(file_exists(SYS_PATH . $contentFile))
                    {
                        require_once SYS_PATH . $contentFile;
                    }
                    else
                    {
                        require_once SYS_PATH . "templates/error404-sitenotfound.html";
                    }
                    $content = ob_get_contents();
	            ob_end_clean();
                    self::replace($name, $content);
                }
            }
        }
        
        public function pregreplace($name, $replacement = NULL)
        {
            if($name != NULL && $replacement != NULL)
            {
                self::$template = preg_replace($name, $replacement, self::$template);
                return true;
            }
            return false;
        }
        
        public static function replace($name = NULL, $replacement = NULL)
        {
            if($name != NULL && $replacement != NULL)
            {
                self::$template = str_replace($name, $replacement, self::$template);
                return true;
            }
            return false;
        }
        
        public static function out()
        {
            return self::$template;
        }
    }
?>