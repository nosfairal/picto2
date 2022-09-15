$("#ajouter").click(() => {
    //$("#drop").append('<div id="mot8" class="drop"></div>');
    var children = document.getElementById("drop").children;
    if (children.length > 1) {
        var first = children[0];
        var last = children[children.length - 1];
        var second = children[1];
    }
    var nextID = parseInt(last.id.substring(3))+1;
    console.log(parseInt(last.id.substring(3))+1);
    var newDroppable = '<div id="mot'+nextID+'"class="drop"></div>';
    $("#drop").append(newDroppable);
    var next= "#mot" + nextID;
    console.log(next)
    $(next).droppable({

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
    });
    
});




// $("#supprimer").click(() => {
//     //$("#drop").append('<div id="mot8" class="drop"></div>');
//     var children = document.getElementById("drop").children;
//     if (children.length > 1) {
//         var last = children[children.length - 1];
//     }
//     var nextID = parseInt(last.id.substring(3))+0;
//     console.log(parseInt(last.id.substring(3))+0);
// }
// )




$("#supprimer").click(() => {
    const list = document.getElementById("drop");
    if (list.hasChildNodes()) {
        var last = children[children.length - 1];
        list.removeChild(list.children[4]);
      }
  });