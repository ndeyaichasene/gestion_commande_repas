<?php

require_once __DIR__ . '/controllers/client.controller.php';
require_once __DIR__ . '/controllers/gerant.controller.php';



// ============================================================
//  FRONT CONTROLLER — menu principal
// ============================================================

function afficherMenuPrincipal(): void
{
    echo "\n============================================\n";
    echo "   VITESERVI - GESTION DE COMMANDES\n";
    echo "============================================\n";
    echo " -- ESPACE CLIENT --\n";
    echo " 1. Consulter le menu\n";
    echo " 2. Passer une commande\n";
    echo " 3. Payer une commande\n";
    echo " 4. Consulter mon historique\n";
    echo " -- ESPACE GÉRANT --\n";
    echo " 5. Ajouter un plat au catalogue\n";
    echo " 6. Lister les commandes en attente\n";
    echo " 7. Valider une commande (statut Payée)\n";
    echo " 8. Assigner un livreur\n";
    echo " 0. Quitter\n";
    echo "============================================\n";
}

do {
    afficherMenuPrincipal();
    global $plats, $commandes,$paiements, $livreurs;
    $choix = saisie("Votre choix");

    switch ($choix) {
        case '1':
            consulterMenu($plats);
            break;
        case '2':
            passerCommande($plats, $commandes, $idClientConnecte);
            break;
        case '3':
            payerCommande($commandes, $paiements);
            break;
        case '4':
            consulterHistorique($commandes, $idClientConnecte);
            break;
        case '5':
            ajouterPlat($plats);
            break;
        case '6':
            listerCommandesEnAttente($commandes);
            break;
        case '7':
            validerCommande($commandes);
            break;
        case '8':
            assignerLivreur($commandes, $livreurs);
            break;
        case '0':
            echo "\nAu revoir !\n";
            break;
        default:
            echo "\nChoix invalide, veuillez réessayer.\n";
    }
} while ($choix !== '0');
