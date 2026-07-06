<?php


function transmettrePaiement(string $numeroCarte, float $montant): bool
{
    $clean = str_replace(' ', '', $numeroCarte);

  
    if (substr($clean, -4) === '0000') {
        return false; 
    }

    return true; 
}