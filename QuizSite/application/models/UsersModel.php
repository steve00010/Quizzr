<?php

class UsersModel extends CI_Model
{
    public function __construct()
    {
    }
    /*
    *   Returns all users
    *
    *   Queries the database and returns every user
    */
    public function getUsers()
    {
        $query = $this->db->get('users');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function getUserSignUpHist(){
        $query = $this->db->get('users');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $ret = array();
            foreach($query->result_array() as $res){
                $time =  strtotime("0:00",$res['signup']);
                if(!isset($ret[$time])) $ret[$time] = 1;
                else $ret[$time]++;
            }
            return $ret;
        }  
    }
    public function GetUsername($uniq){
        $query = $this->db->get_where('users',array('uniqid'=>$uniq));
        if($query->num_rows() >0 ){
            return ($query->result_array()[0]['username']);
        }
        return false;    
    }
    public function GetEmail($user){
        $query = $this->db->get_where('users',array('username'=>$user));
        if($query->num_rows() >0 ){
            return ($query->result_array()[0]['email']);
        }
        return false; 
    }
    public function GetStatus($user){
        $query = $this->db->get_where('users',array('username'=>$user));
        if($query->num_rows() >0 ){
            return ($query->result_array()[0]['public']);
        }
        return false; 
    }
    public function CheckOldPass($user,$pword){
        $query = $this->db->get_where('users',array('username'=>$user));
        if($query->num_rows() >0 ){
            return ($pword == $query->result_array()[0]['password']);
        }
        return false;
    }
    public function CheckPublic($uniqid){
        $query = $this->db->get_where('users',array('uniqid'=>$uniqid,'public'=>true));
        if($query->num_rows() >0 ){
            return true;
        }
        return false;
    }
    public function DeleteUser($user){
        $query = $this->db->get_where('users',array('username'=>$user));
        if($query->num_rows() >0 ){
            $ID =  $query->result_array()[0]['uid'];
        }
        $this->db->delete('users', array('username' => $user));
        $this->db->delete('testresults', array('uID' => $ID));
        $query = $this->db->get_where('test',array('CreatorName'=>$user));
        if($query->num_rows() >0 ){
            foreach($query->result_array() as $test){
                $this->TestsModel->DeleteTest($test['uniqid']);
            }
        }
    }
    public function UpdateEmail($user,$email){
        $data = array(
            'email' => $email
        );
        $this->db->where('username', $user);
        $this->db->update('users', $data);    
    }
    public function UpdateStatus($user,$status){
        if($status) $status = 1;
        else $status = 0;
        $data = array(
            'public' => $status
        );
        $this->db->where('username', $user);
        $this->db->update('users', $data);    
    }
    public function UpdatePassword($user,$pword){

        $data = array(
            'password' => $pword
        );
        $this->db->where('username', $user);
        $this->db->update('users', $data); 
    }
    public function getUsersCount() {
         return $this->db->count_all_results('users');
    }
    private function getUserID($user){
         $query = $this->db->get_where('users',array('username'=>$user));
         if($query->num_rows() >0 ){
            return $query->result_array()[0]['uid'];
         }
         return false;
    }
    public function GetTestTakenNumber($test){
        $query = $this->db->get_where('testresults',array('tID'=>$test));
        return $query->num_rows();
    }
    public function LoadPreviousTestsCreated($user) {
       
        $query = $this->db->get_where('test',array('CreatorName'=>$user));
        $ret = array();
        foreach($query->result_array() as $k=>$test) {
            $name = $test['Name'];
            $noQ = $test['noQ'];
            $ID = $test['tid'];
            $count = $this->GetTestTakenNumber($ID);
            $uniqid = $test['uniqid'];
            $ret[] = array($ID,$name,$noQ,$count,$uniqid);
        }
        return $ret;
    }

    public function LoadPreviousTests($user) {
        $uID = $this->getUserID($user);
        $query = $this->db->get_where('testresults',array('uID'=>$uID));
        $ret = array();
        foreach($query->result_array() as $k=>$test) {

            $ID = $test['tID'];
            $score = $test['score'];
            $date = $test['datetime'];
            $q= $this->db->get_where('test',array('tID'=>$ID));
            foreach($q->result_array() as $t) {
                $name = $t['Name'];
                $noQ = $t['noQ'];
                $uniqid = $t['uniqid'];
            }
            $rets = $score/$noQ*100;
            $net = array($k,$name,$rets,$ID,$uniqid,$date);
            $ret[] = $net;
        }
        return $ret;
    }
    public function NameFromUniq($uniq){
        $query = $this->db->get_where('users',array('uniqid'=>$uniq));
        if($query->num_rows() >0 ){
            return $query->result_array()[0]['username'];
        }
        return false;
    }
}
