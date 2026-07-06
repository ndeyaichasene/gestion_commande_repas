<?php

require_once dirname(__DIR__) . '/utils/validator.php';
require_once dirname(__DIR__) . '/utils/util.view.php';
require_once dirname(__DIR__). '/utils/error.php';
require_once dirname(__DIR__). '/services/commande.service.php';
require_once dirname(__DIR__). '/services/notification.service.php';
require_once dirname(__DIR__). '/models/plat.model.php';
require_once dirname(__DIR__). '/models/commande.model.php';
require_once dirname(__DIR__) . '/models/tabGlobal.model.php';


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

    
    mettreAJourStatutCommande($commandes, $idCommande, 'En préparation');

    
    notifierClient("client{$commandes[$index]['idClient']}@mail.com", "Votre commande #$idCommande est en préparation.");

    echo "\nCommande #$idCommande mise en préparation. Client notifié.\n";
}
