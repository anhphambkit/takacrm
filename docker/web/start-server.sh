#!/bin/bash
echo alias a=\'php artisan\' >> /etc/bash.bashrc
echo alias pr=\'service php7.1-fpm restart\' >> /etc/bash.bashrc
echo alias queue=\'php artisan queue:work\' >> /etc/bash.bashrc
echo alias u=\'php /var/www/html/upgrade\' >> /etc/bash.bashrc
source /etc/bash.bashrc
service php7.1-fpm start
chmod 600 /var/www/html/docker/ssh/ssh_ifoss
#service ssh start
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl start agoyu-queue:*
nginx
