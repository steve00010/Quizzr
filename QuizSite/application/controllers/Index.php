<?php

defined('BASEPATH') or exit('No direct script access allowed');

class index extends CI_Controller
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
    }
    /*
    *   Loads index homepage
    */
    public function index()
    {
        
  		$data = $this->SessionModel->getLogged();
		$data['title'] = "Quizzr";
       // $data['customJS'] = '<script>$(function(){$("footer").css("position","absolute");});</script>';

        $this->load->view('header', $data);
        $this->load->view('index');
        $this->load->view('footer', $data);
    }
    public function about(){

        $data = $this->SessionModel->getLogged();
        $data['title'] = "Quizzr - About";
        $data['customJS'] = '<script>$(function(){$("footer").css("position","absolute");});</script>';
        $this->load->view('header', $data);
        $this->load->view('about');
        $this->load->view('footer', $data);
    }
}
