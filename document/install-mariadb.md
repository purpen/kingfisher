
CentOS安装并设置MariaDB

1. 新建数据库源

    sudo vim /etc/yum.repos.d/MariaDB.repo
    
    [mariadb]
    name = MariaDB
    baseurl = http://yum.mariadb.org/10.1/centos7-amd64
    gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
    gpgcheck=0 // 0是不需要秘钥；1是需要秘钥
    
2. 安装数据库
    
    sudo yum install MariaDB-server MariaDB-client
    
3. 开机自启动
    
    sudo systemctl start mariadb
    
4. 启动数据库

    # 查看mysql状态;关闭数据库  
    # service mysql status  
    # sudo service mysql stop  
    # 启动数据库  
    sudo service mysql start
    
5. 修改数据库密码 mysqladmin -u root -p password root

6.  sudo yum install phpmyadmin

7. sudo ln -s /usr/share/phpMyAdmin  /usr/share/nginx/html