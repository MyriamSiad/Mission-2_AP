<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class connexionController extends Controller
{
    function connecter(){
        session(['visiteur' => null]);
        session(['comptable' => null]);
        return view('connexion')->with('erreurs',null);
    } 
    function valider(Request $request){
      

        $login = $request['login'];
        $mdp = $request['mdp'];
        $visiteur = PdoGsb::getInfosVisiteur($login,$mdp);
        $comptable = PdoGsb::getInfosComptable($login, $mdp);
        if(!is_array($visiteur) && !is_array($comptable) ){
            $erreurs[] = "Login ou mot de passe incorrect(s)";
            return view('connexion')->with('erreurs',$erreurs);
        }
        else if (is_array($visiteur)){
            session(['visiteur' => $visiteur]);
            return view('sommaire')->with('visiteur',session('visiteur'));
        }

        else {

            session(key: ['comptable' => $comptable]);
            return view(view: 'sommaire_comptable')->with(key: 'comptable',value: session(key: 'comptable'));
        }
    } 
    function deconnecter(){
            session(['visiteur' => null]);
            session(['comptable' => null]);
            return redirect()->route('chemin_connexion');
       
           
    }
       
}
