<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

try {
  $dbConnect = connectingToBdd();

  $dbPrepare = $dbConnect -> prepare('SELECT password FROM trippers WHERE idTripper = :idTripper');
  $dbPrepare -> execute(array('idTripper' => $_SESSION['id']));
  $dbPwd = $dbPrepare -> fetch(PDO::FETCH_ASSOC);

  if (array_key_exists('pwdKey', $_POST)) {
    $checkPwd = $_POST['pwdKey'];

    if ($checkPwd === $dbPwd['password']) {
      echo 'ok';
    } else {
      echo 'ko';
    }

  }
} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}
