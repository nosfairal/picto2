/* Vocal */

/* Pictogramme */
$(".imgP").mousedown(function(){ // Lorsque la souris intervient sur un pictogramme
    speech.text = $(this).attr('title');
    speech.pitch = 1; // 0 à 2 = Hauteur
    speech.rate = 1; // 0.5 à 2 = Vitesse
    speech.volume = 0.5; // 0 à 1 = Volume
    speech.lang = 'fr-FR'; // Langue
    speechSynthesis.speak(speech);
});
/* end Pictogramme */

/* Phrase */
$("#play").click(() => {    // Au click sur le bouton "play"
    speech.text = $("#sentenceText").text();
    speech.pitch = 1; // 0 à 2 = Hauteur
    speech.rate = 1; // 0.5 à 2 = Vitesse
    speech.volume = 0.5; // 0 à 1 = Volume
    speech.lang = 'fr-FR'; // Langue
    speechSynthesis.speak(speech);
})
/* end Phrase */


/*variable globale*/
var countWord=0;

/*lecture mot à mot*/
function wordByword() {
    let sentence = $("#sentenceText").text();// variable pour récupérer le texte de la phrase
    let  tabWord=[]; //tableau de mot
    tabWord = sentence.split(" "); //tableau de mot découpé

    if (countWord == 0){ 
        var brightWord = tabWord[countWord] + " ";// mot lu (en fonction de sa position dans le tableau)
    } else {
        var brightWord = " " + tabWord[countWord] + " ";// mot lu (en fonction de sa position dans le tableau)
    }
    // console.log(brightWord);

    if (countWord === tabWord.length - 1) {// si le compteur est égale à la taille du tableau -1 alors on remplace le mot lu par un span avec une classe speciale et on remet le compteur à 0
        speech.text = tabWord[countWord];
        speech.pitch = 1; // 0 à 2 = Hauteur
        speech.rate = 1; // 0.5 à 2 = Vitesse
        speech.volume = 0.5; // 0 à 1 = Volume
        speech.lang = 'fr-FR'; // Langue
        speechSynthesis.speak(speech);
        let replace = sentence.replace(brightWord, '<span class="brightWord">' + brightWord + '</span>');
        // console.log(replace);
        $("#sentenceText").html(replace);
        countWord = 0;

    } else {// sinon on fait la même chose mais on incrémente le compteur pour lire le mot suivant
        speech.text = tabWord[countWord];
        speech.pitch = 1; // 0 à 2 = Hauteur
        speech.rate = 1; // 0.5 à 2 = Vitesse
        speech.volume = 0.5; // 0 à 1 = Volume
        speech.lang = 'fr-FR'; // Langue
        speechSynthesis.speak(speech);
        let replace = sentence.replace(brightWord, '<span class="brightWord">' + brightWord + '</span>');
        // console.log(replace);
        $("#sentenceText").html(replace);
        countWord++;
    }
}
//lecture de la fonction wordByWord au click
$("#playWordByWord").on("click", function() {
    wordByword();
})

/*fin lecture mot à mot

 */
/* Mise à jour de la phrase */
function textUpdate(){
    sentenceToConjug.text("");
    let pictograms = [];    // Tableau qui contiendra les mots correspondants aux pictos droppés
    let i = 1;
    $('.drop').each(function(){ // Parcourt les zones de drop
        if ($("#mot"+i).children().attr('alt') !== undefined) { // Si la zone de drop contient un picto
            pictoWord = $("#mot"+i).children().attr('alt'); // Récupère le mot correspondant au pictogramme
            if (pictoWord == "l'" || pictoWord == "L'" || pictoWord == "j'" || pictoWord == "J'") {
                pictoWordSpace = pictoWord;
            } else {
                pictoWordSpace = pictoWord + ' ';
            }
            pictograms.push(pictoWordSpace); // Et l'envoie dans le tableau
        }
        i++;
    })
    let sentence = pictograms.join('');    // Join les éléments du tableau par un espace
    
    starLevel(sentence);
    getDataConj("/api/get/pictogram"); // (récupère les variantes du pictogramme pour la conjugaison)
    sentence = sentence.charAt(0).toUpperCase() + sentence.substring(1).toLowerCase(); // Met la première lettre de la phrase en majuscule, et le reste en minuscule
    $("#sentenceText").append(sentence);  // Affiche la phrase dans la zone prévue pour
    $('#sentence_text').val(sentenceToConjug.text()); // Donne sa valeur à l'input caché
}
/* end Mise à jour de la phrase */

/* Mise à jour de la phrase NEGATIF */
function negUpdate() {
    sentenceToConjug.text("");
    let pictograms = [];    // Tableau qui contiendra les mots correspondants aux pictos droppés
    let i = 1;
    $('.drop').each(function(){ // Parcourt les zones de drop
        let pictoWord;
        if ($("#mot" + i).children().attr('alt') !== undefined) { // Si la zone de drop contient un picto
            pictoWord = $("#mot" + i).children().attr('alt'); // Récupère le mot correspondant au pictogramme
            if (pictoWord == "l'" || pictoWord == "L'" || pictoWord == "j'" || pictoWord == "J'") {
                pictoWordSpace = pictoWord;
            } else {
                pictoWordSpace = pictoWord + ' ';
            }
            pictograms.push(pictoWordSpace); // Et l'envoie dans le tableau
        }
        i++;
    })
    if (pictograms.length <= 1) {
        alert("La phrase n'est pas assez complète pour être négative");
    } else if (pictograms.length >=2) {
        getDataNeg("/api/get/pictogram"); // (récupère les variantes du pictogramme pour la conjugaison)
    }
    let sentence = pictograms.join('');    // Join les éléments du tableau par un espace
    starLevel(sentence);
    sentence = sentence.charAt(0).toUpperCase() + sentence.substring(1).toLowerCase(); // Met la première lettre de la phrase en majuscule, et le reste en minuscule
    $("#sentenceText").append(sentence);  // Affiche la phrase dans la zone prévue pour
}
/* end Mise à jour de la phrase NEGATIF */

/* Poubelle */
$("#trash").click(() => {
    $("#sentenceText").html('');    // La zone de texte se vide
    $("#drop > div > img").remove();    // Les zones droppables se vident
    $("#drop > div").removeClass("pictoPresent"); // Les classes de contraintes se retirent
    $(".fa-star").css("color", "#ffffff"); //l'étoile redevient blanche
})
/* end Poubelle */

/* Star */
function starLevel(sentence) {
    let picto=$(".drop").children().length;//Compte le nombre de picto dans la phrase
    console.log(picto)
    let star = document.querySelector(".fa-star")
    if(picto===0){star.style.color="#ffffff"} // modifie la couleur de l'étoile en fonction du nombre de pictogrammes droppés
    if(picto===1){star.style.color="#fff2d4"}
    if(picto===2){star.style.color="#eed58f"}
    if(picto===3){star.style.color="#ffe79b"}
    if(picto===4){star.style.color="#fade5d"}
    if(picto===5){star.style.color="#fdd54b"}
    if(picto===6){star.style.color="#eee310"}
}
/* end Star */

/* Négatif/Affirmatif */
$("#neg").click(() => { // Au click sur le bouton "négation"
    negUpdate();        // Fait le traitement relatif à la négation
})
$("#pos").click(() => {
    textUpdate();
})
/* end Négatif/Positif */

/* Mise à jour de la phrase Futur */
function futurUpdate() {
    sentenceToConjug.text("");
    let pictograms = [];    // Tableau qui contiendra les mots correspondants aux pictos droppés
    let i = 1;
    $('.drop').each(function(){ // Parcourt les zones de drop
        let pictoWord;
        if ($("#mot" + i).children().attr('alt') !== undefined) { // Si la zone de drop contient un picto
            pictoWord = $("#mot" + i).children().attr('alt'); // Récupère le mot correspondant au pictogramme
            if (pictoWord == "l'" || pictoWord == "L'" || pictoWord == "j'" || pictoWord == "J'") {
                pictoWordSpace = pictoWord;
            } else {
                pictoWordSpace = pictoWord + ' ';
            }
            pictograms.push(pictoWordSpace); // Et l'envoie dans le tableau
        }
        i++;
    })
    if (pictograms.length <= 1) {
        alert("La phrase n'est pas assez complète pour être futur");
    } else if (pictograms.length >=2) {
        getDataFutur("/api/get/pictogram"); // (récupère les variantes du pictogramme pour la conjugaison)
    }
    let sentence = pictograms.join('');    // Join les éléments du tableau par un espace
    starLevel(sentence);
    sentence = sentence.charAt(0).toUpperCase() + sentence.substring(1).toLowerCase(); // Met la première lettre de la phrase en majuscule, et le reste en minuscule
    $("#sentenceText").append(sentence);  // Affiche la phrase dans la zone prévue pour
}
/* end Mise à jour de la phrase Futur */
$("#futur").click(() => { // Au click sur le bouton "futur"
    futurUpdate();        // Fait le traitement relatif à la futur
})





/* Mise à jour de la phrase Passé */
function passeUpdate() {
    sentenceToConjug.text("");
    let pictograms = [];    // Tableau qui contiendra les mots correspondants aux pictos droppés
    let i = 1;
    $('.drop').each(function(){ // Parcourt les zones de drop
        let pictoWord;
        if ($("#mot" + i).children().attr('alt') !== undefined) { // Si la zone de drop contient un picto
            pictoWord = $("#mot" + i).children().attr('alt'); // Récupère le mot correspondant au pictogramme
            if (pictoWord == "l'" || pictoWord == "L'" || pictoWord == "j'" || pictoWord == "J'") {
                pictoWordSpace = pictoWord;
            } else {
                pictoWordSpace = pictoWord + ' ';
            }
            pictograms.push(pictoWordSpace); // Et l'envoie dans le tableau
        }
        i++;
    })
    if (pictograms.length <= 1) {
        alert("La phrase n'est pas assez complète pour être passé");
    } else if (pictograms.length >=2) {
        getDataPasse("/api/get/pictogram"); // (récupère les variantes du pictogramme pour la conjugaison)
    }
    let sentence = pictograms.join('');    // Join les éléments du tableau par un espace
    newFunction();
    sentence = sentence.charAt(0).toUpperCase() + sentence.substring(1).toLowerCase(); // Met la première lettre de la phrase en majuscule, et le reste en minuscule
    $("#sentenceText").append(sentence);  // Affiche la phrase dans la zone prévue pour


    function newFunction() {
        starLevel(sentence);
    }
}
/* end Mise à jour de la phrase Passe */
$("#passe").click(() => { // Au click sur le bouton "passé"
    passeUpdate();        // Fait le traitement relatif à la passé
})

document.getElementById("mot1").ondblclick = function() {myFunction1()};
function myFunction1() {
    const varName1 = 'mot1';
    if(varName1==='mot1'){$("#mot1 > img").remove();$("#mot1").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot2").ondblclick = function() {myFunction2()};
function myFunction2() {
    const varName2 = 'mot2';
    if(varName2==='mot2'){$("#mot2 > img").remove();$("#mot2").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot3").ondblclick = function() {myFunction3()};
function myFunction3() {
    const varName3 = 'mot3';
    if(varName3==='mot3'){$("#mot3 > img").remove();$("#mot3").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot4").ondblclick = function() {myFunction4()};
function myFunction4() {
    const varName4 = 'mot4';
    if(varName4==='mot4'){$("#mot4 > img").remove();$("#mot4").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot5").ondblclick = function() {myFunction5()};
function myFunction5() {
    const varName5 = 'mot5';
    if(varName5==='mot5'){$("#mot5 > img").remove();$("#mot5").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot6").ondblclick = function() {myFunction6()};
function myFunction6() {
    const varName6 = 'mot6';
    if(varName6==='mot6'){$("#mot6 > img").remove();$("#mot6").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot7").ondblclick = function() {myFunction7()};
function myFunction7() {
    const varName7 = 'mot7';
    if(varName7==='mot7'){$("#mot7 > img").remove();$("#mot7").removeClass("pictoPresent")}
    textUpdate();
}
document.getElementById("mot8").ondblclick = function() {myFunction8()};
function myFunction8() {
    const varName8 = 'mot8';
    if(varName8==='mot8'){$("#mot8 > img").remove();$("#mot8").removeClass("pictoPresent")}
    textUpdate();
}document.getElementById("mot9").ondblclick = function() {myFunction9()};
function myFunction9() {
    const varName9 = 'mot9';
    if(varName9==='mot9'){$("#mot9 > img").remove();$("#mot9").removeClass("pictoPresent")}
    textUpdate();
}document.getElementById("mot10").ondblclick = function() {myFunction10()};
function myFunction10() {
    const varName10 = 'mot10';
    if(varName10==='mot10'){$("#mot10 > img").remove();$("#mot10").removeClass("pictoPresent")}
    textUpdate();
}