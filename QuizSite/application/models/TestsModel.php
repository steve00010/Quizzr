<?php

class TestsModel extends CI_Model
{
    public function __construct()
    {
    }
    public function getTestCreateHist(){
        $query = $this->db->get('test');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $ret = array();
            foreach($query->result_array() as $res){
                $time =  strtotime("0:00",$res['createdate']);
                if(!isset($ret[$time])) $ret[$time] = 1;
                else $ret[$time]++;
            }
            return $ret;
        }  
    }
    public function UpdateName($uniq,$name){
        if($uniq != "" && $name != "") {
            $this->db->where('uniqid', $uniq);
            $this->db->update('test', array('Name'=>$name));
            return true;
        }
        return false;
    }
    public function UpdateStatus($uniq,$status){
        if($status == true || $status == false){
            $status = $status ? 1 : 0;
            $this->db->where('uniqid', $uniq);
            $this->db->update('test', array('status'=>$status));
            return true;
        }
        return false;
    }
    public function DeleteTest($uniq){
        $query = $this->db->get_where('test',array('uniqid'=>$uniq));
        if ($query->num_rows() > 0) {
            $tID = $query->result_array()[0]['tid'];
            $this->db->delete('test', array('tid' => $tID));
            $this->db->delete('testquestions', array('tID' => $tID)); 
            $this->db->delete('testanswers', array('tID' => $tID)); 
            $this->db->delete('testresults', array('tID' => $tID));
            return true; 
        } else {
            return false;
        }

    }
    /* GetPublicTests()
    *   Retrieve all public tests from the databases 
    *   Format them into an array
    *   Return array
    */
    public function GetPublicTests(){
        $query = $this->db->get_where('test',array('status'=>0));
        $retarray = array();
        if ($query->num_rows() == 0) {
            return $retarray;
        } else {
            $res = $query->result_array();
            foreach ($res as $key => $testr) {
                $retarray[] = array('Name'=>$testr['Name'],'CreatorName'=>$testr['CreatorName'],'uniqid'=>$testr['uniqid'],'noQ'=>$testr['noQ']);
            }
        }
        return $retarray;
    }
    /* LoadTestHistory(Unique test ID)
    *   Reteive the test based on the uniqueID
    *   Look up the test results
    *   Store scores and dates in array
    *   Return array
    */
    public function LoadTestHistory($uniq){
        $query = $this->db->get_where('test',array('uniqid'=>$uniq));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $noQ = $query->result_array()[0]['noQ'];
        }
        $this->db->order_by("datetime", "asc");
        $query = $this->db->get_where('testresults',array('uniqid'=>$uniq));
        if ($query->num_rows() == 0) {
            return array(array(),array());
        } else {
            $res = $query->result_array();
            $darray = array();
            $sarray = array();
            foreach($res as $k=> $data){
                $darray[] = $data['datetime'];
                $score = $data['score'];
                if($score != 0) {
                    $score = $score/$noQ*100;
                } 
                $sarray[] = $score;
            }
            return array($darray,$sarray);
        }    
    }
    /*  LoadQuestionBreakdown(Unique test ID)
    *   Gets the testID and number of questions
    *   Get the questions and create array of correct answers 
    *   Get the test results for that test
    *   Loop through the results of the query then the results of the test ; O(n^2)
    *   Store all question results into 2D array
    *   For each result calculate new average score and store in 1D array
    *   Return 2D array contains the two above results  
    */
    public function LoadQuestionBreakdown($uniq){
        $query = $this->db->get_where('test',array('uniqid'=>$uniq));
        if ($query->num_rows() == 0) {
            return array(array(),array());
        } else {
            $noQ = $query->result_array()[0]['noQ'];
            $tID = $query->result_array()[0]['tid'];
        }
        $query = $this->db->get_where('testquestions',array('tID'=>$tID));
        if ($query->num_rows() == 0) {
            return array(array(),array());
        }
        $res = $query->result_array();
        $carray = array();
        foreach($res as $k=> $data){
            $carray[] = $data['ansID'];       
        }
        $query = $this->db->get_where('testresults',array('uniqid'=>$uniq));
        if ($query->num_rows() == 0) {
            return array(array(),array());
        }
        $res = $query->result_array();
        $qdistarray = array();
        $scorearray = array();

        foreach($res as $k=> $data){
            $results = json_decode($data['resultsArray']);
            foreach($results as $b=>$idi) {
                $temp = explode(";",$idi)[1];
                $qdistarray[$b][] = $temp;
                //Initialise $scorearray if first database result
                if($k == 0){
                    //If correct set to 100
                    if($temp == $carray[$b]) $scorearray[$b] = 100;
                    //else 0
                    else $scorearray[$b] = 0;
                }else {
                    //Get current score
                    $score = ($scorearray[$b]/100)*$k;
                    //increment if correct
                    if($temp == $carray[$b]) $score++;
                    //recalculate average based on new score and number of results
                    $scorearray[$b] = round($score/($k+1)*100,1);
                }
            }
        }
        return array($qdistarray,$scorearray);            
    }
    /* LoadTestAdmin(Unique Test ID)
    *   Retrieve TestID and Number of Questions
    *   Loop through results from database of the tests results O(n)
    *   Format each result and calculate average score, max score and low score
    *   Once done return array of results
    */
    public function LoadTestAdmin($uniqID){
        $query = $this->db->get_where('test',array('uniqid'=>$uniqID));
        if ($query->num_rows() == 0) {
            return array('tarray'=>array(),'total'=>0,'ascore'=>0,'noQ'=>0,'highlow'=>array(0,0));
        } else {
            $tID = $query->result_array()[0]['tid'];
            $noQ = $query->result_array()[0]['noQ'];
        }
        $query = $this->db->get_where('testresults',array('tID'=>$tID));
        if ($query->num_rows() == 0) {

            return array('tarray'=>array(),'total'=>0,'ascore'=>0,'noQ'=>0,'highlow'=>array(0,0));
        } else {
            $res = $query->result_array();
            $testarray = array();
            $total = 0;
            $tscore = 0;
            $max = 0;
            $low = 100;
            foreach ($res as $key => $testr) {
                $id = $testr['uID'];
                $total++;
                $score = $testr['score'];
                if($score != 0) {
                    $score = round($score/$noQ*100,1);
                } 
                if($score > $max) $max = $score;
                if($score < $low) $low = $score;
                $tscore += $score;
                $ret = $this->GetNameFromID($id);
                $username = $ret[0];
                $uniqid = $ret[1];
                $date = $testr['datetime'];
                $testarray[] = array('user'=>$username,'score'=>$score,'uniqid'=>$uniqid,'date'=>$date);
            }
            $ascore = round($tscore/$total,1);
            
            return array('tarray' => $testarray,'total'=>$total,'ascore'=>$ascore,'noQ'=>$noQ,'highlow'=>array($low,$max));
        }
    }
    /*  GetNameFromID(Test ID)
    *   Lookup in database and return the users username and uniqueID
    */
    private function GetNameFromID($ID){
        $query = $this->db->get_where('users',array('uid'=>$ID));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $user = $query->result_array()[0]['username'];
            $uniqid = $query->result_array()[0]['uniqid'];
            return array($user,$uniqid);
        }
    }
    /*
    *   Stores a test and its questions in the database
    *
    *   Takes a testObject and stores its data and its questions in the database
    */
    public function storeTest(TestObject $q, $user,$status)
    {
        $uniq = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        $data = array(
         'name' => $q->getTitle(),
         'CreatorName' => $user,
         'noQ' => $q->getnoQs(),
         'uniqid' => $uniq,
         'status' => ($status == "Public") ? 0 : 1,
         'createdate'=>time()
         );
        $this->db->insert('test', $data);
        $insertid = $this->db->insert_id();
        $i = 0;
        foreach ($q->getQOArray() as $Qobj) {
            $this->storeQuestion($Qobj, $insertid, $i);
            ++$i;
        }
        return $uniq;
    }
    /*
    *   Stores a question in the database
    *
    *   Takes a questionObject and stores it in the datbase
    */
    public function storeQuestion(QuestionObject $q, $tID, $qNO)
    {
        $data = array(
         'tID' => $tID,
         'Question' => $q->getTitle(),
         'ansID' => $q->getcAns(),
         'noA' => $q->getnoAs(),
         'qNO' => $qNO
         );
        $this->db->insert('testquestions', $data);
        $i = 0;
        $insertid = $this->db->insert_id();
        foreach ($q->getaArray() as $answer) {
            $this->storeAnswer($answer,  $insertid, $tID, $i);
            ++$i;
        }
    }
    /*
    *   Stores the answer to a question
    *
    *   Stores an answer based on its testid, questionid and id
    */
    public function storeAnswer($answer, $qID, $tID, $aNO)
    {
        $data = array(
         'tID' => $tID,
         'qID' => $qID,
         'Answer' => $answer,
         'aNO' => $aNO,
         );
        $this->db->insert('testanswers', $data);
    }
    /*
    *   Check if a user has taken the test already
    *
    *   First gets the userID from the username from the database
    *   Then check if the user has taken a test previously
    *   Returns true if the test is untaken
    */
    public function checkTaken($tID,$user){
        $query = $this->db->get_where('users',array('username'=>$user));
        if ($query->num_rows() == 0) {
            return true;
        } else {
            $userid = $query->result_array()[0]['uid'];
        }
        $query1 = $this->db->get_where('testresults',array('uniqid'=>$tID,'uID'=>$userid));
        if ($query1->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }
    /* GetTestName (Test Unique ID)
    * Return Test name based on uniqueID
    */ 
    public function GetTestName($uniqid){
        $query = $this->db->get_where('test',array('uniqid'=>$uniqid));
        if ($query->num_rows() == 0) {
            return false;
        } else {
           return $query->result_array()[0]['Name'];
        }
    }
    /* GetTestStatus (Test Unique ID)
    * Return Test status based on uniqueID
    */ 
    public function GetTestStatus($uniqid){
        $query = $this->db->get_where('test',array('uniqid'=>$uniqid));
        if ($query->num_rows() == 0) {
            return false;
        } else {
           return $query->result_array()[0]['status'];
        }
    }
    /*  getTestAnswers(test ID)
    *   Loop through test questions basec on ID and store in array
    *   return array;
    */
    private function getTestAnswers($test){
        $query = $this->db->get_where('testquestions',array('tID'=>$test));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $ansarray = array();
            $res = $query->result_array();
            foreach ($res as $key => $testq) {
                $ans = $testq['ansID'];
                $qID = $testq['qNO'];
                $ansarray[] = $qID.";".$ans;    
            }
            return $ansarray;
        }
    }
    // CheckTestAuthor(Test uniqueID, Creator username)
    // Check if record exists and return true if so false if not
    public function CheckTestAuthor($test,$user){
        $query = $this->db->get_where('test',array('uniqid'=>$test,'CreatorName'=>$user));
        if($query->num_rows() >0 ){ return true;}
        return false;
    }
    /*  ViewTest(Test uniqueID, User username)
    *   Get user ID based on username
    *   Get test ID based on uniqueID
    *   Get test results & score based on userID and testID
    *   Get test correct answers
    *   Loop through results and sotre in boolean array based on if they got answer correct
    *   Store results in array
    *   Encode result array using JSON and return the JSON string
    */
    public function ViewTest($test,$user){
        $query = $this->db->get_where('users',array('username'=>$user));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $userid = $query->result_array()[0]['uid'];
        }
        $query = $this->db->get_where('test',array('uniqid'=>$test));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $tid = $query->result_array()[0]['tid'];
        }
        $query = $this->db->get_where('testresults',array('uID'=>$userid,'tID'=>$tid));
        $ans = array();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $ans = json_decode($query->result_array()[0]['resultsArray']);
            $score = $query->result_array()[0]['score'];
        }
        
        $realans = $this->getTestAnswers($tid);
        
        foreach($ans as $k=> $an){
            if($an == $realans[$k]) { 
                $resa[] = true;
            } else{
                $resa[] = false;
            }
        }
        $totalq = sizeof($realans);
        $perc = $score/$totalq * 100;
        $ret = array(
            'score'=> $perc,
            'resa' => $resa,
            'modelans' => $realans,
            'result'=>$ans
        );
        return json_encode($ret);
    }
    /*  GradeTest(Test UniqueID, User username, Answer array)
    *   Retreive TestID, UserID and Correct Answers
    *   Loop through user answer and store in boolean array if correct or incorrect
    *   Calculate a score based on correct number of answers
    *   Store results in database
    *   Return results once JSON encoded
    */
    public function GradeTest($test,$user,$ans){
        $query = $this->db->get_where('users',array('username'=>$user));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $userid = $query->result_array()[0]['uid'];
        }
            $query = $this->db->get_where('test',array('uniqid'=>$test));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $tid = $query->result_array()[0]['tid'];
        }
        $score = 0;
        $realans = $this->getTestAnswers($tid);
        $resa = array();
        foreach($ans as $k=> $an){
            if($an == $realans[$k]) { 
                $score++;
                $resa[] = true;
            } else{
                $resa[] = false;
            }
        }
        $totalq = sizeof($realans);
        $perc = $score/$totalq * 100;
        $ret = array(
            'score'=> $perc,
            'resa' => $resa,
            'modelans' => $realans

        );
        $data = array(
         'tID' => $tid,
         'uID' => $userid,
         'resultsArray' => json_encode($ans),
         'score'=> $score,
         'uniqid'=>$test,
         'datetime' => time()
         );
        $this->db->insert('testresults', $data);
        return json_encode($ret);
    }
    /*
    *   Get all tests
    *   
    *   Queries the database and returns all tests
    */
    public function getTests()
    {
        $query = $this->db->get('test');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function getTestsCount(){
        return $this->db->count_all_results('test');
    }
    public function getResultsCount(){
        return $this->db->count_all_results('testresults');
    }
    public function getTestAvgLength(){
        $this->db->select_avg('noQ');
        $query = $this->db->get('test');
        if ($query->num_rows() == 0) {
            return 0;
        } else {
            return round($query->result()[0]->noQ);
        }
    }
    /*
    *   Get 10 latest tests
    *   
    *   Queries the database and returns the latest 10 tests
    */
    public function getTestsOverview()
    {
        $this->db->from('test');
        $this->db->order_by("tid", "desc");
        $this->db->limit(10);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    /*
    *   Return a test based on ID
    *
    *   Queries the database for a specific test from its ID and returns it
    */
    public function getTestsByID($id){
        $query = $this->db->get_where('test',array('uniqid'=>$id));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array()[0];
        }
    }
    /*
    *   Load a test based on its ID
    *   
    *   Queries the database for all questions related to the testID
    *   If found parses the data and loads all the answers for each question
    *   Looping through each question all the data is brought together into one array
    */
    public function loadTest($id,$numb,$title) {
        $retArray = [];
        $retArray[] = $title;
        $retArray[] = $numb;
        $retQCArray=[];
        $query = $this->db->get_where('testquestions',array('tID'=>$id));
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $qArray = $query->result_array();
            foreach($qArray as $ques){
                $aArray = [];
                $qID = $ques['qID'];
                $query = $this->db->get_where('testanswers',array('tID'=>$id,'qID'=>$qID));
                if ($query->num_rows() == 0) {
                    return false;
                } else {
                    $aArray = $query->result_array();
                }
                $retQArray = [];
                $retQArray[] = $ques['Question'];
                $retQArray[] = $ques['noA'];
                $retQArray[] = $ques['ansID'];
                for($j=0;$j<$ques['noA'];$j++){
                    $retQArray[] = $aArray[$j]['Answer'];
                }
                $retQCArray[] = $retQArray;
            }
        }
        $retArray[] = $retQCArray;
        return $retArray;
    }
}
