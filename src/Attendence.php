<?php

namespace GradusInventor;

class Attendence {
  /**
   * @var bool $bIsPresent - If the student is present
  **/
  public $bIsPresent = false;

  /**
   * Attendence::__construct()
   * The method __construct, it returns an instance of the class
   *
   * @param bool $bIsPresent - If the student is present
   * @throw \Exception if the is present is empty
  **/
  public function __construct($bIsPresent = false) {
    $this->bIsPresent = $bIsPresent;
  }
}
