#!/bin/zsh
here=`pwd`
alias cp="cp -R"
alias svn="svn"
alias rsync="rsync"
project="infusionsoft-sdk-for-wordpress"
slug="infusionsoft-sdk"
root="/Users/jeffreychimene/wordpress"
#
# Refresh trunk
#
cd $root/$project
echo rsync -av --progress . $root/$project/SVN/$slug/trunk/
# 
rsync -rav . $root/$project/SVN/$slug/trunk/ \
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
--exclude '*infusionsoft-php-sdk/composer*' \
--exclude '*/utilities*' \
--exclude '*infusionsoft-php-sdk/config.sample.php*' \
--exclude '*infusionsoft-php-sdk/style.css*' \
--exclude '*forceutf8/resources*' \
--exclude '*forceutf8/composer.json*' 

#
# Diddle svn
#
cd $root/$project/SVN/$slug
mv trunk $slug
#
# Create zip
#
zip -qr $slug.zip $slug
unzip -tq *zip
find *zip -exec mv {} $here \;
#
# Diddle svn
#
mv $slug trunk
#
# Done
#
cd $here
svn status $root/$project/SVN/$slug
