<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
class gererFraisComptableController extends Controller
{
    public function afficheVisiteur()
    {

        /** Verifie si la personne connecter est bien un comtpable  */

        if(session('comptable') != null){
            $comptable = session('comptable');
            $idComptable = $comptable['id'];
            }
            else{
              return view('connexion')->with('erreurs',null);
            }

            
        // Récupérer les visiteurs
        $lesVisiteurs = PdoGsb::getNomVisiteur();
        
       // $lePrenom  = $lesVisiteurs['prenom'];
      //  $leNom = $lesVisiteurs['nom'];
        // Vérification si des visiteurs existent et si le premier élément est bien un objet
       
            $view = view('Suivie_fiche_frais')
                        ->with('lesVisiteurs', $lesVisiteurs)
                       
                        ->with ('comptable',$comptable);
            // Renvoyer la vue avec les variables 'Nom' et 'Prenom'
            return $view;
        }


    public function Validation()
    {
        /** Verifie si la personne connecter est bien un comtpable, et non un visiteur  */

        if(session('comptable') != null){

            $comptable = session('comptable');
            $idComptable = $comptable['id'];
            $lesVisiteurs = PdoGsb::getNomVisiteur();
            $view = view('Suivie_fiche_frais')
            ->with('lesVisiteurs', $lesVisiteurs)
            ->with ('comptable',$comptable);
            }
            // Sinon on le renvoie vers la page de connexions avec les erreurs 
          
                
            While (session('comptable') == null){

               return redirect()->route('chemin_connexion');
           
               
                if (session('comptable') != null)
                {
                    $view = view('Suivie_fiche_frais')
                    ->with('lesVisiteurs', $lesVisiteurs)
                    ->with ('comptable',$comptable);
                     
                    break;
        
                }
              
                return $view;
            }

            
        // Récupérer les visiteurs à modifié qui on été séléctionné
           if (isset($_POST['visiteur_ids'])) 
           
           {

            $LesInfos = $_POST['visiteur_ids'];
        
            
            foreach ($LesInfos as $fiche) {
               
                // Séparer l'idVisiteur et le mois
                list($idVisiteur, $mois) = explode('-', $fiche);
        
                // Appeler votre fonction de mise à jour
               $Validations =  PdoGsb::setValidation($idVisiteur, $mois);
            }

           // Ici on change la variable view
            $view = view('Suivie_fiche_frais')
            ->with('lesVisiteurs', $lesVisiteurs)
            ->with('Validations',$Validations)
            ->with ('comptable',$comptable);
            
           }

        
           
            return $view;
        }
       
       
    
    
}



















