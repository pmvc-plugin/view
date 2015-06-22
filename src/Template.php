<?php
namespace PMVC\PlugIn\view;
use PMVC as p;
/**
 * base View Template
 */
class Template {

    /**
     * @var string
     */
     public $name;

    /**
     * @var string $path
     */
     public $path;

    /**
     * default funciton
     */
    function __construct($name){
        $this->name = $name;
        $dir = p\lastSlash($this->name);
        $configFile = $dir.'config/config.php';
        if(p\realpath($configFile)){
            $r=p\l($configFile,_INIT_CONFIG);
            $r->var[_INIT_CONFIG]['themeDir'] = $dir;
            $view = p\plug('view');
            foreach($r[1][_INIT_CONFIG] as $k=>$v){
                $view->set($k,$v);   
            }
        }
        $pathFile = $dir.'config/path.php';
        if (p\realpath($pathFile)) {
            $r=p\l($pathFile,_INIT_CONFIG);
            $this->path=$r->var[_INIT_CONFIG];
        } else {
            trigger_error('Can\'t find theme path config file  ('.$pathFile.')');
        }
        if(function_exists('PMVC\transparent')){
            $defaultPathFile = p\transparent('themes/').'/config/path.php';
            if(p\realpath($defaultPathFile)){
                $r=p\l($defaultPathFile,_INIT_CONFIG);
                $this->path = p\mergeDefault($r->var[_INIT_CONFIG],$this->path);
            }
        }
    }

    /**
     * get configure
     */ 
    function get($k){
        return p\plug('view')->get($k);
    }

    /**
    * get tpl files from path
    */
    function getFile($tpl_name){
        if(!empty($this->path[$tpl_name])){
            return $this->path[$tpl_name];
        }else{
            return $this->path['index'];
        }
    }

    /**
     * @return themes folder
     */
    function getDir(){
        return $this->get('themeDir');
    }
} //end class _PMVC_BASE_VIEW_TEMPLATE


