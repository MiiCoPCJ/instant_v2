#* * * * * bash /var/www/crontab/instant.sh
#nohub /usr/bin/php /var/www/instantv2/controllers/EOS.php >> /var/www/logs/eos.log 2>&1 &
#nohub /usr/bin/php /var/www/instantv2/controllers/CompareEOS.php >> /var/www/logs/C_eos.log 2>&1 &


#* */1 * * * /usr/bin/php /var/www/instantv2/controllers/CleanData.php >> /var/www/logs/deleteData.log 2>&1
*/1 * * * * /usr/bin/bash /root/sh/eos.sh >> /root/sh/log.log 2>&1



#!/bin/bash
num=`ps -ef | grep /controllers/EOS | grep -v grep | wc -l`
#echo $num
if [ $num == 0 ];then
        msg=$(date)
        echo "$msg remount EOS.php" >> /root/sh/sh.log
        nohup /usr/bin/php /var/www/instantv2/controllers/EOS.php >> /var/www/logs/instantv2.log 2>&1 &
fi

num=`ps -ef | grep /controllers/CompareEOS | grep -v grep | wc -l`
if (( $num == 0 ));then
        msg=$(date)
        echo "$msg remount CompareEOS.php" >> /root/sh/sh.log
        nohup /usr/bin/php /var/www/instantv2/controllers/CompareEOS.php >> /var/www/logs/C_eos.log 2>&1 &
fi
