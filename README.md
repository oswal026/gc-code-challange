#CODE CHALLENGE

This repository contains the instructions to test an user API that allows:
* Create users with the following parameters: id (UUID v4), name, attributes. 
    - Each attribute is made up of two parameters (key, value).
    - Each user can have as many attributes as we need to save.
* Search users: filtering by attributes value.
* Get all users.

##Requirements
* PHP 7.4
* Symfony 5.0.*
* It is not necessary to use a database.

##Description
This is a complete stack for running Symfony 5 into Docker containers using docker-compose tool.

It is composed by 2 containers:
- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 7.4 PHPversion.

##Instructions to run the project
Here are the instructions to run the project using the scripts in this repository:

1. Clone this repository.
2. Run the following commands: 
    - `cd user-app`
    - `docker-compose up -d`
    
3. The 2 containers are deployed: 
    ```
    Creating symfony-docker_php_1   ... done
    Creating symfony-docker_nginx_1 ... done
    ```
4. Before running the project:
    - Access the project folder: `cd symfony`
    - Run: `composer update`
5. The postman_collection.json file contains the Postman Collection for testing the API endpoints.
