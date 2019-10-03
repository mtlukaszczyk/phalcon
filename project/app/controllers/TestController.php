<?php

namespace App\Controllers;

class TestController extends ControllerBase {

    public function indexAction() {
        echo 'index';
        $this->view->disable();
    }

    public function blockedAction() {
        echo 'blocked';
        $this->view->disable();
    }

    public function pageAction() {
        
    }

    public function voltAction() {
        
    }

}
