<?php
include('lib/config.php');
include('lib/files.fct.php');

try {
  $dbconnect = connectingToBdd();

  if (array_key_exists('data', $_GET) && array_key_exists('line',$_GET)) {
    $updateLine = (int)$_GET['data'];
    $updateProduct = $_GET['line'];

    $dbquery1 = $dbconnect -> query('SELECT productCode, productName FROM products');
    $dbProducts = $dbquery1 -> fetchAll(PDO::FETCH_ASSOC);

    if (array_key_exists('productsList', $_POST) && array_key_exists('quantity', $_POST) && array_key_exists('price', $_POST)) {
      $newProduct = $_POST['productsList'];
      $newQuantity = $_POST['quantity'];
      $newPrice = $_POST['price'];
      //var_dump($newProduct);
      $dbPrepare = $dbconnect -> prepare('UPDATE orderdetails SET productCode = :newProductCode, quantityOrdered = :quantity, priceEach = :price WHERE orderNumber = :orderNumber AND productCode = :productCode');
      $dbPrepare -> execute(array('newProductCode' => $newProduct, 'quantity' => $newQuantity, 'price' => $newPrice, 'orderNumber' => $updateLine, 'productCode' => $updateProduct));

      header('Location:result.php?data='.$updateLine);
    }

  }

  } catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
  }

include('tpl/head.phtml');
include('tpl/pageEdit.phtml');
include('tpl/footer.phtml');
