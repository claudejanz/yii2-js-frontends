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
    <h1 align="center">yii2-js-frontends</h1>
    <br>
</p>

# This project is a skeleton of a [Yii 2](http://www.yiiframework.com/) api with [Angular](https://angular.io/), [Reactjs](https://reactjs.org) and [Vuejs](https://vuejs.org/) frontends

[![Latest Stable Version](https://img.shields.io/packagist/v/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Total Downloads](https://img.shields.io/packagist/dt/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Build Status](https://travis-ci.org/claudejanz/yii2-js-frontends.svg?branch=master)](https://travis-ci.org/claudejanz/yii2-js-frontends)

## Installation

### Install dependencies

~~~bash
cd ./yii-server/
composer install
cd ../angular
npm install
cd ../reactjs
npm install
cd ../vuejs
npm install
~~~

### Install database

~~~bash
cd ./yii-server/
./yii migrate
./yii migrate --migrationPath=@yii/rbac/migrations
./yii rbac 
./yii content
~~~

### Set hosts file

~~~bash
127.0.0.1     api.yii2-js-frontends.local
127.0.0.1     angular.yii2-js-frontends.local
127.0.0.1     reactjs.yii2-js-frontends.local
127.0.0.1     vuejs.yii2-js-frontends.local
~~~

### Set virtial host

~~~bash
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