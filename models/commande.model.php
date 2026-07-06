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