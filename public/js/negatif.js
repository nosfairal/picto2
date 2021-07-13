
/* Requête Pictogrammes Négatif */
function getDataNeg(url) {
    myRequest=new XMLHttpRequest();
    myRequest.onreadystatechange=getResponseNeg;
    myRequest.open("GET", url);
    myRequest.setRequestHeader("content-type","application-json");
    myRequest.send();
}
/* Requête Pictogrammmes Négatif */

/* Réponse Pictogram Pictogrammes Négatif */
function getResponseNeg(){
    try {
        if (myRequest.readyState === XMLHttpRequest.DONE) {
            switch(myRequest.status) {
                case 500:
                    break;
                case 404:
                    break;
                case 200:
                    responseData=JSON.parse(myRequest.responseText);
                    parcoursJSONNeg(responseData);
                    parcoursJSONPlur(responseData);
                    break;
            }
        }
    }
    catch(ex){
        console.log("Ajax error: "+ex.description);
    }
}
/* Réponse Pictogrammes Négatif */

/* Parcours Objets Pictogramme Négatif */
function parcoursJSONNeg(jsonObj) {
    for(let i = 0; i< jsonObj.length; i++){
        let name = jsonObj[i]['name'].toLowerCase();        // Renvoie le nom,
        let premPersSing = jsonObj[i]['prem_pers_sing'];    // la première personne du singulier,
        let deuxPersSing = jsonObj[i]['deux_pers_sing'];    // la deuxième,
        let troisPersSing = jsonObj[i]['trois_pers_sing'];  // la troisième,
        let premPersPlur = jsonObj[i]['prem_pers_plur'];    // la première personne du pluriel,
        let deuxPersPlur = jsonObj[i]['deux_pers_plur'];    // la deuxième,
        let troisPersPlur = jsonObj[i]['trois_pers_plur'];  // la troisième,

        /* Négatif */
        // if (!sentenceToConjug.text().includes(premPersSing) && !sentenceToConjug.text().includes(deuxPersSing) && !sentenceToConjug.text().includes(troisPersSing) && !sentenceToConjug.text().includes(premPersPlur) && !sentenceToConjug.text().includes(deuxPersPlur) && !sentenceToConjug.text().includes(troisPersPlur)) {
            if (sentenceToConjug.text().includes("je") || sentenceToConjug.text().includes("Je")) { // Conjugaison à la première personne du singulier
                if (premPersSing !== null) { // Si le mots en question peut être conjugué et qu'il ne l'est pas déjà
                    if (sentenceToConjug.text().includes(name)) { // Et si le mot en question apparaît dans le champs phrase
                        if (vowel.includes(premPersSing.charAt(0))) {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + premPersSing + " pas")); // Alors remplace le par sa variante
                        } else {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + premPersSing + " pas")); // Alors remplace le par sa variante
                        }
                    }
                }
            } else if (sentenceToConjug.text().includes("tu") || sentenceToConjug.text().includes("Tu")) { // Conjugaison à la deuxième personne du singulier
                if (deuxPersSing !== null) {
                    if (sentenceToConjug.text().includes(name)) {
                        if (vowel.includes(premPersSing.charAt(0))) {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + deuxPersSing + " pas")); // Alors remplace le par sa variante
                        } else {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + deuxPersSing + " pas")); // Alors remplace le par sa variante
                        }
                    }
                }
            } else if (sentenceToConjug.text().includes("nous") || sentenceToConjug.text().includes("Nous")) { // Conjugaison à la première personne du pluriel
                if (premPersPlur !== null) {
                    if (sentenceToConjug.text().includes(name)) {
                        if (vowel.includes(premPersSing.charAt(0))) {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + premPersPlur + " pas")); // Alors remplace le par sa variante
                        } else {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + premPersPlur + " pas")); // Alors remplace le par sa variante
                        }
                    }
                }
            } else if (sentenceToConjug.text().includes("vous") || sentenceToConjug.text().includes("Vous")) { // Conjugaison à la deuxième personne du pluriel
                if (deuxPersPlur !== null) {
                    if (sentenceToConjug.text().includes(name)) {
                        if (vowel.includes(premPersSing.charAt(0))) {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + deuxPersPlur + " pas")); // Alors remplace le par sa variante
                        } else {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + deuxPersPlur + " pas")); // Alors remplace le par sa variante
                        }
                    }
                }
            } else if (sentenceToConjug.text().includes("eux") || sentenceToConjug.text().includes("Eux")) { // Conjugaison à la troisième personne du pluriel
                if (troisPersPlur !== null) {
                    if (sentenceToConjug.text().includes(name)) {
                        if (vowel.includes(premPersSing.charAt(0))) {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + troisPersPlur + " pas")); // Alors remplace le par sa variante
                        } else {
                            sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + troisPersPlur + " pas")); // Alors remplace le par sa variante
                        }
                    }
                }
            } else if (troisPersSing !== null) { // Conjugaison à la troisième personne du singulier
                if (sentenceToConjug.text().includes(name)) {
                    if (vowel.includes(premPersSing.charAt(0))) {
                        sentenceToConjug.text(sentenceToConjug.text().replace(name, "n'" + troisPersSing + " pas")); // Alors remplace le par sa variante
                    } else {
                        sentenceToConjug.text(sentenceToConjug.text().replace(name, "ne " + troisPersSing + " pas")); // Alors remplace le par sa variante
                    }
                }
            }
        // }
        recordingSentence();
        /* end Négatif */
    }
}
/* end Parcours Objets Pictogramme Négatif */