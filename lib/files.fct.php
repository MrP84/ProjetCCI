<?php


function connectingToBdd() {

    $dbconnect = new PDO(DB_DSN,DB_USER,DB_PWD);
    $dbconnect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $dbconnect;
}

function listCountries($dbConnect) {

  $dbQuery2 = $dbConnect -> prepare('SELECT nom_fr_fr, idCountry, alpha2 FROM pays');
  $dbQuery2 -> execute();
  $dbCountries = $dbQuery2 -> fetchAll(PDO::FETCH_ASSOC);

  return $dbCountries;
}

function nouvelleImage($fichier) {
  //nouvelle taille d'image
  $largeur = 50;
  $hauteur = 50;

  //récupération des infos de l'image uploadée et attribution de nouvelles valeurs
  $nomDepart = pathinfo($fichier)['filename'];
  $nomCompletDepart = pathinfo($fichier)['basename'];
  $nomArrivee = $nomDepart.'_50x50.jpeg';
  $dossier = pathinfo($fichier)['dirname'].'/'.$nomArrivee;

  //récupération des dimensions de l'image d'origine
  list($largeurDepart, $hauteurDepart) = getimagesize($fichier);
  $rapportDepart = $largeurDepart/$hauteurDepart;

  //adaptation des nouvelles tailles pour conserver le rapport
    if ($largeur/$hauteur > $rapportDepart)
     $largeur = $hauteur * $rapportDepart;
     else
     $hauteur = $largeur / $rapportDepart;

  //on crée une image avec les nouvelles dimensions
  $imageRedimensionnee = imagecreatetruecolor($largeur, $hauteur);
  $imageDeDepart = imagecreatefromjpeg($fichier);

  //enfin on redimensionne l'image !!
  imagecopyresampled($imageRedimensionnee, $imageDeDepart, 0, 0, 0, 0, $largeur, $hauteur, $largeurDepart, $hauteurDepart);

  //On crée donc une image à partir de l'image redimensionnée
  $imageCree = imagejpeg($imageRedimensionnee, $dossier);
  //On la copie dans le dossier d'où elle vient
  copy($dossier, $nomArrivee);
  //On supprime le fichier crée à la racine du dossier
  unlink($nomArrivee);
  return $dossier;
}

function age($date) {
    $am = explode('/', $date);
    $an = explode('/', date('d/m/Y'));

    if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
    return $an[2] - $am[2];

    return $an[2] - $am[2] - 1;
}

function wordCut($str, $split = 50) {
	if(intval($split) == 0) return $str;

	if(strlen($str) > $split) {
		return substr(trim($str), 0, $split).'(...)';
	}
	else
		return $str;
}
