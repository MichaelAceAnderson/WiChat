# À faire (classés par catégorie puis par priorité)

## Vues
Réparer le scroll ou ne mettre la page à jour qu'à l'envoi/la réception d'un message

## Contrôleur

Passer la réponse de request.php en json et prendre en charge depuis axios
Vérifier l'arrivée d'un nouveau message, sinon ne pas mettre à jour le contenu et rabaisser le scroll de chatBox

## Modèle

Passer sous PostgreSQL
Requêtes préparées

## Sécurité & Technique

Fichier .htaccess (Optionnel)
Mapping URL (Optionnel) [Redirection htaccess ?]

## Style

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
Création de la table utilisateurs (MySQL):  
```
CREATE table users(
	id int AUTO_INCREMENT NOT NULL PRIMARY KEY, 
	nickname VARCHAR(64) NOT NULL UNIQUE
)
```
Création de la table messages:  
```
CREATE table messages(
	authorId int NOT NULL, 
	message TEXT NOT NULL, 
	FOREIGN KEY (authorId) REFERENCES users(id)
)
```
### Création d'un utilisateur
Exemple de création d'un utilisateur (s'il n'existe pas déjà)
```
INSERT INTO users(userId, username)
```

### Création d'un message
Exemple de création d'un message (si l'utilisateur existe): 
```
INSERT INTO messages(chatId, authorId, message)
VALUES(1, 1, "Message")
```
