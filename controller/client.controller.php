<?php

require_once dirname(__DIR__) . '/utils/validator.php';
require_once dirname(__DIR__ ). '/utils/view.php';
require_once dirname(__DIR__ ). '/utils/error.php';
require_once dirname(__DIR__ ). '/models/tabGlobal.model.php';


function consulterMenu(array $plats): void
{
    afficherMenu(rechercherPlatsDisponibles($plats));
}