$(function(){
    $('.sticky').each(function(){
        var parent = $(this).parent();
        var dTop = $(this).offset().top;
        var elem = $(this);

        parent.css('position','relative');
        elem.css('position','absolute');

        $(window).scroll(function(){
            if($(window).scrollTop() > dTop){
                elem.stop().animate({top:$(window).scrollTop() - parent.offset().top + 80},500);
            }else{
                elem.stop().animate({top:dTop - parent.offset().top},500);
            }
        });
        if($(window).scrollTop() > dTop){
            elem.stop().animate({top:$(window).scrollTop() - parent.offset().top + 80},500);
        }
    });
});