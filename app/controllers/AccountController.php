<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class AccountController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle(' Account list');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $numberPage = $this->request->getQuery("page", "int");

        $accountCollection = Users::find();

        $paginator = new Paginator(array(
            "data" => $accountCollection,
            "limit" => 2,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->accounts = $accountCollection;
    }

}
