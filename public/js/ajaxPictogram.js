let myRequest;
let responseData;
const speech = new SpeechSynthesisUtterance();

getData("/api/get/category");

/* Requête Category */
function getData(url) {
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponse;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
}
/* end Requête Category */

/* Réponse Category */
function getResponse(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    responseData=JSON.parse(myRequest.responseText);
                    parcoursJSON(responseData)
                    break
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}
/* end Réponse Category */

/* Parcours Objets Category */
function parcoursJSON(jsonObj) {
    // Affiche d'abord les catégories les plus utilisées
    $(".contentC").append('<div id="1" class="picto categorie audioC mx-4" title="Sujets" ><img src="/images/categories/sujets.png" alt="Sujet"></div>');
    $(".contentC").append('<div id="3" class="picto categorie audioC mx-4" title="Actions" ><img src="/images/categories/actions.png" alt="Action"></div>');
    $(".contentC").append('<div id="10" class="picto categorie audioC mx-4" title="Petits mots" ><img src="/images/categories/determinants.png" alt="Petits mots"></div>');
    // Parcourt les objets JSON
    for(let i=0; i< jsonObj.length;i++){
        let categorie = jsonObj[i]['name'];
        let imageCategorie = jsonObj[i]['filename'];
        let idCategorie = jsonObj[i]['id'];
        // Evite les catégories affichées précédemment
        if (categorie === 'Sujets' || categorie === 'Actions' || categorie === 'Petits mots') {
            continue
        }
        // Affiche les catégories
            $(".contentC").append('<div id="'+idCategorie+'" class="picto categorie audioC mx-4" title="'+categorie+'" ><img src="/images/categories/'+imageCategorie+'" alt="'+categorie+'"></div>');
    }
    // Au clic d'une catégorie
    $(".audioC").click(function(){
        categorie = $(this).attr('title');
        // La synthèse vocale lit son titre
            speech.text = categorie;
            speech.pitch = 1; // 0 à 2 = Hauteur
            speech.rate = 1; // 0.5 à 2 = Vitesse
            speech.volume = 0.5; // 0 à 1 = Volume
            speech.lang = 'fr-FR'; // Langue
            speechSynthesis.speak(speech);
        // Appelle l'API des pictogrammes reliés à la catégorie
        getData1("/api/get/pictogram");
        getCategorie(categorie);
    });
}
/* end Parcours Objets Categories */

/* Getter Categorie */
function getCategorie(categorie){
    return categorie;
};
/* end Getter Categorie */

/* Requête Pictogram */
function getData1(url) {
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponse1;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
}
/* Requête Pictogram */

/* Réponse Pictogram */
function getResponse1(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    responseData=JSON.parse(myRequest.responseText);
                    categorie = getCategorie(categorie);
                    parcoursJSON1(responseData,categorie);
                    break;
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}
/* Réponse Pictogram */

/* Parcours Objets Pictogram */
function parcoursJSON1(jsonObj, categorie) {
    let countDiv = $(".contentP > div ").length;
    if(countDiv === 0){ // Si aucun pictogramme n'est présent
        for(let i = 0; i< jsonObj.length; i++){
            if(jsonObj[i]['category']['name'] === categorie){
                let filename = jsonObj[i]['filename'];
                let name = jsonObj[i]['name'].toLowerCase();
                let id = jsonObj[i]['id'];
                // Affiche les pictogrammes désirés
                $(".contentP").append('<div id="'+id+'" class="picto audioP mx-4" title="'+name+'" ><img src="/images/pictograms/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
                $(".picto .imgP").draggable({   // Les pictogrammes du carousel deviennent draggable
                    helper: 'clone',    // Le pictogramme est cloné
                    revert: 'invalid',  // Le retour ne se produit que si le draggable n'a pas été déposé sur un droppable
                    start:function(){
                        if($(this).hasClass("droppedPicto")){
                            $(this).removeClass("droppedPicto");
                            $(this).parent().removeClass("pictoPresent");
                        }
                    },
                    appendTo: "body",
                    snap: ".drop"
                });
            }
        }
    } else {
        $(".contentP > div").remove();
        countDiv = 0;
        for(let i = 0; i< jsonObj.length; i++){
            if(jsonObj[i]['category']['name'] === categorie){
                let filename = jsonObj[i]['filename'];
                let name = jsonObj[i]['name'];
                let id = jsonObj[i]['id'];
                $(".contentP").append('<div id="'+id+'" class="picto audioP mx-4" title="'+name+'" ><img src="/images/pictograms/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
                $(".picto .imgP").draggable({   // Les pictogrammes du carousel deviennent draggable
                    helper: 'clone',    // Le pictogramme est cloné
                    start:function(){
                        if($(this).hasClass("droppedPicto")){
                            $(this).removeClass("droppedPicto");
                            $(this).parent().removeClass("pictoPresent");
                        }
                    },
                    revert: 'invalid',  // Le retour ne se produit que si le draggable n'a pas été déposé sur un droppable
                    appendTo: 'body',
                    snap: '.drop'

                });
            }
        }
    }
    $(".audioP").mousedown(function(){  // Lorsque la souris intervient sur un pictogramme
        speech.text = $(this).attr('title');
        speech.pitch = 1; // 0 à 2 = Hauteur
        speech.rate = 1; // 0.5 à 2 = Vitesse
        speech.volume = 0.5; // 0 à 1 = Volume
        speech.lang = 'fr-FR'; // Langue
        speechSynthesis.speak(speech);
    });
}
/* end Parcours Objets Pictogram */
