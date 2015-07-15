var vidPlayer;
$(document).ready(function () {
    vidPlayer = new MediaElementPlayer('#agPlayer', {
        features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
        success: function (player) {
            $('a.vidLink').click(function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#pageTitle').position().top
                }, 500);
                $('.playing').remove();

                setPlaying(this, player);
            });
            setPlaying($('a.vidLink').first(), player);
        }
    });

});
function setPlaying(element, player) {
    var playing = $('<div/>').addClass('playing').append($('<p/>').text('Playing...'));
    $(element).after(playing);
    player.setSrc(element.href);
    player.load();
    player.play();
}
