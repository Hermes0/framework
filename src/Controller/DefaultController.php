<?php

namespace Controller;

use Component\Http\Response;
use Component\Controller\BaseController;

class DefaultController extends BaseController
{
    public function __construct()
    {
    }

    public function indexAction()
    {
        return new Response($this->render('index.html'));
    }
}
