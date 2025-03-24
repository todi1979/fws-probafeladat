## Senior fejlesztő egyedi próbafeladat

**Az oldalon az alábbi feladatok szerepelnek:**
* CSV feltöltés, és feldolgozás
* XML letöltés és megnyitás
* SQL feladathoz tartozó lekérdezés


#### Az alábbi docker image-ek szolgáltatták a futtatókörnyezetet:

* nginx (latest)
* phpmyadmin (latest)
* php (8.4)
* mysql (latest)

#### Lépések

* git projekt klónozás 
* az **.env.example** fájlban módosítsd a **PROJECT** nevű változót, és nevezd át .env -re
* generáld le a laravel-hez az APP_KEY -t (**php artisan key:generate --force**)
* állítsd be az url-t a hosts fájlodban, ha docker a futtatókörnyezeted
  (C:\Windows\System32\drivers\etc\hosts)
  127.0.0.1 **probafeladat.loc**
* parancsok futtatása
  * composer install
  * npm install
  * npm run build
  * php artisan migrate
  * php artisan storage:link
* böngészőbe nyisd meg, ha docker a futtatókörnyezet: https://probafeladat.loc/