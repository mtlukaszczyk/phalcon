<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use App\Classes\User as User;

class ControllerBase extends Controller {

    /**
     * Current logged user
     * @var type 
     */
    protected $user = false;

    /**
     * Renders data as JSON for Ajax requests
     * @param mixed $data
     */
    public function renderJSON($data) {
        echo json_encode($data);
        die();
    }

    /**
     * Render data as JSON for Ajax requests in standard format
     * @param boolean $error
     * @param string $msg
     * @param array $data
     */
    public function resultJSON($error, $msg = '', $data = []) {
        $this->renderJSON([
            'error' => $error,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    /**
     * Runs always before action
     */
    public function initialize() {
        if ($this->session->has('userID')) {
            $this->user = new User([
                'id' => $this->session->get('userID'),
                'email' => $this->session->get('userEmail')
            ]);
        } else {
            $this->user = false;
        }

        $this->assets->addJs('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', true);
        $this->assets->addCss('css/bootstrap/bootstrap.min.css');
        $this->assets->addCss('css/bootflat/bootflat.min.css');
        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/font-awesome.css');
        $this->assets->addJs('js/bootstrap/bootstrap.min.js');
        $this->assets->addJs('js/jquery-ui.js');
        $this->assets->addJs('js/main.js');

        $this->view->setVars(
                [
                    "baseUrl" => getenv('BASE_URL'),
                    'user' => [
                        'id' => $this->user == false ? false : $this->user->getID(),
                        'email' => $this->user == false ? false : $this->user->getEmail()
                    ]
                ]
        );
    }

    /**
     * Returns current logged user object
     * @return \Engine\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Returns true is user is logged
     * @return bool
     */
    public function isLogged() {
        return $this->user !== false;
    }

}
