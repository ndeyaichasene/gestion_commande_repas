<?php


function listerLivreursDisponibles(array $livreurs): array
{
    return array_values(array_filter($livreurs, fn ($l) => $l['statut'] === 'Disponible'));
}