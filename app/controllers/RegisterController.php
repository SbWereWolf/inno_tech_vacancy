<?php

/**
 * SessionController
 *
 * Allows to register new users
 */
class RegisterController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    /**
     * Action to register a new user
     */
    public function indexAction()
    {
        $form = new RegisterForm;
        $this->view->form = $form;

        $name = '';
        $username = '';
        $email = '';
        $password = '';
        $repeatPassword = '';
        $isPost = $this->request->isPost();
        if ($isPost) {

            $name = $this->request->getPost('name', array('string', 'striptags'));
            $username = $this->request->getPost('username', 'alphanum');
            $email = $this->request->getPost('email', 'email');
            $password = $this->request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

        }

        $isPasswordFail = $password != $repeatPassword;
        $result = null;
        if ($isPasswordFail) {
            $this->flash->error('Passwords are different');
            $result = false;
        }

        $isRegistered = false;
        $tryRegister = false;
        if (!$isPasswordFail && $isPost) {

            $tryRegister = true;

            $account = new Account();

            $account->username = $username;
            $account->password = password_hash($password, PASSWORD_BCRYPT);
            $account->name = $name;
            $account->email = $email;
            $account->created_at = date('Y-m-d h:i:s');
            $account->active = 'Y';

            $isRegistered = $account->register();
        }

        if (!$isRegistered && $tryRegister) {
            $this->flash->error('Ошибка регистрации');
        }

        if ($isRegistered) {
            $this->tag->setDefault('email', '');
            $this->tag->setDefault('password', '');
            $this->flash->success('Thanks for sign-up, please log-in to view registered accounts');

            $result = $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action" => "index",
                ]
            );
        }

        return $result;

    }
}
