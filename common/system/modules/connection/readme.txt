******************************************
*     Module de gestion de connection    *
******************************************

--- Description ---
    Gère la connection utilisateur et crée une session de connection.

--- Appel ---
    Charger le module avec : request_module('connection');

--- Dépendance ---
    models "soft_users" : soft.users.member.php
        methods :   boolean function soft_users::ifLoginExist(login,mdp) // à la vérification la methode fera un _set pour récupérer les valeurs de l'utilisateur
                    integer function soft_users::getType()

    (si gestion de types_users activer le parametre dans le fichier conf du module)
    ~~models "soft_types_users" : soft.types_users.member.php

--- CONSTANTE et RETOUR ---
    - CONSTANTES:
        __CONNECTED : true/false à true si users connecté
        ~~ __TYPE_USER : valeur clé défénissant le type utilisateur connecté
        __CONNECT_FORM formulaire de connexion, modifiable à dans le pattern "form.temp"
    - RETOUR:
        un formulaire html sera affiché si pas de connection


////////////////////////////////////////////////////////
    methods requise pour le modele users exemple :

    public function ifLoginExist($login,$password){
        global $db;
        try{

            $result = $db->select("SELECT *
                        FROM  `soft_users`
                        WHERE  `login_users` =  '".$login."'
                        AND  `password_users` =  '".$password."'",1);
            if(sizeof($result) > 0){

                $this->set($result); // !!! important
                $this->type_user = new soft_types_users($this->types_id_users);

                $this->last_connection_users = $db->formatTimestamp(time());
                $db->update($this,'id_users = '.$this->id_users);

            }
            return sizeof($result) > 0;

        }catch(exception $e){
            return false;
        }
    }