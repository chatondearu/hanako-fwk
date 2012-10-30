function JAlertBarr(option){

    var o = {
        type : "alert",
        context : "Hello World !",
        timeout : 2,
        animType : "slide",
        animDuring : 0.3
    },
    method = {
        extend : function(obj, extObj) {
            if (arguments.length > 2) {
                for (var a = 1; a < arguments.length; a++) {
                    methods.extend(obj, arguments[a]);
                }
            } else {
                for (var i in extObj) {
                    obj[i] = extObj[i];
                }
            }
            return obj;
        }
    };
    o = method.extend(o,option);
    console.log(o);
    var barr = $('<p id="JAlertBarr" class="'+o.type+'">'+o.context+'</p>');
    barr.prepend('<div class="picto"></div>');
    barr.css({ position:"fixed", zIndex: 999 }).hide();
    $('body').prepend(barr);
    switch(o.animType){
        case "slide":
                barr.slideDown(o.animDuring*1000);
                setTimeout(function(){
                    barr.slideUp(o.animDuring*1000,function(){
                        $(this).remove();
                    });
                },o.timeout*1000);
            break;
        case "fade":
                barr.fadeIn(o.animDuring*1000);
                setTimeout(function(){
                    barr.fadeOut(o.animDuring*1000,function(){
                        $(this).remove();
                    });
                },o.timeout*1000);
            break;
        case "hide":
                barr.hide(o.animDuring*1000);
                setTimeout(function(){
                    barr.show(o.animDuring*1000,function(){
                        $(this).remove();
                    });
                },o.timeout*1000);
            break;
    }
    
}