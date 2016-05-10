---
title: Debug Setup
---

## Create folders
```sh
sudo -i
cd /tmp/
mkdir -m 0777 aws-cache
mkdir -m 0777 ci
mkdir -m 0777 ci/upload

ls -a -l
# drwxrwxrwx   2 root     wheel      68 Nov 19 23:43 aws-cache
# drwxrwxrwx   3 root     wheel     102 Nov 19 23:45 ci
```

## MySQL
```sh
sudo nano /usr/local/opt/mysql/my.cnf
```

insert the following lines
```
default_time_zone='+00:00'
innodb_autoinc_lock_mode=0
```

restart
```sh
mysql.server restart
```

https://gist.github.com/suvozit/6dda7971e240f0a3f282#test
