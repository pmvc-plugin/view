<?php
namespace PMVC\PlugIn\view;

use PMVC as p;
use SplSubject;
use DomainException;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\view';

class view extends p\PlugIn
{

    private $_view;

    public function init()
    {
        $this->_change(p\getOption(_VIEW_ENGINE));
        p\callPlugin(
            'dispatcher',
            'attach',
            [ 
                $this,
                'SetConfig__view_engine_',
            ]
        );
    }

    public function onSetConfig__view_engine_($subject)
    {
        $this->_change(p\getOption(_VIEW_ENGINE));
    }

    private function _change($viewEngine)
    {
        $this->_view = 'view_'.$viewEngine;
        if (!p\plug($this->_view, [\PMVC\PAUSE=>true])) {
           throw new DomainException('View engine not eixis.['.$this->_view.']'); 
        }
    }

    public function update(SplSubject $SplSubject=null)
    {
        parent::update($SplSubject);
        return p\plug($this->_view);
    }
}
