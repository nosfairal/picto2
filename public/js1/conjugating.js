let sentenceToConjug = $("#sentenceText"); // Champs de la phrase
let word = [];
let vowel = ["a", "e", "é", "è", "i", "o", "u", "y"];
let verbConj = true;
let femPlur = false;
let femSing = false;
let mascPlur = false;
let mascSing = false;

/* Requête Pictogram à Conjuguer */
function getDataConj(url) {
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponseConj;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
}
/* Requête Pictogram Pictogram à Conjuguer */

/* Réponse Pictogram à Conjuguer */
function getResponseConj(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    responseData=JSON.parse(myRequest.responseText);
                    parcoursJSONConj(responseData);
                    parcoursJSONPlur(responseData);
                    break;
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}
/* Réponse Pictogram à Conjuguer */

/* Parcours Objets Pictogramme à Conjuguer */
function parcoursJSONConj(jsonObj) {
    let phrase = [];
    let premierVerbe;
    let infinitifVerbe;
    // word = sentenceToConjug.text().split(' ');
    for(let i = 0; i< jsonObj.length; i++) {
        let name = jsonObj[i]['name'].toLowerCase();        // Renvoie le nom,       
        let premPersSing = jsonObj[i]['prem_pers_sing'];    // la première personne du singulier,
        let deuxPersSing = jsonObj[i]['deux_pers_sing'];    // la deuxième,
        let troisPersSing = jsonObj[i]['trois_pers_sing'];  // la troisième,
        let premPersPlur = jsonObj[i]['prem_pers_plur'];    // la première personne du pluriel,
        let deuxPersPlur = jsonObj[i]['deux_pers_plur'];    // la deuxième,
        let troisPersPlur = jsonObj[i]['trois_pers_plur'];  // la troisième
        // Si un verbe est déjà présent alors ne conjugue plus rien

            /* Conjugaison */
       if ((premPersSing === name.substring(0, name.length-1)) || (name == 'être') || (name == 'avoir') || (name == 'descendre') || (name == 'se moucher') || (name == "s'habiller") || (name == "se déshabiller") || (name == 'mettre') || (!sentenceToConjug.text().includes(premPersSing) && !sentenceToConjug.text().includes(deuxPersSing) && !sentenceToConjug.text().includes(troisPersSing) && !sentenceToConjug.text().includes(premPersPlur) && !sentenceToConjug.text().includes(deuxPersPlur) && !sentenceToConjug.text().includes(troisPersPlur))) {
            if (sentenceToConjug.text().includes("je") || sentenceToConjug.text().includes("Je") || sentenceToConjug.text().includes("j'") || sentenceToConjug.text().includes("J'")) { // Conjugaison à la première personne du singulier
                if (premPersSing !== null) { // Si le mots en question peut être conjugué
                    if (sentenceToConjug.text().includes(" " + name + " ") || sentenceToConjug.text().includes("'" + name + " ")) { // Et si le mot en question apparaît dans le champs phrase
                        phrase.push(name); 
                      
                        if (phrase.length === 1){ 
                            premierVerbe = premPersSing;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+premPersSing+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, premPersSing)); // Alors remplace le par sa variante
                            if (vowel.includes(premPersSing.charAt(0)) && sentenceToConjug.text().includes("je ")) { // Si le verbe commence par une voyelle
                                sentenceToConjug.text(sentenceToConjug.text().replace("je ", "j'")); // Alors remplace "je" par "j'"
                            } else if (vowel.includes(premPersSing.charAt(0)) && sentenceToConjug.text().includes("Je ")) {
                                sentenceToConjug.text(sentenceToConjug.text().replace("Je ", "J'"));
                            }
                        } 
                    }
                }
            } else if (sentenceToConjug.text().includes("tu") || sentenceToConjug.text().includes("Tu")) { // Conjugaison à la deuxième personne du singulier
                if (deuxPersSing !== null) {
                    if (sentenceToConjug.text().includes(" " + name + " ")) {
                        phrase.push(name);
                        if (phrase.length === 1){
                            premierVerbe = deuxPersSing;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+deuxPersSing+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, deuxPersSing));                       
                        } 
                    }
                }
            } else if (sentenceToConjug.text().includes("nous") || sentenceToConjug.text().includes("Nous")) { // Conjugaison à la première personne du pluriel
                if (premPersPlur !== null) {
                    if (sentenceToConjug.text().includes(" " + name + " ")) {
                        phrase.push(name);
                        if (phrase.length === 1){
                            premierVerbe = premPersPlur;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+premPersPlur+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, premPersPlur));
                        }
                    }
                }
            } else if (sentenceToConjug.text().includes("vous") || sentenceToConjug.text().includes("Vous")) { // Conjugaison à la deuxième personne du pluriel
                if (deuxPersPlur !== null) {
                    if (sentenceToConjug.text().includes(" " + name + " ")) {
                        phrase.push(name);
                        if (phrase.length === 1){
                            premierVerbe = deuxPersPlur;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+deuxPersPlur+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, deuxPersPlur));
                        } 
                    }
                }
            } else if (sentenceToConjug.text().includes("eux") || sentenceToConjug.text().includes("Eux") || sentenceToConjug.text().includes("ils") || sentenceToConjug.text().includes("Ils") || sentenceToConjug.text().includes("elles") || sentenceToConjug.text().includes("Elles")) { // Conjugaison à la troisième personne du pluriel
                if (troisPersPlur !== null) {
                    if (sentenceToConjug.text().includes(" " + name + " ")) {
                        phrase.push(name);
                        if (phrase.length === 1){
                            premierVerbe = troisPersPlur;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+troisPersPlur+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, troisPersPlur));
                        }
                    }
                }
            } else {
                if(troisPersSing !== null) { // Conjugaison à la troisième personne du singulier                
                    if (sentenceToConjug.text().includes(" " + name + " ")) {   
                        phrase.push(name);
                        if (phrase.length === 1){
                            premierVerbe = troisPersSing;
                            infinitifVerbe = name;
                            // console.log("Cette phrase contient \""+name+"\" qui doit donc être remplacé par \""+troisPersSing+"\"");
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, troisPersSing));
                        } 
                    }
                }
            }
       }
    }
    recordingSentence();
            /* end Conjugaison */
    }
/* end Parcours Objets Pictogramme à Conjuguer */

/* Parcours Objets Pictogramme à Accorder au Pluriel */
function parcoursJSONPlur(jsonObj) {
    for(let i = 0; i< jsonObj.length; i++){
        /*if(jsonObj[i]['name'] === pictoToConj){*/ // Si le nom du pictogramme correspond au pictogamme passé en paramètre
        // console.log("Le pictogramme à conjuguer est \""+pictoToConj+"\"")
        let name = jsonObj[i]['name'].toLowerCase();
        let gender = jsonObj[i]['genre'];                   // Alors, renvoie le genre,
        let pluriel = jsonObj[i]['pluriel'];                // le pluriel,
        let masculinSing = jsonObj[i]['masculin_sing'];     // le masculin singulier
        let masculinPlur = jsonObj[i]['masculin_plur'];     // le masculin pluriel
        let femininSing = jsonObj[i]['feminin_sing'];       // le féminin singulier
        let femininPlur = jsonObj[i]['feminin_plur'];       // le féminin pluriel



        /* Pluriel */

        if (sentenceToConjug.text().includes(" des ") || sentenceToConjug.text().includes("Des ") || sentenceToConjug.text().includes(" mes ") || sentenceToConjug.text().includes("Mes ") || sentenceToConjug.text().includes(" tes ") || sentenceToConjug.text().includes("Tes ") || sentenceToConjug.text().includes(" ses ") || sentenceToConjug.text().includes("Ses ") || sentenceToConjug.text().includes(" les ") || sentenceToConjug.text().includes("Les ") || sentenceToConjug.text().includes(" ces ") || sentenceToConjug.text().includes("Ces ")) { // pluriel
            // console.log("Cette phrase contient un determinant du pluriel")
            if (sentenceToConjug.text().includes(name)[gender] === "féminin" && femininPlur !== null) {
                femPlur = true;
            } else if (sentenceToConjug.text().includes(name)[gender] === "masculin" && masculinPlur !== null) {
                mascPlur = true;
            }
            if (pluriel !== null) { // Si le mot peut s'accorder au pluriel

                if (sentenceToConjug.text().includes(" " + name + " ") || sentenceToConjug.text().includes("'" + name + " ")) {

                    sentenceToConjug.text(sentenceToConjug.text().replace(name, pluriel));
                }
            }
        } else {
            if (sentenceToConjug.text().includes(name)[gender] === "féminin" && femininSing !== null) {
                femSing = true;
            } else if (sentenceToConjug.text().includes(name)[gender] === "masculin" && masculinSing !== null) {
                mascSing = true;
            }
            if (femSing) {
                sentenceToConjug.text(sentenceToConjug.text().replace(name, femininSing));
            } else if (mascSing) {
                sentenceToConjug.text(sentenceToConjug.text().replace(name, masculinSing));
            }
        }
        recordingSentence();
        /* end Pluriel */
    }
}
function recordingSentence(){
    $('#sentence_text').val(sentenceToConjug.text()); // Donne sa valeur à l'input caché
}