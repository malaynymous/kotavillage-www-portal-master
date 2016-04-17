# /etc/cron.d/kotavillage-www-poral: crontab fragment for kotavillage-www-portal
# This clears stale sessions and at the end of the month, moves user accounting
# details into the monthly tables clearing the current months table.
# m h	dom mon dow	command

PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
#MAILTO=
## NEEDS USERNAME
@daily		    root    /usr/share/kotavillage/scripts/mysql_backup

# Most cron scripts have moved to PHP classes actived by cron.php
@hourly         nobody  wget -q http://127.0.0.1/grase/radmin/cron.php -O -
@reboot         nobody  wget -q http://127.0.0.1/grase/radmin/cron.php -O -
