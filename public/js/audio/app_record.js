function makeWaveform(){
    var analyser = Fr.voice.recorder.analyser;

    var bufferLength = analyser.frequencyBinCount;
    var dataArray = new Uint8Array(bufferLength);

    /**
     * The Waveform canvas
     */
    var WIDTH = 500,
        HEIGHT = 200;

    var canvasCtx = $("#level")[0].getContext("2d");
    canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

    function draw() {
        var drawVisual = requestAnimationFrame(draw);

        analyser.getByteTimeDomainData(dataArray);

        canvasCtx.fillStyle = 'rgb(200, 200, 200)';
        canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
        canvasCtx.lineWidth = 2;
        canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

        canvasCtx.beginPath();

        var sliceWidth = WIDTH * 1.0 / bufferLength;
        var x = 0;
        for(var i = 0; i < bufferLength; i++) {
            var v = dataArray[i] / 128.0;
            var y = v * HEIGHT/2;

            if(i === 0) {
                canvasCtx.moveTo(x, y);
            } else {
                canvasCtx.lineTo(x, y);
            }

            x += sliceWidth;
        }
        canvasCtx.lineTo(WIDTH, HEIGHT/2);
        canvasCtx.stroke();
    };
    draw();
}

$(document).ready(function(){
    $("#mic").on("click", function(){
        if (! $("#save").hasClass("enabled")){
            $("#save").addClass("enabled");
        }

        Fr.voice.record($("#live").is(":checked"),function(){
            makeWaveform();
            setTimeout(function() {
                if ($("#save").hasClass('enabled')) {
                    Fr.voice.stopRecordingAfter(0, function () {
                        alert('Votre enregistrement s\'est arrêté au bout de 10 secondes.');
                    });
                }
            }, 10000);
        });
    });

    $("#stop").on("click", function(){
        Fr.voice.stop();
        $("#save").removeClass("enabled");
    });

    $('#save').on("click", function(event){
        event.preventDefault();
        $(this).toggleClass("enabled");
        var $url = $(this).attr("href");
        function upload(blob){
            var formData = new FormData();
            formData.append('file', blob);

            $.ajax({
                url: $url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                error: function(err){
                    alert("Quelque chose s'est mal passé. Veuillez enregistrer à nouveau.")
                },
                success: function() {
                    alert("Votre enregistrement a bien été éffectué !");
                }
            });
        }
        Fr.voice.exportMP3(upload, "blob");
    });
});