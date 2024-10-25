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
                     <a href="{{route('cheminVisiteur')}}" title="Suivie fiche Frais">Suivie fiche Frais</a>
                  </li>

                </li>
                <li class="smenu">
                   <a href="{{route('cheminEdition')}}" title="Edtion Fiche Frais">Edition de fiche Frais</a>
                </li>
                
               <li class="smenu">
                <a href="{{ route('chemin_deconnexion') }}" title="Se déconnecter">Déconnexion</a>
                  </li>
                </ul>
               
        </div>
    @endsection          