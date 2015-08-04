<?php

class Utilisateur{
		
	protected $idutilisateur;
	protected $utilisateurNom;
	protected $utilisateurPrenom;
	protected $utilisateurVille;
	protected $utilisateurAdresse;
	protected $utilisateurCodePostal;
	protected $utilisateurPays;
	protected $utilisateurTel;
	protected $utilisateurMail;
	protected $utilisateurDateInscription;
	protected $utilisateurActif;
	private   $utilisateurMdp;
	protected $utilisateurAdressePaypal;
	
	function __construct($donnees){
								
		$this->hydrate($donnees);
		
		
		if(array_key_exists('idutilisateur', $donnees)){
			$this->idutilisateur 		= $donnees['idutilisateur'];
		}
		
		
		
		
		//$this->idutilisateur 		= $donnees['idutilisateur'];
		$this->utilisateurNom 		= $donnees['utilisateurNom'];
		$this->utilisateurPrenom 	= $donnees['utilisateurPrenom'];
								
	}
							
	// Fait passer automatiquement les variables du tableau $donnée dans leurs SETTER
	public function hydrate(array $donnees){
		foreach ($donnees as $key => $value){
	    // On récupère le nom du setter correspondant à l'attribut.
	    	$method = 'set'.ucfirst($key);
	        
	    	// Si le setter correspondant existe.
	    	if (method_exists($this, $method)){
	      		// On appelle le setter.
	      		$this->$method($value);
			}
			else{
				echo "erreur";
			}
		}
	}						
	
	/**
	 * Test Magic set
	 */						
	public function __set($nom,$valeur){
		
		$this->$nom = $valeur;
	}
	
	
	//**** SET
	
	/**
	 * Vérifie que ID est bien numérique
	 */
	public function setIdUtilisateur($idutilisateur){
		
		$idutilisateur = (int) $idutilisateur;
		
		if ($idutilisateur > 0){
	      $this->idutilisateur = $idutilisateur;
	    }
	}
	
	/**
	 * Vérifie que utilisateurNom est bien alphanum
	 */
	public function setUtilisateurNom($utilisateurNom){
		
		$this->utilisateurNom = $utilisateurNom;
	}
	
	/**
	 * Vérifie que utilisateurPrenom est bien alphanum
	 */
	public function setUtilisateurPrenom($utilisateurPrenom){
		
		$this->utilisateurPrenom = $utilisateurPrenom;
	}
	
	/**
	 * Vérifie que utilisateurVille est bien alphanum
	 */
	public function setUtilisateurVille($utilisateurVille){
		
		$this->utilisateurVille = $utilisateurVille;
	}
	
	/**
	 * Set utilisateurAdresse
	 */
	public function setUtilisateurAdresse($utilisateurAdresse){
		
		$this->utilisateurAdresse = $utilisateurAdresse;
	}
	
	/**
	 * Vérifie que le code postal est numérique et le Set
	 */
	public function setUtilisateurCodePostal($utilisateurCodePostal){
		
		$this->utilisateurCodePostal = $utilisateurCodePostal;	
	}
	
	/**
	 * Vérifie que utilisateurPays est bien alphanum
	 */
	public function setUtilisateurPays($utilisateurPays){
		
		$this->utilisateurPays = $utilisateurPays;
	}
	
	
	/**
	 * Vérifie que le téléphone est numerique
	 */
	public function setUtilisateurTel($utilisateurTel){
		
		$this->utilisateurTel = $utilisateurTel;
	}
	
	/**
	 * Set l'adresse Email
	 */
	 public function setUtilisateurMail($utilisateurMail){
	 	
		$this->utilisateurMail = $utilisateurMail;
	 }
	
	/**
	* Set date d'inscription 
	*/
	public function setUtilisateurDateInscription($utilisateurDateInscription){
			
		$this->utilisateurDateInscription = $utilisateurDateInscription;
	}
	
	/**
	* Vérifie que actif soit numérique
	*/
	public function setUtilisateurActif($utilisateurActif){
			
		if (is_numeric($utilisateurActif)){
	    	$this->utilisateurActif = $utilisateurActif;
		}
	}
	
	/**
	* Set utilisateurMdp
	*/
	public function setUtilisateurMdp($utilisateurMdp){
	 	
		$this->utilisateurMdp = $utilisateurMdp;		
	}
	
	/**
	* Set utilisateurAdressePaypal
	*/
	public function setUtilisateurAdressePayPal($utilisateurAdressePayPal){
		
		$this->utilisateurAdressePaypal = $utilisateurAdressePayPal;
	}
	
	
	//**** FIN DE SET
	
	//**** GET
	
	/**
	 * Test Magic get
	 */						
	public function __get($nom){
		return $this->$nom;
	}
	
	
	/**
	 * get idutilisateur
	 */						
	public function getIdUtilisateur(){
		return $this->idutilisateur;
	} 
}
// Fin