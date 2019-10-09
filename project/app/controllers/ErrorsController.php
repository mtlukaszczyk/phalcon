<?php

namespace App\Controllers;

class ErrorsController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function notFoundAction() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, '404 Not found');
        }
    }

    public function serverErrorAction() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, 'Internal server error');
        }
    }

    public function noAccessAction() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, 'Proszę się zalogować');
        }
    }

}
