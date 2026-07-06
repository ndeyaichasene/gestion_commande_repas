<?php


function notifierClient(string $emailClient, string $message): void
{
    echo "\n[NOTIFICATION EMAIL -> $emailClient] : $message\n";
}



function notifierLivreur(string $telephoneLivreur, string $message): void
{
    echo "\n[NOTIFICATION SMS -> $telephoneLivreur] : $message\n";
}

