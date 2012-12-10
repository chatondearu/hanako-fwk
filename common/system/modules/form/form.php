<?php

include_once("form_Core.php");
?>
<!DOCTYPE html>
<html>
<head>

  <title>Exemple PHP formulaires & mail</title>
  <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">

</head>
<body>

<?php
    //si formulaire est faux ou n'as pas été envoyé j'affiche le formulaire
    if($ifCorrectForm == false || !isset($_POST["form"]) ){
?>

    <p class="msg">
        <?php
            echo $msg;
        ?>
    </p>

    <form id="form" action="form.php" method="post">

        <fieldset>
            <legend>Informations personnelles</legend>
                <label for="nom">
                    nom* :
                </label><br/>
                    <input id="nom"
                           name="nom"
                           type="text"
                           value="<?php if($ifCorrectForm == false) echo $inputs['nom']["result"]; ?>"
                           maxlength="25"
                           tabindex="0"/>
            <?php if($ifCorrectForm == false) echo $inputs['nom']['data']->save_error; ?>
                <br/>

                <label for="prenom">
                    prénom* :
                </label><br/>
                    <input id="prenom"
                           name="prenom"
                           type="text"
                           value="<?php if($ifCorrectForm == false) echo $inputs['prenom']["result"]; ?>"
                           maxlength="25"
                           tabindex="1"/>
            <?php if($ifCorrectForm == false) echo $inputs['prenom']['data']->save_error; ?>
                <br/>

                <input id="garçon"
                       name="genre"
                       type="radio"
                       <?php if($ifCorrectForm == false && $inputs['genre']["result"] == "garcon") echo 'checked="checked"'; ?>
                       value="garcon"
                       tabindex="2"/>
                <label for="garçon">
                    garçon,
                </label>
                <input id="fille"
                       name="genre"
                       type="radio"
                       <?php if($ifCorrectForm == false && $inputs['genre']["result"] == "fille") echo 'checked="checked"'; ?>
                       value="fille"
                       tabindex="3"/>
                <label for="fille">
                    fille
                </label>
            <?php if($ifCorrectForm == false) echo $inputs['genre']['data']->save_error; ?>
                <br/><br/>

                <label for="age">
                    age*
                </label>
                    <select id="age"
                            name="age"
                            tabindex="4">
                        <?php
                            //Génération de la liste des options en php dans une boucle for.
                            $min=18; $max=99 ;
                            for($i=$min; $i <= $max; $i++){
                                echo '<option value="'.$i.'" ';
                                if($inputs["age"]["result"] == $i) echo 'selected="selected"';
                                echo' >'.$i.'</option>';
                            }
                        ?>
                    </select>
            <?php if($ifCorrectForm == false) echo $inputs['age']['data']->save_error; ?>
                <br/><br/>

                <label for="dateNaissance">
                    date de naissance (jj/mm/aaaa):
                </label><br/>
                    <input id="dateNaissance"
                           name="dateNaissance"
                           type="text"
                           value="<?php if($ifCorrectForm == false) echo $inputs['dateNaissance']["result"]; ?>"
                           maxlength="10"
                           size="10"
                           tabindex="5"/>
            <?php if($ifCorrectForm == false) echo $inputs['dateNaissance']['data']->save_error; ?>

        </fieldset>

        <fieldset>
            <legend>Adressse et contact</legend>
            <label for="mail">
                mail* :
            </label><br/>
                <input id="mail"
                       name="mail"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs['mail']["result"]; ?>"
                       maxlength="250"
                       size="50"
                       tabindex="6"/>
            <?php if($ifCorrectForm == false) echo $inputs['mail']['data']->save_error; ?>
            <br/>

            <label for="tel">
                tél :
            </label><br/>
                <input id="tel"
                       name="tel"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs['tel']["result"]; ?>"
                       maxlength="10"
                       tabindex="7"/>
            <?php if($ifCorrectForm == false) echo $inputs['tel']['data']->save_error; ?>
            <br/>

            <label for="adresse">
                adresse :
            </label><br/>
                <input id="adresse"
                       name="adresse"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs['adresse']["result"]; ?>"
                       maxlength="250"
                       tabindex="8"/>
            <?php if($ifCorrectForm == false) echo $inputs['adresse']['data']->save_error; ?>
            <br/>

            <label for="cp">
                code postal :
            </label>
                <input id="cp"
                       name="cp"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs['cp']["result"]; ?>"
                       maxlength="5"
                       size="5"
                       tabindex="9"/>
            <?php if($ifCorrectForm == false) echo $inputs['cp']['data']->save_error; ?>
            <br/>

            <label for="ville">
                ville :
            </label><br/>
                <input id="ville"
                       name="ville"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs['ville']["result"]; ?>"
                       maxlength="25"
                       tabindex="9"/>
            <?php if($ifCorrectForm == false) echo $inputs['ville']['data']->save_error; ?>
            <br/><br/>


            <input id="cgv"
                   name="cgv"
                   type="checkbox"
                   value="true"
                   tabindex="10"/>
            <label for="cgv">
                J'accepte les conditions...*
            </label>
            <?php if($ifCorrectForm == false) echo $inputs['cgv']['data']->save_error; ?>

        </fieldset>
        <fieldset>
            <legend>Votre méssage</legend>

            <label for="titre">
                Titre :
            </label>
            <?php if($ifCorrectForm == false) echo $inputs['titre']['data']->save_error; ?>
            <br/>
                <input id="titre"
                       name="titre"
                       type="text"
                       value="<?php if($ifCorrectForm == false) echo $inputs["titre"]["result"]; ?>"
                       maxlength="50"
                       tabindex="11"/>
            <br/><br/>

            <label for="message">
                Méssage :
            </label>
            <?php if($ifCorrectForm == false) echo $inputs['message']['data']->save_error; ?>
            <br/>
                <textarea id="message"
                       name="message"
                       maxlength="500"
                       cols="40"
                       rows="8"
                       tabindex="12"><?php if($ifCorrectForm == false) echo $inputs["message"]["result"]; ?></textarea>
            <br/><br/>

            <label for="mdp">
                Mot de passe* (8 caracteres) :
            </label>
            <input id="mdp"
                       name="mdp"
                       type="password"
                       value="<?php if($ifCorrectForm == false) echo $inputs["mdp"]["result"]; ?>"
                       maxlength="8"
                       tabindex="12"/> <?php if($ifCorrectForm == false) echo $inputs['mdp']['data']->save_error; ?>
        </fieldset>

        <p>* Champs obligatoire.</p>

        <input type="hidden" name="form" value="true"/>
        <input type="reset" value="Recomencer"/>
        <input type="submit" value="Envoyer"/>
    </form>

<?php
    }
    //Fin du formulaire
?>

</body>
</html>