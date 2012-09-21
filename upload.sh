#!/bin/bash
#cd `dirname $0` #change to the directory wherin this script is being run. The `ftp_file` function depends on the current directory being the same as all the php files.
HOST='taylorassassins.comule.com'
USER='a2852126'

#The first parameter passed will be treated as the password. If nothing is passed, then get the password from the command line
PASSWD=$1
if [ ":$PASSWD" = ":" ] ; then
    echo -n 'What is the ftp password: '
    read PASSWD
fi
echo $PASSWD

#for file in `find | perl -ne 'print unless /\.git/'`
for file in main.php
do
ftp -in <<END_SCRIPT
open $HOST 
$USER
$PASSWD
cd public_html
put $file
quit
END_SCRIPT
done


exit 0
