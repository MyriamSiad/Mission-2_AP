@extends ('sommaire_comptable')


    @section('contenu1')
      <div id="contenu">
 
      <form action="{{route('cheminRemboursement')}}" method="POST">
        {{ csrf_field() }} <!-- laravel va ajouter un champ caché avec un token -->
        <h1>Liste des visiteurs</h1>


        <!-- Liste déroulante -->
        
        <table class="table table-striped-columns table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nom</th>
              <th scope="col">Prenom </th>
              <th scope="col">Montant</th>
              <th scope="col">Mois</th>
              <th scope="col">Etat</th>
              <th scope="col">Date de Validation </th>
              <th scope="col">Date de remboursement</th>
              <th scope="col">Selectionner / Valider </th>
            </tr>
          </thead>
         
            <tbody class="table-group-divider">
              {{ $i = 1 }}
              @foreach($lesVisiteurs as $visiteur)
            
                <tr>
                  <td> {{ $i++}} </td>
                  
                
                  <td>{{ $visiteur['nom'] }} </td>
                  <td> {{ $visiteur['prenom'] }}</td>
                  <td>{{ $visiteur['montant'] }}</td>
                  <td>{{ $visiteur['mois'] }}</td>
                  <td>{{ $visiteur['etat'] }}</td>
                  <td>{{ $visiteur['date'] }}</td>
                  <td>{{ $visiteur['date'] }}</td>
                  <td>
                    <input type="checkbox" name="visiteur_ids[]" value="{{$visiteur['id']}}-{{$visiteur['mois']}}" />
                </td>
                  
                </tr> 
                  
             @endforeach
              
            </tbody>
        </table>
          
        <div class="piedForm">
        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
        </div>
          
        </form>

        <!-- On affiche les récement remboursé une fois qu'on a valider -->
        @if (isset($Validations))
     
        <h1>Liste des visiteurs récemment remboursé</h1>
        <table class="table table-striped-columns table-bordered">
          <thead>
            <tr>
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
         
            <tbody class="table-group-divider">
              {{ $i = 1 }}
              @foreach($Validations as $valider)
            
                <tr>
                  <td> {{ $i++}} </td>
                  
                
                  <td>{{$valider['nom'] }} </td>
                  <td> {{ $valider['prenom'] }}</td>
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