# Radio net


## démarrage du back-end

##  radio.env
ajouter un fichier radio.env dans le dossier radio.components 
Il doit contenir ceci :
`
MYSQL_ROOT_PASSWORD=r00tquizz
MYSQL_USER=radio.db
MYSQL_PASSWORD=radio.db
MYSQL_DATABASE=radio.db
`

## Radio.db.ini 
Ensuite copier coller le fichier radio.db.ini.template avec le nom :
`radio.db.ini` et ajouter ceci :  `username=radio.db
password=radio.db`

## lancement de docker :
``` bash
docker compose up
```

## installation des dépendances : 
```bash 
docker compose exec api.radio composer install
```

