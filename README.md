# Welcome to Rinku Project!

Project for the company Rinku Cinemas
Follow the steps below to install the project successfully

## Requirements

- Ubuntu 22.04
- php 8.1
- MySql 8.0.34+
- git version 2.34.1+
- Composer 2.2.6+

## Installation
1. Clone project https://github.com/NeftaliAcosta/rinku-project.io in folder **/var/www/rinku-project.io/**
2. Add the following file **rinku-project.io.conf** in the folder /etc/apache2/sites-available with the following code:

       VirtualHost *:80>  
       # The ServerName directive sets the request scheme, hostname and port that  
       # the server uses to identify itself. This is used when creating  
       # redirection URLs. In the context of virtual hosts, the ServerName  
       # specifies what hostname must appear in the request's Host: header to  
       # match this virtual host. For the default virtual host (this file) this  
       # value is not decisive as it is used as a last resort host regardless.  
       # However, you must set it for any further virtual host explicitly.  
       #ServerName www.example.com  

       ServerAdmin webmaster@localhost  
       DocumentRoot /var/www/rinku-project.io  
       ServerAlias rinku-project.io  
     
       # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,  
       # error, crit, alert, emerg.  
       # It is also possible to configure the loglevel for particular  
       # modules, e.g.  
       #LogLevel info ssl:warn  
         
       ErrorLog ${APACHE_LOG_DIR}/error.log  
       CustomLog ${APACHE_LOG_DIR}/access.log combined  
         
       # For most configuration files from conf-available/, which are  
       # enabled or disabled at a global level, it is possible to  
       # include a line for only one particular virtual host. For example the  
       # following line enables the CGI configuration for this host only  
       # after it has been globally disabled with "a2disconf".  
       #Include conf-available/serve-cgi-bin.conf  
     
   	    <Directory /var/www/rinku-project.io>  
   		    Options Indexes FollowSymLinks  
   		    AllowOverride All  
   		    Order allow,deny  
   		    Allow from all  
   		    Require all granted  
   	    </Directory>  
       </VirtualHost>

3. Run command sudo a2ensite rinku-project.io.conf
4. Add  the next line  `127.0.1.1  rinku-project.io` in hosts file /etc/hosts
5. Restart apache `sudo systemctl restart apache2`

### Commands Cli
- Reset the database `composer bin-recovery`
- Run the last init to make a specific change to the database `composer bin-init`

![enter image description here](https://i.ibb.co/gMZ2fqg/client-rinku.png)

### Preview
![enter image description here](https://i.ibb.co/zNGCzGR/rinku-preview.png)
