
安装nginx服务器

1. 下载对应当前系统版本的nginx包(package);
    
    wget  http://nginx.org/packages/centos/7/noarch/RPMS/nginx-release-centos-7-0.el7.ngx.noarch.rpm
    
2. 建立nginx的yum仓库

    sudo pm -ivh nginx-release-centos-7-0.el7.ngx.noarch.rpm
    
3. 下载并安装nginx

    sudo yum install nginx
    
4. 启动nginx服务
    
    sudo systemctl stop nginx
    sudo systemctl start nginx
    
    开机自动启动
    sudo systemctl enable nginx
    
5. 默认的配置文件在 /etc/nginx 路径下，使用该配置已经可以正确地运行nginx；如需要自定义，修改其下的 nginx.conf 等文件即可

server {
    listen       80;
    server_name  localhost;
    charset utf-8;
    #access_log  /var/log/nginx/log/host.access.log  main;

    location / {
        root /usr/share/nginx/html;
        index  index.php index.html index.htm;
    }

    #error_page  404              /404.html;

    # redirect server error pages to the static page /50x.html
    #
    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root  /usr/share/nginx/html;
    }

    # proxy the PHP scripts to Apache listening on 127.0.0.1:80
    #
    #location ~ \.php$ {
    #    proxy_pass   http://127.0.0.1;
    #}

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    
    location ~ \.php$ {
        root /usr/share/nginx/html; // 和location / 里面的root保持一致，不然nginx会报File not found错误
        try_files $uri =404;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        #fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
       	fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name; // 按照此配置，不然会报File not found错误
        include        fastcgi_params;
    }

    # deny access to .htaccess files, if Apache's document root
    # concurs with nginx's one
    #
    #location ~ /\.ht {
    #    deny  all;
    #}
}