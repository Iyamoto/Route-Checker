Route-Checker
============
What does the bot do?
Basically checks trace routes and mail changes

Install
=======
Rename sample-config.php to config.php
Edit $emails and $targets
Run php checker.php
Check output
Rename sample-checker.sh to checker.sh
Edit basedir
Add */15 * * * * root /path/to/project/checker.sh >/dev/null 2>&1 to /etc/crontab

Usage
=====
Starts automatically every 15 min. from crontab, just check your email and investigate route changes 

Data structures
===============

Design
======
