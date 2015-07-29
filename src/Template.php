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
     * @var array $paths
     */
     public $paths;

    /**
     * default funciton
     */
    function __construct($name){
        $this->name = $name;
        $dir = p\lastSlash(p\realpath($this->name));
        $configFile = $dir.'config/config.php';
        if(p\realpath($configFile)){
            $r=p\l($configFile,_INIT_CONFIG);
            $view = p\plug('view');
            p\set($view, $r->var[_INIT_CONFIG]);
            $view['themeDir'] = $dir;
        }
        $pathFile = $dir.'config/path.php';
        if (p\realpath($pathFile)) {
            $r=p\l($pathFile,_INIT_CONFIG);
            $this->paths=$r->var[_INIT_CONFIG];
        } else {
            trigger_error('Can\'t find theme path config file  ('.$pathFile.')');
        }
    }

    /**
     * get configure
     */ 
    function get($k){
        return p\plug('view')[$k];
    }

    /**
    * get tpl files from path
    */
    function getFile($tpl_name){
        if(!empty($this->paths[$tpl_name])){
            return $this->paths[$tpl_name];
        }else{
            return $this->paths['index'];
        }
    }

    /**
     * @return themes folder
     */
    function getDir(){
        return $this->get('themeDir');
    }
} //end class Template


