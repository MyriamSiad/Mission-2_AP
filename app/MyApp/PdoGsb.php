<?php
namespace App\MyApp;
use PDO;
use Illuminate\Support\Facades\Config;
class PdoGsb{
        private static string $serveur;
        private static string $bdd;
        private static mixed $user;
        private static mixed $mdp;
        private  $monPdo;

/**
 * crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	public function __construct(){

        self::$serveur='mysql:host=' . Config::get('database.connections.mysql.host');
        self::$bdd='dbname=' . Config::get('database.connections.mysql.database');
        self::$user=Config::get('database.connections.mysql.username') ;
        self::$mdp=Config::get('database.connections.mysql.password');
        $this->monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp);
  		$this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		$this->monPdo =null;
	}


   /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom from visiteur
        where visiteur.login='" . $login . "' and visiteur.mdp='" . $mdp ."'";
    	$rs = $this->monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}


    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
     *  concernées par les deux arguments
     *
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return array|false l'id, le libelle et la quantité sous la forme d'un tableau associatif
     */
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois'
		order by lignefraisforfait.idfraisforfait";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

    /**
     * Retourne tous les id de la table FraisForfait
     * @return array|false
     * return un tableau associatif
     */
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 *
 * @param $idVisiteur
 * @param $mois * mois sous la forme aaaamm
 * @param $lesFrais * lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return void
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->monPdo->exec($req);
		}

	}

/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 *
 * @param $idVisiteur
 * @param $mois  * mois sous la forme aaaamm
 * @return bool
*/
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param $idVisiteur
     * @return mixed return le mois sous la forme aaaamm
     */
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
     * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
     * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return void
     */
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');

		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat)
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		$this->monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite)
			values('$idVisiteur','$mois','$unIdFrais',0)";
			$this->monPdo->exec($req);
		 }
	}


    /**
     * Retourne les mois pour lesquels un visiteur a une fiche de frais
     * @param $idVisiteur
     * @return array retourne un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
     * retourne un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
     */
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur'
		order by fichefrais.mois desc ";
		$res = $this->monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch();
		}
		return $lesMois;
	}

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return mixed return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
     * return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
     */
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs,
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}

    /**
     * Modifie l'état et la date de modification d'une fiche de frais
     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @param $etat
     * @return void
     */

	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now()
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->monPdo->exec($req);
	}


	/***************************************  Ma partie ****************/

 /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
	public function getInfosComptable($login, $mdp){
		$req = "select comptable.id as id, comptable.nom as nom, comptable.prenom as prenom from comptable
        where comptable.login='" . $login . "' and comptable.mdp='" . $mdp ."'";
    	$rs = $this->monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}


	/******************** Récuperer les noms des utilisateurs, pour les afficher dans une liste déroulante*/

	public function getNomVisiteur(): mixed
	{
		$req = "SELECT visiteur.Nom AS nom, visiteur.Prenom AS prenom , visiteur.id AS id, 
		fichefrais.mois AS mois, 
		fichefrais.nbJustificatifs AS Fiche, 
		fichefrais.montantValide AS montant,
		fichefrais.dateModif AS date,
		etat.libelle AS etat 
		 FROM visiteur
		 INNER JOIN fichefrais on fichefrais.idVisiteur = visiteur.id
		 INNER JOIN etat on etat.id = fichefrais.idEtat
		 WHERE idEtat = ? ";
		
		 $idEtat = "VA";
		
		$rs = $this->monPdo->prepare($req);
		$rs->execute([$idEtat]);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	
		
		
		
		
	}


	public function setValidation($idVisiteurs,$lesMois): void
	{
		// On update la table avec les différentes lignes selectionner
		$req = "UPDATE fichefrais 
        SET idEtat = ?, dateModif = CURDATE()
        WHERE idVisiteur = ? AND mois =  ?";

		// Ici on prepare la requete 
		$rs = $this->monPdo->prepare($req);


			
			// Mettre à jour l'état à "RB" (remboursée)
			$idEtat = "RB";
		
			// Exécuter la requête pour chaque visiteur et mois
			$rs->execute([$idEtat, $idVisiteurs, $lesMois]);
			//header("Refresh:0");
        

			// Ensuite ici on récupère la nouvelle liste de Fiche Frais Remboursé 
			// QU'on va afficher par la suite dans un autre tableau 
			// Appeler les fiches récements remboursé 
			

	}

	public function getRecentValidation(): mixed
	{
		$req2 = "SELECT visiteur.Nom AS nom, visiteur.Prenom AS prenom , visiteur.id AS id, 
			fichefrais.mois AS mois, 
			fichefrais.nbJustificatifs AS Fiche, 
			fichefrais.montantValide AS montant,
			fichefrais.dateModif AS date,
			etat.libelle AS etat 
			FROM visiteur
			INNER JOIN fichefrais on fichefrais.idVisiteur = visiteur.id
			INNER JOIN etat on etat.id = fichefrais.idEtat
			WHERE idEtat = ? AND dateModif = CURDATE() ";

			$rs2 = $this->monPdo->prepare($req2);
			$idEtat = "RB";
			$rs2->execute([$idEtat]);

		
			// Ici on va récupérer toutes les lignes des fiches Frais 
			// Récemment Modifié et remboursé 
			$ligne = $rs2->fetchAll(PDO::FETCH_ASSOC);
			
		
			return $ligne;
	}


	// Pour récupérer tout les fiches qui on été modifier pour la dernière fois 
	// le mois Dernnier mais à la même année 
	public function getFiche()
	{
		$req = "SELECT visiteur.Nom AS nom, Visiteur.Prenom AS prenom, visiteur.id AS id,
		fichefrais.mois AS mois, 
		fichefrais.nbJustificatifs AS Fiche, 
		fichefrais.montantValide AS montant,
		fichefrais.dateModif,
		etat.libelle AS etat 
		 FROM visiteur
		 INNER JOIN fichefrais on fichefrais.idVisiteur = visiteur.id
		 INNER JOIN etat on etat.id = fichefrais.idEtat
		 WHERE idEtat = ? 
		 AND YEAR(dateModif) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
 		 AND MONTH(dateModif) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";

		 $rs = $this ->monPdo->prepare($req);
		 $idEtat = "VA";
		 $rs->execute([$idEtat]);

		 $ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		
		 return $ligne;
	}

	


}
