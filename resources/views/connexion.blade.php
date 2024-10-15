@extends ('modeles/visiteur')
 @section('contenu1')
<div id = "contenu">
    <h2>Identification utilisateur</h2>
<form method = "post" action = "">
        {{ csrf_field() }} <!-- laravel va ajouter un champ caché avec un token -->
        @includeWhen($erreurs != null , 'msgerreurs', ['erreurs' => $erreurs]) 
        <p>
        <label for = "nom">Login*</label>
        <input id = "login" type = "text" name = "login"  size = "30" maxlength = "45" required >
        </p>
        <p>
        <label for = "mdp">Mot de passe*</label>
        <input id = "mdp"  type = "password"  name = "mdp" size = "30" maxlength = "45" required>
        </p>
       <input type = "submit" value = "Valider" name = "valider">
       <input type = "reset" value = "Annuler" name = "annuler"> 
        </p>
    </form>
</div>
@endsection