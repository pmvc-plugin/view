<?php
namespace PMVC\PlugIn\view;

use PMVC\TestCase;

class ViewTest extends TestCase
{
    function pmvc_setup()
    {
        \PMVC\unplug('view_fake');
    }

    function testView()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>__NAMESPACE__.'\FakeTemplate'
        ));
        \PMVC\option('set',_VIEW_ENGINE,'fake');
        $this->haveString('view_fake',var_export(\PMVC\plug('view'),true));
    }

    function testGetGetThemeDir()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>__NAMESPACE__.'\FakeTemplate'
        ));
        $path = __DIR__.'/resources/fakeTpl';
        $view->setThemeFolder($path); 
        $view->initTemplateHelper();
        $tpl = $view->getTpl();
        $this->assertTrue(!empty($tpl));
        $this->assertEquals(\PMVC\realpath($path),$view['themeFolder']);
    }

    function testAppendView()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>__NAMESPACE__.'\FakeTemplate'
        ));
        $arr = [
            'foo'=>111,
            'bar'=>222
        ];
        $view->set('data',[
            'foo'=>111,
            'bar'=>222
        ]);        
        $this->assertEquals($arr, $view->get('data'));
        $view->append([
            'data'=>[
                'ccc'=>333
            ]
        ]);
        $this->assertEquals(array_merge($arr,['ccc'=>333]), $view->get('data'));
    }
}

