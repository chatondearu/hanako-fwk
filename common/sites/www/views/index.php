
<div id="header">

    <a><img src="<?php echo IMG_SKINS_PATH; ?>logo_hanako.png"/></a>

    <?php
        if(__CONNECTED){ ?>
    <a href="index-deco.html?">Deconnexion</a>
        <?php
        }else{
            echo __CONNECT_FORM;
        }
    ?>
</div>


<div id="content">
    
</div>


<div id="footer">
    <div></div>
</div>