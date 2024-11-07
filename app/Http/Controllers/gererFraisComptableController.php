<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
use Barryvdh\DomPDF\Facade\Pdf;
class gererFraisComptableController extends Controller
{

    public function VerifeComptable()
    { 
        $flag = false;
        if(session('comptable') != null)
        {

            $flag = true;
        }
        return $flag;
    }

    public function afficheVisiteur()
    {

        /** Verifie si la personne connecter est bien un comtpable  */

        if(gererFraisComptableController::VerifeComptable() == false)
        {
            return view('connexion')->with('erreurs',null);
        }

        else
        {
            $comptable = session('comptable');
             // Récupérer les visiteurs
            $lesVisiteurs = PdoGsb::getNomVisiteur();
            $recent = PdoGsb::getRecentValidation();
            // $lePrenom  = $lesVisiteurs['prenom'];
            //  $leNom = $lesVisiteurs['nom'];
            // Vérification si des visiteurs existent et si le premier élément est bien un objet 
            $view = view('Suivie_fiche_frais')
                        ->with('lesVisiteurs', $lesVisiteurs)               
                        ->with ('comptable',$comptable)
                        ->with('Validations',$recent);
        }   
    
            return $view;
        }


    public function Validation()
    {
       $Verfication =  gererFraisComptableController::VerifeComptable();
        /** Verifie si la personne connecter est bien un comtpable, et non un visiteur  */

        if($Verfication)
            {
                 // $idComptable = $comptable['id'];
                $lesVisiteurs = PdoGsb::getNomVisiteur();
            }
            // Sinon on le renvoie vers la page de connexions avec les erreurs 
            else 
            {
                return redirect()->route('chemin_connexion'); 
            }   
        // Récupérer les visiteurs à modifié qui on été séléctionné
           if (isset($_POST['visiteur_ids'])) 
           
           {
            $LesInfos = $_POST['visiteur_ids'];
            foreach ($LesInfos as $fiche) 
            {
                // Séparer l'idVisiteur et le mois
                list($idVisiteur, $mois) = explode('-', $fiche);
        
                // Appeler votre fonction de mise à jour
               $Validations =  PdoGsb::setValidation($idVisiteur, $mois);
               $afficher = gererFraisComptableController::afficheVisiteur();
               return $afficher;
            }          
                  
           }
           else
           {
            return redirect()->route('chemin_connexion');
           }        
         
        }
       

       
        public function Fiches()
        {

            $Verfication =  gererFraisComptableController::VerifeComptable();
            /** Verifie si la personne connecter est bien un comtpable, et non un visiteur  */
    
            if($Verfication)
                {
                     // $idComptable = $comptable['id'];
                    $lesVisiteurs = PdoGsb::getNomVisiteur();
                    $lesFiches = PdoGsb::getFiche();
                    $comptable = session('comptable');
                    $view = view('Edition_Fiche_Frais')
                    ->with('lesFiches', $lesFiches)
                    ->with ('lesVisiteurs',$lesVisiteurs)
                    -> with('comptable',$comptable);
                }
                // Sinon on le renvoie vers la page de connexions avec les erreurs 
                else 
                {
                    return redirect()->route('chemin_connexion'); 
                }
            
            return $view;
        }
    
        public function ExportePDF()
        {
            $lesFiches = PdoGSB :: getFiche();
         
            $pdf = Pdf::loadView('fiche_paiement_pdf', compact('lesFiches'));
            return $pdf->download('fiche_paiement.pdf');

        }
    
}



















