# À faire (classés par catégorie puis par priorité)

## Vues

Réparer le scroll ou ne mettre la page à jour qu'à l'envoi/la réception d'un message
Ajouter système de notifications si le contrôleur indique une maj du contenu et que la scrollbar n'est pas en bas

## Contrôleur

Passer la réponse de request.php en json et prendre en charge depuis axios
Vérifier l'arrivée d'un nouveau message, sinon ne pas mettre à jour le contenu et rabaisser le scroll de chatBox

## Modèle

Passer sous PostgreSQL
Requêtes préparées

## Sécurité & Technique

Fichier .htaccess (Optionnel)
Mapping URL (Optionnel) [Redirection htaccess ?]

## Accessibilité & Compatibilité

Utiliser Edge DevTools pour détecter les divers problèmes

## Style

Chargement de la feuille de style selon le thème (sombre/clair/...) (Optionnel)
Feuille de style responsive (mobile, ...) (Optionnel)
Calcul de couleurs pour définition de thèmes personnalisés (Optionnel)
Feuille de style d'impression (Optionnel)

# Mémos & Infos Dev

## Base de données

### Création de la base de données

```
CREATE DATABASE WiChat
```

Puis éxécuter WiChat.sql
