<?php
session_start();

include_once('../config/config.php');
include_once('../lib/files.fct.php');

$error = array();
$title = 'Inscription';
$path = '..';
$vue = $path . '/tpl/addTripper.phtml';
$pays = explode('-', explode(',', $GLOBALS['_SERVER']['HTTP_ACCEPT_LANGUAGE'])[0])[1];

echo 'début du script<br>';
try {

  $dbConnect = connectingToBdd();

  $dbQuery1 = $dbConnect -> prepare('SELECT MAX(idTripper) FROM trippers');
  $dbQuery1 -> execute();
  $NbTrippers = $dbQuery1 -> fetch();
  $idNewDir = (string)((int)$NbTrippers[0] + 1);


  //Cas addition d'un nouvel utilisateur
  if (array_key_exists('firstName', $_POST) && array_key_exists('lastName', $_POST) && array_key_exists('bio', $_POST) && array_key_exists('country', $_POST) && array_key_exists('city', $_POST) && array_key_exists('dateOfBirth', $_POST) && array_key_exists('password1', $_POST) && array_key_exists('password2', $_POST) && array_key_exists('avatar', $_FILES) && array_key_exists('email', $_POST)) {

    echo 'lancement des tests<br>';
    //test du mot de passe

    $pwd1 = $_POST['password1'];
    $pwd = $_POST['password2'];

    if ($pwd1 == $pwd)
    {
      $password = password_hash($pwd, PASSWORD_DEFAULT);
    }
    else
    {
      $error[] = 'Les mots de passe ne sont pas identiques';
    }


    //Validité de l'adresse mail

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    $error[] = 'Cette adresse email n\'est pas valide.';
    else {
      $email = $_POST['email'];
      echo 'email validée<br>';
    }


    //Traitement des autres données saisies
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $bio = $_POST['bio'];
    $pseudo = $_POST['pseudo'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $level = 1;

    if (!empty($error)) {
      echo 'Erreurs !!<br>';
      foreach ($error as $key => $value) {
        echo $value;
      }

    } else {
      echo 'coucou<br>';
      $dbprepare = $dbConnect -> prepare('INSERT INTO trippers(firstName, lastName, email, password, pseudo, dateOfBirth, city, idCountry, bio,  idLevel) VALUES (:firstName, :lastName, :email, :password, :pseudo, :dateOfBirth, :city, :country, :bio, :level)');

      $dbprepare -> execute(array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $password,
        'pseudo' => $pseudo,
        'dateOfBirth' => $dateOfBirth,
        'city' => $city,
        'country' => $country,
        'bio' => $bio,
        'level' => $level));

        $idTripper = $dbConnect -> lastInsertId();

        //test sur l'image
        if ($idTripper > 0 && array_key_exists('avatar', $_FILES) && $_FILES['avatar']['error'] == 0) {
          if ($_FILES['avatar']['size'] <= 200000) {

            //pathinfo renvoie un array
            $infosFichier = pathinfo($_FILES['avatar']['name']);
            $extensionUpload = $infosFichier['extension'];
            $extensionsAuth = array('pdf', 'png', 'jpg', 'jpeg');
            $nameUpload = $infosFichier['filename'];

            if (in_array($extensionUpload, $extensionsAuth)) {
              $structure = '../users/';
              //mkdir($structure.'avatars/', 0766, true);
              chmod($structure, 0766);
              chmod('../users/', 0766);
              // envoi du fichier avec move_uploaded_file
              move_uploaded_file($_FILES['avatar']['tmp_name'], $structure.'avatars/'.$idTripper.'.'.$extensionUpload);
              $urlAvatar1 = $structure.'avatars/'.$idTripper.'.'.$extensionUpload;

              $urlAvatar = nouvelleImage($urlAvatar1);
            } else
            $error[] = 'l\'extension du fichier n\'est pas reconnue. Merci de choisir parmi .pdf, .png, .jpg et .jpeg';

          } else
          $error[] = 'la taille du fichier dépasse 200 ko';

        } else {
          $structure = '../users/';
          mkdir($structure.'avatars/', 0766, true);
          chmod($structure, 0766);
          chmod('../users/', 0766);
          $urlAvatar = '../uploads/default.png';
        }

        $dbprepare2 = $dbConnect -> prepare('UPDATE trippers SET avatar = :avatar, personalFile = :personalFile WHERE idTripper = :idTripper');
        $dbprepare2 -> execute(array(
          'avatar' => $urlAvatar,
          'personalFile' => $structure,
          'idTripper' => $idTripper
        ));

        $_SESSION['logged'] = true;
        $_SESSION['user'] = $firstName;
        $_SESSION['avatar'] = $urlAvatar;
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['id'] = $idTripper;
        header('Location:../index.php');
      }
    } else {
      $error[] = 'merci de remplir tous les champs';
      echo 'Oh non... tous les champs ne sont pas remplis<br>';
    }

  } catch (PDOException $e) {
    $error[] = $e->getMessage();
  } catch (Exception $e) {
    $error[] = $e->getMessage();
  }

  if (!empty($error)) {
    echo 'Erreurs !!<br><ul>';
    foreach ($error as $key => $value) {
      echo
      '<li>' .
      $value .
      '</li>';
    }
    echo '</ul>';
  }

  include('../tpl/layout.phtml');
  header('Location:../index.php');
