<?php

session_start();

include('config/config.php');
include('lib/files.fct.php');
include_once('./class/Security.php');

$title = 'Authentification';
$path = '.';
$vue = $path . '/tpl/login.phtml';
$errorMessage = [];

$checkUser = '';
$checkPwd = '';


try {

    if (array_key_exists('userNameAuth', $_POST) && array_key_exists('inputPassword', $_POST)) {

        $dbConnect = connectingToBdd();

        $checkPwd = hash('sha256',Security::bdd($_POST['inputPassword']));
        $checkUser = Security::bdd($_POST['userNameAuth']);

        $dbPrepare = $dbConnect -> prepare('SELECT idTripper, pseudo, password, firstName, admin, avatar FROM trippers WHERE pseudo = :pseudo');
        $dbPrepare -> execute(array('pseudo' => $checkUser));
        $user = $dbPrepare->fetch(PDO::FETCH_ASSOC);



        if ($checkPwd === $user['password'] && $user['admin']) {
            $_SESSION['logged'] = true;
            $_SESSION['admin'] = true;
            $_SESSION['user'] = Security::html($user['firstName']);
            $_SESSION['avatar'] = Security::html($user['avatar']);
            $_SESSION['pseudo'] = Security::html($user['pseudo']);
            $_SESSION['id'] = Security::html($user['idTripper']);

            header('Location:./admin/index.php');
            exit();
        } else if ($checkPwd === $user['password'] && !$user['admin']) {
            $_SESSION['logged'] = true;
            $_SESSION['admin'] = false;
            $_SESSION['user'] = Security::html($user['firstName']);
            $_SESSION['avatar'] = Security::html($user['avatar']);
            $_SESSION['pseudo'] = Security::html($user['pseudo']);
            $_SESSION['id'] = Security::html($user['idTripper']);

            header('Location:index.php');
        } else {
            throw new Exception("Le nom d'utilisateur ou le mot de passe est incorrect ou alors vous n'avez pas les droits requis pour entrer dans cette zone.");
        }
    }

} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
} catch (Exception $e) {
    $errorMessage[] = $e->getMessage();
} finally {
    include('tpl/layout.phtml');
}
