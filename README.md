Folding@Home API console
========================

A Symfony 4.4 LTS console command to interact with [Folding@Home](https://foldingathome.org) project API. This command provides an easy method to check the detailed team stats.

## Installation requirements

* PHP 7.4
* Composer 1.10

## Installation instructions

```bash
$ git clone git@github.com:davidromani/folding-at-home-api-console.git
$ cd folding-at-home-api-console
$ composer install
$ ./vendor/bin/doctrine orm:schema-tool:create -q -n
```

## Usage

Show team stats by ID number in an output pretty format. Remember to replace `<id>` by a team number or team 0 will be searched.

```bash
$ php app.php folding:get:team:stats <id>
```
