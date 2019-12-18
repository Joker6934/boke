# 安装文档

## 扩展要求
- PHP >= 7.0.0
- PHP OpenSSL 扩展
- PHP PDO 扩展
- PHP Mbstring 扩展
- PHP Tokenizer 扩展
- PHP XML 扩展

## 目录指向
安装 blog 之后，你要将 Web 服务器的根目录指向 public 目录。该目录下的 index.php 文件将作为所有进入应用程序的 HTTP 请求的前端控制器。

## 目录权限
需要给这两个文件配置读写权限：storage 目录和 bootstrap/cache 目录应该允许 Web 服务器写入，否则将无法运行。

chmod -R 777 storage 

chmod -R 777 bootstrap/cache

## Web 服务器配置
### Apache
使用 public/.htaccess 文件来为前端控制器提供隐藏了 index.php 的优雅链接。如果你的 Laravel 使用了 Apache 作为服务容器，请务必启用 mod_rewrite 模块，让服务器能够支持 .htaccess 文件的解析。
如果 blog 附带的 .htaccess 文件不起作用，就尝试用下面的方法代替：
```
Options +FollowSymLinks
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

## 修改 .env 中的数据库用户名和密码

## 创建一个Apache虚拟主机，指向./blog/public

## 项目使用的是Composer 的扩展predis, 需要将PHP的phpredis扩展去掉。

## 后台链接 /admin/login  ,用户名admin, 密码123456

### Nginx

如果你使用的是 Nginx，在你的站点配置中加入以下内容，它将会将所有请求都引导到 index.php 前端控制器：
```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
