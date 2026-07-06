<?php

function creerCommandeModel(array &$commandes, array $commande): void
{
    $commandes[] = $commande;
}


function trouverIndexCommande(array $commandes, int $idCommande): ?int
{
    foreach ($commandes as $index => $commande) {
        if ($commande['idCommande'] === $idCommande) {
            return $index;
        }
    }
    return null;
}

function mettreAJourStatutCommande(array &$commandes, int $idCommande, string $statut): bool
{
    $index = trouverIndexCommande($commandes, $idCommande);
    if ($index === null) {
        return false;
    }
    $commandes[$index]['statut'] = $statut;
    return true;
}

function assignerLivreurCommande(array &$commandes, int $idCommande, int $idLivreur): bool
{
    $index = trouverIndexCommande($commandes, $idCommande);
    if ($index === null) {
        return false;
    }
    $commandes[$index]['idLivreur'] = $idLivreur;
    $commandes[$index]['statut'] = 'En livraison';
    return true;
}