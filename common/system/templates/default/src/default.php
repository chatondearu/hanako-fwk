<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

$hnk_tpl_component = array(
    'path' => array(
        'favicon'=>SRC_FAVICON.'/www'
    ),
    'styles' => array(
        gen_style(SRC_CSS.'/core.css'),
        gen_style(SRC_SKINS.'/'.DEFAULT_SKIN.'/css/global.css'),
        gen_style(SRC_SKINS.'/'.DEFAULT_SKIN.'/css/'.HANDLER.'.css')
    ),
    'scripts' => array(
       'top' => array(
           gen_script(SRC_SCRIPTS.'/'.MODERNIZR,false),
           gen_script(SRC_SCRIPTS.'/'.JQUERY,false),
           gen_script(SRC_SCRIPTS.'/global.js',false)
        ),
        'bottom' => array(
            //script Google + plusone
            "
                <script type=text/javascript>
                    window.___gcfg = {lang: 'fr'};

                    (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                </script>
            ",
            //Script Twitter widget
            '
                <script>
                    !function(d,s,id){
                        var js,
                            fjs=d.getElementsByTagName(s)[0];
                        if(!d.getElementById(id)){
                            js=d.createElement(s);
                            js.id=id;
                            js.src="//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js,fjs);
                        }
                    }(document,"script","twitter-wjs");
                </script>
            ',
            //Script Google Analytics
            "
            <script>

              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', 'UA-36590575-1']);
              _gaq.push(['_setDomainName', 'rlienard.fr']);
              _gaq.push(['_trackPageview']);

              (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();

            </script>
            "
        )
    )
);