# Beer Api 

Tu trouveras les consignes sur https://follow-health.notion.site/Test-Backend-Developer-9d166619cde74d9293e5e6c4da63760a

## Informations utiles pour la review 

### Mise à jour de la base de données

```
$ bin/console d:d:c --if-not-exists
$ bin/console d:m:m
```

### Import du fichier CSV

Commande à utiliser :

```
$ bin/console app:import-csv 
```

### Ajout d'un checkin

Les endpoints d'ajout/suppression/modification d'un checkin sont les seules à être protégées par authentification. 
Elles se trouvent derrière le firewall `api` qui utilise JWT.

Il faudra donc pour accéder à ces endpoint qu'un utilisateur existe et récupérer un token.

Commande pour créer les clés privée/publique nécessaires au fonctionnement du bundle https://github.com/lexik/LexikJWTAuthenticationBundle : 

```
$ bin/console lexik:jwt:generate-keypair
```

Commande pour créer un utilisateur de test : 

```
$ bin/console app:create-test-user
```

Commande pour générer un token JWT pour cet utilisateur :
```
$ bin/console lexik:generate-token testuser
```

Si vous utilisez la doc swagger, il faut ensuite renseigner ce token dans le champ prévu à cet effet.

### Reste à faire 

* Implémenter les process de suppression/mise à jour des checkin en autorisant ces actions uniquement si l'utilisateur courant est le créateur du checkin cible
* Ajouter des tests 
* Afficher les erreurs de validation dans la sortie de la commande d'import