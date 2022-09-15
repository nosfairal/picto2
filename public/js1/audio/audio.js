$(document).ready(function(){
    $('#audio').hide();
    let $play = $('.play');
    let $audio = $('#audio');
    $play.on('click', function (e){
        e.preventDefault();
        let $url = $(this).attr('href');
        $audio.attr('src', $url).show();
        $audio[0].play();
    });
});