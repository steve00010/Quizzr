<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("Questionobject.php");
class TestObject {
  private $title;
  private $noQs;
  private $qArray;
  private $QOArray = array();
  public function __construct($params)
  {
    $this->title = $params['title'];
    $this->noQs = $params['noQs'];
    $this->qArray = $params['qArray'];
    $CI =& get_instance();
    foreach( $this->qArray as $qInfo) {

      $qTitle = $qInfo[0];
      $noAs = $qInfo[1];
      $cAns = $qInfo[2];
       $aArray = null;
      for($i =3;$i<($noAs+3);$i++){
        $aArray[] = $qInfo[$i];
      }
      
      $params1 = array('title' => $qTitle, 'noAs' => $noAs, 'aArray' => $aArray, 'cAns'=>$cAns);

      $QO = new QuestionObject($params1);
      array_push($this->QOArray,$QO);    
    }
  }
  public function getTitle()
  {
    return $this->title;
  }
  public function getnoQs()
  {
    return $this->noQs;
  }
  public function getQOArray()
  {
    return $this->QOArray;
  }
  public function store() {


  }
}
