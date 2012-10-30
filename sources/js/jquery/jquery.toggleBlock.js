
$(function(){
    $('.toggle').each(function(){
        var h1 = $('h1',this);
        var elem = $(this);

        var close = $('<span class="close fr"><img src="'+URI+'css/img/close.png"/></span>');
        close.click(function(){
            if(h1.next().is(':visible')){
                elem.stop().animate({height: h1.outerHeight()});
                h1.nextAll().hide();
            }else{
                elem.stop().animate({height: "100%"});
                h1.nextAll().show();
            }
        });
        h1.append(close);

        h1.mouseenter(function(){
            $('.close',this).show();
        }).mouseleave(function(){
            $('.close',this).hide();
        });
    });
});