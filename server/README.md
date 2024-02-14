# Radio net


## démarrage du back-end

##  radio.env
ajouter un fichier radio.env dans le dossier radio.components 
Il doit contenir ceci :
`
MYSQL_ROOT_PASSWORD=r00t
MYSQL_USER=radio_net
MYSQL_PASSWORD=radio_net
MYSQL_DATABASE=radio_net
`

## Radio.db.ini 
Ensuite copier coller le fichier radio.db.ini.template avec le nom :
`radio.db.ini` et ajouter ceci :  
`username=radio_net
password=radio_net`

## lancement de docker :
``` bash
docker compose up
```

## installation des dépendances : 
```bash 
docker compose exec radio.api composer install
```

## obtenir les données de bdd : 
aller sur le localhost:8080 
Se connecter avec les données du radio.db
Ajouter les données en important les données sql qui se trouve dans le dossier server/sql 