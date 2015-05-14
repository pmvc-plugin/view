<?php
namespace PMVC\PlugIn\View;
use PMVC as p;

${_INIT_CONFIG}[_CLASS] = 'PMVC\PlugIn\View\_PMVC_VIEWENGINE';

class _PMVC_VIEWENGINE extends p\PLUGIN{
    function update($observer=null,$state=null){
        return p\plug('view-'.p\getOption(_VIEW_ENGINE));
    } 
}


/**
 * base view engine
 */
class VIEW extends p\PLUGIN
{
    /**
     * @var object
     */
    private $_tpl;

    /**
     * @var object
     */
    public $path;

    /**
     * @var object
     */
    public $folder;

    function process(){}
    function &getInstance(){}

    /**
     * for view componet
     */
    function component($name,$config){
        $name = 'component_'.$name;
        if(p\exists('cache','plugIn')){
            $oCache = p\plug('cache');
            if( $oCache->isCouldCache()
               && ('auto'==$config['type'] || 'cache'==$config['type'])
            ){
                $oCache->regNoCache($name,$config);
                $this->set($name,'<!--no-cache-'.$name.'-->');
                return;
            }
        }
        $obj= p\plug($name,$config);
        $obj->view();
        return $obj;
    }

    /**
     * get template object
     */
    function getTplInstance(){
        return $this->_tpl;
    }

    /**
     * set template object
     */
    function initTemplateHelper($tplFolder,$tpl=null){
        if(!$this->_tpl){
            if(is_null($tpl)){
               $tpl = new TEMPLATE($tplFolder);
            }
            $this->_tpl=$tpl;
        }
        return $this->_tpl;
    }

    /**
     * get Tpl
     */
    function getTplFile($path){
        return $this->_tpl->getFile($path);
    }


} //end class

/**
 * base View Template
 */
class TEMPLATE {

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
        if(p\realpath($pathFile)){
            $r=p\l($pathFile,_INIT_CONFIG);
            $this->path=$r->var[_INIT_CONFIG];
        }
        $defaultPathFile = p\transparent('themes/').'/config/path.php';
        if(p\realpath($defaultPathFile)){
            $r=p\l($defaultPathFile,_INIT_CONFIG);
            $this->path = p\mergeDefault($r->var[_INIT_CONFIG],$this->path);
        }
    }

    /**
     * get cinfigure
     */ 
    function get($k){
        return p\plug('view')->get($k);
    }

    /**
    * get tpl files from path
    */
    function getFile($tpl_name){
        return $this->path[$tpl_name];
    }

    /**
     * @return themes folder
     */
    function getDir(){
        return $this->get('themeDir');
    }
} //end class _PMVC_BASE_VIEW_TEMPLATE



/**
 * the base componet
 */
class COMPONENT extends p\PLUGIN {

    /**
     * direct echo it
     */
    function output(){
        echo $this->getHtml();
    }

    /**
     * use in view
     */
    function view(){
        p\plug('view')->set($this->name,$this->getHtml());
    }

    /**
     * @return componet html
     */
    function getHtml(){}
    
}
?>
