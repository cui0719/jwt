<h1>基于laravel 5.5 实现的 JWT token认证</h1>
<h3>JWT简介</h3>
JWT(json web token)是为了在网络应用环境间传递声明而执行的一种基于JSON的开放标准。

JWT的声明一般被用来在身份提供者和服务提供者间传递被认证的用户身份信息，以便于从资源服务器获取资源。比如用户登录，登录后操作识别用户身份。
<h3>使用说明</h3>

1.配置.env文件

2.执行数据迁移脚本 php artisan migrate

3.命令行执行 composer install 安装依赖