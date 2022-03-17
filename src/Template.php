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
    private $_configs = [];

    /**
     * Default funciton
     */
    function __construct($folder)
    {
        $configFile = $folder.'/config/config.php';
        if(p\realpath($configFile)) {
            $r=p\l(
                $configFile,
                _INIT_CONFIG
            );
            $this->_configs =& $r->var[_INIT_CONFIG]; 
        } else {
            return !trigger_error('Can\'t find theme config file  ('.$configFile.')');
        }
    }

    /**
     * Get configs
     */ 
    function __invoke()
    {
        return $this->_configs;
    }

    /**
     * Get tpl files from path
     */
    function getFile($tpl_name, $useDefault = true)
    {
        $backendConfig = p\get($this->_configs, 'backend');
        $paths = p\get($backendConfig, 'paths');
        if (is_null($tpl_name)) {
            $tpl_name = '';
        }
        $file = p\get($paths, $tpl_name); 
        if (empty($file) && $useDefault) {
            $file = p\get($paths, 'index'); 
        }
        if (!empty($file)) {
            return p\realpath($file);
        } else {
            return null;
        }
    }

} //end class Template
