<?php

function ajouterPlatModel(array &$plats, array $plat): void
{
    $plats[] = $plat;
}

function trouverPlatParId(array $plats, int $idPlat): ?array
{
    foreach ($plats as $plat) {
        if ($plat['idPlat'] === $idPlat) {
            return $plat;
        }
    }
    return null;
}

function mettreAJourDisponibilitePlat(array &$plats, int $idPlat, bool $disponibilite): bool
{
    foreach ($plats as &$plat) {
        if ($plat['idPlat'] === $idPlat) {
            $plat['disponibilite'] = $disponibilite;
            return true;
        }
    }
    return false;
}