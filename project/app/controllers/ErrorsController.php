<?php

namespace App\Controllers;

use Phalcon\Http\Request;

class ErrorsController extends ControllerBase {

    private $requestInstance;

    public function initialize() {
        parent::initialize();
        $this->requestInstance = new Request();
    }

    public function notFoundAction() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, '404 Not found');
        }
    }

    public function show500Action() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, 'Internal server error');
        }
    }

    public function show401Action() {
        if ($this->request->isAjax()) {
            $this->resultJSON(true, 'Proszę się zalogować');
        }
    }

}
