#!/bin/sh
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
cd $root/$project/$slug
rsync -av --progress . $root/$project/SVN/$slug/trunk/ \
--exclude */.git*  \
--exclude */.hg* \
--exclude */*Test* \
--exclude */*test* \
--exclude */*nstalled* \
--exclude */*platform* \
--exclude */README.md* \
--exclude */bin* \
--exclude */example* \
--exclude */$project/composer* \
--exclude */infusionsoft-php-sdk/composer* \
--exclude */Infusionsoft/utilities* \
--exclude */Infusionsoft/config.sample.php* \
--exclude */style.css* \
--exclude */forceutf8/resources* \
--exclude */forceutf8/composer.json*
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
