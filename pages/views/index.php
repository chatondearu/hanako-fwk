
<div id="header">

    <a><img src="<?php echo IMG_SKINS_PATH; ?>kiwa_logo.png"/></a>

    <?php
        echo $title;
        if(__CONNECTED){ ?>
    <a href="index-deco.html?">Deconnexion</a>
        <?php
        }else{
            echo __CONNECT_FORM;
        }
        echo $menu
    ?>

    <form method="post">
        <input type="text" name="search" value="your search" title="recherche" size="35"/>
        <span class="picto search"></span>
    </form>

    <p><?php echo $mod_contents->get('parameter.menu.item2');?></p>

</div>


<div id="content">
    
</div>


<div id="footer">
    <div></div>
</div>