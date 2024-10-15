@extends ('listemois')
@section('contenu2')

<h3>Fiche de frais du mois {{ $numMois }}-{{ $numAnnee }} : 
    </h3>
    <div class="encadre">
    <p>
    Etat : <strong>{{ $libEtat }} depuis le {{ $dateModif }} </strong>
         <br> Montant validé : <strong>{{ $montantValide }} </strong>
     </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
        <tr>
            @foreach($lesFraisForfait as $unFraisForfait)
			    <th> {{$unFraisForfait['libelle']}} </th>
            @endforeach
		</tr>
        <tr>
            @foreach($lesFraisForfait as $unFraisForfait)
                <td class="qteForfait">{{ $unFraisForfait['quantite'] }} 
                </td>
            @endforeach
		</tr>
    </table>
  	</div>
@endsection