<?php

function trouverPlatParId(array $plats, int $idPlat): ?array
{
    foreach ($plats as $plat) {
        if ($plat['idPlat'] === $idPlat) {
            return $plat;
        }
    }
    return null;
}