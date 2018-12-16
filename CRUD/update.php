<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

var_dump($_POST);

if (array_key_exists('firstNameUpdate', $_POST) && array_key_exists('lastNameUpdate', $_POST) && array_key_exists('cityUpdate', $_POST) && array_key_exists('countryUpdate', $_POST) && array_key_exists('pseudoUpdate', $_POST) && array_key_exists('emailUpdate', $_POST) && array_key_exists('bioUpdate', $_POST)) {
  $firstNameUpdate = $_POST['firstNameUpdate'];
  $lastNameUpdate = $_POST['lastNameUpdate'];
  $pseudoUpdate = $_POST['pseudoUpdate'];
  $emailUpdate = $_POST['emailUpdate'];
  $cityUpdate = $_POST['cityUpdate'];
  $countryUpdate = $_POST['countryUpdate'];
  $bioUpdate = $_POST['bioUpdate'];

  var_dump($bioUpdate);
} else {
  var_dump($_POST);
}

try {
  $dbConnect = connectingToBdd();

  $dbCountries = listCountries($dbConnect);

  $dbPrepare = $dbConnect -> prepare('UPDATE trippers SET firstName = :firstName, lastName = :lastName, email = :email, pseudo = :pseudo, city = :city, idCountry = :idCountry, bio = :bio WHERE idTripper = :idTripper');
  $dbPrepare -> execute(array(
    'firstName' => $firstNameUpdate,
    'lastName' => $lastNameUpdate,
    'email' => $emailUpdate,
    'pseudo' => $pseudoUpdate,
    'city' => $cityUpdate,
    'idcountry' => $countryUpdate,
    'bio' => $bioUpdate,
    'idTripper' => $_SESSION['id']
  ));

  echo 'Update ok';

} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}

header('Location: editTripper.php');
