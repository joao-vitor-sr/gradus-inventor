<?php

require 'vendor/autoload.php';

$oXlsx        = new GradusInventor\Xlsx('data.xlsx', 0);
$aAttendences = $oXlsx->parseStudentGroupAttendences();
$aGrades      = $oXlsx->parseStudentGroupGrades(3, 7);
$aStudents    = $oXlsx->parseStudents($aGrades, $aAttendences);

var_dump($aStudents);
$sExampleStudentRegistration = '45454';
var_dump($aStudents[$sExampleStudentRegistration]);
