<?php
namespace PMVC\PlugIn\view;

use PHPUnit_Framework_TestCase;

class ViewEngineTest extends PHPUnit_Framework_TestCase
{
    function setup()
    {
        \PMVC\unplug('view');
        \PMVC\option('set',_VIEW_ENGINE,'fake');
    }

    function testStateShouldReffreence()
    {
        $view = \PMVC\plug('view_fake',array(
            _CLASS=>__NAMESPACE__.'\FakeTemplate'
        ));
        $viewState = $view->getRef();
        $viewState['foo'] = 'bar';
        $this->assertEquals('bar', $view->get('foo'));
    }
}
