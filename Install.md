#ERP生产环境部署备忘录

* public_ip		         120.132.50.251
* network_ip             10.10.39.2
* username:              tianxiaoyi     
* password:              txy@nht#small$2016
* domain name            erp.taihuoniao.com


##[Mysqld]

server_name	**mysql**
server_user	root
config_file	/etc/my.cnf
password
server_passwd	d3in@2016#2016.2016
install_dir	/opt/software/mysql
pid_file	/opt/software/mysql/mysql.sock.lock
data_dir	/data/mysql/data
port		3306
service_name	mysqld
start_method	service mysqld [start|restart|reload|stop|status]
login_method	mysql -u root -p[password]


#[nginx]
server_name	nginx
server_user	www
config_file	/opt/nginx/conf/nginx.conf | /opt/nginx/conf/vhosts/*
install_dir	/opt/nginx
pid_file	/data/pid/nginx.pid
log_file	/data/log/[nginx-error.log|nginx-access.log|nginx-status.log]
port		80
service_name	nginxd
start_method	service nginxd [start|stop|restart|reload|status]
command_dir	/opt/software/nginx/sbin/

#[php]
server_name	php
server_user	www
config_file	/etc/php-fpm.conf & /etc/php.ini
install_dir	/opt/php-5.6.5
pid_file	/opt/php-5.6.5/php/var/run/php-fpm.pid
log_file	/opt/php-5.6.5/php/var/run/php-fpm.log
port		9000
service_name	php-fpm
start_method	service php-fpm [start|stop|restart|reload|status]
command_dir	/opt/software/php/bin/

#[redis]
server_name	redis
server_user	root
config_file	/opt/software/redis/conf/6379_redis.conf
install_dir	/opt/software/redis
pid_file	/opt/software/redis/pid
log_file	/opt/software/redis/log
hard-disk_file	/data/redis/data/
port		6379
service_name	redisd
start_method	service redisd [start|stop|restart]
command		
		redis-benchmark #test_command
		redis-cli	#command line tool
		redis-server	#redis_service start daemon
		redis-stat	#redis_service check_status_tool
        
###登陆有密码的Redis：
在登录的时候的时候输入密码：
```
redis-cli  -h 10.10.39.2 -p 6379 -a erpadmin@2016#2016.2016
```                 
先登陆后验证：
```
redis 127.0.0.1:6379> auth erpadmin@2016#2016.2016
```
