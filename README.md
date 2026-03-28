# 新闻资讯管理系统

基于原生 HTML、CSS、JavaScript、jQuery、PHP 和 MySQL 构建的新闻资讯管理系统，包含新闻浏览、新闻发布、评论管理、用户管理、文件上传下载、验证码校验和邮箱找回密码等完整业务流程。

这个项目采用前后端分离的组织方式：

- `web` 目录提供前台页面和后台管理页面
- `api` 目录提供 PHP 接口、数据库访问能力和文件服务

项目适合作为课程设计、毕业设计、PHP 全栈练习项目，或作为一个轻量级新闻门户 / 内容管理系统的基础版本。

## 项目特点

- 支持新闻列表浏览与新闻详情查看
- 支持用户注册、登录、退出登录
- 支持验证码校验
- 支持邮箱验证码找回密码
- 支持新闻新增、编辑、删除
- 支持评论发布与评论管理
- 支持用户信息查询与后台用户管理
- 支持文件上传、文件列表展示与下载访问
- 提供前台浏览页面与后台管理平台两套界面

## 技术栈

- 前端：HTML5、CSS3、JavaScript、jQuery
- 后端：PHP
- 数据库：MySQL
- 邮件服务：PHPMailer
- 交互方式：AJAX + JSON 接口

## 目录结构

```text
news/
├─ api/                  # PHP 接口服务
│  ├─ public/            # 公共配置、数据库工具、CORS、邮件组件
│  ├─ upload/            # 上传文件存储目录
│  ├─ login.php          # 登录接口
│  ├─ register.php       # 注册接口
│  ├─ addNew.php         # 新增新闻
│  ├─ updateNewByid.php  # 编辑新闻
│  ├─ deleteNewById.php  # 删除新闻
│  ├─ getNewList.php     # 获取新闻列表
│  ├─ getNewById.php     # 获取新闻详情
│  ├─ addReview.php      # 新增评论
│  ├─ getReviewList.php  # 评论管理列表
│  ├─ getUserList.php    # 用户管理列表
│  ├─ upload.php         # 文件上传
│  ├─ download.php       # 文件列表 / 下载信息
│  └─ forgetPassword_*.php # 找回密码流程
└─ web/                  # 前端静态页面
   ├─ index.html         # 新闻浏览首页
   ├─ news_detail.html   # 新闻详情页
   ├─ login.html         # 登录页
   ├─ register.html      # 注册页
   ├─ forgot-password.html # 找回密码页
   ├─ home.html          # 后台首页
   ├─ users.html         # 用户管理页
   ├─ review.html        # 评论管理页
   ├─ files.html         # 文件管理页
   └─ js/index.js        # 前台首页脚本
```

## 功能模块

### 1. 前台新闻浏览

- 浏览新闻列表
- 查看新闻详情
- 登录后查看个人信息
- 登录后可参与评论

### 2. 用户系统

- 用户注册
- 用户登录
- Cookie 维持登录状态
- 验证码校验
- 邮箱找回密码

### 3. 新闻管理

- 发布新闻
- 编辑新闻
- 删除新闻
- 按标题关键字搜索新闻

### 4. 评论管理

- 用户对新闻发表评论
- 后台查看评论列表
- 删除评论

### 5. 用户管理

- 查看用户列表
- 根据角色和状态筛选
- 新增用户
- 编辑用户信息

### 6. 文件管理

- 上传图片或文件
- 统计文件数量和总大小
- 展示文件后缀、访问地址和文件大小

## 页面说明

前台页面：

- `index.html`：新闻门户首页
- `news_detail.html`：普通用户新闻详情页
- `login.html`：登录页
- `register.html`：注册页
- `forgot-password.html`：找回密码页

后台页面：

- `home.html`：后台首页 / 仪表盘
- `build.html`：新闻发布页面
- `edit_new.html`：新闻编辑页面
- `users.html`：用户管理页面
- `add_user.html`：新增用户页面
- `edit_user.html`：编辑用户页面
- `review.html`：评论管理页面
- `files.html`：文件管理页面
- `news_detail_admin.html`：后台新闻详情页

## 主要接口

### 用户相关

- `login.php`：用户登录
- `logout.php`：退出登录
- `register.php`：用户注册
- `getUserById.php`：根据用户 ID 获取用户信息
- `getUserList.php`：后台查询用户列表
- `addUser.php`：后台新增用户
- `forgetPassword_1.php`：发送邮箱验证码
- `forgetPassword_2.php`：校验邮箱验证码
- `forgetPassword_3.php`：重置密码

### 新闻相关

- `getNewList.php`：获取新闻列表
- `getNewById.php`：获取新闻详情
- `addNew.php`：新增新闻
- `updateNewByid.php`：更新新闻
- `deleteNewById.php`：删除新闻
- `getNewTotle.php`：统计新闻总数

### 评论相关

- `addReview.php`：新增评论
- `getReviewByNid.php`：根据新闻 ID 获取评论
- `getReviewList.php`：后台评论列表
- `deleteReviewById.php`：删除评论
- `getReviewTotle.php`：统计评论总数

### 文件相关

- `upload.php`：上传文件
- `download.php`：获取上传目录文件列表

## 数据库设计说明

根据接口逻辑，项目至少依赖以下数据表：

- `users`：用户表
- `new`：新闻表
- `reviews`：评论表
- `email_code`：邮箱验证码表

仓库当前未包含现成的 SQL 建表脚本，因此在本地部署时需要根据接口字段自行建表，或者结合接口中的 SQL 语句反推表结构。

## 快速开始

### 1. 准备环境

- PHP 7.x 或更高版本
- MySQL 5.7 / 8.0
- Apache、Nginx 或 PHP 集成环境

### 2. 配置数据库

编辑 `api/public/config.php`，设置你自己的数据库连接信息：

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'news');
define('DB_PORT', 3306);
```

### 3. 配置接口访问域名

项目中前后端地址使用了固定域名配置，需要根据本地环境调整：

- `api/public/cors.php` 中默认允许的前端来源为 `http://www.new.com:8080`
- 前端页面中的 AJAX 请求默认指向 `http://www.new.com:8081`

如果你本地没有配置该域名，请按你的实际访问地址统一修改前端接口地址和后端跨域设置。

### 4. 配置邮件服务

找回密码功能依赖 PHPMailer 和 SMTP 邮箱配置，请根据自己的邮箱服务修改 `api/sendEmail.php` 中的发件配置。

建议将邮箱账号、授权码等敏感信息改为环境变量或单独配置文件，不要直接写入仓库。

### 5. 启动项目

你可以将：

- `web` 部署到静态站点或本地 Web 服务
- `api` 部署到支持 PHP 的 Web 服务

确保：

- 前端可正常访问 HTML 页面
- 后端 PHP 接口可被前端跨域调用
- `api/upload` 目录具备写入权限

## 适用场景

- PHP 课程设计项目
- 新闻管理系统练习项目
- 后台管理系统练手项目
- 基础内容管理系统原型

## 当前项目可优化点

从现有代码结构来看，这个项目已经具备完整业务闭环，但如果继续完善，建议优先处理以下方向：

- 将数据库和邮箱敏感配置迁移到环境变量
- 为 SQL 操作增加参数化查询，减少注入风险
- 完善输入校验与异常处理
- 补充数据库初始化脚本
- 统一接口命名规范，例如 `Totle` 可调整为 `Total`
- 将前端公共样式和脚本进一步模块化

## 声明

本 README 基于仓库当前代码结构、页面文件、接口文件和业务逻辑整理而成，适合直接作为 GitHub 项目首页说明使用。
