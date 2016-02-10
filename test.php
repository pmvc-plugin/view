<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');
class ViewTest extends PHPUnit_Framework_TestCase
{
    function testView()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>'FakeTemplate'
        ));
        PMVC\option('set',_VIEW_ENGINE,'fake');
        $this->assertContains('view_fake',var_export(PMVC\plug('view'),true));
    }

    function testGetGetThemeDir()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>'FakeTemplate'
        ));
        $path = './test/fakeTpl';
        $view->setThemeFolder($path);
        $view->initTemplateHelper(); 
        $tpl = $view->getTpl();
        $this->assertEquals(\PMVC\lastSlash(\PMVC\realpath($path)),$tpl->getDir());
    }
}

class FakeTemplate extends \PMVC\PlugIn\view\ViewEngine
{

}
