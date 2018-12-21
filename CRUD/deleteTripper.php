<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');
include_once('../class/Security.php')

try {
  $dbConnect = connectingToBdd();

  if ($_SESSION['id'] > 1 && (array_key_exists('id', $_GET) && $_GET['id'] === $_SESSION['id'])) {
    $idTripper = Security::html($_GET['id']);

    $dbPrepapre = $dbConnect -> prepare('DELETE FROM trippers WHERE idTripper = :idTripper');
    $dbPrepapre -> execute(array('idTripper' => $idTripper));

    header('Location:../logout.php');
    }

  } catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
  }
