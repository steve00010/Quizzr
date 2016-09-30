<?php

defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{
    /* 
    *  Load Controller 
    *  Load Models and helpers
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('SessionModel');
        $this->load->model('UsersModel');

        $this->load->database();
    }
    /*
    *   Loads the users profile
    *
    *   Get the users details and loads them into the profile
    */
    public function profile()
    {
        if (!$this->SessionModel->CheckLogged()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['title'] = $data['auth']['Username'].' - Profile';
            $user = $this->session->userdata('QuizU');
            $data['oldtests'] = $this->UsersModel->LoadPreviousTests($user);
            $data['createdtests'] = $this->UsersModel->LoadPreviousTestsCreated($user);
            $data['email'] = $this->UsersModel->GetEmail($user);
            $data['status'] = $this->UsersModel->GetStatus($user);

            $this->load->view('header', $data);
            $this->load->view('profile');
            $this->load->view('footer');
        }
    }
    public function ViewProfile($userID = null){
        if (!$this->SessionModel->CheckLogged()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['pub'] = $this->UsersModel->CheckPublic($userID);
            if($data['pub']) {
                
            } 
            $this->load->view('header', $data);
            $this->load->view('viewprofile');
            $this->load->view('footer');
        }
    }
    public function settingspword() {
        $oldpass = $this->input->post("OldPass",true);
        $newpass = $this->input->post("NewPass",true);
        if (strlen($newpass) < 6) {
            echo 'PSHORT';
        } elseif ($oldpass == $newpass){
            echo 'SAMEPASS';
        }else {
            $pwordold = password_hash($oldpass, PASSWORD_DEFAULT);
            $user = $this->session->userdata('QuizU');
            if (!$this->UsersModel->CheckOldPass($user,$pwordold)) {
                echo 'OLDPASS';
            } else {
                $pwordnew = password_hash($newpass, PASSWORD_DEFAULT);
                $this->UsersModel->UpdatePassword($user,$pwordnew);
                echo 'SUCCESS';
            }
        }
        
    }
    public function settingsstatus() {
        $status = $this->input->post("status",true);
        $user = $this->session->userdata('QuizU');
        if($status == true || $status == false) {
            if(strlen($user) > 0) {
                $this->UsersModel->UpdateStatus($user,$status);
                echo 'SUCCESS';                
            } else {
                echo $user;
                echo "USERMISSING";
            }
        }else {
            echo "SFAIL";
        }        
    }
    public function settingsemail(){
        $email = $this->input->post("email",true);
        if((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            echo 'EINVALID';
        } elseif (!$this->AuthModel->CheckEmail($email)) {
            echo 'ETAKEN';
        } else {
            $user = $this->session->userdata('QuizU');
            $this->UsersModel->UpdateEmail($user,$email);
            echo 'SUCCESS';
        }
    }
    public function settings() {
        if (!$this->SessionModel->CheckLogged()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['title'] = 'Quizzr - Settings';
            $data['customScript'] = array("settings.js");
            $this->load->view('header', $data);
            $this->load->view('settings');
            $this->load->view('footer');
        }

    }
}
