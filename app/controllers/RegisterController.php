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

        $name='';
        $username='';
        $email='';
        $password='';
        $repeatPassword='';
        $isPost= $this->request->isPost();
        if ($isPost) {

            $name = $this->request->getPost('name', array('string', 'striptags'));
            $username = $this->request->getPost('username', 'alphanum');
            $email = $this->request->getPost('email', 'email');
            $password = $this->request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

        }

        $isPasswordFail = $password != $repeatPassword;
        $result = null;
        if ( $isPasswordFail) {
            $this->flash->error('Passwords are different');
            $result = false;
        }

        $isRegistered = false;
        $tryRegister = false;
        $user = new Users();
        if(!$isPasswordFail && $isPost){

            $tryRegister = true;

            $user->username = $username;
            $user->password = sha1($password);
            $user->name = $name;
            $user->email = $email;
            $user->created_at = new Phalcon\Db\RawValue('now()');
            $user->active = 'Y';

            $isRegistered = $user->save();
            $isMongoRegisterd = $user->register();
        }

        if (!$isRegistered && $tryRegister) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        }

        if($isRegistered){
            $this->tag->setDefault('email', '');
            $this->tag->setDefault('password', '');
            $this->flash->success('Thanks for sign-up, please log-in to start generating invoices');

            $result = $this->dispatcher->forward(
                [
                    "controller" => "session",
                    "action"     => "index",
                ]
            );
        }

        return $result;

    }
}
