<?php

session_start();

include('config/config.php');
include('lib/files.fct.php');

$title = 'Authentification';
$path = '.';
$vue = $path . '/tpl/login.phtml';
$errorMessage = [];

$checkUser = '';
$checkPwd = '';


try {

    if (array_key_exists('userNameAuth', $_POST) && array_key_exists('inputPassword', $_POST)) {
        $checkPwd = hash('sha256',$_POST['inputPassword']);
        $checkUser = $_POST['userNameAuth'];

        $dbConnect = connectingToBdd();
        $dbPrepare = $dbConnect -> prepare('SELECT idTripper, pseudo, password, firstName, admin, avatar FROM trippers WHERE pseudo = :pseudo');
        $dbPrepare -> execute(array('pseudo' => $checkUser));
        $user = $dbPrepare->fetch(PDO::FETCH_ASSOC);



        if ($checkPwd === $user['password'] && $user['admin']) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $user['firstName'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['idTripper'];

            header('Location:./admin/index.php');
            exit();
        } else if ($checkPwd === $user['password'] && !$user['admin']) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $user['firstName'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['idTripper'];

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
