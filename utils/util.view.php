<?php

function saisie(string $message): string
{
    return trim(readline($message . " : "));
}