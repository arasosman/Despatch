## Despatch Challenge

Static code analysis and tests were given importance in the project.


### Installation

    git clone https://github.com/arasosman/Despatch.git
	cd despatch
    docker-compose up -d --build
    docker-compose exec app cp .env.example .env
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate


### Migration

    php artisan migrate

### Tests

    docker-compose exec app composer test

    if use windows exec this 
    composer test_windows

    test indcluded PhpCS, PhpMD and PhpUnit