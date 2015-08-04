<?php


class UtilisateurSql{
	
	private $pdo; // Instance connexion db
	
	function __construct($pdo){
		
		$this->pdo = $pdo;
	}
	
	public function selectIdFromSession($idSession){
				
		$query 	= "SELECT idutilisateur FROM utilisateur, logConnexion WHERE utilisateur.idutilisateur  = logConnexion.utilisateur_idutilisateur AND logConnexion.idlogConnexion = :idsession";
		$prep  	= $this->pdo->prepare($query);
		$prep->bindValue(':idsession', $idSession, PDO::PARAM_STR);
		
		try {
		   $prep->execute();
		   $data 	= $prep->fetch();
		   $retour	= $data['idutilisateur'];		   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       return $retour; 
	}
	
	public function select($idutilisateur){
		
		$query 	= "SELECT * FROM utilisateur WHERE idutilisateur = :idutilisateur ";
		$prep  	= $this->pdo->prepare($query);
		$prep->bindValue(':idutilisateur', $idutilisateur, PDO::PARAM_INT);
		
		try {
				
			$prep->execute();
		   	$data 		= $prep->fetch();
		   
		   	$donnees	= [	'idUtilisateur' => $data['idutilisateur'],
							'utilisateurNom' => $data['utilisateurNom'],
							'utilisateurPrenom' => $data['utilisateurPrenom'],
							'utilisateurVille' => $data['utilisateurVille'],
							'utilisateurAdresse' => $data['utilisateurAdresse'],
							'utilisateurCodePostal' => $data['utilisateurCodePostal'],
							'utilisateurPays' => $data['utilisateurPays'],
							'utilisateurTel' => $data['utilisateurTel'],
							'utilisateurMail' => $data['utilisateurMail'],
							'utilisateurDateInscription' => $data['utilisateurDateInscription'],
							'utilisateurActif' => $data['utilisateurActif'],
							'utilisateurMdp' => $data['utilisateurMdp'],
							'utilisateurAdressePaypal' => $data['utilisateurAdressePaypal']];
		   
		   $retour 		= new utilisateur($donnees);
		} 
		catch (PDOException $e) {
		  
		   $retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
		return $retour;
	}
	
	public function selectInfoExpedition($idutilisateur){
		
		$query 	= "SELECT idutilisateur,utilisateurNom,utilisateurPrenom,utilisateurVille,utilisateurAdresse,utilisateurCodePostal,utilisateurPays,utilisateurTel 
					FROM utilisateur WHERE idutilisateur = :idutilisateur";
		$prep  	= $this->pdo->prepare($query);
		$prep->bindValue(':idutilisaeur', $idutilisateur, PDO::PARAM_STR);
		
		try {
		   $prep->execute();
		   $data 	= $prep->fetch();
		   $donnees	= [	'idUtilisateur' 		=> $data['idutilisateur'],
						'utilisateurNom' 		=> $data['utilisateurNom'],
						'utilisateurPrenom' 	=> $data['utilisateurPrenom'],
						'utilisateurVille' 		=> $data['utilisateurVille'],
						'utilisateurAdresse' 	=> $data['utilisateurAdresse'],
						'utilisateurCodePostal' => $data['utilisateurCodePostal'],
						'utilisateurPays' 		=> $data['utilisateurPays'],
						'utilisateurTel' 		=> $data['utilisateurTel']];
		   
		   $retour 	= new utilisateur($donnees);		   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       
		return $retour; 
	}
	
	
	/**
	 * Met à jour les informations d'un membre.
	 * Renvoi un tableau de resultat
	*/
	public function update($utilisateur){
		
		$retour;
		
		$query = "	UPDATE utilisateur	SET 
					utilisateurNom			= :utilisateurNom,
					utilisateurPrenom		= :utilisateurPrenom,
					utilisateurVille		= :utilisateurVille,
					utilisateurAdresse 		= :utilisateurAdresse,
					utilisateurCodePostal	= :utilisateurCodePostal,
					utilisateurPays         = :utilisateurPays,
					utilisateurTel 			= :utilisateurTel
					WHERE idutilisateur 	= :idutilisateur LIMIT 1";
		
		$prep  	= $this->pdo->prepare($query);
		
		$prep->bindValue(':idutilisaeur', $utilisateur->idutilisateur, PDO::PARAM_INT);
		$prep->bindValue(':utilisateurNom', $utilisateur->utilisateurNom, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurPrenom', $utilisateur->utilisateurPrenom, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurVille', $utilisateur->utilisateurVille, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurAdresse', $utilisateur->utilisateurAdresse, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurCodePostal', $utilisateur->utilisateurCodePostal, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurPays', $utilisateur->utilisateurPays, PDO::PARAM_STR);
		$prep->bindValue(':utilisateurTel', $utilisateur->utilisateurTel, PDO::PARAM_STR);
		
		try {
		   	if($prep->execute()){
				$retour = TRUE;
		   	}
			else{
				$retour = FALSE;
			}
		   	   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}      
           
        return $retour; 
	}
	
	

	 /**
     * Active ou desactive un compte utilisateur, lui permettant ainsi de pouvoir se connecter
     */
     public function updateActivation($idutilisateur,$actif){
        
        $retour;
       	$query = "  UPDATE utilisateur  SET 
                    utilisateurActi       = ?
                    WHERE idutilisateur     = ? LIMIT 1";
        
        $prep  	= $this->pdo->prepare($query);
		
		$prep->bindValue(1, $actif, PDO::PARAM_STR);
		$prep->bindValue(2, $idutilisateur, PDO::PARAM_INT);
		
		if($prep->execute()){
			$retour = TRUE;
		}
		else{
			$retour = FALSE;
		}
		
		
		
		/*try {
		   	if($prep->execute()){
				$retour = TRUE;
		   	}
			else{
				$retour = FALSE;
			}
		   	   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			
			$retour = FALSE;
			
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       */
		return $retour; 
    }
     
     
    
	/**
	 * Met à jour les informations d'un membre.
	 * Renvoi un tableau de resultat
	*/
	public function updateLogin($idutilisateur,$mail){
		
		$retour;
       	$query = "  UPDATE utilisateur  SET 
                    utilisateurMail        	= :mail
                    WHERE idutilisateur     = :idutilisateur LIMIT 1";
        
        $prep  	= $this->pdo->prepare($query);
		
		$prep->bindValue(':mail', $mail, PDO::PARAM_STR);
		$prep->bindValue(':idutilisaeur', $idutilisateur, PDO::PARAM_INT);
		
		try {
		   	if($prep->execute()){
				$retour = TRUE;
		   	}
			else{
				$retour = FALSE;
			}
		   	   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       	return $retour; 
    }
	
	/**
	 * Met à jour le mot de passe sans vérification de l'ancien MDP
	 */
	 public function updateMdpSansVerif($idutilisateur,$mdpCrypter){
	 		
	 	$retour;
       	$query = "  UPDATE utilisateur  SET 
                    utilisateurMail        	= :mail
                    WHERE idutilisateur     = :idutilisateur LIMIT 1";
        
        $prep  	= $this->pdo->prepare($query);
		
		$prep->bindValue(':mdpCrypter', $mdpCrypter, PDO::PARAM_STR);
		$prep->bindValue(':idutilisaeur', $idutilisateur, PDO::PARAM_INT);
		
		try {
		   	if($prep->execute()){
				$retour = TRUE;
		   	}
			else{
				$retour = FALSE;
			}
		   	   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       
		return $retour; 
    }
	 
	 /**
     * Insert un nouvel utilisteur
     * Renvoi l'id si OK
     * Renvoi FALSE si erreur
     */
	 public function insert($utilisateur){
	 		
	 	print_r($utilisateur);
	    
		$query 	= 'INSERT INTO utilisateur 
						(utilisateurNom,utilisateurPrenom,utilisateurVille,utilisateurAdresse,utilisateurCodePostal,utilisateurPays,utilisateurTel,utilisateurMail,utilisateurDateInscription,utilisateurActif,utilisateurMdp) 
               		VALUES 	(:nom,:prenom,:ville,:adresse,:codePostal,:pays,:tel,:mail,NOW(),:actif,:mdp)';
		$prep  	= $this->pdo->prepare($query);
		 
		$prep->bindValue(':nom', $utilisateur->utilisateurNom, PDO::PARAM_STR);
		$prep->bindValue(':prenom', $utilisateur->utilisateurPrenom, PDO::PARAM_STR);
		$prep->bindValue(':adresse', $utilisateur->utilisateurAdresse, PDO::PARAM_STR);
		$prep->bindValue(':codePostal', $utilisateur->utilisateurCodePostal, PDO::PARAM_STR);
		$prep->bindValue(':pays', $utilisateur->utilisateurPays, PDO::PARAM_STR);
		$prep->bindValue(':ville', $utilisateur->utilisateurVille, PDO::PARAM_STR);
		$prep->bindValue(':tel', $utilisateur->utilisateurTel, PDO::PARAM_STR);
		$prep->bindValue(':mail', $utilisateur->utilisateurMail, PDO::PARAM_STR);
		$prep->bindValue(':actif', 0, PDO::PARAM_INT);
		$prep->bindValue(':mdp', $utilisateur->utilisateurMdp, PDO::PARAM_STR);
		
		try {
		   $prep->execute();
		   $retour = $this->pdo->lastInsertId();
		} 
		catch (PDOException $e) {
		  
		   $retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       
		return $retour;  
	 }
     
     /**
     * Verification que l'adresse Email utilisé est bien unique
     * @param $mail adresse Email a verifier
     * @param $idutilisateur, facultatif permet de valider une modification
	 * @return TRUE si disponible, FALSE si utilisé
     */
     public function checkMail($mail,$idutilisateur){
        
		if($idutilisateur!=''){
           	$query = 'SELECT utilisateurMail FROM utilisateur WHERE utilisateurMail = ? '.$saufIdutilisateur.' AND idutilisateur !=?';
			$prep  = $this->pdo->prepare($query);
			 
			$prep->bindValue(1, $mail, PDO::PARAM_STR);
			$prep->bindValue(2, $idutilisateur, PDO::PARAM_INT);
        }
		else{
			$query = 'SELECT utilisateurMail FROM utilisateur WHERE utilisateurMail = ? '.$saufIdutilisateur.'';
			$prep  = $this->pdo->prepare($query);
			 
			$prep->bindValue(1, $mail, PDO::PARAM_STR);
		}
		
		try {
		   $prep->execute();
		   if($prep->rowCount()==0){
				$retour = TRUE;
			}
		} 
		catch (PDOException $e) {
		  
		   $retour = FALSE;
		}
		
		
		return $retour;
	}
	 
	 /**
     * Defini adressePaypal
     */
     public function updatePaypalMail($idutilisateur,$paypalMail){
        
        $retour;
       	$query = "  UPDATE utilisateur  SET 
                    utilisateurAdressePaypal= :paypalMail
                    WHERE idutilisateur     = :idutilisateur LIMIT 1";
        
        $prep  	= $this->pdo->prepare($query);
		
		$prep->bindValue(':paypalMail', $paypalMail, PDO::PARAM_STR);
		$prep->bindValue(':idutilisaeur', $idutilisateur, PDO::PARAM_INT);
		
		try {
		   	if($prep->execute()){
				$retour = TRUE;
		   	}
			else{
				$retour = FALSE;
			}
		   	   
		} 
		catch (PDOException $e) {
			$retour = FALSE;
			exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
		if(isset($messages)){
			foreach($messages as $message)
			{
				echo '<p>Le ', $message->date, ' par ', $message->auteur, ' : <br />', $message->contenu, '</p>';
			}
		}
		
       return $retour; 
    }
}
// FIN