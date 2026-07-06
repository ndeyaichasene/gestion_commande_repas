<?php

require_once dirname(__DIR__) . '/utils/validator.php';
require_once dirname(__DIR__) . '/utils/util.view.php';
require_once dirname(__DIR__). '/utils/error.php';
require_once dirname(__DIR__). '/services/commande.service.php';
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