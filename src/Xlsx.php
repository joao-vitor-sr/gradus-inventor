<?php

namespace GradusInventor;

use Shuchkin\SimpleXLSX;

class Xlsx {

  /**
  * @var string $sFilePath - Path to the xlsx file to be interpreted
  **/
  public $sFilePath = '';

  /**
   * @var int $iIndexColumnGroupArrays - Which column to use to group the arrays
  **/
  public $iIndexColumnGroupArrays = '';

  /**
  *  @var SimpleXLSX $oXlsx - Instance of the SimpleXLSX class
  **/
  private $oXlsx;

  /**
   * Xlsx::__construct()
   * The __construct method, it returns an instance of the class
   *
   * @param string $sFilePath - Path to the xlsx file to be interpreted
   * @param int $iIndexColumnGroupArrays - Which column to use to group the arrays
   * @throws \Exception if the file path is empty or the file cannot be opened
  **/
  public function __construct($sFilePath, $iIndexColumnGroupArrays) {
    if (empty($sFilePath)) {
      throw new \Exception('Path to the xlsx file is required');
    }

    $this->sFilePath = $sFilePath;
    $this->oXlsx = SimpleXLSX::parse($sFilePath);

    if (!$this->oXlsx) {
      throw new \Exception('Unable to open file');
    }

    if (empty($iIndexColumnGroupArrays) && $iIndexColumnGroupArrays !== 0) {
      throw new \Exception('Index column group arrays is required');
    }

    $this->iIndexColumnGroupArrays = $iIndexColumnGroupArrays;
  }


  /**
    * Xlsx::parseStudents()
    * Parse the students from the xlsx file
    *
    * @param Grade[] $aGrades - The grades of the students
    * @param Attendence[] $aAttendences - The attendences of the students
    *
    * @return Student[]
    * @throws \Exception if the file cannot be opened
    * @access public
   **/
  public function parseStudents($aGrades, $aAttendences) : array {
    if (!$this->oXlsx) {
      throw new \Exception('Unable to open file');
    }

    $aRows = $this->oXlsx->rows();
    unset($aRows[0]);

    $aStudents = [];
    foreach ($aRows as $sIndexRow => $aRow) {
      $sGroupValue = $aRow[$this->iIndexColumnGroupArrays];

      $aStudents[$sGroupValue] = new Student(
      $aRow[0],
      $aRow[1],
      $aRow[2],
      $aGrades[$sGroupValue],
      $aAttendences[$sGroupValue]
      );
    }

    return $aStudents;
  }

  /**
   * Xlsx::parseStudentGroupGrades()
   * Parse the grades from the xlsx file
   *
   * @param int $iFirstColumnGrade - The first column of the grades
   * @param int $iFinalColumnGrade - The final column of the grades
   *
   * @return Grade[]
   * @throw \Exception if the file cannot be opened
   **/
  public function parseStudentGroupGrades($iFirstColumnGrade, $iFinalColumnGrade) : array {
    if (!$this->oXlsx) {
      throw new \Exception('Unable to open file');
    }

    $aRows = $this->oXlsx->rows();
    
    $aHeader      = $aRows[0];
    $aGradesNames = [];
    foreach ($aHeader as $sIndex => $sContentHeader) {
      if ($sIndex < $iFirstColumnGrade || $sIndex > $iFinalColumnGrade) { continue; }
      $aGradesNames[$sIndex] = $sContentHeader;
    }

    $aGrades = [];
    unset($aRows[0]);

    foreach ($aRows as $sIndexRow => $aRow) {
      foreach ($aRow as $sIndexColumn => $sColumn) {
        if ($sIndexColumn < $iFirstColumnGrade || $sIndexColumn > $iFinalColumnGrade) { continue; }
        $aGrades[$aRow[$this->iIndexColumnGroupArrays]][] = new Grade($sColumn, $aGradesNames[$sIndexColumn]);
      }
    }

    return $aGrades;
  }

  /**
  * Xlsx::parseStudentGroupAttendences()
  * Return an array of Attendence objects from the xlsx file
  *
  * @return Attendence[]
  * @throws \Exception if the file cannot be opened
  **/
  public function parseStudentGroupAttendences() : array {
    if (!$this->oXlsx) {
      throw new \Exception('Unable to open file');
    }

    $aRows = $this->oXlsx->rows();
    
    $aHeader             = $aRows[0];
    $aAttendencesColumns = [];
    foreach ($aHeader as $sIndex => $sContentHeader) {
      if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $sContentHeader) || strtotime($sContentHeader)) {
        $aAttendencesColumns[] = $sIndex;
      }
    }

    $aAttendences = [];
    unset($aRows[0]);

    foreach ($aRows as $sIndexRow => $aRow) {
      foreach ($aRow as $sIndexColumn => $sColumn) {
        if (!in_array($sIndexColumn, $aAttendencesColumns)) { continue; }
        $aAttendences[$aRow[$this->iIndexColumnGroupArrays]][] = new Attendence($sColumn == 'f');
      }
    }

    return $aAttendences;
  }
}
