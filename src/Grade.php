<?php

namespace GradusInventor;

class Grade {
  /**
   * @var float
  **/
  private $fGrade;

  /**
   * @var string
  **/
  private $sNameExam = '';

  /**
   * Grade::__construct()
   * The method to create a new instance of the Grade class
   *
   * @param float $fGrade - the grade of the exam
   * @param string $sNameExam - the name of the exam
  **/
  public function __construct($fGrade, $sNameExam = '') {
    if (empty($fGrade)) {
      throw new \Exception('Grade cannot be empty');
    }

    $this->fGrade = $fGrade;

    if (empty($sNameExam)) {
      throw new \Exception('Name of the exam cannot be empty');
    }

    $this->sNameExam = $sNameExam;
  }
}
