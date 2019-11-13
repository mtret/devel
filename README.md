# How to run

First clone the repo to a folder of your choosing.

### Prerequisites
* [docker](https://www.docker.com/)
* [docker-compose](https://docs.docker.com/compose/)
* Make

### Container
 - [nginx](https://hub.docker.com/_/nginx/) 1.16.+
 - [php-fpm](https://hub.docker.com/_/php/) 7.3.+
- [mysql](https://hub.docker.com/_/mysql/) 5.7.+

### Installing the app

Switch to the project folder and use make commands in the following order. 


Run containers:
```
 make build-up
```

Composer install:
```
 make composer-install 
```

Fix privileges if needed:
```
 make chmod 
```

Prepare db schema:
```
make schema-init
```

Run migrations:
```
make migrate
```

### Running the app

This is only for testing purposes, so before you to send an email, set MAILER_DEV_MAIL in .env file (all the emails will head there)
and run 

```
make newsletter
```

Mails are sent through SMTP and caught by mailcatcher container, view them at [localhost:1080](localhost:1080)