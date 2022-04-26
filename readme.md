Seguire i seguenti passi per far partire il programma 
- Avere installato docker sul proprio pc 

I seguenti comandi dovranno essere scritti tamite terminale
- docker run -d -p 8080:80 --name my-apache-php-app --rm  -v IlPercorsoDellaCartella:/var/www/html zener79/php:7.4-apache --> questo comando permetterà di avviare un webserver dockerizzato

- docker run --name my-mysql-server --rm -v IlPercorsoDellaCartella/mysqldata:/var/lib/mysql -v IlPercorsoDellaCartella/dump:/dump -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest 

- docker exec -it my-mysql-server bash

- mysql -u root -p < /dump/create_employee.sql; exit;


In questo progetto è stata utilizzata la tecnica di programazzione AJAX che rende possibile la comunicazione tra client e server, sono state utilizzate le operazioni GET, POST, PUT, DELETE.

- GET --> permettere di fare una richiesta al server 

- DELETE --> Elimina il dato che viene selezionato dalla richiesta

- POST --> Ha la funzione di aggiungere i dati all'interno del server

- PUT --> Modifica i dati già salvati in precedenza 