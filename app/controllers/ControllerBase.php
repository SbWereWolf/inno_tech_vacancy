<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->tag->prependTitle(' Volkhin Nikolay | ');
        $this->view->setTemplateAfter('main');
    }
}
