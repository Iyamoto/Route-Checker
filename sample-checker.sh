#!/bin/bash
#rename sample-checker.sh to checker.sh
#chmod +x checker.sh
#replace basedir with your path to project
#and add to /etc/crontab: */15 * * * * root /path/to/project/checker.sh >/dev/null 2>&1

basedir="/path/to/project"
php="/usr/bin/php"

cd $basedir
date > lastrun.log
$php checker.php >> lastrun.log