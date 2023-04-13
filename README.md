# WiChat

WiChat est un projet de chat en ligne, développé en PHP, HTML, CSS, JS (avec Axios) & SQL.

## To-do

- [ ] Réparer le scroll ou ne mettre la page à jour qu'à l'envoi/la réception d'un message
- [ ] Ajouter système de notifications si le contrôleur indique une maj du contenu et que la scrollbar n'est pas en bas
- [ ] Vérifier l'arrivée d'un nouveau message, sinon ne pas mettre à jour le contenu et rabaisser le scroll de chatBox
- [ ] Fichier .htaccess (Optionnel)
- [ ] Mapping URL (Optionnel) [Redirection htaccess ?]
- [ ] Calcul de couleurs pour définition de thèmes personnalisés (Optionnel)
- [ ] Feuille de style d'impression (Optionnel)

## Mémos & Infos Dev

### Démarrer le projet

- Étape 1: Installer XAMPP (ou un serveur Apache & PHP)

- Étape 2: Installer PostGreSQL & [Créer la base de données](#base-de-données)

- Étape 3: Cloner le projet

```powershell
git clone https://gitlab.com/Adrien_Sv/WiChat.git 
```

- Étape 4: Lancer les serveurs Apache (+PHP) et PostGreSQL
- Étape 5: Ouvrir [le projet](http://localhost) dans un navigateur

### Base de données

#### Accès superuser

```sql
postgres:WC770rwx
```

#### Création de la base de données

```sql
CREATE DATABASE wichat
```

Puis éxécuter WiChat.sql
