<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

$error = array();
$title = 'Mon espace privé';
$path = '..';
$vue = $path . '/tpl/editTripper.phtml';
$error = [];


//var_dump($_SESSION);

try {
  $dbConnect = connectingToBdd();

  $dbCountries = listCountries($dbConnect);


  if (!empty($_SESSION) && (int)$_SESSION['id'] > 0) {
    $dbPrepare = $dbConnect -> prepare('SELECT t.firstName, t.lastName, t.pseudo, t.email, t.city, t.avatar, t.bio, t.idCountry, p.nom_fr_fr, l.levelName FROM trippers t INNER JOIN pays p ON p.idCountry = t.idCountry INNER JOIN level l ON t.idLevel = l.idLevel WHERE t.idTripper = :idTripper');

    $dbPrepare -> execute(array('idTripper' => $_SESSION['id']));
    $dbTripperEdit = $dbPrepare -> fetch(PDO::FETCH_ASSOC);

    //var_dump($dbTripperEdit);

    $dbprepare2 = $dbConnect -> prepare('SELECT departure, title FROM notebooks WHERE idTripper = :idTripper');
    $dbprepare2 -> execute(array('idTripper' => $_SESSION['id']));
    $dbNoteBooks = $dbprepare2 -> fetchAll(PDO::FETCH_ASSOC);

} else {
  header('Location:../login.php');
}
} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}

include('../tpl/layout.phtml');
