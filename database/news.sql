SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `news`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE `news`;

DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `email_code`;
DROP TABLE IF EXISTS `new`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `imgUrl` varchar(255) NOT NULL,
  `register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `new` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `newImgUrl` varchar(255) NOT NULL,
  `uid` int NOT NULL,
  `newTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_new_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `review` text NOT NULL,
  `reviewTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int NOT NULL,
  `nid` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_reviews_uid` (`uid`),
  KEY `idx_reviews_nid` (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `email_code` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `captcha` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email_code_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `imgUrl`, `register`, `status`) VALUES
(1, 'admin', '123456', 'admin@qq.com', 'admin', 'http://www.new.com:8081/upload/1765283085.jpg', '2026-03-28 20:00:00', 'true'),
(2, 'test', '123456', 'test@qq.com', 'user', 'http://www.new.com:8081/upload/1769762861.png', '2026-03-28 20:10:00', 'true'),
(3, 'banned_user', '123456', 'banned@qq.com', 'user', 'http://www.new.com:8081/upload/1769762861.png', '2026-03-28 20:20:00', 'false');

INSERT INTO `new` (`id`, `title`, `content`, `newImgUrl`, `uid`, `newTime`) VALUES
(1, '欢迎来到新闻资讯安全靶场', '这个项目不是生产系统，而是为了练习 Web 安全问题而准备的演示环境。你可以从登录、新闻详情、评论、文件上传和后台页面等入口切入，做代码审计与漏洞复现。', 'http://www.new.com:8081/upload/1772505394.png', 1, '2026-03-28 20:30:00'),
(2, '靶场默认数据说明', '默认数据库里已经准备了管理员、普通用户、新闻和评论数据。导入 SQL 后，只要前后端地址正确、MySQL 配置正确，就可以直接登录并浏览页面。', 'http://www.new.com:8081/upload/1769814173.jpg', 1, '2026-03-28 20:40:00');

INSERT INTO `reviews` (`id`, `review`, `reviewTime`, `uid`, `nid`) VALUES
(1, '这条评论用于确认评论列表和详情页可以正常显示。', '2026-03-28 20:45:00', 2, 1),
(2, '导入初始化 SQL 后，前台和后台都有内容可看。', '2026-03-28 20:46:00', 1, 2);

SET FOREIGN_KEY_CHECKS = 1;
