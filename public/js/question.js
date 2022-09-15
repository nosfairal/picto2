/* Selection de la Question */
$("#question").change(function(){   // Au changement du select
    let question = $('#question option:selected').text();   // Cible le texte de la question sélectionnée
    const speech = new SpeechSynthesisUtterance();
    speech.text = question;
    speech.pitch = 1; // 0 à 2 = Hauteur
    speech.rate = 1; // 0.5 à 2 = Vitesse
    speech.volume = 0.5; // 0 à 1 = Volume
    speech.lang = 'fr-FR'; // Langue
    speechSynthesis.speak(speech);  // La synthèse vocale lit la question
    console.log(question);
    filterPictogram(question); // Filtre les pictogrammes en fonction de la question
})
/* end Selection de la Question */

/* Filtre des catégories */
function filterPictogram(question) {
    let categoryQuestion = []; // Tableau qui prendra les categories correspondant à la question
    let questionSelected = question; // Variable correspondant à la question sélectionnée
    if (questionSelected === 'Quel âge as-tu ?') { // Si la question sélectionnée correspond à telle chaîne de caractères
        categoryQuestion = ["Chiffres"];   // Alors sélectionne les pictogrammes de ces categories
    } else if (questionSelected === 'Qu\'as-tu mangé ce matin ?') {
        categoryQuestion = ["Fruits et légumes","Aliments"];
    } else if (questionSelected === 'Que veux-tu manger ?') {
        categoryQuestion = ["Aliments", "Fruits et légumes"];
    } else if (questionSelected === 'Quelle est ta boisson préférée ?') {
        categoryQuestion = ["Boissons"];
    } else if (questionSelected === 'Quel est ton sport préféré ?') {
        categoryQuestion = ["Sports"];
    } else if (questionSelected === 'Quel est ton animal préféré ?') {
        categoryQuestion = ["Animaux"];
    } else if (questionSelected === 'Quelle est ta couleur préférée ?') {
        categoryQuestion = ["Couleurs"];
    } else if (questionSelected === 'Avec quoi veux-tu jouer ?') {
        categoryQuestion = ["Jouet"];
    } else if (questionSelected === 'Que veux-tu faire plus tard ?') {
        categoryQuestion = ["Personnes"];
    } else if (questionSelected === 'Où aimes-tu aller ?') {
        categoryQuestion = ["Lieux"];
    } else if (questionSelected === 'Où as-tu mal ?') {
        categoryQuestion = ["Corps humain"];
    } else if (questionSelected === 'Comment te sens-tu ?') {
        categoryQuestion = ["Émotions"];
    } else if (questionSelected === 'Comment te sens-tu quand tu es à l\'école ?') {
        categoryQuestion = ["Émotions"];
    } else if (questionSelected === 'Comment te sens-tu quand tu es à la maison ?') {
        categoryQuestion = ["Émotions"];
    } else if (questionSelected === 'De quelle couleur sont tes yeux ?') {
        categoryQuestion = ["Couleurs"];
    } else if (questionSelected === 'Quel couvert tu veux utiliser ?') {
        categoryQuestion = ["Couverts"];
    } else if (questionSelected === 'Quel temps fait-il aujourd\'hui ?') {
        categoryQuestion = ["Météo"];
    } else if (questionSelected === 'Quels vêtements choisir quand il fait froid ?') {
        categoryQuestion = ["Vêtements"];
    } else if (questionSelected === 'Combien as-tu de doigts ?') {
        categoryQuestion = ["Chiffres"];
    } else if (questionSelected === 'Quelle image désigne le cou ?') {
        categoryQuestion = ["Corps humain"];
    } else if (questionSelected === 'Quelle partie de ton corps permet d\'entendre ?') {
        categoryQuestion = ["Corps humain"];
    } else if (questionSelected === 'Qui te coupe les cheveux ?') {
        categoryQuestion = ["Personnes"];
    } else if (questionSelected === 'Qui éteint le feu ?') {
        categoryQuestion = ["Personnes"];
    } else if (questionSelected === 'Sélectionne des légumes ...') {
        categoryQuestion = ["Fruits et légumes"];
    } else if (questionSelected === 'Où vas-tu acheter le pain ?') {
        categoryQuestion = ["Lieux"];
    } else if (questionSelected === 'De quelle couleur est l\'herbe dans le jardin ?') {
        categoryQuestion = ["Couleurs"];
    } else if (questionSelected === 'Où peux-tu prendre le train ?') {
        categoryQuestion = ["Transports"];
    } else if (questionSelected === 'Avec quel moyen de transport peut-on aller dans l\'espace ?') {
        categoryQuestion = ["Transports"];
    } else {    // Sinon affiche les toutes
        categoryQuestion = ["Sujets", "Boissons", "Actions", "Adjectifs", "Aliments", "Animaux", "Chiffres", "Corps Humain", "Couleurs", "Déterminants", "Émotions", "Fruits et légumes", "Langue des signes", "Lieux", "Météo", "Multimédia", "Objets", "Personnes", "Scolarité", "Transports", "Vêtements","Sports"];
    }
    
    $(".contentP .picto").each(function() { // Pour chaque pictogramme
        if (categoryQuestion.includes($(this).attr("title"))) { // Si la catégorie du pictogramme correspond à la question
            $(this).css("display", "block");    // Alors affiche les
        } else {
            $(this).css("display", "none"); // Sinon ne les affiche pas
        }
    });
}
/* end Filtre des Catégories */

