<?php

namespace App\Controllers;

class UserController extends ControllerBase {

    public function indexAction() {
        
    }

    public function loginAction() {

        $error = true;

        if ($this->request->isPost()) {

            $data = \App\Models\User::where('email', $this->request->getPost("login"))
                    ->where('state', 'on')
                    ->first(['id', 'email', 'password']);

            if (isset($data) && !is_null($data)) {

                $password = $this->request->getPost("password");

                if ($this->security->checkHash($password, $data->password)) {

                    $this->session->set('userID', $data->id);
                    $this->session->set('userEmail', $data->email);
                    $error = false;
                }
            } else {
                $this->security->hash(rand());
            }
        }

        $this->resultJSON($error);
    }

    public function logoutAction() {
        $this->session->remove('userID');
        $this->session->remove('userEmail');

        $this->resultJSON(false);
    }

}
