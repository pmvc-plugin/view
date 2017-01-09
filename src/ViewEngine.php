<?php
namespace PMVC\PlugIn\view;

use PMVC as p;
use DomainException;

const THEME_PATH = 'themePath';

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
    
    /**
     * Purpose to use __invoke for get instance
     * if u use another template framework
     */

    public function __construct()
    {
        $this['headers'] = [];
    }

    /**
     * Set theme path
     * $this['themePaht'] : plugin config
     * $this->get('themePath') : template varible 
     * Template variable will only set once, and will pass to client.
     * Plugin config could set multi times, and will not pass to client.
     */
    public function setThemePath($val)
    {
        if (!isset($this[THEME_PATH])) {
            $this->set(THEME_PATH, $val);
        }
        $this[THEME_PATH] = $val;
    }

    /**
     * Set theme folder
     */
    public function setThemeFolder($val)
    {
        $this['themeFolder'] = \PMVC\realpath($val);
        if (!$this['themeFolder']) {
            throw new DomainException('Template folder was not found: ['.$val.']');
        }
    }

    /**
     * Append View
     */
    public function append(array $arr)
    {
        $this->_view = array_merge_recursive(
            $this->_view,
            $arr
        );
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
            p\set($this, $tpl());
        }

        /**
         *   Copy tpl variables back to plugin config
         *   if there are custom variables from view_config_helper  
         */
        $copykeys = ['assetsRoot', 'staticVersion'];
        foreach ($copykeys as $key) {
            $v = p\value($this->_view,[$key]); 
            if (!is_null($v)) {
                $this[$key] = $v;
            } 
        }
        return $this->_tpl;
    }

    /**
     * Get Tpl
     */
    public function getTplFile($path, $useDefault = true)
    {
        return $this->_tpl->getFile($path, $useDefault);
    }

    public function flush()
    {
        flush();
    }

    public function disable()
    {
       $this['run']=false;
    }

    public function enable()
    {
       unset($this['run']);
       unset($this['themePath']);
    }
} //end class
