<?php
abstract class Router
{
    static protected $controller;
    static protected $action;
    static protected $params;
    static protected $rules;

    private static function arrayClean($array)
    {
        foreach($array as $key => $value)
        {
            if(strlen($value) == 0)
            {
                unset($array[$key]);
            }
        }
    }

    private static function ruleMatch($rule, $data)
    {
        $ruleItems = explode('/',$rule); self::arrayClean($ruleItems);
        $dataItems = explode('/',$data); self::arrayClean($dataItems);

        if(count($ruleItems) == count($dataItems))
        {
            $result = array();

            foreach($ruleItems as $ruleKey => $ruleValue)
            {
                if(preg_match('/^:[\w]{1,}$/',$ruleValue))
                {
                    $ruleValue = substr($ruleValue,1);
                    $result[$ruleValue] = $dataItems[$ruleKey];
                }
                else
                {
                    if(strcmp($ruleValue,$dataItems[$ruleKey]) != 0)
                    {
                        return false;
                    }
                }
            }

            if(count($result) > 0)
            {
                return $result;
            }

            unset($result);
        }
        return false;
    }

    private static function defaultRoutes($url)
    {
        //// process default routes
        $items = explode('/',$url);

        // remove empty blocks
        foreach($items as $key => $value)
        {
            if(strlen($value) == 0)
            {
                unset($items[$key]);
            }
        }

         // extract data
         if(count($items))
         {
             self::$controller = array_shift($items);
             self::$action = array_shift($items);
             self::$params = $items;
         }
     }

     protected function __construct()
     {
         self::$rules = array();
     }

     public static function init()
     {   
         $url = $_SERVER['REQUEST_URI'];
         $isCustom = false;

         if(count(self::$rules))
         {
             foreach(self::$rules as $ruleKey => $ruleData)
             {
                 $params = self::ruleMatch($ruleKey,$url);
                 if($params)
                 {
                     self::$controller = $ruleData['controller'];
                     self::$action = $ruleData['action'];
                     self::$params = $params;
                     $isCustom = true;
                     break;
                 }
             }
         }

         if(!$isCustom)
         {
             self::defaultRoutes($url);
         }

         if(!strlen(self::$controller))
         {
             self::$controller = 'site';
         }

         if(!strlen(self::$action))
         {
             self::$action = '';
         }
     }
     
     public static function addMap($file = "maps/routerMap.php")
     {
         require_once SYS_PATH . $file;
         foreach($values as $data)
         {
             self::addRule($data[0], $data[1]);
         }
     }
     
     public static function addRule($rule, $target)
     {
         self::$rules[$rule] = $target;
     }

     public static function getController()
     {
         return self::$controller;
     }
     
     public static function getAction()
     {
         return self::$action;
     }
     
     public static function getParams()
     {
         return self::$params;
     }
     public static function getParam($id)
     {
         return self::$params[$id];
     }
}
?>