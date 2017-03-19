<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'demo@phalconphp.com');
            $this->tag->setDefault('password', 'phalcon');
        }
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $account
     */
    private function _registerSession(Account $account)
    {
        $this->session->destroy(true);

        $this->session->start();

        $this->session->set('auth', array(
            'id' => $account->id,
            'name' => $account->name
        ));
    }

    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {

        $isPost = $this->request->isPost();
        $email = '';
        $password = '';
        if ($isPost) {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
        }

        $result = null;
        $account = Account::authenticate($email, $password);
        $isSuccess = !empty($account->id);
        if ($isSuccess) {
            $this->_registerSession($account);
            $this->flash->success('Welcome ' . $account->name);

            $result = $this->dispatcher->forward(
                [
                    "controller" => "account",
                    "action" => "index",
                ]
            );
        }

        if (!$isSuccess) {
            $this->flash->error('Wrong email/password');
            $result = $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action" => "index",
                ]
            );
        }

        return $result;
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->destroy(true);

        $this->session->remove('auth');
        $this->flash->success('Goodbye!');

        $this->session->start();

        return $this->dispatcher->forward(
            [
                "controller" => "session",
                "action" => "index",
            ]
        );
    }
}
