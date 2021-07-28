var waveTherapist = WaveSurfer.create({
    container: "#waveform-therapist",
     barHeight: 6,
     barGap: 6,
    partialRender: true,
    scrollParent: true,
    waveColor: 'grey',
    progressColor: '#0015fc',
    cursorColor: 'black',
    plugins: [
        WaveSurfer.spectrogram.create({
            wavesurfer: wavesurfer,
            container: "#spectrogram-therapist",
            fftSamples: 512,
            labels: true
        }),
        WaveSurfer.timeline.create({
            container: '#timeline-therapist',
            timeInterval: timeInterval,
            primaryLabelInterval: primaryLabelInterval,
            secondaryLabelInterval: secondaryLabelInterval,
            primaryColor: '#76e6bc',
            secondaryColor: 'green',
            primaryFontColor: '#000000',
            secondaryFontColor: 'blue',
        })

    ]
});

function wavesurferTherapist() {
  $('wave').css("height", "256px");
  var audioTherapist = window.localStorage.getItem("urlTherapist");
  waveTherapist.load(audioTherapist);
  setTimeout(function () {
      $("#chargement-therapist").hide();
  }, 1000);
}

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

        canvasCtx.fillStyle = 'rgb(200,200,200)';
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

$(document).ready(function () {

  $("#chargement-therapist").hide();

  $('#record-therapist').on("click", function(event){
    event.preventDefault();
    $('#record_voice').hide().replaceWith('<div id="wave_canvas"><input class="d-none" type="checkbox" id="live"/><canvas id="level" width="500" height="340" ></canvas></div>');
    $("#chargement-therapist").find('p').html('Enregistrement du fichier audio ...');
    $('#stop').toggleClass('disabled');
    $(this).toggleClass('disabled');
    Fr.voice.record($("#live").is(":checked"),function() {
        makeWaveform();
    });
  }); 

  $('#stop').on("click",  function (event) {
    event.preventDefault();
    $("#chargement-therapist").show();
    $("#wave_canvas").hide();
    Fr.voice.exportMP3(function (url) {
      window.localStorage.setItem("urlTherapist", url);
    }, "URL");
    setTimeout(function () {
      $("#chargement-therapist").hide();
      $("#chargement-therapist").find('p').html('Chargment du spectrogramme ...');
      $('#player-therapist').toggleClass('disabled');
    }, 15000);
    $(this).toggleClass('disabled');
  });

  $('#player-therapist').on('click', function (event) {
      event.preventDefault();
      $("#chargement-therapist").show();
      wavesurferTherapist();
      $(this).toggleClass('disabled');
      //$('#stop').toggleClass('disabled');
      $('#playRecord-therapist').toggleClass('disabled');
  });

  $('#playRecord-therapist').on('click',function (event) {
      event.preventDefault();
      waveTherapist.playPause();
  });

});