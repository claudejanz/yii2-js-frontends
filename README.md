# Yii2-js-frontends

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <a href="https://github.com/angular" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/139426" height="100px">
    </a>
    <a href="https://github.com/facebook/react" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/React-icon.svg/1280px-React-icon.svg.png" alt="" height="100">
    </a>
    <a href="https://github.com/vuejs/vue" target="_blank">
        <img src="https://vuejs.org/images/logo.png" height="100px">
    </a>
</p>

This project is a skeleton of a [Yii 2](http://www.yiiframework.com/) api with [Angular](https://angular.io/), [Reactjs](https://reactjs.org) and [Vuejs](https://vuejs.org/) frontends

[![Latest Stable Version](https://img.shields.io/packagist/v/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Total Downloads](https://img.shields.io/packagist/dt/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Build Status](https://travis-ci.org/claudejanz/yii2-js-frontends.svg?branch=master)](https://travis-ci.org/claudejanz/yii2-js-frontends)

## Installation

### Install dependencies

Install all required dependencies.

~~~bash
cd ./yii2-server/   # go to yii server folder.
composer install    # install yii dependencies through [composer](https://getcomposer.org/)
cd ../angular       # go to angular folder
npm install         # install angular dependencies through node packet manager [npm](https://www.npmjs.com/)
cd ../reactjs       # go to reactjs folder
npm install         # install reactjs dependencies through node packet manager [npm](https://www.npmjs.com/)
cd ../vuejs         # go to vuejs folder
npm install         # install vuejs dependencies through node packet manager [npm](https://www.npmjs.com/)
~~~

### Install database

Configure your database name and access in ./yii-server/config/db.php or simpliy create a mysql database called "yii2-js-frontends" with "root" and no password access

Then run following scripts to migrate and populate your database:

~~~bash
cd ../yii2-server/      # go to yii-server root
./yii migrate           # database schema for users, topics, posts and comments - press entre at prompt
./yii migrate --migrationPath=@yii/rbac/migrations  # database schema for role based access(RBAC) - press enter at prompt
./yii rbac              # generate RBAC permissions, rules and roles - press enter at prompt
./yii content           # generate First users - press enter at prompt
~~~

### Set hosts file

Set your .hosts file to access api and frontends. Only the first one is required for developpment. the three others are for production tests.

~~~bash
127.0.0.1     api.yii2-js-frontends.local
127.0.0.1     angular.yii2-js-frontends.local
127.0.0.1     reactjs.yii2-js-frontends.local
127.0.0.1     vuejs.yii2-js-frontends.local
~~~

You can change api baseUrl in ./config/config.json shared by all front-end framworks

### Set virtial host

Set your vhosts on Apache Server to access api and frontends. Only the first one is required for developpment. the three others are for production tests

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

! Don't forget to restart server after setting your vhosts

## Run in developpment

### Vuejs

To run vuejs in dev mode go to vuejs folder and run

~~~batch
npm run dev
~~~

You can access front-end through [http://localhost:8082](http://localhost:8082)
