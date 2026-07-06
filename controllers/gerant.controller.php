<?php

require_once dirname(__DIR__). '/utils/validator.php';
require_once dirname(__DIR__). '/utils/util.view.php';
require_once dirname(__DIR__). '/utils/error.php';
require_once dirname(__DIR__). '/services/commande.service.php';
require_once dirname(__DIR__). '/services/livreur.service.php';
require_once dirname(__DIR__). '/services/notification.service.php';
require_once dirname(__DIR__). '/models/plat.model.php';
require_once dirname(__DIR__). '/models/livreur.model.php';
require_once dirname(__DIR__). '/models/commande.model.php';
require_once dirname(__DIR__). '/models/livreur.model.php';
require_once dirname(__DIR__) .'/models/tabGlobal.model.php';


function ajouterPlat(array &$plats): void
{
    $nom = saisie("Nom du plat");
    $prixSaisi = saisie("Prix (F)");
    $description = saisie("Description");

    $errors = [];
    required($nom, 'nom', $errors);
    positive($prixSaisi, 'prix', $errors);
    required($description, 'description', $errors);

    if (!empty($errors)) {
        showError($errors);
        return;
    }

    $idPlat = count($plats) + 1;
    ajouterPlatModel($plats, [
        'idPlat'        => $idPlat,
        'nom'           => $nom,
        'prix'          => (float) $prixSaisi,
        'description'   => $description,
        'disponibilite' => true,
    ]);

    echo "\nPlat \"$nom\" ajouté au catalogue avec succès (#$idPlat).\n";
}

function listerCommandesEnAttente(array $commandes): void
{
    afficherListeCommandes(recupererCommandesParStatut($commandes, 'En attente'));
}


function validerCommande(array &$commandes): void
{
    $commandesPayees = recupererCommandesParStatut($commandes, 'Payée');

    if (empty($commandesPayees)) {
        echo "\nAucune commande payée en attente de validation.\n";
        return;
    }

    afficherListeCommandes($commandesPayees);

    $idCommandeSaisi = saisie("Identifiant de la commande à valider");

    $errors = [];
    required($idCommandeSaisi, 'identifiant de la commande', $errors);
    if (!empty($errors)) {
        showError($errors);
        return;
    }
    $idCommande = (int) $idCommandeSaisi;

    $index = trouverIndexCommande($commandes, $idCommande);
    if ($index === null || $commandes[$index]['statut'] !== 'Payée') {
        showError(["Cette commande n'est pas éligible à la validation (doit être au statut Payée)."]);
        return;
    }

    $confirmation = saisie("Confirmer le lancement en préparation ? (o/n)");
    if (strtolower($confirmation) !== 'o') {
        echo "\nOpération annulée.\n";
        return;
    }

    // RG3 : mise à jour du statut.
    mettreAJourStatutCommande($commandes, $idCommande, 'En préparation');

    // RG4 : notification automatique du client.
    notifierClient("client{$commandes[$index]['idClient']}@mail.com", "Votre commande #$idCommande est en préparation.");

    echo "\nCommande #$idCommande mise en préparation. Client notifié.\n";
}

function assignerLivreur(array &$commandes, array &$livreurs): void
{
    $idCommandeSaisi = saisie("Identifiant de la commande prête à expédier");

    $errors = [];
    required($idCommandeSaisi, 'identifiant de la commande', $errors);
    if (!empty($errors)) {
        showError($errors);
        return;
    }
    $idCommande = (int) $idCommandeSaisi;

    $index = trouverIndexCommande($commandes, $idCommande);
    if ($index === null || $commandes[$index]['statut'] !== 'En préparation') {
        showError(["Cette commande n'est pas prête à être expédiée."]);
        return;
    }

    // RG2 : affichage des livreurs disponibles.
    $livreursDisponibles = listerLivreursDisponibles($livreurs);
    if (empty($livreursDisponibles)) {
        echo "\nAucun livreur disponible pour le moment.\n";
        return;
    }
    afficherListeLivreurs($livreursDisponibles);

    $idLivreurSaisi = saisie("Identifiant du livreur à assigner");

    $errors = [];
    required($idLivreurSaisi, 'identifiant du livreur', $errors);
    if (!empty($errors)) {
        showError($errors);
        return;
    }
    $idLivreur = (int) $idLivreurSaisi;

    $livreur = trouverLivreurParId($livreurs, $idLivreur);
    if ($livreur === null || $livreur['statut'] !== 'Disponible') {
        showError(["Ce livreur n'est pas disponible."]);
        return;
    }

    // RG3 : confirmation de l'assignation.
    $confirmation = saisie("Confirmer l'assignation de {$livreur['nom']} ? (o/n)");
    if (strtolower($confirmation) !== 'o') {
        echo "\nAssignation annulée.\n";
        return;
    }

    // RG4 : mise à jour des statuts + notification.
    assignerLivreurCommande($commandes, $idCommande, $idLivreur);
    mettreAJourStatutLivreur($livreurs, $idLivreur, 'Occupé');
    notifierLivreur($livreur['telephone'], "Nouvelle livraison assignée : commande #$idCommande.");

    echo "\nLivreur {$livreur['nom']} assigné à la commande #$idCommande avec succès.\n";
}
