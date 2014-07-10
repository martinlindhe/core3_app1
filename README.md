# About

Sample app with bootstrap setup etc,
using AngularJS





# Install

In the app root, create a symlink named "core3" to core3 root directory:

  ln -s /Users/ml/dev/core3 core3





## OSX SETUP

On OSX, assuming you have Apache and PHP enabled, create a symlink in /Library/WebServer:

  sudo ln -s /Users/ml/dev/core3_app1/ /Library/WebServer/Documents/app1

Then, go to http://localhost/app1

In /etc/apache2/httpd.conf,
change

  <Directory "/Library/WebServer/Documents">
    AllowOverride all             # allows use of .htaccess files
  </Directory>


Create a symlink for angular.js to be accessable in the web root:

  ln -s /Users/ml/dev/core3_app1/vendor/components/angular.js/ js/angular.js

Symlink for angular-ui/bootstrap:

  ln -s /Users/ml/dev/core3_app1/vendor/angular-ui/bootstrap js/angular-ui-bootstrap
