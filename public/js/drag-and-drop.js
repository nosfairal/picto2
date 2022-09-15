/* Drag */
// Les pictogrammes du carousel deviennent draggable
$(".picto img").draggable({
    // Le pictogramme est cloné
    helper: 'clone',
    // Le retour ne se produit que si le draggable n'a pas été déposé sur un droppable
    revert: 'invalid',
    start:function(){
        if($(this).hasClass("droppedPicto")){
            $(this).removeClass("droppedPicto");
            $(this).parent().removeClass("pictoPresent");
        }
    },
    appendTo: "body",
    snap: ".drop",
});
/* end Drag */

/* Drop */
$("#drop .drop").droppable({

    accept: function(){
        // N'accepte plus de pictogramme quand la classe "pictoPresent" est présente
        return !$(this).hasClass("pictoPresent");
    },
    tolerance: "fit",
    classes: {
        "ui-droppable-active": "ui-state-highlight"
    },
    
    drop: function(ev, ui){
        let draggableElement = $(ui.helper).clone(); // Clone du pictogramme draggé
        let droppedOn = $(this); // Zone où le pictogramme est droppé
        // Ajout d'une classe indiquant que la zone n'est plus disponible lorsqu'un pictogramme est droppé
        droppedOn.addClass("pictoPresent");
        // Ajout d'une classe indiquant que le pictogramme est droppé
        $(draggableElement).addClass("droppedPicto pictoPosition").appendTo(droppedOn);
        textUpdate(); // La phrase est mis à jour
        draggableElement.draggable({
            // Le retour ne se produit que si le draggable n'a pas été déposé sur un droppable
            revert: 'invalid',
            appendTo: "body",
            snap: ".wrapperP",
        })
        $(".pictoPosition").draggable({
            start: function( event, ui ) {
                $(this).addClass('pictoAbsolute'); 
            },
            stop: function( event, ui ) {
                $(this).removeClass('pictoAbsolute'); 
            }
        });
        // Le carousel de pictogramme devient droppable
        $(".wrapperP").droppable({
            // Il n'accepte que les pictogrammes qui ont déjà été droppé
            accept: ".droppedPicto",
            tolerance: "fit",
            drop: function (ev, ui) {
                let draggableElement = $(ui.helper); // Clone du pictogramme draggé
                let droppedOn = $(this);
                // La classe de contrainte est retiré de la zone de drop
                draggableElement.parent().removeClass("pictoPresent");
                draggableElement.remove(); // Le pictogramme disparait
                textUpdate(); // La phrase est mis à jour
                
            },
        })
        $(".wrapperSCP").droppable({
            // Il n'accepte que les pictogrammes qui ont déjà été droppé
            accept: ".droppedPicto",
            tolerance: "fit",
            drop: function (ev, ui) {
                let draggableElement = $(ui.helper); // Clone du pictogramme draggé
                let droppedOn = $(this);
                // La classe de contrainte est retiré de la zone de drop
                draggableElement.parent().removeClass("pictoPresent");
                draggableElement.remove(); // Le pictogramme disparait
                textUpdate(); // La phrase est mis à jour
                
            },
        })
        
    }
})

/* end Drop */
