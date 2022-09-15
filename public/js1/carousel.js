// Récupère la div du carousel des catégories
const carouselC = document.querySelector(".carouselC"),
    // Récupère le flèche droite (suivant) des catégories
    nextC = document.querySelector(".nextC"),
    // Récupère la flèche gauche (précédent) des catégories
    prevC = document.querySelector(".prevC");

// Variable correspondant à la taille des transitions du carousel
let widthC = 150;

// Récupère la div du carousel des catégories
const carouselSCP = document.querySelector(".carouselSCP"),
    // Récupère le flèche droite (suivant) des catégories
    nextSCP = document.querySelector(".nextSCP"),
    // Récupère la flèche gauche (précédent) des catégories
    prevSCP = document.querySelector(".prevSCP");

// Récupère la div du carousel des pictogrammes
const carouselP = document.querySelector(".carouselP"),
    // Récupère le flèche droite (suivant) des pictogrammes
    nextP = document.querySelector(".nextP"),
    // Récupère la flèche gauche (précédent) des pictogrammes
    prevP = document.querySelector(".prevP");

// Au clic sur la flèche droite des pictogrammes
nextP.addEventListener("click", e => {
    // Scroll (vers la droite) de la taille de la variable widthC, préalablement déclarée, pour x (horizontal)
    carouselP.scrollBy(widthC, 0);
});
// Au clic sur la flèche droite des pictogrammes
prevP.addEventListener("click", e => {
    // Scroll (vers la gauche) de la taille de la variable widthC, préalablement déclarée, pour x (horizontal)
    carouselP.scrollBy(-(widthC), 0);
});

// Au clic sur la flèche droite des sous catégories
nextSCP.addEventListener("click", e => {
    // Scroll (vers la droite) de la taille de la variable widthC, préalablement déclarée, pour x (horizontal)
    carouselSCP.scrollBy(widthC, 0);
});
// Au clic sur la flèche droite des sous-catégories
prevSCP.addEventListener("click", e => {
    // Scroll (vers la gauche) de la taille de la variable widthC, préalablement déclarée, pour x (horizontal)
    carouselSCP.scrollBy(-(widthC), 0);
});

// Même chose pour le carousel des catégorie ...
nextC.addEventListener("click", e => {
    carouselC.scrollBy(widthC, 0);
});
prevC.addEventListener("click", e => {
    carouselC.scrollBy(-(widthC), 0);
});

/*
let widthP = contentP.offsetWidth;
window.addEventListener("resize", e => (widthP = contentP.offsetWidth));*/