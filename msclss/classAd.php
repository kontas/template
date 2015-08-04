<?php

class conn{
		
	private 	$sql_server	= 'localhost';  
	private 	$sql_db		= 'template'; 
	private 	$sql_prefix;
	protected  	$sql_login;
	protected  	$sql_pwd;	
	
	public function newCon($utilisateur){
		
		if($utilisateur=='lectureUtil'){
			$this->sql_login= '';
			$this->sql_pwd	= '';	
		}
		elseif($utilisateur=='lectureParam'){
			$this->sql_login= '';
			$this->sql_pwd	= '';
		}
		else{
			$this->sql_login= 'root';
			$this->sql_pwd	= '';
		}
		
		
		try{
		    $strConnection = "mysql:host=".$this->sql_server.";dbname=".$this->sql_db;
		    $arrExtraParam= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); 
		    
		    $pdo = new PDO($strConnection, $this->sql_login, $this->sql_pwd, $arrExtraParam); //Instancie la connexion
		    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		    
		   	return $pdo;
		}
		catch(PDOException $e) {
		   	$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
		    die($msg);
		}
	}
	
	
}






function mySqlMailError($mySqlError){
	
	mail('','erreur MySql',$mySqlError);
}

 
/**
 * @param la chaine à controler
 * @param le link sql
 * @return Chaine securisée
 */
function securite_bddV2($string,$link)
{
	// On regarde si le type de string est un nombre entier (int)
	if(ctype_digit($string))
	{
		//$string = intval($string);
	}
	// Pour tous les autres types
	else
	{
		$string = mysqli_real_escape_string($link, $string);
		$string = strip_tags($string);
		$string = addcslashes($string, '%_');
	}
	return $string;
}

/**
 * Envoi un mail au format HTML
 */

function envoiEmail($destinataire,$sujet,$corpsMessage){
		
	
	$passage_ligne = "\n";
	//=====Déclaration des messages au format texte et au format HTML.
	//$message_txt = $corpsMessage;
	
	$message_html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
						<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
						<meta name='viewport' content='width=device-width' />
						<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
						<title>'".$sujet."'</title>
						</head>
						<body bgcolor='#FFFFFF'>
						<!-- BODY -->
						".$corpsMessage."
						<!-- /BODY -->
						<p style='font-style:italic'>Ce message est un message automatique, merci de ne pas y répondre</p>
						</body>
						</html>";
	///=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	//=====Définition du sujet.
	$sujet = $sujet;
	//=====Création du header de l'e-mail.
	$header = "From: \"cilsila.fr\"<contact@cilsila.fr>".$passage_ligne;
	$header.= "Reply-to: \"cilsila.fr\"<contact@cilsila.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	//$message.= "Content-Type: text/plain; charset=\"UTF8\"".$passage_ligne;
	//$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	//$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	//$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"UTF8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//=====Envoi de l'e-mail.
	
	
	
	mail($destinataire,$sujet,$message,$header);
	
	//==========	
}


/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}







function selectPays($selected){
	
	
	$paysListe = array (  'AF' => 'Afghanistan',
						  'ZA' => 'Afrique du Sud',
						  'AL' => 'Albanie',
						  'DZ' => 'Algérie',
						  'DE' => 'Allemagne',
						  'AD' => 'Andorre',
						  'AO' => 'Angola',
						  'AI' => 'Anguilla',
						  'AQ' => 'Antarctique',
						  'AG' => 'Antigua-et-Barbuda',
						  'AN' => 'Antilles néerlandaises',
						  'SA' => 'Arabie saoudite',
						  'AR' => 'Argentine',
						  'AM' => 'Arménie',
						  'AW' => 'Aruba',
						  'AU' => 'Australie',
						  'AT' => 'Autriche',
						  'AZ' => 'Azerbaïdjan',
						  'BS' => 'Bahamas',
						  'BH' => 'Bahreïn',
						  'BD' => 'Bangladesh',
						  'BB' => 'Barbade',
						  'BE' => 'Belgique',
						  'BZ' => 'Belize',
						  'BM' => 'Bermudes',
						  'BT' => 'Bhoutan',
						  'BO' => 'Bolivie',
						  'BA' => 'Bosnie-Herzégovine',
						  'BW' => 'Botswana',
						  'BN' => 'Brunéi Darussalam',
						  'BR' => 'Brésil',
						  'BG' => 'Bulgarie',
						  'BF' => 'Burkina Faso',
						  'BI' => 'Burundi',
						  'BY' => 'Bélarus',
						  'BJ' => 'Bénin',
						  'KH' => 'Cambodge',
						  'CM' => 'Cameroun',
						  'CA' => 'Canada',
						  'CV' => 'Cap-Vert',
						  'CL' => 'Chili',
						  'CN' => 'Chine',
						  'CY' => 'Chypre',
						  'CO' => 'Colombie',
						  'KM' => 'Comores',
						  'CG' => 'Congo',
						  'KP' => 'Corée du Nord',
						  'KR' => 'Corée du Sud',
						  'CR' => 'Costa Rica',
						  'HR' => 'Croatie',
						  'CU' => 'Cuba',
						  'CI' => 'Côte d’Ivoire',
						  'DK' => 'Danemark',
						  'DJ' => 'Djibouti',
						  'DM' => 'Dominique',
						  'SV' => 'El Salvador',
						  'ES' => 'Espagne',
						  'EE' => 'Estonie',
						  'FJ' => 'Fidji',
						  'FI' => 'Finlande',
						  'FR' => 'France',
						  'GA' => 'Gabon',
						  'GM' => 'Gambie',
						  'GH' => 'Ghana',
						  'GI' => 'Gibraltar',
						  'GD' => 'Grenade',
						  'GL' => 'Groenland',
						  'GR' => 'Grèce',
						  'GP' => 'Guadeloupe',
						  'GU' => 'Guam',
						  'GT' => 'Guatemala',
						  'GG' => 'Guernesey',
						  'GN' => 'Guinée',
						  'GQ' => 'Guinée équatoriale',
						  'GW' => 'Guinée-Bissau',
						  'GY' => 'Guyana',
						  'GF' => 'Guyane française',
						  'GE' => 'Géorgie',
						  'GS' => 'Géorgie du Sud et les îles Sandwich du Sud',
						  'HT' => 'Haïti',
						  'HN' => 'Honduras',
						  'HU' => 'Hongrie',
						  'IN' => 'Inde',
						  'ID' => 'Indonésie',
						  'IQ' => 'Irak',
						  'IR' => 'Iran',
						  'IE' => 'Irlande',
						  'IS' => 'Islande',
						  'IL' => 'Israël',
						  'IT' => 'Italie',
						  'JM' => 'Jamaïque',
						  'JP' => 'Japon',
						  'JE' => 'Jersey',
						  'JO' => 'Jordanie',
						  'KZ' => 'Kazakhstan',
						  'KE' => 'Kenya',
						  'KG' => 'Kirghizistan',
						  'KI' => 'Kiribati',
						  'KW' => 'Koweït',
						  'LA' => 'Laos',
						  'LS' => 'Lesotho',
						  'LV' => 'Lettonie',
						  'LB' => 'Liban',
						  'LY' => 'Libye',
						  'LR' => 'Libéria',
						  'LI' => 'Liechtenstein',
						  'LT' => 'Lituanie',
						  'LU' => 'Luxembourg',
						  'MK' => 'Macédoine',
						  'MG' => 'Madagascar',
						  'MY' => 'Malaisie',
						  'MW' => 'Malawi',
						  'MV' => 'Maldives',
						  'ML' => 'Mali',
						  'MT' => 'Malte',
						  'MA' => 'Maroc',
						  'MQ' => 'Martinique',
						  'MU' => 'Maurice',
						  'MR' => 'Mauritanie',
						  'YT' => 'Mayotte',
						  'MX' => 'Mexique',
						  'MD' => 'Moldavie',
						  'MC' => 'Monaco',
						  'MN' => 'Mongolie',
						  'MS' => 'Montserrat',
						  'ME' => 'Monténégro',
						  'MZ' => 'Mozambique',
						  'MM' => 'Myanmar',
						  'NA' => 'Namibie',
						  'NR' => 'Nauru',
						  'NI' => 'Nicaragua',
						  'NE' => 'Niger',
						  'NG' => 'Nigéria',
						  'NU' => 'Niue',
						  'NO' => 'Norvège',
						  'NC' => 'Nouvelle-Calédonie',
						  'NZ' => 'Nouvelle-Zélande',
						  'NP' => 'Népal',
						  'OM' => 'Oman',
						  'UG' => 'Ouganda',
						  'UZ' => 'Ouzbékistan',
						  'PK' => 'Pakistan',
						  'PW' => 'Palaos',
						  'PA' => 'Panama',
						  'PG' => 'Papouasie-Nouvelle-Guinée',
						  'PY' => 'Paraguay',
						  'NL' => 'Pays-Bas',
						  'PH' => 'Philippines',
						  'PN' => 'Pitcairn',
						  'PL' => 'Pologne',
						  'PF' => 'Polynésie française',
						  'PR' => 'Porto Rico',
						  'PT' => 'Portugal',
						  'PE' => 'Pérou',
						  'QA' => 'Qatar',
						  'HK' => 'R.A.S. chinoise de Hong Kong',
						  'MO' => 'R.A.S. chinoise de Macao',
						  'RO' => 'Roumanie',
						  'GB' => 'Royaume-Uni',
						  'RU' => 'Russie',
						  'RW' => 'Rwanda',
						  'CF' => 'République centrafricaine',
						  'DO' => 'République dominicaine',
						  'CD' => 'République démocratique du Congo',
						  'CZ' => 'République tchèque',
						  'RE' => 'Réunion',
						  'EH' => 'Sahara occidental',
						  'BL' => 'Saint-Barthélémy',
						  'KN' => 'Saint-Kitts-et-Nevis',
						  'SM' => 'Saint-Marin',
						  'MF' => 'Saint-Martin',
						  'PM' => 'Saint-Pierre-et-Miquelon',
						  'VC' => 'Saint-Vincent-et-les Grenadines',
						  'SH' => 'Sainte-Hélène',
						  'LC' => 'Sainte-Lucie',
						  'WS' => 'Samoa',
						  'AS' => 'Samoa américaines',
						  'ST' => 'Sao Tomé-et-Principe',
						  'RS' => 'Serbie',
						  'CS' => 'Serbie-et-Monténégro',
						  'SC' => 'Seychelles',
						  'SL' => 'Sierra Leone',
						  'SG' => 'Singapour',
						  'SK' => 'Slovaquie',
						  'SI' => 'Slovénie',
						  'SO' => 'Somalie',
						  'SD' => 'Soudan',
						  'LK' => 'Sri Lanka',
						  'CH' => 'Suisse',
						  'SR' => 'Suriname',
						  'SE' => 'Suède',
						  'SJ' => 'Svalbard et Île Jan Mayen',
						  'SZ' => 'Swaziland',
						  'SY' => 'Syrie',
						  'SN' => 'Sénégal',
						  'TJ' => 'Tadjikistan',
						  'TZ' => 'Tanzanie',
						  'TW' => 'Taïwan',
						  'TD' => 'Tchad',
						  'TF' => 'Terres australes françaises',
						  'IO' => 'Territoire britannique de l\'océan Indien',
						  'PS' => 'Territoire palestinien',
						  'TH' => 'Thaïlande',
						  'TL' => 'Timor oriental',
						  'TG' => 'Togo',
						  'TK' => 'Tokelau',
						  'TO' => 'Tonga',
						  'TT' => 'Trinité-et-Tobago',
						  'TN' => 'Tunisie',
						  'TM' => 'Turkménistan',
						  'TR' => 'Turquie',
						  'TV' => 'Tuvalu',
						  'UA' => 'Ukraine',
						  'UY' => 'Uruguay',
						  'VU' => 'Vanuatu',
						  'VE' => 'Venezuela',
						  'VN' => 'Viêt Nam',
						  'WF' => 'Wallis-et-Futuna',
						  'YE' => 'Yémen',
						  'ZM' => 'Zambie',
						  'ZW' => 'Zimbabwe',
						  'ZZ' => 'région indéterminée',
						  'EG' => 'Égypte',
						  'AE' => 'Émirats arabes unis',
						  'EC' => 'Équateur',
						  'ER' => 'Érythrée',
						  'VA' => 'État de la Cité du Vatican',
						  'FM' => 'États fédérés de Micronésie',
						  'US' => 'États-Unis',
						  'ET' => 'Éthiopie',
						  'BV' => 'Île Bouvet',
						  'CX' => 'Île Christmas',
						  'NF' => 'Île Norfolk',
						  'IM' => 'Île de Man',
						  'KY' => 'Îles Caïmans',
						  'CC' => 'Îles Cocos - Keeling',
						  'CK' => 'Îles Cook',
						  'FO' => 'Îles Féroé',
						  'HM' => 'Îles Heard et MacDonald',
						  'FK' => 'Îles Malouines',
						  'MP' => 'Îles Mariannes du Nord',
						  'MH' => 'Îles Marshall',
						  'UM' => 'Îles Mineures Éloignées des États-Unis',
						  'SB' => 'Îles Salomon',
						  'TC' => 'Îles Turks et Caïques',
						  'VG' => 'Îles Vierges britanniques',
						  'VI' => 'Îles Vierges des États-Unis',
						  'AX' => 'Îles Åland');
	$option;
	
	foreach ($paysListe as $key => $value) {
		
		$defaut ='';
		if($selected===$key){
			$defaut = "selected='selected'";
		}

		$option .= "<option value='".$key."' ".$defaut.">".$value."</option>";
		
	}
	
	echo "<select class='form-control' name='country' id='pays'>";
		echo $option;
	echo "</select>";
}

?>