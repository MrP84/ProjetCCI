<?php

session_start();
//var_dump($_SESSION);
if (!$_SESSION['logged']) {
header('Location:../login.php');
//$_SESSION
}

include('../config/config.php');
include('../lib/files.fct.php');

$title = 'Accueil Admin';
$path = '..';
$vue = $path . '/tpl/indexAdmin.phtml';



try {
  $dbConnect = connectingToBdd();

  $dbPrepare = $dbConnect -> prepare('SELECT t.idTripper, t.firstName, t.email, t.lastName, t.avatar, t.bio, t.pseudo, DATE_FORMAT(t.dateOfBirth, "%d/%m/%Y") AS dateToCompute, DATE_FORMAT(t.dateOfRegister, "%d/%m/%Y") AS registerDate, l.levelName, p.nom_fr_fr FROM trippers t INNER JOIN pays p ON t.idCountry = p.idCountry INNER JOIN level l ON t.idLevel = l.idLevel ORDER BY t.idTripper');

   $dbPrepare -> execute();
   $dbResult = $dbPrepare->fetchAll(PDO::FETCH_ASSOC);

   //$age = age($dbResult[0]['dateToCompute']);
   //$age = age('08/03/1984');
   //var_dump($dbResult);

 } catch (PDOException $e) {
   echo 'Erreur de connexion : ' . $e->getMessage();
 }

   include('../tpl/layout.phtml');
