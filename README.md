## Despatch Challenge

Static code analysis and tests were given importance in the project.

#### please don't forget to add app_key to .env file. otherwise it won't connect to the market api.

### Installation

    git clone https://github.com/arasosman/Despatch.git
	cd despatch
    docker-compose up -d --build
    docker-compose exec app cp .env.example .env
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate

please don't forget to add app_key to .env file. otherwise it won't connect to the market api.

### Migration
migration is required.

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
I plan to add more detailed tests about import operations in a more comfortable time.

### Command

#### php artisan sync:order
    
    It pulls the order list from the market api and writes it to the queue for later processing.
    If the request does not come in a single list, other pages are also queued.

#### php artisan request_queue:work

    triggers two jobs to process the queue
    It takes the order id from the queue and get order data from service 
        and imports it to the database together with its relations.