<?php

session_start();

include_once('./config/config.php');
include_once('./lib/files.fct.php');
//ini_set('display_errors',1);

$error = array();
$title = 'Inscription';
$path = '.';
$vue = $path . '/tpl/addTripper.phtml';
$pays = explode('-', explode(',', $GLOBALS['_SERVER']['HTTP_ACCEPT_LANGUAGE'])[0])[1];

try {
  $dbConnect = connectingToBdd();



  $dbCountries = listCountries($dbConnect);

  //Test sur l'existence du pseudo
  if (array_key_exists('inputPseudo', $_GET) && array_key_exists('inputEmail', $_GET)) {
    $pseudoTest = $_GET['inputPseudo'];
    $emailTest = $_GET['inputEmail'];
    $dbQuery3 = $dbConnect -> prepare('SELECT COUNT(*) AS nb FROM trippers WHERE pseudo = :pseudo OR email= :email');
    $dbQuery3 -> execute(array('pseudo' => $pseudoTest, 'email' => $emailTest));
    $res = $dbQuery3 -> fetch(PDO::FETCH_ASSOC);
    if ($res['nb'] != 0)
      $error[] = 'Ce pseudo ou cet email existe déjà.';
    if (strlen($pseudoTest) > 50) {
      $error[] = 'Le pseudo que vous avez choisi est trop long, merci d\'en choisir un plus court.';
    }
  }
} catch (PDOException $e) {

}
include('./tpl/layout.phtml');
