<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');
include_once('../class/Security.php');

try {
  $dbConnect = connectingToBdd();

  $dbCountries = listCountries($dbConnect);

  $dbprepare2 = $dbConnect -> prepare('SELECT * FROM trippers WHERE idTripper = :idTripper');
  $dbprepare2 -> execute(array('idTripper' => $_SESSION['id']));
  $dbResult = $dbprepare2 -> fetch(PDO::FETCH_ASSOC);

  if (array_key_exists('firstNameUpdate', $_POST) && array_key_exists('lastNameUpdate', $_POST) && array_key_exists('cityUpdate', $_POST) && array_key_exists('countryUpdate', $_POST) && array_key_exists('pseudoUpdate', $_POST) && array_key_exists('emailUpdate', $_POST) && array_key_exists('bioUpdate', $_POST)) {
    $firstNameUpdate = Security::bdd($_POST['firstNameUpdate']);
    $lastNameUpdate = Security::bdd($_POST['lastNameUpdate']);
    $pseudoUpdate = Security::bdd($_POST['pseudoUpdate']);
    $emailUpdate = Security::bdd($_POST['emailUpdate']);
    $cityUpdate = Security::bdd($_POST['cityUpdate']);
    $countryUpdate = Security::bdd($_POST['countryUpdate']);
    $bioUpdate = Security::bdd($_POST['bioUpdate']);

    $dbPrepare = $dbConnect -> prepare('UPDATE trippers SET firstName = :firstName, lastName = :lastName, email = :email, pseudo = :pseudo, city = :city, idCountry = :idCountry, bio = :bio WHERE idTripper = :idTripper');
    $dbPrepare -> execute(array(
        'firstName' => $firstNameUpdate,
        'lastName' => $lastNameUpdate,
        'email' => $emailUpdate,
        'pseudo' => $pseudoUpdate,
        'city' => $cityUpdate,
        'idCountry' => $countryUpdate,
        'bio' => $bioUpdate,
        'idTripper' => (int)$_SESSION['id']
      ));


  } else if (array_key_exists('initialPassword', $_POST) && array_key_exists('newPassword', $_POST) && array_key_exists('confirmNewPassword', $_POST)) {
   $pwd1 = Security::bdd($_POST['initialPassword']);
   $pwd2 = Security::bdd($_POST['newPassword']);
   $pwd3 = Security::bdd($_POST['confirmNewPassword']);

   if ($pwd2 == $pwd3)
   {
     $password = hash('sha256', $pwd2);
   }


     $dbPrepare3 = $dbConnect -> prepare('UPDATE trippers SET password = :password WHERE idTripper = :idTripper');
     $dbPrepare3 -> execute(array('password' => $password, 'idTripper' => $_SESSION['id']));

     header('Location: editTripper.php');
 }


} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}
