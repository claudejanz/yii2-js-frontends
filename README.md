<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <a href="https://github.com/angular" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/139426" height="100px">
    </a>
    <a href="https://github.com/facebook/react" target="_blank">
        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9Ii0xMS41IC0xMC4yMzE3NCAyMyAyMC40NjM0OCI+CiAgPHRpdGxlPlJlYWN0IExvZ288L3RpdGxlPgogIDxjaXJjbGUgY3g9IjAiIGN5PSIwIiByPSIyLjA1IiBmaWxsPSIjNjFkYWZiIi8+CiAgPGcgc3Ryb2tlPSIjNjFkYWZiIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiPgogICAgPGVsbGlwc2Ugcng9IjExIiByeT0iNC4yIi8+CiAgICA8ZWxsaXBzZSByeD0iMTEiIHJ5PSI0LjIiIHRyYW5zZm9ybT0icm90YXRlKDYwKSIvPgogICAgPGVsbGlwc2Ugcng9IjExIiByeT0iNC4yIiB0cmFuc2Zvcm09InJvdGF0ZSgxMjApIi8+CiAgPC9nPgo8L3N2Zz4K" alt="" height="100">
    </a>
    <a href="https://github.com/vuejs/vue" target="_blank">
        <img src="https://vuejs.org/images/logo.png" height="100px">
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

### Set hosts file
~~~
127.0.0.1	api.yii2-js-frontends.local
127.0.0.1	vuejs.yii2-js-frontends.local
127.0.0.1	reactjs.yii2-js-frontends.local
127.0.0.1	angular.yii2-js-frontends.local
~~~

### Set virtial host
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