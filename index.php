<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

require('msclss/classAd.php');
require('msclss/classUtilisateur.php');
require('msclss/classUtilisateurSql.php');

// Nouvelle connexion PDO
$conn 			= new conn;
$pdo 			= $conn->newCon('');

$utilisateurSql = new utilisateurSql($pdo);

//Selection d'un utilisateur en base de donnée
$utilisateur 	= $utilisateurSql->select('15');

// lecture variable utilisateur actif
echo "Statu Actuel:".$utilisateur->__get('utilisateurActif');

// Changment de la variable utilisateur actif
$utilisateur->setUtilisateurActif(0);

// Enregistrement de la nouvelle valeur utilisateur actif en base
if($utilisateurSql->updateActivation($utilisateur->__get('idutilisateur'), 1)){
	echo "sauvegarde OK";	
}
else{
	echo "erreur";
	
	list($pdoCode, $internalCode, $msg) = $pdo->errorInfo();
    die(sprintf("erreur SQL : %d/%d, %s", $pdoCode, $internalCode, $msg));
	
	//echo $pdo->errorCode();
}

// lecture actif
echo "Statu modifié:".$utilisateur->__get('utilisateurActif');


// data d'un nouvel utilisateur
$dataNouvelUtilisateur = [	'utilisateurNom' 		=> 'Nom',
							'utilisateurPrenom' 	=> 'Prenom',
							'utilisateurVille' 		=> 'Manosque',
							'utilisateurMail'		=> date('Ymds:s'),
							'utilisateurMdp'		=> 'motDePasse',
							'utilisateurAdresse' 	=> '23 rue de truc',
							'utilisateurCodePostal' => '04100',
							'utilisateurPays' 		=> 'FR',
							'utilisateurTel' 		=> '0606060606'];

// Déclaration du nouvel utilisateur
$nouvelUtilisateur = new utilisateur($dataNouvelUtilisateur);

// Enregistrement du nouvel utilisateur en base de donnée
$idNouvelUtilisateur = $utilisateurSql->insert($nouvelUtilisateur);

$tartampion = new Utilisateur($dataNouvelUtilisateur = [	'utilisateurNom' 		=> 'Tartempion',
															'utilisateurPrenom' 	=> 'laLune' ]);	
															
print_r($tartampion);		
