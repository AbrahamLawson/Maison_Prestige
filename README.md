------------------------------- Production GROUPE 4 ------------------------------

______________ Membres du groupe ____________

- Manuel Govinda AGBAHE
- Mattis ALMEIDA LIMA
- Blessing-Grace EKLOU-DOVI
- Faithgot Letonsou GLIN DAYI
- Hanane ISSIAKENE
- Abraham LAWSON



---------------------------------------------------------------------------------------------------------------------------------------------

- Lien `Figma` de la Présentation de la soutenance : https://www.figma.com/file/M9gbIb8deU8NdDzrD2kF0C/Restitution-technique?type=design&node-id=9%3A2&mode=design&t=Mnb8coniAz4JBkGp-1

    - En premier, n'oubliez pas de connecter la db dans le fichier `bdd_connect.php`.

- Toutes les attentes du projet ont été comblés et en plus des fonctionnalités demandées :
    
    - Un super utilisateur  qui a tous les roles avec lequel, vous pouvez créer d'autres comptes et leur attribuer le role voulu , Ses identifiants sont :
        - Email : `sudo@sudo.fr`
        - M D P : `super_user`
    - Dans la gestion des roles:
        - Un admin ne peut pas modifier le role d'un admin ou émettre des actions sur un compte admin
        - Seul le sudo ou les sudos si vous en avez créé par commande SQL (c'est la seule manière d'en définir) peut travailler sur tous les comptes admins jusqu'au bas niveau, il a le droit de définir quelqu'un comme admin également

        - Coté ENTRETIEN, nous avons plutot pensé à deux roles :
            - Le role LOGISTIC qu'ont ceux qui peuvent créer les équipes, planifier des taches et gérer des actions de maintenances.

            - Le role MAINTENANCE qu'ont ceux qui obéissent, tout le monde ne peut avoir cette interface pour créer et gérer des équipes comme ils veulent en entretien. À l'avenir, un dashboard maintenance pour ceux qui ont ce compte est envisageable pour voir les entretiens planifiés pour une équipe ainsi que modifier le statut de ces entretiens. Mais pour le moment, juste un mail peut etre envoyé par les lecteurs pour informer celui mis sur la tache afin qu'il s'en occupe. Leur dashboard n'est pas différent de celui d'un client simple.

    - Un système d'ALERT avec une interface attrayante est conçue pour valider ou refuser une action de réservation, c'est dans le but de ne pas retourner l'erreur sur la page du logement ou de la réservtion vu qu'il faut demander à réserver ou à modifier la réservation  avant d'obtenir le formulaire. Cette interface est affichée pendant 5 ou 6s au plus puis redirige vers la page idéale.

    - Un mail d'inscription et de confirmation de réservation à l'inscription et à la réservation d'un logement sur notre site

- Dans notre développement, on a voulu changer un peu de gout avec un fichier JSON envisagé pour gérer nos requetes SQLs, il permet au lecteur du code de voir l'action qu'on émet au lieu de voir une longue requete SQL. Ça facilite la lecture du code et la modification facile d'une requete quand un truc ne marche pas lorsqu'on était en mode maintenance du projet. Une fonction est aussitot implémentée dans le fichier recuperer_Requete.php pour récuperer ces requetes plus facilement.

- On a essayé de gérer le RESPONSIVE au mieux qu'on peut.