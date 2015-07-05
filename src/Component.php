<?php
namespace PMVC\PlugIn\view;
use PMVC as p;

/**
 * the base componet
 */
class Component extends p\PLUGIN {

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
        p\plug('view')[$this->name]=$this->getHtml();
    }

    /**
     * @return componet html
     */
    function getHtml(){}
    
}
