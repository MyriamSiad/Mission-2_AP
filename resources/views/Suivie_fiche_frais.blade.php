@extends ('sommaire_comptable')


    @section('contenu1')
      <div id="contenu">
 
      <form  action="{{route('cheminRemboursement')}}" id = "formulaire" method="POST">
        {{ csrf_field() }} <!-- laravel va ajouter un champ caché avec un token -->
        <h1>Liste des fiches à Valider : </h1>
       
        @foreach($lesVisiteurs as $visiteur)
        <div class="card" id = "card">
          <h5 class="card-header">{{ $visiteur['nom'] }} - {{ $visiteur['prenom'] }}</h5>
          <div class="card-body">
            
            <h5 class="card-title"> Date : {{ $visiteur['mois'] }}  </h5>
            <h6 class="card-title"> Etat : {{ $visiteur['etat'] }}  </h5>
            <p class="card-text"> Montant :  {{ $visiteur['montant'] }}  € </p>
            <p> <strong> Selectionner : </strong>
            <input type="checkbox"  class="btn btn-primary" name="visiteur_ids[]" value="{{$visiteur['id']}}-{{$visiteur['mois']}}" />
            </p> 
          </div>
          
        </div>  
        
          @endforeach
        
          <div class="piedForm">
         

              <button  id="ok" type="submit" value="Valider"  class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Valider
              </button>
             
              <button  id="annuler" type="reset" type="submit" value="Effacer" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off"> Effacer
              </button>
          
           
            </div>
          </form>

    
        <!-- On affiche les récement remboursé une fois qu'on a valider -->
       
       
        <h1>Liste des visiteurs récemment remboursé</h1>
        <table class="table table-striped-columns table-bordered Rembourser">
          <thead class="table-success">
            <tr >
              <th scope="col">#</th>
              <th scope="col">Nom</th>
              <th scope="col">Prenom </th>
              <th scope="col">Montant</th>
              <th scope="col">Mois</th>
              <th scope="col">Etat</th>
              <th scope="col">Date de Validation </th>
              <th scope="col">Date de remboursement</th>
          
            </tr>
          </thead>
          @if (isset($Validations))
            <tbody  class="table-group-divider ">
              {{ $i = 1 }}
              @foreach($Validations as $valider)
            
                <tr>
                  <td> {{ $i++}} </td>
                  
                
                  <td>{{$valider['nom'] }} </td>
                  <td> {{$valider['prenom'] }}</td>
                  <td>{{ $valider['montant'] }}</td>
                  <td>{{$valider['mois'] }}</td>
                  <td>{{ $valider['etat'] }}</td>
                  <td>{{ $valider['date'] }}</td>
                  <td>{{ $valider['date'] }}</td>
                 
                  
                </tr> <!-- Assurez-vous que 'id' existe dans la base de données -->
                  
             @endforeach
              
            </tbody>

        </table>

     
@endif

@endsection 