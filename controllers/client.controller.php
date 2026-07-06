<?php

require_once dirname(__DIR__) . '/utils/validator.php';
require_once dirname(__DIR__ ). '/utils/util.view.php';
require_once dirname(__DIR__ ). '/utils/error.php';
require_once dirname(__DIR__ ). '/services/plat.service.php';
require_once dirname(__DIR__ ). '/services/commande.service.php';
require_once dirname(__DIR__ ). '/models/commande.model.php';
require_once dirname(__DIR__ ). '/models/tabGlobal.model.php';


function consulterMenu(array $plats): void
{
    afficherMenu(rechercherPlatsDisponibles($plats));
}

function passerCommande(array $plats, array &$commandes, int $idClient): void
{
    $panier = [];

    echo "\nComposez votre panier (laissez l'identifiant du plat vide pour terminer).\n";

    do {
        afficherMenu(rechercherPlatsDisponibles($plats));
        $idPlatSaisi = saisie("Identifiant du plat à ajouter (vide pour terminer)");

        if ($idPlatSaisi === '') {
            break;
        }

        $errors = [];
        required($idPlatSaisi, 'identifiant du plat', $errors);
        if (!empty($errors)) {
            showError($errors);
            continue;
        }

        $idPlat = (int) $idPlatSaisi;
        $quantiteSaisie = saisie("Quantité");

        $errors = [];
        positive($quantiteSaisie, 'quantité', $errors);
        if (!empty($errors)) {
            showError($errors);
            continue;
        }
        $quantite = (int) $quantiteSaisie;

        // RG2 : le système vérifie la disponibilité de chaque plat.
        if (!verifierDisponibilite($plats, $idPlat)) {
            showError(["Ce plat est indisponible."]);
            continue;
        }

        $plat = trouverPlatParId($plats, $idPlat);
        $panier[] = [
            'idPlat'   => $plat['idPlat'],
            'nom'      => $plat['nom'],
            'prix'     => $plat['prix'],
            'quantite' => $quantite,
        ];

        echo "-> {$plat['nom']} ajouté au panier.\n";
    } while (true);

    if (empty($panier)) {
        echo "\nPanier vide, commande annulée.\n";
        return;
    }

    // RG3 : le système calcule le montant total de la commande.
    $montantTotal = calculerMontantTotal($panier);
    afficherRecapitulatif($panier, $montantTotal);

    $confirmation = saisie("Confirmer la commande ? (o/n)");

    // RG4 : le client valide la commande, statut "En attente".
    if (strtolower($confirmation) !== 'o') {
        echo "\nCommande annulée par le client.\n";
        return;
    }

    $idCommande = count($commandes) + 1;
    creerCommandeModel($commandes, [
        'idCommande'    => $idCommande,
        'idClient'      => $idClient,
        'plats'         => $panier,
        'dateCommande'  => date('d/m/Y H:i'),
        'statut'        => 'En attente',
        'montantTotal'  => $montantTotal,
        'idLivreur'     => null,
    ]);

    echo "\nCommande #$idCommande enregistrée avec succès. Statut : En attente\n";
}

function consulterHistorique(array $commandes, int $idClient): void
{
    afficherListeCommandes(recupererHistoriqueClient($commandes, $idClient));
}