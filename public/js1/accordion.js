// accordéon
$( function() {
    let icons = {
        header: "bi bi-plus",
        activeHeader: "bi bi-dash"
    };
    $( "#accordion" ).accordion({
        collapsible: true,
        active:0,
        heightStyle: "content",
        icons: icons
    });
} );

// subaccordéon
$( function() {
    let icons = {
        header: "bi bi-plus",
        activeHeader: "bi bi-dash"
    };
    $( "#subaccordion" ).accordion({
        collapsible: true,
        active:0,
        heightStyle: "content",
        icons: icons
    });
} );