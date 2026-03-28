# 新闻资讯 Web 安全靶场

这不是一个面向生产环境的“正规管理系统”，而是一个用新闻资讯业务外壳包装出来的 **Web 漏洞练习项目 / 靶场项目**。  
它的重点不是业务有多规范，而是：

- 入口足够典型：登录、注册、找回密码、新闻发布、评论、文件上传、后台页面
- 链路足够完整：前端页面、PHP 接口、MySQL、Cookie、Session、上传目录都在
- 代码足够直白：适合拿来做代码审计、漏洞复现、课堂演示和本地攻防练习

如果你要的是一个“能立马搭起来”的靶场，这个仓库就是按这个方向整理的。

## 项目定位

你可以把它理解成：

- 一个以“新闻系统”为壳子的 PHP Web 靶场
- 一个适合练 SQL 注入、XSS、弱鉴权、上传问题的教学项目
- 一个适合本地演示和练手的安全实验环境

不建议把它当成正式后台系统、CMS 或企业项目模板使用。

## 当前仓库可练的方向

结合现有代码，比较直观的练习点包括：

- SQL 注入
- 存储型 / 反射型 XSS
- 验证码绕过
- 弱鉴权与越权访问
- 明文密码与弱口令风险
- 任意文件上传 / 上传校验不足
- 敏感配置硬编码
- 前后端信任边界不清

## 代码里已经存在的典型靶场特征

- 多处接口直接拼接 SQL，没有参数化
- 登录和注册都存在 `0000` 万能验证码逻辑
- 用户密码以明文方式存储和比对
- 部分写接口没有严格权限校验
- 上传接口没有严格校验文件类型和内容
- 数据库账号、跨域来源、默认资源地址存在硬编码
- 前端页面直接拼接后端返回内容，存在 XSS 练习空间

## 环境要求

最小可运行环境：

- PHP 7.4 及以上
- MySQL 5.7 / 8.0
- 支持 PHP 的 Web 运行方式
- 推荐本地 Windows / Linux / macOS 环境

PHP 建议开启这些扩展：

- `mysqli`
- `gd`

说明：

- `mysqli` 用于数据库连接
- `gd` 用于生成验证码图片
- 邮件找回密码功能依赖 SMTP 配置，但不是必须项，不配也能跑主流程

## 目录说明

```text
NewLab/
├─ api/                  # PHP 接口、数据库连接、上传目录、邮件逻辑
│  ├─ public/
│  ├─ upload/
│  ├─ login.php
│  ├─ register.php
│  ├─ addNew.php
│  ├─ addReview.php
│  ├─ addUser.php
│  ├─ upload.php
│  └─ ...
├─ web/                  # 前端页面
│  ├─ index.html
│  ├─ login.html
│  ├─ register.html
│  ├─ home.html
│  ├─ users.html
│  ├─ review.html
│  └─ js/
└─ database/
   └─ news.sql           # 初始化数据库脚本（含演示数据）
```

## 10 分钟搭建

下面这套流程是为了让别人拿到仓库后能尽快跑起来。

### 1. 下载项目

把项目放到本地任意目录即可，例如：

```text
C:\Users\Sailboat\Desktop\NewLab
```

### 2. 配置本地域名

这个项目的前端和后端代码里已经大量写死了下面两个地址：

- `http://www.new.com:8080` 对应前端
- `http://www.new.com:8081` 对应后端

所以最省事的做法不是全局改代码，而是直接配本地 `hosts`。

Windows：

1. 用管理员身份打开记事本或编辑器
2. 编辑文件 `C:\Windows\System32\drivers\etc\hosts`
3. 加入这一行：

```text
127.0.0.1 www.new.com
```

Linux / macOS：

编辑 `/etc/hosts`，加入同样一行：

```text
127.0.0.1 www.new.com
```

### 3. 初始化数据库

仓库已经补了初始化脚本：

- [database/news.sql](C:\Users\Sailboat\Desktop\NewLab\database\news.sql)

这个脚本会做这些事：

- 创建 `news` 数据库
- 重建 `users`、`new`、`reviews`、`email_code` 四张表
- 插入默认管理员、普通用户、新闻和评论演示数据

如果你是全新环境，直接导入即可。

MySQL 命令行导入示例：

```powershell
cd C:\Users\Sailboat\Desktop\NewLab
mysql -uroot -p < .\database\news.sql
```

如果你用的是 Navicat、DBeaver、Workbench，也可以直接打开 `database/news.sql` 执行。

注意：

- 这个脚本会重建基础表，适合首次初始化或重置靶场数据
- 如果你的 MySQL 账号没有建库权限，请先手动创建 `news` 数据库，再执行脚本中的建表和插入部分

### 4. 修改数据库连接

编辑：

- [config.php](C:\Users\Sailboat\Desktop\NewLab\api\public\config.php)

把数据库账号密码改成你自己的：

```php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','你的数据库密码');
define('DB_NAME','news');
define('DB_PORT',3306);
```

### 5. 可选：配置邮件找回密码

如果你只想先把靶场跑起来，这一步可以先跳过。  
如果你想让“找回密码”功能正常工作，再去改：

- [sendEmail.php](C:\Users\Sailboat\Desktop\NewLab\api\sendEmail.php)

你至少要替换这几个值：

- `Username`
- `Password`
- `From`

当前代码默认按 QQ 邮箱 SMTP 写的：

- 服务器：`smtp.qq.com`
- 端口：`465`
- 加密：`ssl`

不配邮件也不会影响登录、注册、新闻、评论、上传这些主流程。

### 6. 启动前端和后端

这个项目前端是静态页面，后端是 PHP 接口。  
最简单的启动方式是直接用 PHP 内置服务器开两个端口。

终端 1：启动前端

```powershell
cd C:\Users\Sailboat\Desktop\NewLab\web
php -S 127.0.0.1:8080
```

终端 2：启动后端

```powershell
cd C:\Users\Sailboat\Desktop\NewLab\api
php -S 127.0.0.1:8081
```

如果你更习惯 Apache / Nginx / phpStudy / XAMPP，也可以：

- 把 `web` 作为前端站点根目录，跑在 `8080`
- 把 `api` 作为 PHP 站点根目录，跑在 `8081`

### 7. 首次访问

启动后，优先访问这些页面：

- 前台首页：[http://www.new.com:8080/index.html](http://www.new.com:8080/index.html)
- 登录页：[http://www.new.com:8080/login.html](http://www.new.com:8080/login.html)
- 注册页：[http://www.new.com:8080/register.html](http://www.new.com:8080/register.html)
- 后端接口样例：[http://www.new.com:8081/getNewList.php?search=](http://www.new.com:8081/getNewList.php?search=)

## 默认账号与测试数据

导入 `database/news.sql` 后，默认会有这些数据：

- 管理员账号：`admin`
- 管理员密码：`123456`
- 普通用户账号：`test`
- 普通用户密码：`123456`
- 万能验证码：`0000`

说明：

- `admin` 登录后会跳到后台 `home.html`
- 普通用户登录后会跳到前台 `index.html`
- 数据库里已经带了新闻、评论和头像地址，导入后页面不会是空的

## 启动后怎么判断是否成功

你可以按这个顺序快速验收：

1. 打开登录页，验证码图片能正常显示
2. 用 `admin / 123456 / 0000` 登录成功
3. 成功跳转到后台首页 `home.html`
4. 打开前台首页时能看到新闻列表
5. 打开新闻详情页时能看到评论
6. 文件管理页能列出 `api/upload` 目录下的文件

只要上面这几步正常，说明这个靶场已经基本搭起来了。

## 常见问题排查

### 1. 页面能打开，但 AJAX 全部报错

优先检查这三件事：

- `hosts` 里有没有 `127.0.0.1 www.new.com`
- 后端是不是跑在 `8081`
- [cors.php](C:\Users\Sailboat\Desktop\NewLab\api\public\cors.php) 里的来源是不是和前端地址一致

### 2. 登录页验证码不显示

通常是 PHP `gd` 扩展没开。  
验证码接口在：

- [captcha.php](C:\Users\Sailboat\Desktop\NewLab\api\captcha.php)

### 3. 登录时报数据库连接失败

检查：

- [config.php](C:\Users\Sailboat\Desktop\NewLab\api\public\config.php) 的账号密码
- MySQL 服务是否已启动
- `news` 数据库是否已经导入成功

### 4. 找回密码用不了

这是正常的，如果你还没配 SMTP。  
先把其它核心功能跑通，再决定要不要配置：

- [sendEmail.php](C:\Users\Sailboat\Desktop\NewLab\api\sendEmail.php)

### 5. 页面里图片是破图

请确认后端接口是从 `api` 目录启动的，并且下面目录可访问：

- [upload](C:\Users\Sailboat\Desktop\NewLab\api\upload)

### 6. 想不用 `www.new.com`，直接改成 `localhost`

可以，但要同时改两类地方：

- `web` 目录里所有写死的 `http://www.new.com:8081`
- [cors.php](C:\Users\Sailboat\Desktop\NewLab\api\public\cors.php) 里的允许来源

如果只是为了尽快跑起来，直接改 `hosts` 会更省时间。

## 适合的使用场景

- Web 安全课程作业
- PHP 代码审计练习
- 漏洞复现演示
- 本地靶场搭建
- 入门级攻防练手

## 使用提醒

- 请只在本地、隔离网络或授权测试环境中使用
- 仓库里存在明显不安全实现，不要直接暴露到公网
- 这就是靶场，不是生产模板
- 如果你后续想做“修复版”，建议另开分支，不要直接把靶场特征改没

## 一句话总结

这是一个 **“新闻业务壳子 + 常见 Web 漏洞练习点 + 可快速本地搭建”** 的 PHP 靶场项目。  
重点应该放在审计、复现、利用和修复思路，而不是把它包装成成熟的后台管理系统。
