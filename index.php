<?php

require_once __DIR__ . '/controllers/client.controller.php';
require_once __DIR__ . '/controllers/gerant.controller.php';



// ============================================================
//  FRONT CONTROLLER — menu principal
// ============================================================
global $plats,$commandes,$paiements;

consulterMenu($plats);   
passerCommande($plats, $commandes, $idClientConnecte); 
payerCommande($commandes, $paiements);
consulterHistorique($commandes, $idClientConnecte);
ajouterPlat($plats);
listerCommandesEnAttente($commandes);
validerCommande($commandes);
