<?php

require_once __DIR__ . '/controllers/client.controller.php';
require_once __DIR__ . '/controllers/gerant.controller.php';



// ============================================================
//  FRONT CONTROLLER — menu principal
// ============================================================
global $plats,$commandes;

consulterMenu($plats);   
passerCommande($plats, $commandes, $idClientConnecte); 
consulterHistorique($commandes, $idClientConnecte);
