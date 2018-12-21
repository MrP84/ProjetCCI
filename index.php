<?php
session_start();
include('config/config.php');
include('lib/files.fct.php');
//ini_set('display_errors',1);

$title = "Votre carnet de voyage numérique";
$image = "img/accueil.jpg";
$path = '.';
$vue = $path . '/tpl/index.phtml';
$index = true;
//var_dump($index);

//input date is the next friday
$shift = date('N');
switch ($shift) {
  case 1:
    $shift = 4;
    break;
  case 2:
    $shift = 3;
    break;
  case 3:
    $shift = 2;
    break;
  case 4:
    $shift = 1;
    break;
  case 6:
    $shift = 6;
    break;
  case 7:
    $shift = 5;
    break;
  default:
    $shift = 0;
    break;
}
$day = date('d') + $shift;
$day<10?$departure = date('Y-m-').'0'.$day:$departure = date('Y-m-').$day;


include('tpl/layout.phtml');
