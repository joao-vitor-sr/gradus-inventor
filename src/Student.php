<?php

namespace GradusInventor;

class Student {
  /**
  * @var string
  **/
  public $sRegistration = '';

  /**
  * @var string
  **/
  public $sEmail = '';

  /**
  * @var string
  **/
  public $sName = '';

  /**
  * @var GradusInventor\Grade[]
  **/
  public $aGrades = [];

  /**
  * @var GradusInventor\Attendence[]
  **/
  public $aAttendances = [];

  /**
  * GradusInventor\Student:__construct()
  * The __construct method is a special method that is called when an object is created. It is used to initialize the object's properties.
  *
  * @param string $sRegistration
  * @param string $sEmail
  * @param string $sName
  * @param GradusInventor\Grade[] $aGrades
  * @param GradusInventor\Attendence[] $aAttendances
  *
  * @access public
  * @return void
  **/
  public function __construct($sRegistration, $sEmail, $sName, $aGrades, $aAttendances) {
    $this->sRegistration = $sRegistration;
    $this->sName = $sName;
    $this->sEmail = $sEmail;
    $this->aGrades = $aGrades;
    $this->aAttendances = $aAttendances;
  }
}
