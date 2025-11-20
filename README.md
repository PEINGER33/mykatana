# MyKatana par TAS Ozgur

## Thème

MyKatana est un projet d'application web Symfony réalisé dans le cadre du module CSC4101.  
Il s'agit d'une plateforme permettant à des membres de gérer :

- Leur inventaire personnel de katanas (Trousseau)
- Leurs katanas eux-mêmes
- Leurs galeries publiques ou privées (Katanakake)
- La consultation des galeries publiques des autres membres
- L’ajout d’images à leurs katanas

L’application inclut également :

- Un système complet d’authentification
- Un contrôle d’accès basé sur les rôles (USER / ADMIN)
- Une contextualisation des données : chaque membre ne voit que ses propres données (sauf les galeries publiques)

## Dépôt GitHub

Lien du dépôt :  
https://github.com/PEINGER33/mykatana.git

---

## Modèle conceptuel (contextualisation des entités)

Correspondances du sujet avec les entités :

- [Inventaire] = Trousseau
- [Objet] = Katana
- [Galerie] = Katanakake
- [User]   = Member

Diagramme du modèle :  
https://app.diagrams.net/#G12dKkN0y7UBMRm4JmLsTvmdswY3GX1kor#%7B%22pageId%22%3A%22eWfJXFkcnHLeDeFjSnNW%22%7D

### Propriétés des entités

#### Trousseau
- id / int / notnull  
- description / string / notnull  
- katanas / Collection / OneToMany  

#### Katana
- id / int / notnull  
- description / string / notnull  
- type / string / notnull  
- longueur / float / Positive  
- imageName / string / nullable  
- imageFile / fichier  
- contentType / string / nullable  
- trousseau / Trousseau / ManyToOne  

#### Katanakake
- id / int / notnull  
- description / string / notnull  
- publiée / boolean / notnull  
- createur / Member / ManyToOne  
- katanas / Collection / ManyToMany  

#### Member
- id / int / notnull  
- email / string / notnull  
- roles / array / nullable  
- password / string / notnull  
- trousseau / Trousseau / OneToOne  
- katanakakes / Collection / OneToMany  

### Relations résumées

Member → Trousseau : 1–1  
Trousseau → Katana : 1–N  
Member → Katanakake : 1–N  

---

## Guide d'utilisation

- Accueil : http://127.0.0.1:8000/
- Connexion : http://127.0.0.1:8000/login
- Index des galeries : http://127.0.0.1:8000/katanakake
- Index des inventaires : http://127.0.0.1:8000/trousseau
- Index des katanas : http://127.0.0.1:8000/katana
- Index des membres : http://127.0.0.1:8000/member

Certaines pages nécessitent une connexion.

### Utilisateurs disponibles pour les tests

| Email              | Mot de passe | Rôle        |
|-------------------|--------------|-------------|
| olivier@localhost | 123456       | ROLE_USER   |
| slash@localhost   | 123456       | ROLE_ADMIN  |

### Comportement selon le rôle

- **ADMIN** : accès complet à toutes les données  
- **USER** : accès uniquement à son trousseau, ses katanas et ses galeries  
- **Anonyme** : accès uniquement aux galeries publiques  

---

## Explication des Fixtures

Les Fixtures créent automatiquement une base cohérente pour tester l’application.

### Membres et trousseaux

Chaque membre possède un trousseau :

- Trousseau d’Olivier : « Lot de katana 1 »
- Trousseau de Slash : « Lot de katana 2 »

### Katanas

Chaque trousseau contient deux katanas :

- **Olivier** : Honjo Masamune, Kusanagi-no-Tsurugi  
- **Slash** : Muramasa, Mikazuki Munechika  

### Galeries

Chaque membre a une galerie :

- Galerie d’Olivier : « Collection d’Olivier » (publique) — contient ses deux katanas  
- Galerie de Slash : « Les sabres légendaires de Slash » (privée) — contient ses deux katanas  

### Images

Seuls quatre katanas disposent d’une image (pour limiter la taille du projet) :  
Honjo, Kusanagi, Mikazuki, Muramasa.

---

## Remarques importantes

- Sur Windows, le serveur local Symfony peut parfois dépasser le délai d’attente (30 secondes).  
  Ce problème ne s’est pas produit sous Linux.  
- Un `cache:clear` est parfois nécessaire pour éviter des lenteurs importantes lors des requêtes Symfony.  
- Les images ont volontairement été limitées pour réduire la taille de l’archive du projet.
