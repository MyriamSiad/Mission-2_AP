# gsb-laravel-master
Cas GSB en utilisant laravel  

- [Installation et Mise en oeuvre](#Installation-et-Mise-en-oeuvre)
  - [Installation](#Installation)
  - [Copie des fichiers de gsb](#Copie-des-fichiers-de-gsb)
- [Bugs à l'utilisation](#Bugs-à-l'utilisation)
  - [Erreur 404](#Erreur-404)
  - [Pas d'erreur affichée](#Pas-d'erreur-affichée)
  - [Debugger votre programme](#Debugger-votre-programme)
- [Exemple](#Exemple-créer-une-page-test)
  - [Étape 1 créer le lien dans le sommaire](#Étape-1-créer-le-lien-dans-le-sommaire)
  - [Étape 2 créer la route](#Étape-2-créer-la-route)
  - [Étape 3.1 Ajouter une méthode au contrôleur, EtatFraisController](#Étape-31-Ajouter-une-méthode-au-contrôleur-EtatFraisController)
  - [Étape 3.2 Ajouter une méthode à un nouveau contrôleur](#Étape-32-Ajouter-une-méthode-à-un-nouveau-contrôleur)
  - [Étape 4 Créer la vue ](#Étape-4-Créer-la-vue)

## Installation et Mise en oeuvre

### Installation
La première étape consiste à installer une version standard de LARAVEL. Pour cela, il est plus facile d'utiliser 
l'application **composer**. Pour tester si composer est actif saisir dans le terminal :
> composer -V

S'il n'y a rien et que vous utilisez Laragon allez dans le repertoire de composer en saisissant :
>cd le/chemin/de/composer

Une fois **composer** identifié saisissez :
> composer selfupdate

Composer sera mis à jour. En cas d'erreur, rien de grave, vous pouvez continuer le process.
* Déplacez-vous pour aller dans le répertoire de publication (www sous Windows).
* Ouvrez une console dans ce répertoire. Saisissez la première fois :
> composer global require laravel/installer
> Laravel new gsbLaravel
 - Vous allez avoir des questions que vous passerez par défaut.
 - Vérifiez bien à la fin que la base de donnée est bien `Mysql`
 - A la question suivante :  
     `Default database updated. Would you like to run the default database migrations? (yes/no)`  
     répondre no
   
Si votre base de données n'est pas chargée, saisir :
>php artisan migrate

### Copie des fichiers de gsb
* Téléchargez gsb-laravel-master
* Copiez les fichiers du zip dans votre répertoire
* Répondez que vous voulez modifier à chaque fois que la question est posée.
* Il faudra modifier si nécessaire les paramètres de connexion du fichier d'environnement :
>  .env 

## Bugs à l'utilisation
### Erreur 404
Une fois installé, avec laragon, vous pouvez rencontrer des erreurs avec les routes (erreur 404).  
Dans ce cas, il faut lancer le serveur interne de laravel.
1. Lancer le terminal
2. se déplacer dans le répertoire ou se trouve gsbLaravel
3. saisir : `php artisan serve`
4. Dans le navigateur saisir http://127.0.0.1:8000 
### Pas d'erreur affichée
Dans certains cas l'application "tourne" sans afficher d'erreurs.
Avec Laragon choisissez :
* le serveur apache
* la version 8.x.x de php
## Debugger votre programme
1. L'instruction **dd()** affiche les données passées en paramètre et stoppe le programme
2. L'instruction **dump()** affiche les données passées en paramètre et continue l'exécution
3. L'instruction **@dump()** a la même fonctionnalité que **dump()** mais s'exécute dans la vue.
4. Les logs sont visibles dans le répertoire **storage/logs**
5. Si la page d'erreur n'apparait pas, vous pouvez installer telescope : `php artisan telescope:install` 

2 outils pour debugger :
#### [laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
> composer require barryvdh/laravel-debugbar --dev
#### [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
> composer require --dev barryvdh/laravel-ide-helper

Cela donne accès à des commandes **artisan**
## Exemple créer une page test
Cet Exemple est valable pour le visiteur, à vous de l’adapter pour un autre type d’intervenant. 
### Étape 1 créer le lien dans le sommaire
```
<li class="smenu">  
<a href="{{ route('chemin_test') }}" title="test">test</a> 
</li>
```
### Étape 2 créer la route
Ici, on affiche des données, d'où la méthode GET.
```
Route::controller(etatFraisController::class)->group(function () {
  ...
 Route::get('/test', 'test')->name('chemin_test');
});

```
### Étape 31 Ajouter une méthode au contrôleur EtatFraisController
```
function test(){ 
    if( session('visiteur')!= null){    //Sans la session l’insertion du sommaire  
    $visiteur = session('visiteur');    //provoque une erreur 
    $idVisiteur = $visiteur['id']; 
    return view('test') ->with('visiteur',$visiteur); 
    } 
    else{ 
        return view('connexion')->with('erreurs',null); 
    } 
}
```
### Étape 32 Ajouter une méthode à un nouveau contrôleur
Dans ce cas il est préférable de créer le contrôleur avec **artisan**
>php artisan make:controller MonController

La suite est identique :
```
function test(){ 
    if( session('visiteur')!= null){    //Sans la session l’insertion du sommaire  
    $visiteur = session('visiteur');    //provoque une erreur 
    $idVisiteur = $visiteur['id']; 
    return view('test') ->with('visiteur',$visiteur); 
    } 
    else{ 
        return view('connexion')->with('erreurs',null); 
    } 
}
```
### Étape 4 Créer la vue 
```
@extends ('sommaire') 
    @section('contenu1') 
     <h1>titre</h1> 
    @endsection 
```
