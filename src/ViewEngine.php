<?php
namespace PMVC\PlugIn\view;

use PMVC as p;

const themePath = 'themePath';

/**
 * Base view engine.
 *
 * @parameters string themeFolder
 * @parameters string themePath
 * @parameters string headers 
 */
abstract class ViewEngine extends p\PlugIn
{
    /**
     * @var object
     */
    private $_tpl;

    /**
     * view variable
     */
    private $_view=array();

    abstract public function process();

    public function &getInstance()
    {
    }

    public function __construct()
    {
        $this['headers'] = [];
    }

    /**
     * Set theme path
     * ViewEngine will use $this->get('themePath') for global variable and use to include file
     * Template variable will use different themePath from $this['themePath'].
     */
    public function setThemePath($val)
    {
        if (!isset($this[themePath])) {
            $this->set(themePath, $val);
        }
        $this[themePath] = $val;
    }

    /**
     * Set theme folder
     */
    public function setThemeFolder($val)
    {
        $this['themeFolder'] = \PMVC\realpath($val);
        if (!$this['themeFolder']) {
            return !trigger_error('Template folder was not found: ['.$val.']');
        }
    }

    /**
     * get veiw
     */
     public function &get($k=null)
     {
         return p\get($this->_view, $k);
     }

    /**
     * set veiw
     */
     public function set($k, $v=null)
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
     * get template object
     */
    public function getTpl()
    {
        return $this->_tpl;
    }

    /**
     * set template object
     */
    public function initTemplateHelper($tpl=null)
    {
        if (!$this->_tpl) {
            if (is_null($tpl)) {
                $tpl = new Template($this['themeFolder']);
            }
            $this->_tpl = $tpl;
            p\set($this,$tpl());
        }
        return $this->_tpl;
    }

    /**
     * get Tpl
     */
    public function getTplFile($path, $useDefault = true)
    {
        return $this->_tpl->getFile($path, $useDefault);
    }
} //end class
