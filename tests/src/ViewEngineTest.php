<?php
namespace PMVC\PlugIn\view;

use PMVC\TestCase;

class ViewEngineTest extends TestCase
{
    function pmvc_setup()
    {
        \PMVC\unplug('view');
        \PMVC\option('set', _VIEW_ENGINE, 'fake');
    }

    function testStateShouldReffreence()
    {
        $view = \PMVC\plug('view_fake', [
            _CLASS => __NAMESPACE__ . '\FakeTemplate',
        ]);
        $viewState = $view->getRef();
        $viewState['foo'] = 'bar';
        $this->assertEquals('bar', $view->get('foo'));
    }
}
