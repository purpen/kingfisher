
# kingfisher

ERP For Taihuoniao.

###运行环境要求

* PHP >= 5.5.9
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

建议环境：Nginx 1.10 / PHP 5.6 / MariaDB 10.1(Mysql 5.6) / Laravel 5.1
使用说明：[英文文档](https://laravel.com/docs/5.1)；[中文文档](http://laravel-china.org/docs/5.1)。

###安装使用

#####第一步：安装composer包管理器

访问[composer](http://pkg.phpcomposer.com/)，根据文档说明安装composer。
    
#####第二步：开发环境生成ssh公钥。

```
ssh-keygen -t rsa -C "your email!"
```

#####第三步：克隆kingfisher代码

```
git clone git@github.com:purpen/kingfisher.git
```

#####第四步：composer安装框架文件

```
composer install
```

######Remark
* 安装 Laravel 之后，需要你配置 **storage** 和 **bootstrap/cache** 目录的读写(777)权限。

```
sudo chmod -R 777 storage 
```
```
sudo chmod -R 777 bootstrap/cache
```

* 安装 Laravel 之后，一般应用程序根目录会有一个 **.env** 的文件。如果没有的话，复制 **.env.example** 并重命名为 **.env** 。

```
php -r "copy('.env.example', '.env');"
```

* 更新系统秘钥
```
php artisan key:generate
```
* 重新加载插件
```
composer dump-autoload
```
* 自定义函数库和类库目录
```
app/helper.php和app/Libraries/
```


###初始化用户角色
```
php artisan db:seed --class=RoleInitSeeder
```
* 如果提示Class RoleInitSeeder does not exist
* 执行 composer dump-autoload


###Mysql数据导出命令
```
mysqldump -uroot -p kingfisher permissions > kingfisher.permissions.sql
```

###Mysql数据导入命令
```
mysql -uroot -p kingfisher < kingfisher.permissions.sql
```



###任务开启命令
```
5 * * * * php /opt/project/kingfisher/artisan schedule:run 1>> /dev/null 2>&1

```

#Queue队列特别注意的问题
>如果为任务指定队列【queuename】,则执行任务时，必须指定--queue=queuename队列参数，否则，php artisan queue:listen监测并执行默认队列，不会执行某个特定队列

```
php artisan queue:listen redis --queue=stats,emails
```


##物流开通
申通、圆通、韵达、顺丰

##同步自营商城信息
* 同步自营商城商品信息命令
```
php artisan selfShop:pull product
```

* 同步自营商城SKU信息命令
```
php artisan selfShop:pull sku
```

* 通过商品编码建立商品与SKU的关联 命令
```
php artisan productAndSku:join
```

* 创建api文档
```
apidoc -i app/Http/Controllers/Api/V1 -o public/apidoc
```

* 创建SaasApi文档
```
apidoc -i app/Http/Controllers/Api/SaasV1 -o public/SaasApi
```
