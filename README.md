__[TOC]__
# À faire (classés par catégorie puis par priorité)

## Contenu

Cadre de lecture/envoi de messages

## Fonctionnalités

Envoi de message

## Sécurité & Technique

Fichier .htaccess (Optionnel)

Mapping URL (Optionnel)

## Style

/!\ Styliser les messages envoyés/reçus du tableau

Chargement de la feuille de style selon le thème (sombre/clair/...) (Optionnel)

Feuille de style responsive (mobile, ...) (Optionnel)

Calcul de couleurs pour définition de thèmes personnalisés (Optionnel)

Feuille de style d'impression (Optionnel)

# Mémos & Infos Dev
## Base de données
### Création des tables
Création de la base de données:  
```
CREATE DATABASE WiChat
```
Création de la table utilisateurs:  
```
CREATE table users(
	id int AUTO_INCREMENT NOT NULL PRIMARY KEY, 
	username VARCHAR(64) NOT NULL
)
```
Création de la table messages:  
```
CREATE table messages(
	chatId int NOT NULL, 
	authorId int NOT NULL, 
	message TEXT NOT NULL, 
	FOREIGN KEY (authorId) REFERENCES users(id)
)
```
### Création d'un utilisateur
Exemple de création d'un utilisateur (s'il n'existe pas déjà)
```
INSERT INTO messages(chatId, authorId, message)
```

### Création d'un message
Exemple de création d'un message (si l'utilisateur existe): 
```
INSERT INTO messages(chatId, authorId, message)
VALUES(1, 1, "Message")
```
