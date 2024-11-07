

function realoadForm()
{

    var formulaire = document.getElementById("formulaire");

    formulaire.addEventListener("submit", function(event) {
    location.reload(true)// Empêche l'envoi normal du formulaire
    
    
    });


} 