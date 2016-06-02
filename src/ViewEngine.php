<?php
namespace PMVC\PlugIn\view;

use PMVC as p;

/**
 * base view engine
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

    /**
     * Set theme path
     * Client site will use $this->get('themePath') for global variable
     * Lazy load and First load will use different themePath from $this['themePath']
     */
    public function setThemePath($val)
    {
        if (!isset($this['themePath'])) {
            $this->set('themePath', $val);
        }
        $this['themePath'] = $val;
    }

    /**
     * Set theme folder
     */
    public function setThemeFolder($val)
    {
        $this['themeDir'] = \PMVC\realpath($val);
        if (!$this['themeDir']) {
            return !trigger_error('Template folder was not found: ['.$this['themeDir'].']');
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
      * Append. 
      */
     public function append($k, $v=null)
     {
        if (is_null($v)) {
            return;
        }
        $this->_view[$k] = array_merge(
            \PMVC\value($this->_view,[$k],[]),
            \PMVC\toArray($v)
        );
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
    public function initTemplateHelper($folder, $tpl=null)
    {
        if (!$this->_tpl) {
            if (is_null($tpl)) {
                $tpl = new Template($folder);
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
