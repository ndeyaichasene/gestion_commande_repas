<?php

function verifierDisponibilite(array $plats, int $idPlat): bool
{
    $plat = trouverPlatParId($plats, $idPlat);
    return $plat !== null && $plat['disponibilite'] === true;
}

function rechercherPlatsDisponibles(array $plats): array
{
    return array_values(array_filter($plats, fn ($p) => $p['disponibilite'] === true));
}