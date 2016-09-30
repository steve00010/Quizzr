<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QuestionObject {
  private $title;
  private $noAs;
  private $cAns;
  private $aArray;

  public function __construct($params)
  {
    $this->title = $params['title'];
    $this->noAs = $params['noAs'];
    $this->aArray = $params['aArray'];
    $this->cAns = $params['cAns'];
  }
  public function getTitle() {
    return $this->title;
  }
  public function getnoAs() {
    return $this->noAs;
  }
  public function getcAns() {
    return $this->cAns;
  }
  public function getaArray() {
    return $this->aArray;
  }
}
