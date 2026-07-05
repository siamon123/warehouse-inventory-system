<?php
abstract class BaseController {
    protected $session;

    public function __construct() {
        global $session;
        $this->session = $session;
    }

    protected function render($view, $data = []) {
        extract($data);
        require_once('views/' . $view . '.php');
    }

    protected function redirect($location, $msg = false) {
        redirect($location, $msg);
    }

    protected function flash($type, $msg) {
        $this->session->msg($type, $msg);
    }
}
