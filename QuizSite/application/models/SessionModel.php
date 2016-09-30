<?php

class SessionModel extends CI_Model
{
    public function __construct()
    {
    }
    /*
    *   Checks if a user is logged in
    *
    *   Checks their session data and returns the result
    */
    public function checkLogged()
    {
        return ($this->session->userdata('LOGGED_IN') == true && $this->session->userdata('QuizU') != '');
    }
    /*
    *   Returns session data
    *
    *   Returns the session data to if they are logged in, their username and admin status
    */
    public function getLogged()
    {
        if ($this->checkLogged()) {
            $data['auth']['LOGGED_IN'] = true;
            $data['auth']['Username'] = $this->echoName($this->session->userdata('QuizU'));
            $data['auth']['Admin'] = $this->session->userdata('Admin');
        } else {
            $data['auth']['LOGGED_IN'] = false;
        }

        return $data;
    }
    /*
    *   XSS parsing for a username
    *
    *   Capitalises and XSS filters a username and returns it
    */
    public function echoName($name) {
      return htmlspecialchars(ucfirst($name));
    }
    /*
    *   Check if a user is an admin
    *
    *   Returns the admin status of a user from the session data
    */
    public function checkAdmin()
    {
        if ($this->checkLogged()) {
            return $this->session->userdata('Admin');
        } else {
            return false;
        }
    }
}
