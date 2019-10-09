<?php

namespace App\Controllers;

class TestController extends ControllerBase {

    public function indexAction() {
        echo 'test::index';
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

    public function testTestAction($parameter, $parameter2) {
        echo 'test_test';
        echo '--';
        echo $parameter;
        echo '--';
        echo $parameter2;
    }

}
