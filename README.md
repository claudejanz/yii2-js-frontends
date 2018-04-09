# Yii2-js-frontends

This project is a skeleton of a [Yii 2](http://www.yiiframework.com/) api with [Angular](https://angular.io/), [Reactjs](https://reactjs.org) and [Vuejs](https://vuejs.org/) frontends

[![Latest Stable Version](https://img.shields.io/packagist/v/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Total Downloads](https://img.shields.io/packagist/dt/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Build Status](https://travis-ci.org/claudejanz/yii2-js-frontends.svg?branch=master)](https://travis-ci.org/claudejanz/yii2-js-frontends)

## Installation

### Dependencies managers

To install project and all dependencies, we need 2 dependencies managers:

* [npm](https://www.npmjs.com/) needs to be globaly installed for js dependencies.

* [composer](https://getcomposer.org/doc/00-intro.md#introduction) needs to be globaly installed for php dependencies.

> You can test your installations by running: **npm -v** for checking npm and: **composer -V** for composer 

### Install project

Run flowing command to create project and load all necessary dependencies:

~~~bash
composer create-project --stability=dev claudejanz/yii2-js-frontends your-folder
~~~

> Don't forget to change **your-folder** to your desired destination folder 

### Install database

Configure your database name and access in **./yii-server/config/db.php** or simpliy create a mysql database called "**yii2-js-frontends**" with "**root**" and **no password** access

Run following scripts to migrate and populate your database:

~~~bash
cd ./yii2-server/      # go to yii-server root
./yii migrate           # database schema for users, topics, posts and comments - press entre at prompt
./yii migrate --migrationPath=@yii/rbac/migrations  # database schema for role based access(RBAC) - press enter at prompt
./yii rbac              # generate RBAC permissions, rules and roles - press enter at prompt
./yii content           # generate First users - press enter at prompt
~~~

### Set hosts file

Set your *.hosts* file to access api and frontends. Only the first one is required for development. the three others are for production tests.

~~~bash
127.0.0.1     api.yii2-js-frontends.local
127.0.0.1     angular.yii2-js-frontends.local
127.0.0.1     reactjs.yii2-js-frontends.local
127.0.0.1     vuejs.yii2-js-frontends.local
~~~

> You can change api **baseUrl** in ./config/config.json shared by **all front-end framworks**

### Set virtial host

Set your vhosts on Apache Server to access api and frontends. 
> Only the first one is required for developpment. the three others are for production tests

~~~apache
<VirtualHost *:80>
    ServerName api.yii2-js-frontends.local
    DocumentRoot c:/GitDepot/yii2-js-frontends/yii2-server/web
    <Directory  "c:/GitDepot/yii2-js-frontends/yii2-server/web/">
        Options All
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
             RewriteEngine On
             RewriteBase /
             RewriteRule ^index\.php$ - [L]
             RewriteCond %{REQUEST_FILENAME} !-f
             RewriteCond %{REQUEST_FILENAME} !-d
             RewriteRule . /index.php [L]
        </IfModule>
     </Directory>
</VirtualHost>
<VirtualHost *:80>
    ServerName angular.yii2-js-frontends.local
    DocumentRoot "c:/GitDepot/yii2-js-frontends/angular/dist/"    
    <Directory  "c:/GitDepot/yii2-js-frontends/angular/dist/">
        Options All
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
             RewriteEngine On
             RewriteBase /
             RewriteRule ^index\.html$ - [L]
             RewriteCond %{REQUEST_FILENAME} !-f
             RewriteCond %{REQUEST_FILENAME} !-d
             RewriteRule . /index.html [L]
        </IfModule>
     </Directory>
</VirtualHost>
<VirtualHost *:80>
    ServerName reactjs.yii2-js-frontends.local
    DocumentRoot "c:/GitDepot/yii2-js-frontends/reactjs/public/"    
    <Directory  "c:/GitDepot/yii2-js-frontends/reactjs/public/">
        Options All
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
             RewriteEngine On
             RewriteBase /
             RewriteRule ^index\.html$ - [L]
             RewriteCond %{REQUEST_FILENAME} !-f
             RewriteCond %{REQUEST_FILENAME} !-d
             RewriteRule . /index.html [L]
        </IfModule>
     </Directory>
</VirtualHost>
<VirtualHost *:80>
    ServerName vuejs.yii2-js-frontends.local
    DocumentRoot "c:/GitDepot/yii2-js-frontends/vuejs/dist/"
    <Directory  "c:/GitDepot/yii2-js-frontends/vuejs/dist/">
        Options All
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
             RewriteEngine On
             RewriteBase /
             RewriteRule ^index\.html$ - [L]
             RewriteCond %{REQUEST_FILENAME} !-f
             RewriteCond %{REQUEST_FILENAME} !-d
             RewriteRule . /index.html [L]
        </IfModule>
     </Directory>
</VirtualHost>
~~~

> Don't forget to restart server after setting your vhosts

## Run in development

### Vuejs

To run *vuejs* in dev mode go to vuejs folder and run

~~~batch
npm run dev
~~~

You can access front-end through [http://localhost:8082](http://localhost:8082)

## TODO

- [ ] angular
- [ ] reactjs
- [x] vuejs
- [x] yii2
