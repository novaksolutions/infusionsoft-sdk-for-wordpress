This repository is the source for [Infusionsoft SDK WordPress plugin](https://wordpress.org/plugins/infusionsoft-sdk)

HOWTO Use

1. Clone this repository and make the resulting directory your current working directory.  
  Skip this step if you already have a current working directory.  
  `git clone https://github.com/jchimene/infusionsoft-sdk-for-wordpress.git`
1. Checkout the SVN repository.  
  `svn co https://plugins.svn.wordpress.org/infusionsoft-sdk SVN/infusionsoft-sdk`  
  Put the repository in a subdirectory to reduce confusion. If you put it elsewhere, update `copy-to-svn.sh`
1. Install or Update library dependencies. Use `update` when you already have a current working directory.  
  `composer install -o` or `composer update -o`
1. Update `trunk` in the SVN working copy.  
  `./copy-to-svn.sh`  
  The script will create a zip file that can be used to install the development version, aka `trunk` via wp-cli:  
  `wp @local plugin install --force --activate infusionsoft-sdk.zip`
