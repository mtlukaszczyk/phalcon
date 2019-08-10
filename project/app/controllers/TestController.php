<?php

namespace App\Controllers;

class TestController extends ControllerBase {

    public function indexAction() {
        $this->view->disable();
    }

    public function blockedAction() {
        echo 'blocked';
        $this->view->disable();
    }

    public function test() {
        echo 'test';
    }

}
