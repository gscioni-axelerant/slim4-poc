Slim PoC in DDD
========================

Proof of concept di un approccio Domain-Driven Design in Hexagonal Architecture con Slim 4.7 
per lo sviluppo di un microservizio API

![Php 8.0.10](https://img.shields.io/badge/Php-8.0.10-9cf.svg?style=flat-square&logo=php)
![MySQL 8.0](https://img.shields.io/badge/MySQL-8.0-red.svg?style=flat-square&logo=mysql)
![Slim 4.7](https://img.shields.io/badge/Slim-4.7-purple.svg?style=flat-square&logo=slimphp)
![Docker 20.10](https://img.shields.io/badge/Docker-20.10-blue.svg?style=flat-square&logo=docker)
![Node 16.12.0](https://img.shields.io/badge/Node.js-16.12.0-green.svg?style=flat-square&logo=nodedotjs)

## Preparazione ambiente sviluppo
L'applicazione funziona all'interno di un container docker. Preparare l'ambiente in questo modo:

#### Requisiti
- Docker
- Docker compose

#### Primo avvio
L'ambiente è containerizzato con Docker, dove è presente un alias per eseguire i comandi più frequenti
```
git clone git@github.com:gscioni-innoteam/slim4-poc.git
make build
make up
make enter
composer install
```

Il container php è configurato per far comunicare Xdebug con l'IDE in uso.

## Sviluppo

#### Entrare dentro il container php
```
make enter;
```
#### Abilitare Xdebug (da dentro il container php)
```
sudo xon;
```

#### Eseguire i test (da dentro il container php)
```
vendor/bin/phpunit
```

## Hooks pre-commit
Il sistema elaborerà alcuni hooks automatici, uno fra questi è il commitlint.
Vengono eseguiti check di analisi statica e test ad ogni commit.

Per modificarne il flusso:
```
nano scripts/git-hooks/pre-commit
```

## Tools

#### Eseguire il fix del coding style
```
make cs-fix
```

#### Eseguire phpstan
```
make phpstan
```

#### Abilitare/disabilitare Xdebug
```
make xon/xoff
```

#### Avere una lista dei comandi disponibili
```
make help
```

### Librerie / Tools
* [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
* [PHP CS Fixer configs](https://mlocati.github.io/php-cs-fixer-configurator)
* [Commitlint](https://commitlint.js.org/#/)
* [Commitlint rules](https://www.npmjs.com/package/@commitlint/config-conventional#rules)
* [PHPStan](https://github.com/phpstan/phpstan)
* [Doctrine](https://www.doctrine-project.org/)
