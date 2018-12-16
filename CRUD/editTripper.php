<?php

session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

$error = array();
$title = 'Mon espace privé';
$path = '..';
$vue = $path . '/tpl/editTripper.phtml';
$error = [];




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



    // $dbprepare = $dbConnect -> prepare('SELECT c.customerName, c.contactLastName, c.contactFirstName, c.phone, c.addressLine1, c.addressLine2, c.city, c.state, c.postalCode, c.country, e.lastName, e.firstName, e.employeeNumber
    //                                   FROM customers c
    //                                   INNER JOIN employees e
    //                                   ON c.salesRepEmployeeNumber = e.employeeNumber
    //                                   WHERE customerNumber= :customerNb');
    // $dbprepare2 -> execute(array('customerNb' => $editCustomerNb));
    // $dbCustomerInfos = $dbprepare2 -> fetchAll(PDO::FETCH_ASSOC);
    //
    // // var_dump($dbCustomerInfos);
    // // var_dump($dbEmployees);
    //
    // if (array_key_exists('firstName', $_POST) && array_key_exists('lastName', $_POST) && array_key_exists('customName', $_POST) && array_key_exists('phoneNb', $_POST) && array_key_exists('address1', $_POST) && array_key_exists('address2', $_POST) && array_key_exists('postCode', $_POST) && array_key_exists('customCity', $_POST) && array_key_exists('customCountry', $_POST) && array_key_exists('associatedVendor', $_POST)) {
    //   $newFirstName = $_POST['firstName'];
    //   $newLastName = $_POST['lastName'];
    //   $newCustomName = $_POST['customName'];
    //   $newPhoneNb = $_POST['phoneNb'];
    //   $newAddress1 = $_POST['address1'];
    //   $newAddress2 = $_POST['address2'];
    //   $newPostCode = $_POST['postCode'];
    //   $newCustomCity = $_POST['customCity'];
    //   $newCustomCountry = $_POST['customCountry'];
    //   $newAssociatedVendor = $_POST['associatedVendor'];
    //
    //   $dbPrepare3 = $dbconnect -> prepare('UPDATE customers SET customerName = :newcustomerName, contactLastName = :newcontactLastName, contactFirstName = :newcontactFirstName, phone = :newphone, addressLine1 = :newaddressLine1, addressLine2 = :newaddressLine2, city = :newcity, postalCode = :newpostalCode, country = :newcountry, salesRepEmployeeNumber = :newsalesRepEmployeeNumber WHERE customerNumber = :customerNumber');
    //   $dbPrepare3 -> execute(array('newcustomerName' => $newCustomName, 'newcontactLastName' => $newLastName,
    //   'newcontactFirstName' => $newFirstName,
    //   'newphone' => $newPhoneNb,
    //   'newaddressLine1' => $newAddress1,
    //   'newaddressLine2' => $newAddress2,
    //   'newcity' => $newCustomCity, 'newsalesRepEmployeeNumber' => $newAssociatedVendor,'customerNumber' => $editCustomerNb, 'newpostalCode' => $newPostCode, 'newcountry' => $newCustomCountry));
    //
    //   header('Location:result.php?data='.$backPageNb);
    // }

} else {
  header('Location:../login.php');
}
} catch (PDOException $e) {
  echo 'Erreur de connexion : ' . $e->getMessage();
}

include('../tpl/layout.phtml');
