******************************************
*     Module de gestion de connection    *
******************************************

--- Description ---
    Gère la connection utilisateur et crée une session de connection.

--- Appel ---
    Charger le module avec : request_module('connection');

--- Dépendance ---

    (si gestion de types_users activer le parametre dans le fichier conf du module)
    ~~models "soft_types_users" : soft.types_users.member.php

--- CONSTANTE et RETOUR ---
    - CONSTANTES:
        __CONNECTED : true/false à true si users connecté
        ~~ __TYPE_USER : valeur clé défénissant le type utilisateur connecté
        __CONNECT_FORM formulaire de connexion, modifiable à dans le pattern "form.temp"
    - RETOUR:
        un formulaire html sera affiché si pas de connection