# About

Sample app with bootstrap setup etc,
using AngularJS





# Install

In the app root, create a symlink named "core3" to core3 root directory:

  ln -s /Users/ml/dev/core3 core3


## OSX SETUP:

On OSX, create a symlink in /Library/WebServer

  sudo ln -s /Users/ml/dev/core3_app1/ /Library/WebServer/Documents/app1

Then, go to http://localhost/app1

In /etc/apache2/httpd.conf,
change

  <Directory "/Library/WebServer/Documents">
    AllowOverride all             # allows use of .htaccess files
  </Directory>


  sudo nano /etc/apache2/httpd.conf

Enable php:

  LoadModule php5_module libexec/apache2/libphp5.so

save & exit

  sudo apachectl restart

xxxx Set up an apache vhost with the root directory pointing to core3_app1
and point your browser at it.

xxxx Put your app in the app subfolder

## END OSX SETUP


# TODO

XXX TODO rewrite rule to map vendor/components/angular.js to /js/angular.js web path
XXX TODO dont expose vendor path on web server!!!!!


XXXX TODO config path to core3 with a symlink in app root!!!

TODO later: composer dependency for core3 ?

XXX TODO SECURITY .htaccess rewrite regel för att blocka .git katalogen funkar inte!!!!



XXXX DROP angular.js directory and checkout with composer!
