<?php
PMVC\Load::plug();
PMVC\setPlugInFolders(['../']);
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
        $this->assertTrue(!empty($tpl));
        $this->assertEquals(\PMVC\realpath($path),$view['themeFolder']);
    }
}

class FakeTemplate extends \PMVC\PlugIn\view\ViewEngine
{
    public function process() {

    }
}
