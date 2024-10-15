<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
class gererFraisController extends Controller{

    function saisirFrais(Request $request){
        if( session('visiteur') != null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $anneeMois = MyDate::getAnneeMoisCourant();
            $mois = $anneeMois['mois'];
            if(PdoGsb::estPremierFraisMois($idVisiteur,$mois)){
                 PdoGsb::creeNouvellesLignesFrais($idVisiteur,$mois);
            }
            $lesFrais = PdoGsb::getLesFraisForfait($idVisiteur,$mois);
            $view = view('majFraisForfait')
                    ->with('lesFrais', $lesFrais)
                    ->with('numMois',$anneeMois['numMois'])
                    ->with('erreurs',null)
                    ->with('numAnnee',$anneeMois['numAnnee'])
                    ->with('visiteur',$visiteur)
                    ->with('message',"")
                    ->with ('method',$request->method());
            return $view;
        }
        else{
            return view('connexion')->with('erreurs',null);
        }
    }
    function sauvegarderFrais(Request $request){
        if( session('visiteur')!= null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $anneeMois = MyDate::getAnneeMoisCourant();
            $mois = $anneeMois['mois'];
            $lesFrais = $request['lesFrais'];
            $lesLibFrais = $request['lesLibFrais'];
            $nbNumeric = 0;
            foreach($lesFrais as $unFrais){
                if(is_numeric($unFrais))
                    $nbNumeric++;
            }
            $view = view('majFraisForfait')->with('lesFrais', $lesFrais)
                    ->with('numMois',$anneeMois['numMois'])
                    ->with('numAnnee',$anneeMois['numAnnee'])
                    ->with('visiteur',$visiteur)
                    ->with('lesLibFrais',$lesLibFrais)
                    ->with ('method',$request->method());
            if($nbNumeric == 4){
                $message = "Votre fiche a été mise à jour";
                $erreurs = null;
                PdoGsb::majFraisForfait($idVisiteur,$mois,$lesFrais);
        	}
		    else{
                $erreurs[] ="Les valeurs des frais doivent être numériques";
                $message = '';
            }
            return $view->with('erreurs',$erreurs)
                        ->with('message',$message);
        }
        else{
            return view('connexion')->with('erreurs',null);
        }
    }
}














