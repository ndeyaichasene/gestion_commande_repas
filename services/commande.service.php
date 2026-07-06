<?php

function calculerMontantTotal(array $panier): float
{
    $total = 0.0;
    foreach ($panier as $ligne) {
        $total += $ligne['prix'] * $ligne['quantite'];
    }
    return $total;
}

function recupererCommandesParStatut(array $commandes, string $statut): array
{
    return array_values(array_filter($commandes, fn ($c) => $c['statut'] === $statut));
}

function recupererHistoriqueClient(array $commandes, int $idClient): array
{
    return array_values(array_filter($commandes, fn ($c) => $c['idClient'] === $idClient));
}