// Message si le viewport n'est pas assez large

$(document).ready(function() {
    function checkWidth() {
        let windowSize = $(window).width();

        if (windowSize < 550) {
            $("<div class='col-8 ms-auto my-5'><p class='mx-auto'>Cet espace vous propose de créer des phrases à l'aide de pictogrammes. </br> Cette partie de l'application ne peut être utilisée que sur tablette et ordinateur.</p></div>").replaceAll("#content");
            $("#commandButtons").attr("class", "d-none");
        }
    }
    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);
});