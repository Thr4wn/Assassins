#!/bin/bash
cd `dirname $0` #change to the directory wherin this script is being run.
#cd public_html # Change to public_html directory.
HOST='taylorassassins.comule.com'
USER='a2852126'
#The first parameter passed will be treated as the password. If nothing is passed, then get the password from the command line
PASSWD=$1
if [ ":$PASSWD" = ":" ] ; then
    echo -n 'What is the ftp password: '
    read PASSWD
fi



for file in `find | perl -ne 'print unless /\.git/'`
do
ftp -in $HOST<<END_SCRIPT
user $USER $PASSWD
put $file
quit
END_SCRIPT
done

exit 0
