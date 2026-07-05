<?php

function showError(array $errors): void
{
    echo "\n--- Erreur(s) ---\n";
    foreach ($errors as $e) {
        echo "  - $e\n";
    }
    echo "-----------------\n\n";
}
