#!/bin/zsh
alias cd="cd"
alias cp="cp -R"
alias find="find"
alias mv="mv"
alias svn="svn"
alias rsync="rsync -rav"
alias unzip="unzip -tq"
alias zip="zip -qr"
project="infusionsoft-sdk-for-wordpress"
slug="infusionsoft-sdk"
SVN="SVN"
here=`pwd`
root=`echo "$(dirname $here)"`
#
# Refresh trunk
#
cd $root/$project
rsync . $root/$project/$SVN/$slug/trunk/ \
--exclude '.*' \
--exclude 'composer.json' \
--exclude 'composer.lock' \
--exclude '*sh' \
--exclude '*zip' \
--exclude '*Test*' \
--exclude '*test*' \
--exclude '*nstalled*' \
--exclude 'README.md*' \
--exclude '*bin*' \
--exclude '*SVN*' \
--exclude '*/example*' \
--exclude '*/utilities*' \
--exclude '*infusionsoft-php-sdk/composer*' \
--exclude '*Infusionsoft/config.sample.php*' \
--exclude '*Infusionsoft/style.css*' \
--exclude '*forceutf8/resources*' \
--exclude '*forceutf8/composer.json*' 

#
# Diddle svn
#
cd $root/$project/$SVN/$slug
mv trunk $slug
#
# Create zip
#
zip $slug.zip $slug
unzip *zip
mv *zip $here
#
# Diddle svn
#
mv $slug trunk
#
# Done
#
cd $here
svn status $root/$project/$SVN/$slug
