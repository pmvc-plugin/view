<?php
namespace PMVC\PlugIn\view;

use PMVC as p;
use PMVC\HashMap;
use PMVC\PlugIn;
use DomainException;

const THEME_PATH = 'themePath';

/**
 * Base view engine.
 *
 * @parameters string themeFolder
 * @parameters string themePath
 * @parameters string headers
 */
abstract class ViewEngine extends PlugIn
{
    /**
     * @var object
     */
    private $_tpl;

    /**
     * view variable
     */
    private $_view;

    abstract public function process();

    /**
     * Purpose to use __invoke for get instance
     * if u use another template framework
     */

    public function __construct()
    {
        $this['headers'] = [];
        $this->_view = new HashMap();
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
        if ($val) {
            $this['themeFolder'] = p\realpath($val);
            if (!$this['themeFolder']) {
                throw new DomainException(
                    'Template folder was not found: [' . $val . ']'
                );
            }
            if (empty($this->_tpl)) {
                $this->_tpl = $this->initTemplateHelper();
            }
        }
    }

    /**
     * Append View
     */
    public function append(array $arr)
    {
        $this->_view[[]] = $arr;
    }

    /**
     * Prepend View
     */
    public function prepend(array $arr)
    {
        $_view = p\get($this->_view);
        $_view = array_merge_recursive($arr, $_view);
        $this->_view->offsetUnset($_view);
    }

    public function &getRef()
    {
        return $this->_view;
    }

    /**
     * get veiw
     */
    public function &get($k = null, $default = null)
    {
        return p\get($this->_view, $k, $default);
    }

    /**
     * get veiw
     */
    public function getOne($k = null, $default = null)
    {
        $one = p\get($this->_view, $k, $default);
        if (is_array($one)) {
            $one = reset($one);
        }
        return $one;
    }

    /**
     * set veiw
     */
    public function set($k, $v = null)
    {
        return p\set($this->_view, $k, $v);
    }

    /**
     * clean veiw
     */
    public function clean($k = null)
    {
        return p\clean($this->_view, $k);
    }

    /**
     * get template object
     */
    public function getTpl($tpl = null)
    {
        if (empty($this->_tpl)) {
            $this->_tpl = $this->initTemplateHelper($tpl);
        }
        return $this->_tpl;
    }

    /**
     * set template object
     */
    public function initTemplateHelper($tpl = null)
    {
        if (is_null($tpl)) {
            $tpl = new Template($this['themeFolder']);
        }
        $this[[]] = $tpl('backend');
        $this->append($tpl('view'));

        /**
         *   Copy tpl variables back to plugin config
         *   if there are custom variables from view_config_helper
         */
        $copykeys = ['assetsRoot', 'staticVersion'];
        foreach ($copykeys as $key) {
            $v = p\get($this->_view, $key);
            if (!is_null($v)) {
                $this[$key] = $v;
            }
        }
        return $tpl;
    }

    /**
     * Get Tpl
     */
    public function getTplFile($path, $useDefault = true, $tpl = null)
    {
        return $this->getTpl($tpl)->getFile($path, $useDefault);
    }

    public function flush()
    {
        if (isEnabled()) {
            ob_get_level() > 0 && ob_flush();
            flush();
        }
    }

    public function isEnabled()
    {
        /**
         * Meaning?
         * 1. not run yet.
         * 2. run not set to false.
         * 3. is ready to do parse
         */
        return !isset($this['run']);
    }

    public function enable()
    {
        unset($this['run']);
        unset($this['themePath']);
    }

    public function disable()
    {
        $this['run'] = false;
    }
} //end class
