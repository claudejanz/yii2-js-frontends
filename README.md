<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">yii2-js-frontends</h1>
    <br>
</p>

This project is a skeleton of a [Yii 2](http://www.yiiframework.com/) api 
with [Angular](https://angular.io/), 
[Reactjs](https://reactjs.org)  
and [Vuejs](https://vuejs.org/) frontends

[![Latest Stable Version](https://img.shields.io/packagist/v/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Total Downloads](https://img.shields.io/packagist/dt/claudejanz/yii2-js-frontends.svg)](https://packagist.org/packages/claudejanz/yii2-js-frontends)
[![Build Status](https://travis-ci.org/claudejanz/yii2-js-frontends.svg?branch=master)](https://travis-ci.org/claudejanz/yii2-js-frontends)

## Installation

# Set hosts file
~~~
127.0.0.1	api.yii2-js-frontends.local
127.0.0.1	vuejs.yii2-js-frontends.local
127.0.0.1	reactjs.yii2-js-frontends.local
127.0.0.1	angular.yii2-js-frontends.local
~~~

# Set virtial host
~~~
<VirtualHost *:80>
	ServerName api.yii2-js-frontends.local
	DocumentRoot c:/GitDepot/yii2-js-frontends/server/web
	<Directory  "c:/GitDepot/yii2-js-frontends/server/web/">
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
    DocumentRoot "c:/GitDepot/yii2-js-frontends/reactjs/build/"    
    <Directory  "c:/GitDepot/yii2-js-frontends/reactjs/build/">
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
    DocumentRoot "c:/GitDepot/yii2-js-frontends/vuejs/public/"    
    <Directory  "c:/GitDepot/yii2-js-frontends/vuejs/public/">
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