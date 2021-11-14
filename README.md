Slim PoC in DDD
========================

Proof of concept di un approccio Domain-Driven Design in Hexagonal Architecture con Slim 4.7 
per lo sviluppo di un microservizio API

![Php 8.0.10](https://img.shields.io/badge/Php-8.0.10-9cf.svg?style=flat-square&logo=php)
![Slim 4.7](https://img.shields.io/badge/Slim-4.7-purple.svg?style=flat-square&logo=data:image/png;base64,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)
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
