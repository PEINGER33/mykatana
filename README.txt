Liste des propriétés des entités du modèle :

"Voir le diagramme du modèle fait sur : diagram.io" (https://app.diagrams.net/#G12dKkN0y7UBMRm4JmLsTvmdswY3GX1kor#%7B%22pageId%22%3A%22eWfJXFkcnHLeDeFjSnNW%22%7D)

[Inventaire] = Trousseau 
[Objet] = Katana
[Galerie] = Katanakake
[User]


(Nom propriété / Type / Contraintes)

Trousseau :
	- id / int / notnull
	- description / string / notnull
	
Katana:
	- id / int / notnull
	- description / string / notnull
	- type / string / notnull
	- longueur / float / Positive