This repository is the source for [Infusionsoft SDK WordPress plugin](https://wordpress.org/plugins/infusionsoft-sdk)

HOWTO Use

1. Checkout the SVN repository
  `svn co https://plugins.svn.wordpress.org/infusionsoft-sdk SVN/infusionsoft-sdk`  
  Put the repository in a subdirectory to reduce confusion. If you put it elsewhere, update `copy-to-svn.sh`
1. Install or Update library dependencies
  `composer install -o` or `composer update -o`
1. Update the SVN repository
  `./copy-to-svn.sh`  
  The script will create a zip file that can be used to install the plugin. 