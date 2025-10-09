TAS Ozgur

Lien du dépot GitHub sur mon compte personnel : https://github.com/PEINGER33/mykatana.git

"Voir le diagramme du modèle fait sur : diagram.io" (https://app.diagrams.net/#G12dKkN0y7UBMRm4JmLsTvmdswY3GX1kor#%7B%22pageId%22%3A%22eWfJXFkcnHLeDeFjSnNW%22%7D)

[Inventaire] = Trousseau 
[Objet] = Katana
[Galerie] = Katanakake
[User]

Liste des propriétés des entités du modèle :

(Nom propriété / Type / Contraintes)

Trousseau :
	- id / int / notnull
	- description / string / notnull
	
Katana:
	- id / int / notnull
	- description / string / notnull
	- type / string / notnull
	- longueur / float / Positive


REMARQUE IMPORTANTE :
- J'ai expérimenté sur Windows le projet et par moment le local host ne répond pas (délais de 30s dépasé). Je ne vois pas la cause de ce problème.
Donc parfois ça marche et parfois non. Je soupsonne mon ordinateur d'etre défaillant. Sur Linux je n'ai rencontré aucun problème.