Requirements:
-
- docker
- docker-compose

Build project:
- 
- from project directory:
```
docker-compose build --force-rm --no-cache
```

Static code analysis:
-
- from ``movie_app`` docker container:
```
vendor/bin/phpstan
```


Run Tests:
-
from ``movie_app`` docker container:
```
vendor/bin/phpunit
```
