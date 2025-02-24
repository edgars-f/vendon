1. ```git clone git@github.com:edgars-f/vendon.git```

2. ```cd vendon```

3. ```docker-compose up --build```

4. ```docker-compose exec backend composer install && \ ```
```docker-compose exec backend /var/www/html/vendor/bin/phinx migrate -c /var/www/html/config/phinx.php && \```
```docker-compose exec backend /var/www/html/vendor/bin/phinx seed:run -c /var/www/html/config/phinx.php```

5. Open http://localhost:80/