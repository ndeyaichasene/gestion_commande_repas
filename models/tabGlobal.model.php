<?php



// ============================================================
//  TABLEAU GLOBAL (MÉMOIRE) — remplace une vraie base de données
// ============================================================

$plats = [
    ['idPlat' => 1, 'nom' => 'Burger Classic',  'prix' => 2500, 'description' => 'Steak, cheddar, salade', 'disponibilite' => true],
    ['idPlat' => 2, 'nom' => 'Poulet Braisé',   'prix' => 3000, 'description' => 'Épices maison',          'disponibilite' => true],
    ['idPlat' => 3, 'nom' => 'Frites',          'prix' => 1000, 'description' => 'Portion moyenne',        'disponibilite' => true],
    ['idPlat' => 4, 'nom' => 'Jus de Bissap',   'prix' => 500,  'description' => 'Fait maison',            'disponibilite' => true],
];

$clients = [
    ['idClient' => 1, 'nom' => 'Sene', 'prenom' => 'Aicha', 'adresse' => 'Dakar Plateau', 'telephone' => '77 200 30 30', 'email' => 'aicha@mail.com'],
    ['idClient' => 2, 'nom' => 'Diop', 'prenom' => 'Adja', 'adresse' => 'Sicap', 'telephone' => '77 544 81 19', 'email' => 'chacha@mail.com'],
];

$gerants = [
    ['idGerant' => 1, 'nom' => 'Diop', 'email' => 'gerant@vitservi.com'],
];

$commandes = [];

$livreurs = [
    ['idLivreur' => 1, 'nom' => 'Ibrahima Sarr', 'telephone' => '77 111 11 11', 'statut' => 'Disponible'],
    ['idLivreur' => 2, 'nom' => 'Modou Diagne',  'telephone' => '78 222 22 22', 'statut' => 'Disponible'],
    ['idLivreur' => 3, 'nom' => 'Omar Ba',       'telephone' => '76 333 33 33', 'statut' => 'Occupé'],
];

$paiements = [];

$idClientConnecte = 1;