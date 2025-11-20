MyKatana — Projet Symfony
Auteur : TAS Ozgur

====================================================
                    Thème du projet
====================================================

MyKatana est une application web Symfony développée dans le cadre du module CSC4101.  
Elle permet aux membres de :

- Gérer leur inventaire personnel de katanas (Trousseau)
- Gérer leurs katanas
- Créer des galeries publiques ou privées (Katanakake)
- Consulter les galeries publiques des autres membres
- Ajouter des images à leurs katanas
- S’authentifier et naviguer dans une interface contextualisée

L’application inclut :
- Un système d'authentification complet  
- Un contrôle d’accès basé sur les rôles  
- Une contextualisation des données selon l’utilisateur  
- La gestion d’images (VichUploader)  
- Un modèle de données relationnel complet  

====================================================
                    Dépôt GitHub
====================================================

https://github.com/PEINGER33/mykatana.git

====================================================
             Correspondance des entités
====================================================

Inventaire  → Trousseau  
Objet       → Katana  
Galerie     → Katanakake  
User        → Member  

Diagramme du modèle :  
https://app.diagrams.net/#G12dKkN0y7UBMRm4JmLsTvmdswY3GX1kor

====================================================
                    Modèle de données
====================================================

Trousseau :
- id (int, notnull)
- description (string, notnull)
- katanas (Collection, OneToMany)

Katana :
- id (int, notnull)
- description (string, notnull)
- type (string, notnull)
- longueur (float, positive)
- imageName (string, nullable)
- imageFile (file, upload)
- contentType (string, nullable)
- trousseau (ManyToOne)

Katanakake :
- id (int, notnull)
- description (string, notnull)
- publiee (bool, notnull)
- createur (ManyToOne)
- katanas (ManyToMany)

Member :
- id (int, notnull)
- email (string, unique)
- roles (array)
- password (string)
- trousseau (OneToOne)
- katanakakes (OneToMany)

Relations principales :
- Member → Trousseau (1–1)
- Trousseau → Katana (1–N)
- Member → Katanakake (1–N)
- Katanakake ↔ Katana (N–N)

====================================================
                  Guide d’utilisation
====================================================

Pages principales :
- Page d'accueil Symfony : http://127.0.0.1:8000/
- Connexion           : http://127.0.0.1:8000/login
- Galeries            : http://127.0.0.1:8000/katanakake
- Inventaire          : http://127.0.0.1:8000/trousseau
- Katanas             : http://127.0.0.1:8000/katana

Certaines pages nécessitent une authentification.

====================================================
               Rôles et restrictions
====================================================

ROLE_ADMIN :
- Accès à toutes les données
- Peut consulter toutes les galeries, publiques et privées

ROLE_USER :
- Accède uniquement à son trousseau
- À ses propres katanas
- À ses propres galeries

Utilisateur anonyme :
- Peut consulter uniquement les galeries publiques

====================================================
            Comptes de test disponibles
====================================================

1) olivier@localhost / 123456 / ROLE_USER  
2) slash@localhost   / 123456 / ROLE_ADMIN  

====================================================
                   Remarques importantes
====================================================

- Sous Windows, le serveur Symfony répond parfois avec un délai dépassé (30s).  
  Fonctionnement stable sous Linux.
- Sans exécuter `symfony console cache:clear`, certaines requêtes dépassent 30 secondes  
  et génèrent une exception Symfony.

====================================================

Fin du fichier README
