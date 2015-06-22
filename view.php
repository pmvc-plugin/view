<?php
namespace PMVC\PlugIn\view;

use PMVC as p;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\view';

class view extends p\PlugIn
{
    public function update(\SplSubject $SplSubject=null)
    {
        return p\plug('view_'.p\getOption(_VIEW_ENGINE));
    }
}
