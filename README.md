# projectBarber

-------------------------------------

Web-Application Symfony BARBER juin 01, 2018, 6:00 pm.

## Status

Master : [![build status]()](https://github.com/youdeve/ProjectBarber/commits/master)

Develop : [![build status]()](https://github.com/youdeve/ProjectBarber/commits/develop)


# First of all

Several dependancies are required to install or deploy this project
* [GitHub](https://desktop.github.com/)
* [Composer](https://getcomposer.org/download/)
* [Bower](http://bower.io/#install-bower)


# Install development environment
* Create a MySQL database

* Clone from project repository from GitHub

```sh
git clone git@github.com:youdeve/ProjectBarber.git
cd barber-server
git checkout develop
```

* Install symfony bundles using composer. Fulfill the database connection
credentials

```sh
$ composer install
```

* Install web dependencies using bower

```sh
$ bower install
```

# (Re)-initialize application

This command purges database, initiate tables strucutre according to Doctrine
annotations. The *--dev* argument generates sample data fixtures (<GROUP>@barber.fr / 123456)

```sh
$ php bin/console doctrine:fixtures:load [--dev]
```
You might need to install assets with symlinks (on Windows, you have to run this
command as administrator)

```sh
$ php bin/console assets:install --symlink
```

# Run PHP Server

If you do not specify <HOST> and <PORT>, serveur will run on 127.0.0.1:8080

```sh
$ php bin/console server:run [<HOST>:<PORT>]
```

You can also start your server as a background task (unavailable on Windows...)

```sh
$ php bin/console server:start [<HOST>:<PORT>]
```

Then you can stop it

```sh
$ php bin/console server:stop [<HOST>:<PORT>]
```

# Demo datas

```sh
$ php bin/console doctrine:fixture:load --dev
```

- admin@barber.fr
- jean@barber.fr
- AntoineLeManager@barber.fr

Password : 123456


# Symfony useful commands

## List all routes of the application

```sh
$ php bin/console debug:router
```

Filter routes to find some, quickly (not available on windows)

```sh
$ php bin/console debug:router | grep "FILTER"
```

## Clear cache

```sh
$ php bin/console cache:clear --env={prod|dev}
```

## FOSJsRoutingBundle

Configure what routes to expose

```yaml
# app/config/config.yml
fos_js_routing:
    routes_to_expose: [ ^api, route_to_expose, ... ]
```

Dump routes into an asset file, what make it possible to generate routes in the client-side (JavaScript)

```sh
$ php bin/console fos:js-routing:dump
```

Generate routes in the javascript

```javascript
Routing.generate('my_route_to_expose', { id: 10 });
// will result in /foo/10/bar
```

## Run PHPUnit Tests suite

In order to check the project properly run on your system, and before committing
changes, you should run tests and apply corrections if some of them fail.

* Download [PHPUnit](https://phpunit.de/) executable

```sh
# run the whole tests suite
phpunit
# run only one test controller
phpunit tests/MyBundle/Controller/MyControllerTest.php
```
