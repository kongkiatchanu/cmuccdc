$(document).ready(function() {

    $('.search').each(function() {
        var self = $(this);
        var div = self.children('div');
        var placeholder = div.children('input').attr('placeholder');
        var placeholderArr = placeholder.split(/ +/);
        if(placeholderArr.length) {
            var spans = $('<div />');
            $.each(placeholderArr, function(index, value) {
                spans.append($('<span />').html(value + '&nbsp;'));
            });
            div.append(spans);
        }
        self.click(function() {
            self.addClass('open');
            setTimeout(function() {
                self.find('input').focus();
            }, 750);
        });
        $(document).click(function(e) {
            if(!$(e.target).is(self) && !jQuery.contains(self[0], e.target)) {
                self.removeClass('open');
            }
        });
    });
    //set-anima
    if($('#anima-home').length){
        var element = $('#anima-home');
        var anima_home = {
            container: element[0],
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: element.data('icon')
        };
    }    
    //event-anima
    if($('#anima-home').length){
        anima_home = lottie.loadAnimation(anima_home);
        $('#anima-home').hover(function () {
                // over
                anima_home.setSpeed(1.75);
                anima_home.playSegments([0,16],true);
            }, function () {
                // out
                anima_home.setSpeed(1.75);
                anima_home.playSegments([16,24],true);
            }
        );
    }
});