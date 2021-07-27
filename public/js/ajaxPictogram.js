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
        getData1("/api/get/pictogram", "/api/get/subcategory");
        getCategorie(categorie);
    });
}
/* end Parcours Objets Categories */




/* Requête Pictogram */
function getData1(url,url1) { // url = api/get/pictogram  url1 = api/get/subcategory
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponse1;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
    myRequest1=new XMLHttpRequest();
    myRequest1.onreadystatechange+=getResponse1;
    myRequest1.open("GET", url1);
    myRequest1.setRequestHeader("content-type","application-json");
    myRequest1.send();
}
/* Requête Pictogram */


/* Réponse Pictogram */
function getResponse1(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE && myRequest1.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status && myRequest1.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    categorie = getCategorie(categorie);
                    responseData1=JSON.parse(myRequest1.responseText);
                    responseData=JSON.parse(myRequest.responseText);
                    parcoursJSON1(categorie,responseData1,responseData);
                    break;
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}

/* Getter Categorie */
function getCategorie(categorie){
    return categorie;
};
/* end Getter Categorie */

/* Parcours SubCategory Pictogram */
function parcoursJSON1(categorie, jsonObj1,jsonObj) {  //
    // console.log(jsonObj); 
    let countDiv = $(".contentP > div ").length;
    if(countDiv === 0){ // Si aucun pictogramme n'est présent
        for(let i=0; i< jsonObj1.length;i++){
            if(jsonObj1[i]['category_id']['name'] === categorie){
                let filename = jsonObj1[i]['filename'];
                let name = jsonObj1[i]['name'].toLowerCase();
                let id = jsonObj1[i]['id'];
                
                // Affiche les sous-catégories
                $(".contentP").append('<div id="'+id+'" class="sous-categorie subcat audioSCP mx-4" title="'+name+'" ><img src="/images/sous-categories/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
            }
        }
        for(let i = 0; i< jsonObj.length; i++){
            if (jsonObj[i]['category']) {
                if(jsonObj[i]['category']['name'] === categorie){
                    // console.log('test')
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
                        snap: ".drop",
                    });
                }
            }
        }
    } else {
        $(".contentP > div").remove();
        $(".contentSCP > div").remove();
        countDiv = 0;
        for(let i=0; i< jsonObj1.length;i++){
            if(jsonObj1[i]['category_id']['name'] === categorie){
                let filename = jsonObj1[i]['filename'];
                let name = jsonObj1[i]['name'].toLowerCase();
                let id = jsonObj1[i]['id'];
                // Affiche les sous-catégories
                $(".contentP").append('<div id="'+id+'" class="sous-categorie subcat audioSCP mx-4" title="'+name+'" ><img src="/images/sous-categories/'+filename+'" class="imgP " title="'+name+'" alt="'+name+'"></div>');
            }
        }
        for(let i = 0; i< jsonObj.length; i++){
            if (jsonObj[i]['category']) {
                if(jsonObj[i]['category']['name'] === categorie){
                    let filename = jsonObj[i]['filename'];
                    let name = jsonObj[i]['name'];
                    let id = jsonObj[i]['id'];
                    $(".contentP").append('<div id="'+id+'" class="audioP picto mx-4" title="'+name+'" ><img src="/images/pictograms/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
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
                        snap: '.drop',
                    });
                }
            }
        }
    }    
}   
/* end Parcours SubCategory Pictogram */

$(document).on("click", ".audioSCP", function(e) { // Lorsque la souris intervient sur un pictogramme
    // $(".audioSCP").click(function(){ 
        subcategorie = $(this).attr('title'); 
        speech.text = subcategorie;
        speech.pitch = 1; // 0 à 2 = Hauteur
        speech.rate = 1; // 0.5 à 2 = Vitesse
        speech.volume = 0.5; // 0 à 1 = Volume
        speech.lang = 'fr-FR'; // Langue
        speechSynthesis.speak(speech);
        getData2("/api/get/pictogram");
        getSubCategorie(subcategorie);
    });


$(document).on("mousedown", ".audioP", function(e) { // Lorsque la souris intervient sur un pictogramme
// $(".audioP").mousedown(function(){
    speech.text = $(this).attr('title');
    speech.pitch = 1; // 0 à 2 = Hauteur
    speech.rate = 1; // 0.5 à 2 = Vitesse
    speech.volume = 0.5; // 0 à 1 = Volume
    speech.lang = 'fr-FR'; // Langue
    speechSynthesis.speak(speech);
});


/* Getter Categorie */
function getSubCategorie(subcategorie){
    return subcategorie;
};
/* end Getter Categorie */

/* Requête Category */
function getData2(url) {
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponse2;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
}
/* end Requête Category */

/* Réponse Pictogram */
function getResponse2(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    responseData=JSON.parse(myRequest.responseText);
                    subcategorie = getSubCategorie(subcategorie);
                    parcoursJSON2(responseData,subcategorie);
                    break;
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}

function parcoursJSON2(jsonObj, subcategorie) {
    let countDiv = $(".contentSCP > div ").length;
    if(countDiv === 0){ // Si aucun pictogramme n'est présent
        for(let i = 0; i<jsonObj.length; i++){ 
            //console.log(jsonObj[i]);
            if (jsonObj[i]["category"]) {
                continue;
            } else {
                let json = jsonObj[i]['subcategory_id']['name'].toLowerCase();
                let subcat = subcategorie.toLowerCase();
                if(json === subcat){
                    let filename = jsonObj[i]['filename'];
                    let name = jsonObj[i]['name'].toLowerCase();
                    let id = jsonObj[i]['id'];
                    // Affiche les pictogrammes désirés
                    $(".contentSCP").append('<div id="'+id+'" class="picto audioSCP1 mx-4" title="'+name+'" ><img src="/images/pictograms/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
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
                        snap: ".drop",
                    });
                }
            } 
        }
    } else {
        $(".contentSCP > div").remove();
        countDiv = 0;
        for(let i = 0; i< jsonObj.length; i++){
            if (jsonObj[i]["category"]) {
                continue;
            } else {
                let json = jsonObj[i]['subcategory_id']['name'].toLowerCase();
                let subcat = subcategorie.toLowerCase();
                if(json === subcat){
                    let filename = jsonObj[i]['filename'];
                    let name = jsonObj[i]['name'].toLowerCase();
                    let id = jsonObj[i]['id'];
                    // Affiche les pictogrammes désirés
                    $(".contentSCP").append('<div id="'+id+'" class="picto audioSCP1 mx-4" title="'+name+'" ><img src="/images/pictograms/'+filename+'" class="imgP" title="'+name+'" alt="'+name+'"></div>');
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
                        snap: ".drop",
                    });
                }
            } 
        }
    }
    $(".audioSCP1").mousedown(function(){  // Lorsque la souris intervient sur un pictogramme
        speech.text = $(this).attr('title');
        speech.pitch = 1; // 0 à 2 = Hauteur
        speech.rate = 1; // 0.5 à 2 = Vitesse
        speech.volume = 0.5; // 0 à 1 = Volume
        speech.lang = 'fr-FR'; // Langue
        speechSynthesis.speak(speech);
    });
}