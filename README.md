# Beery
[![Build Status](https://travis-ci.com/lchrusciel/Beery.svg?token=cTZwsneSCKxJFLqtmGSW&branch=master)](https://travis-ci.com/lchrusciel/Beery)

Backend application for sharing beers information and rating them. 

This project was built as a master thesis project and was described in "Modern methods of software development based on recommendation platform". The whole master thesis is available here: https://github.com/lchrusciel/MasterThesis

### Roadmap

**0.1.0**

- Adding new beers
- Browsing list of beers

**0.2.0**

- User registration
- Rating beers

**0.3.0**

- Presenting list of recommended beers

**0.4.0**

- Editing beers descriptions
- Beers info validation

**Future**

- Beer images
- Geolocal recommendation
- Closest recommended beer
- Friends
- Friends recommendation

### Installation

Run local instance of neo4j and MySQL database.

```bash
$ composer install --prefer-dist
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
```

### Usage

### Testing

To run existing tests, type in console:

```bash
$ source .test.env
$ composer test
```

### Infection
```warning
This configuration requires pre installed infection library on local environment!
```

Basic configuration for mutation testing framework has been deliver together with this library. In order to run infection
framework one has to rename `phpspec-with-test-coverage.yml.dist` to `phpspec.yml` and run following command:
```bash
$ infection --test-framework=phpspec
```
