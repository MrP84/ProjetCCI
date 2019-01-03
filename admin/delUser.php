<?php

session_start();
//var_dump($_SESSION);
if (!$_SESSION['logged'] || !$_SESSION['admin']) {
header('Location:../login.php');
//$_SESSION
}

include('../config/config.php');
include('../lib/files.fct.php');
include_once('../class/Security.php');

try {

  $dbConnect = connectingToBdd();

  if ($_SESSION['id'] && $_SESSION['admin'] && (array_key_exists('id', $_GET) && $_GET['id'] !== 1)) {
    $idTripper = Security::html($_GET['id']);

    $dbPrepapre = $dbConnect -> prepare('DELETE FROM trippers WHERE idTripper = :idTripper');
    $dbPrepapre -> execute(array('idTripper' => $idTripper));

    header('Location:index.php');
  } else {
    echo "vous n'avez pas le droit de supprimer cet utilisateur ! (non mais pour qui vous vous prenez ?!??)";
  }

  } catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
  }
