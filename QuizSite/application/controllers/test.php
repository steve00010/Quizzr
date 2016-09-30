<?php

defined('BASEPATH') or exit('No direct script access allowed');

class test extends CI_Controller
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
    *   Takes post request and creates a test
    *
    *   Parse the Json from the post request
    *   Stores the test and returns result
    */
    public function create()
    {
        if (!$this->SessionModel->CheckLogged()) {
            header('Location: http://'.base_url());
        } else {
            $json=$this->input->post('Json',true);
            $status=$this->input->post('Status',true);
            if(!is_null($json)) {
                $title = $json[0];
                if($title == "" || !isset($title)){ 

                    echo json_encode(array('fail','TitleSmall'));
                }
                else {
                    $noqs = $json[1];
                    $qArray = $json[2];
                    $params = array('title' => $title, 'noQs' => $noqs, 'qArray' => $qArray);
                    $this->load->library('testobject', $params, 'TO');
                    $unique = $this->TestsModel->storeTest($this->TO, $this->session->userdata('QuizU'),(!isset($status) || is_null($status)) ? 'Public' : $status);
                    echo json_encode(array('success',$unique));
                }
            }

        }
    }

    public function show()
    {
        $data = $this->SessionModel->getLogged();
        $data['testl'] = $this->TestsModel->GetPublicTests();
        $data['title'] = "Tests list";
        if($this->SessionModel->CheckLogged())  $data['customScript'] = array("qGen.js");
        $this->load->view('header', $data);
        $this->load->view('tests');
        $this->load->view('footer');
    }

    /*  
    *   Loads the page for a user to take a test
    *
    *   Takes the testID from the url
    *   Loads the test from the database using that testID
    *   Loads the page with the test information
    */
    public function taketest($tID = NULL){
        if (!$this->SessionModel->CheckLogged()) {
            header('Location: http://'.base_url());
        }
        if($tID !== null OR $tID !== 0 && $this->SessionModel->CheckLogged()){
            $data = $this->SessionModel->getLogged();
            $data['title'] = "Quizzr - take test";
            $test = $this->TestsModel->getTestsByID($tID);
            $testload = $this->TestsModel->loadTest($test['tid'],$test['noQ'],$test['Name']);
            $allA = [];
            $allA[] = $testload[0];
            $allA[] = $test['CreatorName'];
            $allA[] = $testload[1];
            $qus = [];
            if(sizeof($testload[2]) < 1){
               header('Location: http://'.base_url());
            } else {
                foreach ($testload[2] as $key => $answer) {
                    $aArray = [];
                    for($i=3;$i<($answer[1]+3);$i++){
                        $aArray[] = $answer[$i];
                    }
                    $data1 = array (
                        'title'=>$answer[0],
                        'qNo'=>$answer[1],
                        'aArray'=>$aArray
                    );
                    $qus[] = $data1;
                }
                $allA[] = $qus;
                $data['testdata'] = $allA;
                $data['view'] = false;
                $data['customScript'][] = 'gradetest.js';
                $this->load->view('header', $data);
                $this->load->view('taketest');
                $this->load->view('footer');
            }
        }
    }
    /*
    *   Grades a users test and returns the result
    *
    *   Checks if the test has been taken already
    *   Grades the test and returns the result.
    */
    public function gradetest(){
        if($this->SessionModel->CheckLogged()){
            $user = $this->session->userdata('QuizU');
            $tID = $this->input->Post('ID');
            if($this->TestsModel->checkTaken($tID,$user)){
                $res = json_decode($this->input->Post('result'));
                echo $this->TestsModel->GradeTest($tID,$user,$res);
            } else {
               echo 'false';
            } 
        }  else {
            header('Location: http://'.base_url());
        }
    }
    public function admintest($tID){
        if($this->SessionModel->CheckLogged()){
            if($this->TestsModel->CheckTestAuthor($tID,$this->session->userdata('QuizU')) || $this->SessionModel->checkAdmin()  )
            {
                $data = $this->SessionModel->getLogged();
                $data['testtakers'] = $this->TestsModel->LoadTestAdmin($tID);
                $data['testdata']['testname'] = $this->TestsModel->GetTestName($tID);
                $data['testdata']['testcode'] = $tID;
                $data['testdata']['status'] = $this->TestsModel->GetTestStatus($tID);

                $data['title'] =  $data['testdata']['testname']." Admin page";
                $data['customScript'][] = 'testadmin.js';

                $this->load->view('header', $data);
                $this->load->view('testadmin', $data);
                $this->load->view('footer');
            }
            else {
                header('Location: http://'.base_url());
            }
        }
        else {
            header('Location: http://'.base_url());
        }
    }
    public function teststats($tID){
        if($tID == null || !$this->SessionModel->CheckLogged() || (!$this->TestsModel->CheckTestAuthor($tID,$this->session->userdata('QuizU')) && !$this->SessionModel->checkAdmin()) ){
            header('Location: http://'.base_url());
        } 
        $testdata = $this->TestsModel->LoadQuestionBreakdown($tID);
        echo json_encode($testdata);
    }
    public function testhistory($tID){
        if($tID == null || !$this->SessionModel->CheckLogged() || (!$this->TestsModel->CheckTestAuthor($tID,$this->session->userdata('QuizU')) && !$this->SessionModel->checkAdmin()) ){
            header('Location: http://'.base_url());
        } 
        $testdata = $this->TestsModel->LoadTestHistory($tID);
        echo json_encode($testdata);
    }
    public function userhistory($uID){
        
    }
    public function usertestview($tID = null, $user = null){
        if($tID == null || !$this->SessionModel->CheckLogged() || !$this->TestsModel->CheckTestAuthor($tID,$this->session->userdata('QuizU')) || !$this->SessionModel->checkAdmin() ){
            header('Location: http://'.base_url());
        } 
        $data = $this->SessionModel->getLogged();

        $test = $this->TestsModel->getTestsByID($tID);
        $testload = $this->TestsModel->loadTest($test['tid'],$test['noQ'],$test['Name']);
        $allA = [];
        $allA[] = $testload[0];
        $allA[] = $test['CreatorName'];
        $allA[] = $testload[1];
        $qus = [];
        if(sizeof($testload[2]) < 1){
           header('Location: http://'.base_url());
        } else {
            foreach ($testload[2] as $key => $answer) {
                $aArray = [];
                for($i=3;$i<($answer[1]+3);$i++){
                    $aArray[] = $answer[$i];
                }
                $data1 = array (
                    'title'=>$answer[0],
                    'qNo'=>$answer[1],
                    'aArray'=>$aArray
                );
                $qus[] = $data1;
            }
            $allA[] = $qus;
            $data['testdata'] = $allA;
            $name = $this->UsersModel->NameFromUniq($user);
            $data['user']['name'] = $name;
            $data['user']['uniqid'] = $user;
            $data['user']['testid'] = $tID;
            $data['view'] = true;
            $data['customScript'][] = 'gradetestview.js';
            $data['title'] = "View user test";

            $this->load->view('header', $data);
            $this->load->view('taketest');
            $this->load->view('footer');
        }
    }
    public function checktest(){
        if($this->SessionModel->CheckLogged()){
            $user = $this->session->userdata('QuizU');
            $tID = $this->input->Post('ID');
            if($this->input->Post('user') != null) {
                $user = $this->input->Post('user');
                $user = $this->UsersModel->NameFromUniq($user);
            }
            if(!$this->TestsModel->checkTaken($tID,$user)){
               echo $this->TestsModel->ViewTest($tID,$user);
            }else {
                echo 'false';
            }
        }  else {
            header('Location: http://'.base_url());
        }
    }
    public function deleteTest($uniq){
        if($uniq == null || !$this->SessionModel->CheckLogged() || (!$this->TestsModel->CheckTestAuthor($uniq,$this->session->userdata('QuizU')) && !$this->SessionModel->checkAdmin()) ){
            echo false;
        }else {
            echo $this->TestsModel->DeleteTest($uniq);
        }
    }
    public function editTest($uniq) {
         if($uniq == null || !$this->SessionModel->CheckLogged() || (!$this->TestsModel->CheckTestAuthor($uniq,$this->session->userdata('QuizU')) && !$this->SessionModel->checkAdmin()) ){
            echo false;
        }else {

            $status = $this->input->Post('status');
            if(isset($status)) {
                echo $this->TestsModel->UpdateStatus($uniq,$status);
            }
            $newname = $this->input->Post('name');
            if(isset($newname) || $newname != "") {
                echo $this->TestsModel->UpdateName($uniq,$newname);
            }
        }
    }
}
