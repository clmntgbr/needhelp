# Symfony NeedHelp Test

Vous êtes chargé(e) de développer une plateforme similaire à NeedHelp.com. Cette plateforme met en
relation des personnes ayant besoin d'aide pour des petits travaux (Customer) avec des prestataires de
services (Jobber).

## Getting Started

1. Clone this repo
2. Run `cp .env.dist .env`
3. Run `make start` to initialize the project
4. Run `make init` to initialize the project
5. You can run `make help` to see all commands available

## Overview

Open `http://localhost:8070/admin` in your favorite web browser for symfony app
Open `http://localhost:8071` in your favorite web browser for the client app

## Features

* PHP 8.3.2
* Nginx 1.20
* MariaDB 10.4.19
* Symfony 7.0.2

**Enjoy!**

**Improvements**

- Adding security on calls with api token
- Adding role to avoid jobber to accept offer for example, customer can only see jobs they posted and many more business rules.
- Adding tests with PHPUnit & Behat