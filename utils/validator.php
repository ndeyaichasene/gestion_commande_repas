<?php


function required(string $value, string $nom, array &$errors): void
{
    if ($value === null || trim((string) $value) === '') {
        $errors[] = "Le champ \"$nom\" est obligatoire.";
    }
}


function positive(string $value, string $nom, array &$errors): void
{
    if (!is_numeric($value) || (float) $value <= 0) {
        $errors[] = "Le champ \"$nom\" doit être un nombre positif.";
    }
}

function validDate(string $value, string $nom, array &$errors): void
{
    $d = DateTime::createFromFormat('d/m/Y', $value);
    if (!$d || $d->format('d/m/Y') !== $value) {
        $errors[] = "Le champ \"$nom\" doit être une date valide (JJ/MM/AAAA).";
    }
}


function validNumeroCarte(string $value, array &$errors): void
{
    $clean = str_replace(' ', '', $value);
    if (!preg_match('/^\d{16}$/', $clean)) {
        $errors[] = "Le numéro de carte doit contenir 16 chiffres.";
    }
}