<?php

namespace Component\Controller;

class BaseController
{
    public function render($template)
    {
        //die(var_dump( __DIR__.'/../../Recources/'.$template));

        ob_start();
        include __DIR__.'/../../Recources/'.$template;

        return ob_get_clean();
    }
}
