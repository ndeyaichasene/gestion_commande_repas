<?php

function mettreAJourStatutLivreur(array &$livreurs, int $idLivreur, string $statut): bool
{
    foreach ($livreurs as &$livreur) {
        if ($livreur['idLivreur'] === $idLivreur) {
            $livreur['statut'] = $statut;
            return true;
        }
    }
    return false;
}


function trouverLivreurParId(array $livreurs, int $idLivreur): ?array
{
    foreach ($livreurs as $livreur) {
        if ($livreur['idLivreur'] === $idLivreur) {
            return $livreur;
        }
    }
    return null;
}