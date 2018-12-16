<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

try {
  $dbConnect = connectingToBdd();

  if (!empty($_SESSION) && (int)$_SESSION['id'] > 0) {
    $dbPrepare = $dbConnect -> prepare('SELECT t.firstName, t.lastName, t.pseudo, t.email, t.city, t.avatar, t.bio, t.idCountry, p.nom_fr_fr, l.levelName, t.idTripper FROM trippers t INNER JOIN pays p ON p.idCountry = t.idCountry INNER JOIN level l ON t.idLevel = l.idLevel WHERE t.idTripper = :idTripper');

    $dbPrepare -> execute(array('idTripper' => $_SESSION['id']));
    $dbTripperEdit = $dbPrepare -> fetch(PDO::FETCH_ASSOC);
    $resultJson = json_encode($dbTripperEdit);
    echo $resultJson;


  } else {
    header('Location:../login.php');
  }
  } catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
  }
