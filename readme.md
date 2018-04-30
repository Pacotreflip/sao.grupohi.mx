# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

##Requerimientos  del sistema
- Node js Version 6.12.3
- Nmp 3.10.10
- gulp
- Mysql 5.7
- php 7.1

##Ubuntu 17
**Manual de instalación de slq server**

    https://www.microsoft.com/en-us/sql-server/developer-get-started/php/ubuntu/
    https://docs.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac

**Manual de instalación de nodejs**

    Version de node js requerido 6.X
    curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
    sudo apt-get install -y build-essential
    sudo apt-get install -y nodejs
    
**Manual instalación mysql 5.7**

    sudo apt-get install mysql-server mysql-client

- descargar compatibilidad mysql
    
    `https://dev.mysql.com/downloads/file/?id=474129`

     
**Instalación librerias extra de php 7.1**
    
    sudo apt-get install php7.1 libapache2-mod-php7.1 php7.1-cli php7.1-common php7.1-mbstring php7.1-gd php7.1-intl php7.1-xml php7.1-mysql php7.1-mcrypt php7.1-zip
   
**Instalación de gulp**
    
    npm install gulp-cli -g
    
    
##Comando de ejecusión 

**Seeders Control de permisos**
    
    php artisan db:seed --class=RolesPermissionsSeeder
    
**Migraciones DB Seguridad**
    
    php artisan migrate --database=seguridad --path=database/migrationsSeguridad
    
    