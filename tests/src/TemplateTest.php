<?php
namespace PMVC\PlugIn\view;

use PMVC\TestCase;

class TemplateTest extends TestCase
{
    public function pmvc_setup()
    {
        \PMVC\unplug('view_fake');
    }

    public function testGetGetThemeDir()
    {
        $view = \PMVC\plug('view_fake', [
            _CLASS => __NAMESPACE__ . '\FakeTemplate',
        ]);
        $path = __DIR__ . '/../resources/fakeTpl';
        $view->setThemeFolder($path);
        $view->initTemplateHelper();
        $tpl = $view->getTpl();
        $this->haveString(
            'resources/fakeTpl/index.html',
            $tpl->getFile('index')
        );
    }
}
