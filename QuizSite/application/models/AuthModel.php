<?php

class AuthModel extends CI_Model
{
    public function __construct()
    {
    }
    /*
    *   Checks if the username is taken
    *
    *   Queries the database and returns the result
    */
    public function CheckUser($user)
    {
        $query = $this->db->get_where('users', array('username' => $user));
            //if new user return true
            if ($query->num_rows() == 0) {
                return true;
            }
            //if not new return false
            else {
                return false;
            }
    }
    /*
    *   Checks if the email is taken
    *
    *   Queries the database and returns the result
    */
    public function CheckEmail($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
            //if new user return true
            if ($query->num_rows() == 0) {
                return true;
            }
            //if not new return false
            else {
                return false;
            }
    }
    /*
    *   Authenticates a user
    *   
    *   Takes the username and password
    *   Queries the database and then checks against the password
    *   If valid checks their admin status and returns the result
    *   If not returns the lack of validation
    */
    public function Login($user, $pass)
    {
        $query = $this->db->get_where('users', array('username' => $user));
        if ($query->num_rows() == 0) {
            return 0;
        } else {
            foreach ($query->result_array() as $row) {
                $pword = $row['password'];
                $admin = $row['admin'];
            }
            if (password_verify($pass, $pword)) {
                if ($admin) {
                    return 3;
                } else {
                    return 2;
                }
            } else {
                return 1;
            }
        }
    }
    /*
    *   Registers a user
    *
    *   Checks the username and email are valid
    *   Stores the data in the database
    */
    public function RegisterUser($user, $email, $pass)
    {
        if ($this->CheckUser($user) && $this->CheckEmail($user)) {
            $unique = substr(md5(uniqid(mt_rand(), true)), 0, 6);
            $data = array(
               'username' => $user,
               'password' => $pass,
               'email' => $email,
               'uniqid' => $unique,
               'signup' => time()
            );
            $this->db->insert('users', $data);
            return true;
        } else {
            return false;
        }
    }
}
