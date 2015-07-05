<?php
namespace PMVC\PlugIn\view;
use PMVC as p;
/**
 * base view engine
 */
class ViewEngine extends p\PlugIn
{
    /**
     * @var object
     */
    private $_tpl;

    /**
     * @var object
     */
    public $forward;

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
                $this[$name] = '<!--no-cache-'.$name.'-->';
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
               $tpl = new Template($tplFolder);
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
