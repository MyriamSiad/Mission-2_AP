@extends ('sommaire_comptable')


    @section('contenu1')
      <div id="contenu">
 
     
        {{ csrf_field() }} <!-- laravel va ajouter un champ caché avec un token -->
        <h1>Liste des visiteurs</h1>


        <!-- Liste déroulante -->
        
        <table class="table table-striped-columns table-bordered ">
          <thead class=" table-info">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nom</th>
              <th scope="col">Prenom </th>
              <th scope="col">Montant</th>
              <th scope="col">Mois</th>
              <th scope="col">Etat</th>
              <th scope="col">Date de Validation </th>
              <th scope="col">Date de remboursement</th>
             <!-- <th scope="col">Selectionner / Valider </th>// -->
            </tr>
          </thead>
         
            <tbody class="table-group-divider">
              {{ $i = 1 }}
              @foreach($lesFiches as $fiche)
            
                <tr >
                  <td> {{ $i++}} </td>
                  
                
                  <td >{{$fiche['nom'] }} </td>
                  <td> {{$fiche['prenom'] }}</td>
                  <td>{{ $fiche['montant'] }}</td>
                  <td>{{ $fiche['mois'] }}</td>
                  <td>{{ $fiche['etat'] }}</td>
                  <td>{{ $fiche['dateModif'] }}</td>
                  <td> A venir</td>     
                  
                </tr> 
                  
             @endforeach
              
            </tbody>
        </table>
          
        <div class="piedForm">
        <p>
          <form action="{{route('cheminEditionPDF')}}" method="POST">
            {{ csrf_field() }}
          <button type="submit" class="btn btn-primary">Exporter en PDF</button>
          
        </p> 
        </div>
          
        </form>

       

@endsection 