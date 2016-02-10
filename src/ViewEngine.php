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
     * view variable
     */
     private $_view=array();

    function process(){}
    function &getInstance(){}

    /**
     * Set theme path
     * Client site will use $this->get('themePath') for global variable
     * Lazy load and First load will use different themePath from $this['themePath']
     */
    function setThemePath($val)
    {
        if (!isset($this['themePath'])) {
            $this->set('themePath',$val);
        }
        $this['themePath'] = $val;
    }

    /**
     * Set theme folder
     */
    function setThemeFolder($val)
    {
        $val = p\realpath($val);
        if (!$val) {
            return !trigger_error('Can\'t find theme path  ('.$val.')');
        }
        $this['themeDir'] = p\lastSlash($val);
    }

    /**
     * get veiw
     */
     function &get ($k=null)
     {
        return p\get($this->_view, $k);
     }

    /**
     * set veiw
     */
     function set ($k, $v=null)
     {
        return p\set($this->_view, $k, $v);
     }

    /**
     * clean veiw
     */
    public function clean($k=null)
    {
        return p\clean($this->_view, $k);
    }

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
    function getTpl(){
        return $this->_tpl;
    }

    /**
     * set template object
     */
    function initTemplateHelper($tpl=null){
        if(!$this->_tpl){
            if(is_null($tpl)){
               $tpl = new Template();
            }
            $this->_tpl=$tpl;
        }
        return $this->_tpl;
    }

    /**
     * get Tpl
     */
    function getTplFile($path, $useDefault = true){
        return $this->_tpl->getFile($path, $useDefault);
    }


} //end class
