1. ```git clone git@github.com:edgars-f/vendon.git```

2. ```cd vendon```

3. ```docker-compose up --build```

4. ```docker-compose exec backend composer install ```

5. ```docker-compose exec backend /var/www/html/vendor/bin/phinx migrate -c /var/www/html/config/phinx.php ```

6. ```docker-compose exec backend /var/www/html/vendor/bin/phinx seed:run -c /var/www/html/config/phinx.php```

5. Atver http://localhost:80/

Backend loģika sadalīta pēc Controller-Service-Repository paterna.

Prasījās vēl JSON middelware ielikt, lai automātiski objektus par JSON responsiem atgriež visās vietās.

Izmantoju dažas PHP bibliotēkas:

```bramus/router``` priekš rūtinga;

```robmorgan/phinx``` migrācijām un seedingam;

```vlucas/phpdotenv``` priekš .env

```fakerphp/faker``` lai saģenerētu fake datus.

Backends uz 8081 griežas

frontends - next.js uz 80

```/api/tests/``` priekš visiem testiem

```/api/tests/XXX``` - konkrētais tests

```/api/reports``` - visi testu dati

Rūti redzami zem ```/public/index.php```

4/5/6. punktu komandas nepaspēju salikt dokerī, lai būtu automātisiki migrācijas un data seedings :)

Kaut ko varēja vēl labāk sasplitot pa kontrolieriem/servisiem, bet gan jau kopējo ainu iedos.
