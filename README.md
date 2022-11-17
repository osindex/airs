# airs

是基于 Laravel 开发的 Admin (https://github.com/zkuyuo/airs) 的服务端。

## 要求

- Laravel  >= 7.0.0
- PHP >= 7.2.0

## 安装

首先安装laravel,并且确保你配置了正确的数据库连接。

```
composer require zkuyuo/airs
```

然后运行下面的命令来发布资源:

```
php artisan airs:install
```

命令执行成功会生成配置文件，数据迁移和构建SPA的文件。

修改 `app/Http/Kernel.php` ：

```
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        ...
        '.permission' => \Zkuyuo\Airs\Http\Middleware\Authenticate::class,
    ];

    protected $middlewareGroups = [
            ...
            'api' => [
                ...
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            ],
        ];
}
```

执行数据迁移，数据填充

```
php artisan migrate

php artisan db:seed --class="Zkuyuo\Airs\Database\AirsTableSeeder"
```

后台登录的账号 `admin` , 密码 `secret`

## 路由中间件

* auth:sanctum 用于鉴权
* .permission 权限验证

## airs.php 可选配置

```php
return [
    'guards' => [
        // laravel-permission 相对应的 guard
        'admin' => [
            'model' => \Zkuyuo\Airs\Models\AdminUser::class, //登录鉴权的模型
            'login_fields' => [	// 登录验证的字段，支持多个
                'username',
            ],
            'conditions' => [ // 登录验证的额外条件
                ['status', '=', 1]
            ]
        ]
    ],
    'route_prefix' => "api", //路由前缀
    
    'middleware' => [
        'basic' => 'api', //基础中间件

        'auth' => ['auth:sanctum'], //鉴权中间件

        'permission' => ['auth:sanctum', '.permission'] //包含权限检测的中间件
    ]
];
```

## 依赖扩展包

* spatie/laravel-permission
* laravel/sanctum

## 常见错误

* csrf token missing or incorrect ， 请修改 sanctum.php 中的 `stateful` , 如 vite 使用的 `localhost:3000 `去除即可。更多详细请访问`laravel/sanctum`文档。

