<?php

use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

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

        $collectionCursor = Account::findAll();

        $accounts = array();
        foreach ($collectionCursor as $rowNumber => $record) {
            $account = Account::RecordToArray($record);
            $accounts[] = $account;
        }

        foreach ($accounts as $key => $account) {
            $this->setIfNotExists($account, Account::USERNAME, $accounts, $key);
            $this->setIfNotExists($account, Account::NAME, $accounts, $key);
            $this->setIfNotExists($account, Account::EMAIL, $accounts, $key);
            $this->setIfNotExists($account, Account::CREATED_AT, $accounts, $key);
        }

        $paginator = new PaginatorArray(array(
            "data" => $accounts,
            "limit" => 2,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->accounts = $accounts;
    }

    /**
     * @param $account
     * @param $index
     * @param $accounts
     * @param $key
     * @return array
     */
    private function setIfNotExists(&$account, $index, &$accounts, $key)
    {
        $isArray = is_array($account);
        $isExists = array_key_exists($index, $account);
        if (!$isExists && $isArray) {
            $accounts[$key][$index] = '';
            return array($isExists, $accounts);
        }
    }

}
