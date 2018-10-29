# Webflix

On veut créer un nouveau Netflix

Projet:
- créer un dépot Github
- faire le lien avec le dépot local
- penser à la BDD...

Pages :

----Partie 1-----
- accueil (index.php) -> liste des films triée par catégorie
- Voir un film (movie_single.php?id=4) -> on peut voir un film
- ajouter un film (movie_add.php) -> on peut ajouter un film dans la BDD

----Partie 2-----
- modifier un film (movie_edit.php?id=4) -> on peut modifier un film dans la BDD
- supprimer un film (movie_delete.php?id=4) -> on peut supprimer un film de la BDD


----Partie 3-----
- inscription (register.php) -> formulaire d'inscription (username, email, mdp, confirmer le mdp)
- connexion (login.php) -> formulaire de connexion(email, mdp)

----Partie 4-----
- les pages Voir, Ajouter, Modifier et Supprimer un film ne sont accessibles que par quelqu'un qui est connecté

----Partie 5-----
- mot de passe oublié (remember_me.php) -> 1er formulaire où on inscrit l'email, s'il existe / on envoie un lien à l'utilisateur par mail pour redéfinir son mdp. Ce lien doit être unique et accessible pendant 24h (sinon 404). Si le ien est valide, on arrive sur un 2eme formulaire où l'on redéfinit le mdp (mdp, confirmer le mdp) 

Fonctionnalités:

Structure:

BDD:
- Movie : id, title, description, video_link, cover, released_at, category_id
- Category : id, name
- User : id, username, email, password, token, token_expiration
