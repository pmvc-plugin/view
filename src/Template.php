<?php
namespace PMVC\PlugIn\view;
use PMVC as p;
/**
 * base View Template
 */
class Template
{
    /**
     * default funciton
     */
    function __construct(){
        $dir = $this->getDir();
        $configFile = $dir.'config/config.php';
        $view = p\plug('view');
        if(p\realpath($configFile)){
            $r=p\l($configFile,_INIT_CONFIG);
            p\set($view, $r->var[_INIT_CONFIG]);
        }
        $pathFile = $dir.'config/path.php';
        if (p\realpath($pathFile)) {
            $r=p\l($pathFile,_INIT_CONFIG);
            $view['paths']=$r->var[_INIT_CONFIG];
        } else {
            return !trigger_error('Can\'t find theme path config file  ('.$pathFile.')');
        }
    }

    /**
    * get tpl files from path
    */
    function getFile($tpl_name, $useDefault = true){
        $view = p\plug('view');
        if(!empty($view['paths'][$tpl_name])){
            return $view['paths'][$tpl_name];
        }else{
            if ($useDefault) {
                return $view['paths']['index'];
            } else {
                return null;
            }
        }
    }

    /**
     * @return themes folder
     */
    function getDir(){
        return p\plug('view')['themeDir'];
    }
} //end class Template


