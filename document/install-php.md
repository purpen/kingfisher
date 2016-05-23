
Centos下Yum安装PHP5.5,5.6,7.0

默认的版本太低了，手动安装有一些麻烦，想采用Yum安装的可以使用下面的方案：

1.检查当前安装的PHP包

    yum list installed | grep php

    如果有安装的PHP包，先删除他们
    yum remove php.x86_64 php-cli.x86_64 php-common.x86_64 php-gd.x86_64 php-ldap.x86_64 php-mbstring.x86_64 php-mcrypt.x86_64 php-mysql.x86_64 php-pdo.x86_64

2.更新yum源
    
    Centos 5.X
    rpm -Uvh http://mirror.webtatic.com/yum/el5/latest.rpm
    
    CentOs 6.x
    rpm -Uvh http://mirror.webtatic.com/yum/el6/latest.rpm
    
    CentOs 7.X
    rpm -Uvh https://mirror.webtatic.com/yum/el7/epel-release.rpm
    rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
    
    如果想删除上面安装的包，重新安装
    rpm -qa | grep webstatic
    rpm -e  上面搜索到的包即可

3.运行yum install

    yum install php55w.x86_64 php55w-cli.x86_64 php55w-common.x86_64 php55w-gd.x86_64 php55w-ldap.x86_64 php55w-mbstring.x86_64 php55w-mcrypt.x86_64 php55w-mysql.x86_64 php55w-pdo.x86_64 php55w-fpm

    yum install php56w.x86_64 php56w-cli.x86_64 php56w-common.x86_64 php56w-gd.x86_64 php56w-ldap.x86_64 php56w-mbstring.x86_64 php56w-mcrypt.x86_64 php56w-mysql.x86_64 php56w-pdo.x86_64 php56w-fpm 

    yum install php70w.x86_64 php70w-cli.x86_64 php70w-common.x86_64 php70w-gd.x86_64 php70w-ldap.x86_64 php70w-mbstring.x86_64 php70w-mcrypt.x86_64 php70w-mysql.x86_64 php70w-pdo.x86_64 php70w-fpm

注：选择自己需要的版本安装，只要安装一个即可。

简易安装步骤（曹伟）
sudo yum install php56w* --skip-broken
sudo yum remove php56w-mysqlnd.x86_64
sudo yum install php56w-mysql.x86_64

必须启动php56-fpm

不然会报以下错误
#2011/09/30 23:47:54 [error] 31160#0: *35 connect() failed (111: Connection refused) while connecting to upstream, client: xx.xx.xx.xx, server: domain.com, request: \"GET /dev/ HTTP/1.1\", upstream: \"fastcgi://127.0.0.1:9000\", host: \"domain.com\"

sudo service php-fpm start

开机自动启动
sudo systemctl enable php-fpm

清除日志内容
cat /dev/null > error.log 