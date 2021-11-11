Slim PoC in DDD
========================

Proof of concept di un approccio Domain-Driven Design in Hexagonal Architecture con Slim 4.7 
per lo sviluppo di un microservizio API

![Slim 4.7](https://img.shields.io/badge/Slim-4.7-purple.svg?style=flat-square&logo=slimphp)
![Php 8.0.10](https://img.shields.io/badge/Php-8.0.10-blue.svg?style=flat-square&logo=php)
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

Mentre per avere una lista dei comandi disponibili:
```
make help
```

Il container php è configurato per far comunicare Xdebug con l'IDE in uso.

## Sviluppo

#### Abilitare Xdebug
```
sudo xon;
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

### Librerie / Tools
* [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
* [PHP CS Fixer configs](https://mlocati.github.io/php-cs-fixer-configurator)
* [Commitlint](https://commitlint.js.org/#/)
* [Commitlint rules](https://www.npmjs.com/package/@commitlint/config-conventional#rules)
* [PHPStan](https://github.com/phpstan/phpstan)
