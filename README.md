## Despatch Challenge

Static code analysis and tests were given importance in the project.


### Installation

    git clone https://github.com/arasosman/Despatch.git
	cd despatch
    docker-compose up -d --build
    docker-compose exec app cp .env.example .env
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate

please don't forget to add app_key to .env file. otherwise it won't connect to the market api.

### Migration

    docker-compose exec app php artisan migrate

### Run importer
Importer is the command to import data from market api. Invoked once a minute by scheduled tasks.

    docker-compose exec app php artisan schedule:work
normally this command should be called by supervisor.

all running commands, Jobs and all other details. You can watch on Laravel Telescope

    http://localhost:8080/telescope

### Tests

    docker-compose exec app composer test

    if use windows exec this 
    composer test_windows

    test indcluded PhpCS, PhpMD and PhpUnit