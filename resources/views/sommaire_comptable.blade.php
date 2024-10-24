@extends ('modeles/visiteur')
    @section('menu')
            <!-- Division pour le sommaire -->
        <div id="menuGauche">
            <div id="infosUtil">
                  
             </div>  
               <ul id="menuList">
                   <li >
             
                   <strong>Bonjour {{$comptable['nom'] ." ".$comptable['prenom']}}</strong>
                   <br> <br>
                   <strong>Role  : Comptable
                      
                  </strong>

                   </li>
                  <li class="smenu">
                     <a href="{{route('cheminVisiteur')}}" title="Affiche Nom Visiteur ">Suivie fiche Frais</a>
                  </li>
                
               <li class="smenu">
                <a href="{{ route('chemin_deconnexion') }}" title="Se déconnecter">Déconnexion</a>
                  </li>
                </ul>
               
        </div>
    @endsection          