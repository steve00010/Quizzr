<?php

defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
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
        $this->load->model('TestsModel');
        $this->load->database();
    }
    /*
    *   Loads Admin dashboard
    *
    *   Check if user has admin privilege
    *   Return to index if so
    *   Else load all models and the page
    */
    public function index()
    {
        if (!$this->SessionModel->checkAdmin()) {
            header('Location: http://'.base_url());
        } else {

            $data = $this->SessionModel->getLogged();
            $tests = $this->TestsModel->getTestsOverview();
            if ($tests) {
                foreach ($tests as $row) {
                    $data['test'][] = $row;
                }
            } else {
                $data['test'] = false;
            }
            $users = $this->UsersModel->getUsers();
            if ($users) {
                foreach ($users as $row) {
                    $data['user'][] = $row;
                }
            } else {
                $data['user'] = false;
            }
            $data['totaltests'] = $this->TestsModel->getTestsCount();
            $data['totalusers'] = $this->UsersModel->getUsersCount();
            $data['teststaken'] = $this->TestsModel->getResultsCount();
            $data['testavg'] = $this->TestsModel->getTestAvgLength();
            $data['title'] = 'Admin Page';
            $data['customScript'] = array("adminstats.js");

            $data['customJS'] = '<script>$(function(){$("#AdminLink").addClass("active");});</script>';
            $this->load->view('header', $data);
            $this->load->view('admin/Aheader');
            $this->load->view('admin/Aindex');
            $this->load->view('footer', $data);
        }
    }
    public function UserSignUp(){
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            echo json_encode($this->UsersModel->getUserSignUpHist());
        }
    }
    public function TestCreate(){
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            echo json_encode($this->TestsModel->getTestCreateHist());
        }
    }
    /*
    *   Loads Admin view of a test
    *
    *   Check if user has admin privilege
    *   Return to index if not
    *   Else load the page
    */
    public function viewtest($tID = null)
    {
        if (!$this->SessionModel->checkAdmin()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['title'] = 'Admin Page';
            $this->load->view('header', $data);
            $this->load->view('admin/Aheader');
            $this->load->view('admin/Atests');
            $this->load->view('footer');
        }
    }
    public function viewuser($uID = null) {
        if (!$this->SessionModel->checkAdmin()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();

            $data['user']['Username'] = ucfirst($this->UsersModel->GetUsername($uID));
            $user = $data['user']['Username'];
            $data['user']['oldtests'] = $this->UsersModel->LoadPreviousTests($user);
            $data['user']['createdtests'] = $this->UsersModel->LoadPreviousTestsCreated($user);
            $data['user']['email'] = $this->UsersModel->GetEmail($user);
            $data['user']['status'] = $this->UsersModel->GetStatus($user);
            $data['title'] = $user.' - Admin Page';
            $data['customJS'] = '<script>$(function(){$("#AdminLink").addClass("active");});</script>';
            $data['customScript'] = array("adminsettings.js");
            $this->load->view('header', $data);
            $this->load->view('admin/Aviewuser');
            $this->load->view('footer');
        }
    }
    public function settingspword(){
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            $newpass = $this->input->post("NewPass",true);
            $user = $this->input->post("User",true);
            if (strlen($newpass) < 6) {
                echo 'PSHORT';
            } else if(strlen($user) > 0) {
                $pwordnew = password_hash($newpass, PASSWORD_DEFAULT);
                $this->UsersModel->UpdatePassword($user,$pwordnew);
                echo 'SUCCESS';                
            } else {
                echo $user;
                echo "USERMISSING";
            }
        }
    }
    public function settingsemail() {
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            $email = $this->input->post("email",true);
            $this->load->model('AuthModel');
            $user = $this->input->post("user",true);
            if((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
                echo 'EINVALID';
            } elseif (!$this->AuthModel->CheckEmail($email)) {
                echo 'ETAKEN';
            } else if(strlen($user) > 0) {
                $this->UsersModel->UpdateEmail($user,$email);
                echo 'SUCCESS';                
            } else {
                echo $user;
                echo "USERMISSING";
            }
        }
    }
    public function settingsdelete(){
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            $user = $this->input->post("user",true);
            $this->UsersModel->DeleteUser($user);
            echo 'SUCCESS';
        }
    }
    public function settingsstatus() {
        if (!$this->SessionModel->checkAdmin()) {
            echo "Nope";
        } else {
            $status = $this->input->post("status",true);
            $user = $this->input->post("user",true);
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
    }
    /*
    *   Loads Admin view of all users
    *
    *   Check if user has admin privilege
    *   Return to index if not
    *   Else load all users
    *   Load the page full of users
    */
    public function users()
    {
        if (!$this->SessionModel->checkAdmin()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['title'] = 'Admin Page';
            $users = $this->UsersModel->getUsers();
            if ($users) {
                foreach ($users as $row) {
                    $data['user'][] = $row;
                }
            } else {
                $data['user'] = false;
            }
            $data['customJS'] = '<script>$(function(){$("#AdminLink").addClass("active");});</script>';
            $this->load->view('header', $data);
            $this->load->view('admin/Aheader');
            $this->load->view('admin/Ausers', $data);
            $this->load->view('footer', $data);
        }
    }
    /*
    *   Loads Admin view of all tests
    *
    *   Check if user has admin privilege
    *   Return to index if not
    *   Else load all users
    *   Load the page full of users
    */
    public function tests()
    {
        if (!$this->SessionModel->checkAdmin()) {
            header('Location: http://'.base_url());
        } else {
            $data = $this->SessionModel->getLogged();
            $data['title'] = 'Admin Page';
            $tests = $this->TestsModel->getTests();
            if ($tests) {
                foreach ($tests as $row) {
                    $data['test'][] = $row;
                }
            } else {
                $data['test'] = false;
            }
            $data['customJS'] = '<script>$(function(){$("#AdminLink").addClass("active");});</script>';
            $data['customScript'] = array("qGen.js");
            $this->load->view('header', $data);
            $this->load->view('admin/Aheader');
            $this->load->view('admin/Atests', $data);
            $this->load->view('footer', $data);
        }
    }
}
