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