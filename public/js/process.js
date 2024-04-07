/* ===================================================================

  Process File Views

  =================================================================== */
var audioPlayer = new Plyr('#audio-player', {
    controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'download'],
    tooltips: { controls: true, seek: true }
});

var videoPlayer = new Plyr('#video-player', {
    controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'download', 'fullscreen'],
    tooltips: { controls: true, seek: true }
});

$(document).on('click', '.file-name', function(e) {

    "use strict";
    
    e.preventDefault();

    var id = $(this).attr("id");

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: 'process',
        data:{
            id: id,
        },
        success:function(data) {   

            if ($.inArray(data['format'], ['png', 'jpg', 'jpeg', 'gif', 'tiff']) !== -1) {

                var items = [{src: data['url']}];

                var viewer = new PhotoViewer(items, {
                    
                    footerToolbar: [
                        'zoomIn','zoomOut','fullscreen','actualSize',
                        'customButton'
                    ],
                    customButtons: {
                        customButton: {
                        text: '<i class="fas fa-cloud-download-alt" ></i>',
                        title: 'Download Image',
                        click: function (context, e) {
                            getFile(data['url']);
                        }
                        }
                    }

                });
            
            } else if ($.inArray(data['format'], ['mp3', 'wav', 'ogg', 'aac', 'flac']) !== -1) {

                    $('#audio-player-modal').modal('show');

                    audioPlayer.source = {
                        type: 'audio',
                        title: 'Audio File',
                        sources: data['url'],
                    };

                    $('#audio-player-box a[target="_blank"]').removeAttr('target');

                    audioPlayer.download = data['url'];
                    audioPlayer.play();             

            } else if ($.inArray(data['format'], ['mp4', 'avi', 'mov', 'flv', 'webm', 'mpeg']) !== -1) {

                    $('#video-player-modal').modal('show');

                    videoPlayer.source = {
                        type: 'video',
                        title: 'Video File',
                        sources: data['url']
                    };

                    $('#video-player-box a[target="_blank"]').removeAttr('target');

                    videoPlayer.download = data['url'];
                    videoPlayer.play();             

            } else {
                getFile(data['url']);
            }
    
        }
    
    });


});

function getFile(data) {
//window.open(data,'_blank');
window.location.href = data;
        return false;
}

$('#audio-player-modal').on('hidden.bs.modal', function () {
    audioPlayer.stop(); 
});

$('#video-player-modal').on('hidden.bs.modal', function () {
    videoPlayer.stop(); 
});
