<?php
namespace PMVC\PlugIn\view;
use PMVC as p;
/**
 * Base View Template
 * This class should be isolated.
 * Not contain any plugin so it could use multi templates at same process
 */
class Template
{
    /**
     * @var array
     */
     public $configs = array();

    /**
     * @var array
     */
     public $paths;

    /**
     * Default funciton
     */
    function __construct($folder){
        $configFile = $folder.'/config/config.php';
        if(p\realpath($configFile)){
            $r=p\l($configFile,_INIT_CONFIG);
            $this->configs =& $r->var[_INIT_CONFIG]; 
        }
        $pathFile = $folder.'/config/path.php';
        if (p\realpath($pathFile)) {
            $r=p\l($pathFile,_INIT_CONFIG);
            $this->paths =& $r->var[_INIT_CONFIG];
        } else {
            return !trigger_error('Can\'t find theme path config file  ('.$pathFile.')');
        }
    }

    /**
     * Get configs
     */ 
     function &__invoke()
     {
        $arr =  array_merge(
            $this->configs,
            array('paths'=>$this->paths)
        );
        return $arr;
     }

    /**
    * Get tpl files from path
    */
    function getFile($tpl_name, $useDefault = true){
        if(!empty($this->paths[$tpl_name])){
            return $this->paths[$tpl_name];
        }else{
            if ($useDefault) {
                return $this->paths['index'];
            } else {
                return null;
            }
        }
    }

} //end class Template


