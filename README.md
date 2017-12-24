# Beery
[![Build Status](https://travis-ci.com/lchrusciel/Beery.svg?token=cTZwsneSCKxJFLqtmGSW&branch=master)](https://travis-ci.com/lchrusciel/Beery)

Backend application for sharing beers information and rating them. 

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
