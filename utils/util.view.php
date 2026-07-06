<?php

function saisie(string $message): string
{
    return trim(readline($message . " : "));
}

function afficherMenu(array $plats): void
{
    echo "\n=== MENU DU RESTAURANT ===\n";
    foreach ($plats as $plat) {
        $dispo = $plat['disponibilite'] ? 'Disponible' : 'Indisponible';
        printf(
            "  [%d] %-20s %6.0f F  (%s)\n         %s\n",
            $plat['idPlat'],
            $plat['nom'],
            $plat['prix'],
            $dispo,
            $plat['description']
        );
    }
    echo "==========================\n";
}

function afficherRecapitulatif(array $panier, float $montantTotal): void
{
    echo "\n--- Récapitulatif de la commande ---\n";
    foreach ($panier as $ligne) {
        printf("  %d x %s\n", $ligne['quantite'], $ligne['nom']);
    }
    printf("Montant total : %.0f F\n", $montantTotal);
    echo "-------------------------------------\n";
}

function afficherListeCommandes(array $commandes): void
{
    if (empty($commandes)) {
        echo "\nAucune commande à afficher.\n";
        return;
    }
    echo "\n=== COMMANDES ===\n";
    foreach ($commandes as $c) {
        printf(
            "  [%d] Client #%d - Statut: %-14s - Total: %6.0f F - Date: %s\n",
            $c['idCommande'],
            $c['idClient'],
            $c['statut'],
            $c['montantTotal'],
            $c['dateCommande']
        );
    }
    echo "==================\n";
}
