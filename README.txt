MyKatana par TAS Ozgur

Thème :
MyKatana est un projet d'application web Sympfony qui s'inscrit dans le cadre du module CSC4101
- Ce projet est une application Symfony permettant à des membres de gérer :
	§Leur inventaire personnel de katanas (Trousseau)
	§Leurs katanas eux-mêmes
	§Leurs galeries publiques ou privées (Katanakake)
	§La consultation des galeries publiques des autres membres
	§L’ajout d’images à leurs katanas
- L’application intègre également :
	§Un système complet d’authentification
	§Un contrôle d’accès en fonction du rôle
	§Une contextualisation des données : chaque membre ne voit que ses propres données (sauf les galeries publiques)

GitHub :
Lien du dépot GitHub sur mon compte personnel : https://github.com/PEINGER33/mykatana.git


Voici la contextaualisation des entité dans mon projet:
"Voir le diagramme du modèle fait sur : diagram.io" (https://app.diagrams.net/#G12dKkN0y7UBMRm4JmLsTvmdswY3GX1kor#%7B%22pageId%22%3A%22eWfJXFkcnHLeDeFjSnNW%22%7D)
[Inventaire] = Trousseau 
[Objet] = Katana
[Galerie] = Katanakake
[User] = Member

Liste des propriétés des entités du modèle :

- : (Nom propriété / Type / Contraintes)
+ : (Nom propriété / Type / Relation)

Trousseau :
	- id / int / notnull
	- description / string / notnull
	+ katanas / Collection / OneToMany (un trousseau contient plusieurs katanas)
	
Katana:
	- id / int / notnull
	- description / string / notnull
	- type / string / notnull
	- longueur / float / Positive
	- imageName / string / nullable
	- imageFile / fichier /
	- contentType / string / nullable
	+ trousseau / Trousseau / ManyToOne

Katanakake :
	- id / int / notnull
	- description / string / notnull
	- publiée / boolean / notnull
	+ createur / Member / ManyToOne
	+ katanas / Collection / ManyToMany (une galerie contient plusieurs katanas)

Member :
	- id / int / notnull
	- email / string / notnull
	- roles / array / nullable
	- password / string / notnull
	+ trousseau / Trousseau / OneToOne (un membre possède un seul trousseau)
	+ katanakakes / Collection / OneToMany (un membre peut créer plusieurs galeries)

Relations (résumé):
Member → Trousseau (1–1)
Trousseau → Katana (1–N)
Member → Katanakake (1–N)

Guide d'utilisation de l'application :
- page d'accueil : http://127.0.0.1:8000/
- page de connexion : http://127.0.0.1:8000/login
- index galerie : http://127.0.0.1:8000/katanakake
- index inventaire : http://127.0.0.1:8000/trousseau
- index object : http://127.0.0.1:8000/katana
- index user : http://127.0.0.1:8000/member


Attention certaines pages necessitent de se connecter !

Explication des différents utilisateurs possibles:
*ADMIN :
Il a un accès global à toutes les pages et sans filtres de données.
*USER : 
Il peut accéder à son propre trousseau,à ses katanas et à ses galeries.
Ces pages filtres les informations pour ne présenter que les siennes.
*Anonyme :
Un utilisateur anonyme ne peut consulter que les galeries publiques : il n’a pas accès aux trousseaux, ni aux objets (katanas) personnels des membres, ni aux galeries privées.

Utilisateurs Tests disponible :
(email / password / roles ) 

1 : olivier@localhost / 123456 /ROLE_USER
2 : slash@localhost / 123456 / ROLE_ADMIN

Explication des Fixtures :
Chaque utilisateur a un trousseau (Trousseau Olivier : "Lot de katana 1" / Trousseau Slash : "Lot de katana 2")
Chaque trousseau contient initialement 2 katanas tel que ( Olivier : Honjo et Kusanagi / Slash : Muramasa et Mikazuki )
Olivier possède une galerie publique appelé "Colelction d'Olivier" qui contient ses 2 katanas.
Slash possède une galerie privée appelé "Les sabres légendaires de Slash" qui contient ses 2 katanas.


REMARQUES IMPORTANTES :
- J'ai expérimenté sur Windows le projet et par moment le local host ne répond pas (délais de 30s dépasé). Je ne vois pas la cause de ce problème.
Donc parfois ça marche et parfois non. Je soupsonne mon ordinateur d'etre défaillant. Sur Linux je n'ai rencontré aucun problème.
- J'ai par ailleurs remarqué que si je ne cache:clear pas alors le temps d'execution de mes requetes dépassent 30s et générent uneexceptions Symphony.
- Par ailleur, tous les katanas n'ont pas d'image seul Honjo, Kusanagi, mikazuki, muramasa en ont (je ne voulais pas que le dossier soit trop volumineux)