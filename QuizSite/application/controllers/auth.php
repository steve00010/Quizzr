<?php

defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
{
    /* 
    *  Load Controller 
    *  Load Models and helpers
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->database();
        $this->load->model('AuthModel');
        $this->load->library('session');
    }
    
    /*
    *   Takes post request and authenticates a user
    *
    *   Login, take username and password from post request
    *   Check valid strings and check authentication
    *   Return response 
    */
    public function login()
    {
        $user = $this->input->post('user',true);
        $pword = $this->input->post('pword',true);
        if (strlen($user) > 0 && strlen($pword) > 0) {
            $check = $this->AuthModel->Login($user, $pword);
            if ($check == 2) {
                echo 'LSUC';
                $this->session->set_userdata('LOGGED_IN', true);
                $this->session->set_userdata('QuizU', $user);
                $this->session->set_userdata('Admin', false);
            } elseif ($check == 0) {
                echo 'LFAILUNAME';
            } elseif ($check == 1) {
                echo 'LFAILPWORD';
            } elseif ($check == 3) {
                echo 'LSUC';
                $this->session->set_userdata('LOGGED_IN', true);
                $this->session->set_userdata('QuizU', $user);
                $this->session->set_userdata('Admin', true);
            }
        } else {
            echo 'FAIL';
        }
    }
    /*
    *   Takes post request and registeres a user
    *
    *   Take user, password and email from post request
    *   Clean for XSS on each input (true param)
    *   Check password, email and username validity
    *   If valid register user and log them in
    */
    public function register()
    {
        $user = $this->input->post('user',true);
        $pword = $this->input->post('pword',true);
        $email = $this->input->post('email',true);
        if (strlen($pword) < 6) {
            echo 'PSHORT';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'ETAKEN';
        } else {
            $pword = password_hash($pword, PASSWORD_DEFAULT);
            if (!$this->AuthModel->CheckUser($user)) {
                echo 'UTAKEN';
            } elseif (!$this->AuthModel->CheckEmail($email)) {
                echo 'ETAKEN';
            } else {
                if ($this->AuthModel->RegisterUser($user, $email, $pword)) {
                    echo 'RSUC';
                    $this->session->set_userdata('LOGGED_IN', true);
                    $this->session->set_userdata('QuizU', $user);
                    $this->session->set_userdata('Admin', false);
                } else {
                    echo 'RFAIL';
                }
            }
        }
    }
    /*
    *   Logs a user out
    *
    *   Remove session variables and send user back to homepage
    */
    public function logout()
    {
        $this->session->unset_userdata('QuizU');
        $this->session->set_userdata('LOGGED_IN', false);
        header('Location: http://'.base_url());
    }
    /*
    *   User and email validation
    *
    * Check if user name of email is taken
    * Return result
    */
    public function check($type = null)
    {
        if ($type == 'user') {
            $user = $this->input->post('user',true);

            echo($this->AuthModel->CheckUser($user));
        } elseif ($type == 'email') {
            $email = $this->input->post('email',true);

            echo($this->AuthModel->CheckEmail($email));
        }
    }
}
