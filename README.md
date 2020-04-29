Folding@Home API console
========================

A Symfony 4.4 LTS console command to interact with [Folding@Home](https://foldingathome.org) project API. This command provides an easy method to check the detailed team stats.

---

#### Installation requirements

* PHP 7.1.3 (or higher)
* PHP ctype extension
* PHP iconv extension
* Composer 1.10

#### Installation instructions

```bash
$ git clone git@github.com:davidromani/folding-at-home-api-console.git
$ cd folding-at-home-api-console
$ composer install
```

#### Edit environment config 

Remember to edit `.env` config file according to your system environment needs. Replace `<detault_folding_team_number_to_check>` by your team number or 0 (if you don't have).

```bash
$ touch .env
$ echo "FOLDING_API_URL=https://api.foldingathome.org/" >> .env
$ echo "FOLDING_TEAM_NUMBER=<detault_folding_team_number_to_check>" >> .env
```

#### Usage

To show your default team to check.

```bash
$ php bin/console app:get:team:stats
```

Or show another team by ID number. Remember to replace `<id>` by a team number.

```bash
$ php bin/console app:get:team:stats <id>
```
