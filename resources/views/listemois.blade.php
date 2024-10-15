@extends ('sommaire')
    @section('contenu1')
      <div id="contenu">
        <h2>Mes fiches de frais</h2>
        <h3>Mois à sélectionner : </h3>
      <form action="{{ route('chemin_listeFrais') }}" method="post">
        {{ csrf_field() }} <!-- laravel va ajouter un champ caché avec un token -->
        <div class="corpsForm"><p>
          <label for="lstMois" >Mois : </label>
          <select id="lstMois" name="lstMois">
              @foreach($lesMois as $mois)
                  @if ($mois['mois'] == $leMois)
                    <option selected value="{{ $mois['mois'] }}">
                      {{ $mois['numMois']}}/{{$mois['numAnnee'] }} 
                    </option>
                  @else 
                    <option value="{{ $mois['mois'] }}">
                      {{ $mois['numMois']}}/{{$mois['numAnnee'] }} 
                    </option>
                  @endif
              @endforeach
          </select>
        </p>
        </div>
        <div class="piedForm">
        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
        </div>
          
        </form>
  @endsection 
 