TripNoteBook
===========================

1. Objectif du projet
----------------------------------

Ce site a pour vocation d'être un carnet de voyage numérique. La présentation desktop sert de vitrine à l'application mobile.

Sur son mobile, l'utilisateur a la possibilité de prendre des photos et de les ajouter directement à son carnet.

2. Fonctionnalités
---------------------------------------

Le site contient 2 parties distinctes :
* La partie ADMIN ou bac-office
* La partie client ou front-office

Dans la partie ADMIN, seuls les administrateurs du site ont l'opportunité d'accéder aux informations de l'ensemble des membres. Notamment, l'édition, la suppression ou encore l'ajout ou le retrait de la possibilité d'être administrateur.

Dans la partie client, les visiteurs non enregistrés peuvent accéder aux carnets en ligne sans pour autant accéder à l'intégralité des informations de chaque carnet.

Une fois, enregistrés, cette possibilité est étendue aux seuls carnets des membres dont l'utilisateur est un *follower*.

Par ailleurs, le membre enregistré et connecté accède à son espace privé. Espace dans lequel il accède à l'ensemble de ses propres informations. Il peut les modifier intégralement ou morceau par morceau. S'il n'a pas encore de carnet, il peut également à partir de cet espace en créer un.

Les membres connectés peuvent échanger des messages privés via un espace chat.

Enfin, la création et l'édition d'un carnet ne sont accessibles qu'aux membres inscrites et connectés.

3. Mise en oeuvre
----------------------------

Le *CRUD* est la priorité de ce projet. Respectivement :

* L'inscription d'un nouveau membre
* L'édition des informations de ce membre
  * Depuis l'espace Admin
  * Depuis l'espace privé
* La suppression d'un membre
  * Depuis l'espace Admin
  * Depuis l'espace privé
* L'affichage de tous les membres inscrits (uniquement depuis l'espace Admin)
* L'affichage de toutes les informations du membre (depuis l'espace privé)

La création d'un carnet, l'ajout et l'édition du carnet, la possibilité d'y inscrire des commentaires et même de le supprimer sera la deuxième étape.

L'espace chat sera la dernière étape.
