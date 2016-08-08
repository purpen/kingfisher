
# 命名规范

--help (-h)             Display this help message
                        显示帮助信息

--quiet (-q)            Do not output any message 
                        不输出任何消息

--verbose (-v|vv|vvv)   Increase the verbosity of messages: 
                        1 for normal output, 2 for more verbose output and 3 for debug 
                        增加冗长的消息：1 正常输出 2 更加详细的输出 3调试输出

--version (-V)          Display this application version
                        显示此应用程序的版本

--ansi                  Force ANSI output
                        强制用 ANSI码输出

--no-ansi               Disable ANSI output
                        禁用用 ANSI码输出

--no-interaction (-n)   Do not ask any interactive question 

                        不要问任何交互式问题

--env                   The environment the command should run under. 
                        在环境命令下运行

Available commands(可用的命令):

clear-compiled          Remove the compiled class file
                        清除编译后的类文件

down                    Put the application into maintenance mode
                        使应用程序进入维修模式

env                     Display the current framework environment
                        显示当前框架环境

fresh                   Remove the scaffolding included with the framework
                        清除包含框架外的支架

help                    Displays help for a command
                        显示命令行的帮助

inspire                 Display an inspiring quote
                        显示一个启发灵感的引用

list                    Lists commands
                        列出命令

migrate                 Run the database migrations
                        运行数据库迁移

optimize                Optimize the framework for better performance
                        为了更好的框架去优化性能

serve                   Serve the application on the PHP development server
                        在php开发服务器中服务这个应用

tinker                  Interact with your application
                        在你的应用中交互

up                      Bring the application out of maintenance mode
                        退出应用程序的维护模式

app

app:name                Set the application namespace
                        设置应用程序命名空间

auth

auth:clear-resets       Flush expired password reset tokens 
                        清除过期的密码重置密钥

cache

cache:clear             Flush the application cache 
                        清除应用程序缓存

cache:table             Create a migration for the cache database table
                        创建一个缓存数据库表的迁移

config

config:cache            Create a cache file for faster configuration loading 
                        创建一个加载配置的缓存文件 

config:clear            Remove the configuration cache file 
                        删除配置的缓存文件

db

db:seed                 Seed the database with records 
                        执行数据库填充

event

event:generate          Generate the missing events and handlers based on registration 
                        在记录上生成错过的事件和基础程序

handler

handler:command         Create a new command handler class 
                        创建一个新的命令处理程序类

handler:event           Create a new event handler class
                        创建一个新的事件处理程序类

key

key:generate            Set the application key 
                        设置程序密钥

make

make:command            Create a new command class 
                        生成一个命令类

make:console            Create a new Artisan command 
                        生成一个Artisan命令

make:controller         Create a new resource controller class 
                        生成一个资源控制类

make:event              Create a new event class 
                        生成一个事件类

make:middleware         Create a new middleware class 
                        生成一个中间件

make:migration          Create a new migration file 
                        生成一个迁移文件

make:model              Create a new Eloquent model class 
                        生成一个Eloquent 模型类

make:provider           Create a new service provider class 
                        生成一个服务提供商的类

make:request            Create a new form request class 
                        生成一个表单消息类

migrate

migrate:install         Create the migration repository 
                        创建一个迁移库文件

migrate:refresh         Reset and re-run all migrations 
                        复位并重新运行所有的迁移

migrate:reset           Rollback all database migrations 
                        回滚全部数据库迁移

migrate:rollback        Rollback the last database migration 
                        回滚最后一个数据库迁移

migrate:status          Show a list of migrations up/down 
                        显示列表的迁移 进入维护模式/退出维护模式

queue

queue:failed            List all of the failed queue jobs 
                        列出全部失败的队列工作

queue:failed-table      Create a migration for the failed queue jobs database table 
                        创建一个迁移的失败的队列数据库工作表

queue:flush             Flush all of the failed queue jobs 
                        清除全部失败的队列工作

queue:forget            Delete a failed queue job 
                        删除一个失败的队列工作

queue:listen            Listen to a given queue 
                        监听一个确定的队列工作

queue:restart           Restart queue worker daemons after their current job 
                        重启现在正在运行的所有队列工作

queue:retry             Retry a failed queue job 
                        重试一个失败的队列工作

queue:subscribe         Subscribe a URL to an Iron.io push queue 去Iron.io
                        订阅URL,放到队列上  

queue:table             Create a migration for the queue jobs database table 
                        创建一个迁移的队列数据库工作表

queue:work              Process the next job on a queue 
                        进行下一个队列任务

route

route:cache             Create a route cache file for faster route registration 
                        为了更快的路由注册，创建一个路由缓存文件

route:clear             Remove the route cache file 
                        清除路由缓存文件

route:list              List all registered routes 
                        列出全部的注册路由 

schedule

schedule:run            Run the scheduled commands 
                        运行预定命令

session

session:table           Create a migration for the session database table 
                        创建一个迁移的SESSION数据库工作表

vendor

vendor:publish          Publish any publishable assets from vendor packages 
                        发表一些可以发布的有用的资源来自提供商的插件包


1. 控制器相关
    
    php artisan make:controller Common/BaseController
    
    注意：控制器命名，采用驼峰命名法，并且必须加Controller后缀，不允许直接在Controllers目录下新建。
    建议：根据功能分类，将控制器放在相关的目录里面。
    
2. 模型相关
    
    php artisan make:model Models/UserModel
    
    注意：模型命名，采用驼峰命名法，并且必须加Model后缀，不允许直接在App目录下新建。
    建议：根据数据表名称，将模型放在相关的目录里面。
    
3. 视图相关
    
    注意：视图默认位于resources/views目录下，手动新建，并且要以.blade.php结尾。
    建议：根据不能的功能、控制器等新建子目录，然后新建对应模板。
    
4. 路由相关
    
    注意：路由的主文件位于app/Http/routes.php，拆分后的子路由在app/Http/Routes下面。
        如果新建子路由，必须在路由目录下新建，并且要require到app/Http/routes.php中。
    建议：新建路由文件，按照不同功能新建。
    
5. 中间体相关
    
    php artisan make:middleware EncryptCookiesMiddleware
    
    注意：中间体命名，采用驼峰命名法，并且必须加Middleware后缀。
    建议：根据功能分类命名。
    
6. 请求相关
    
    php artisan make:request UserRequest
    
    注意：请求命名，采用驼峰命名法，并且必须加Request后缀。
    建议：根据功能分类命名。

7. 服务提供者相关
    
    php artisan make:provider UserServiceProvider
    
    注意：服务提供者命名，采用驼峰命名法，并且必须加ServiceProvider后缀。
    建议：根据功能分类命名。
    
8. 服务提供者相关
    
    php artisan make:provider UserServiceProvider
    
    注意：服务提供者命名，采用驼峰命名法，并且必须加ServiceProvider后缀。
    建议：根据功能分类命名。
    
9. 策略类相关-策略类是原生的PHP类，基于授权资源对授权逻辑进行分组
    
    php artisan make:policy UserPolicy
    
    注意：策略类命名，采用驼峰命名法，并且必须加Policy后缀。
    建议：根据功能分类命名。