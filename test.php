<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');
class ViewTest extends PHPUnit_Framework_TestCase
{
    function testView()
    {
        PMVC\InitPlugin(array(
            'view_fake'=>array(
                _CLASS=>'FakeTemplate'
            )
        ));
        PMVC\option('set',_VIEW_ENGINE,'fake');
        $this->assertContains('view_fake',var_export(PMVC\plug('view'),true));
    }
}

class FakeTemplate extends \PMVC\PlugIn\view\ViewEngine
{

}
