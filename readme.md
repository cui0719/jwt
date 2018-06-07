<h1>基于laravel 5.5 实现的 JWT token无痛刷新认证</h1>
<h3>JWT简介</h3>
JWT(json web token)是为了在网络应用环境间传递声明而执行的一种基于JSON的开放标准。

JWT的声明一般被用来在身份提供者和服务提供者间传递被认证的用户身份信息，以便于从资源服务器获取资源。比如用于APP用户登录，登录后操作识别用户身份。
<h3>说明</h3>
此demo主要实现Jwt 客户端登录成功后服务器向客户端发放token，在token有效期内可以使用此token做身份验证，token有两个有效期，一个是token的过期时间，一个是token的失效时间（过期时间为两周，失效时间可自己设置，但要比过期时间短，可任意设置时间）。本实例实现了在token有效期内可正常向服务器请求，在失效后还没到过期时间，向客户端发放新的token，并且保证此次请求依然能正常获取到数据。
<h3>配置</h3>

1.执行 composer require tymon/jwt-auth 1.0.0-rc.1 添加jwt扩展

2.发布配置文件 php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

3.生成秘钥 php artisan jwt:secret ，此命令会在你的 .env 文件中新增一行 JWT_SECRET=secret

4.配置 Auth guard ，在 config/auth.php 文件中，你需要将 guards/driver 更新为 jwt：<br/>
```php
'defaults' =>
 
    'guard' => 'api',
    
    'passwords' => 'users',
    
],

'guards' => [

    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
    
],
```
<h3>更改model</h3>
如果需要使用 jwt-auth 作为用户认证，我们需要对我们的 User 模型进行一点小小的改变，实现一个接口，变更后的 User 模型如下：
<p>User.php</p>
```php
    
    namespace App;
    
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;
        // Rest omitted for brevity
        /**
         *
         * Get the identifier that will be stored in the subject claim of the JWT.
         *
         * @return mixed
         */
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         *
         * @return array
         */
        public function getJWTCustomClaims() {
            return [];
        }
    }
```
