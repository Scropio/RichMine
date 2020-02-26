-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-31 00:03:47
-- 服务器版本： 5.5.62-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qt_zzhr168_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `clt_ad`
--

CREATE TABLE IF NOT EXISTS `clt_ad` (
  `ad_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '广告名称',
  `type_id` tinyint(5) NOT NULL COMMENT '所属位置',
  `pic` varchar(200) NOT NULL DEFAULT '' COMMENT '广告图片URL',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '广告链接',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `sort` int(11) NOT NULL COMMENT '排序',
  `open` tinyint(2) NOT NULL COMMENT '1=审核  0=未审核',
  `content` varchar(225) DEFAULT '' COMMENT '广告内容'
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='广告表';

--
-- 转存表中的数据 `clt_ad`
--

INSERT INTO `clt_ad` (`ad_id`, `name`, `type_id`, `pic`, `url`, `addtime`, `sort`, `open`, `content`) VALUES
(15, '素材火的目的是 让所有人都能 高效 简洁 的建立网站', 1, '/uploads/20190313/c57c5765432f4908059c33724a89106f.jpg', 'http://www.sucaihuo.com', 1480909037, 1, 1, '虽然世界上有成千上万的建站系统，但素材火会告诉你，真正高效的建站系统是什么样的。'),
(17, '即使是后台我们也极力追求尽善尽美', 1, '/uploads/20190313/3e4c4e4486638433d01788dc11ef6e90.jpg', 'http://www.sucaihuo.com', 1481788850, 2, 1, '素材火采用了优美的layui框架，一面极简，一面丰盈。加上angular Js，让数据交互变得更为简洁直白。用最基础的代码，实现最强大的效果，让你欲罢不能！'),
(18, 'ThinkPHP5极大的提高了素材火的可拓展性', 1, '/uploads/20190313/d1a096528a278da4e49afee951029039.jpg', 'http://www.sucaihuo.com', 1481788869, 3, 1, '素材火采用的ThinkPHP5为基础框架，从而使得素材火的拓展性变的极为强大。从模型构造到栏目建立，再到前台展示，一气呵成，网站后台一条龙式操作，让小白用户能快速掌握素材火管理系统的核心操作，让小白开发者能更好的理解素材火的核心构建价值。');

-- --------------------------------------------------------

--
-- 表的结构 `clt_admin`
--

CREATE TABLE IF NOT EXISTS `clt_admin` (
  `admin_id` tinyint(4) NOT NULL COMMENT '管理员ID',
  `username` varchar(20) NOT NULL COMMENT '管理员用户名',
  `pwd` varchar(70) NOT NULL COMMENT '管理员密码',
  `group_id` mediumint(8) DEFAULT NULL COMMENT '分组ID',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `realname` varchar(10) DEFAULT NULL COMMENT '真实姓名',
  `tel` varchar(30) DEFAULT NULL COMMENT '电话号码',
  `ip` varchar(20) DEFAULT NULL COMMENT 'IP地址',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `mdemail` varchar(50) DEFAULT '0' COMMENT '传递修改密码参数加密',
  `is_open` tinyint(2) DEFAULT '0' COMMENT '审核状态',
  `avatar` varchar(120) DEFAULT '' COMMENT '头像'
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='后台管理员';

--
-- 转存表中的数据 `clt_admin`
--

INSERT INTO `clt_admin` (`admin_id`, `username`, `pwd`, `group_id`, `email`, `realname`, `tel`, `ip`, `add_time`, `mdemail`, `is_open`, `avatar`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1, '77179475@qq.com', '', '14776114977', '127.0.0.1', 1482132862, '0', 1, '/uploads/20190727/1529014341c970b66a0539972be8c3da.png'),
(14, 'admin1', 'e10adc3949ba59abbe56e057f20f883e', 1, '4581324@qq.com', NULL, '13029853448', '114.83.251.145', 1566057653, '0', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `clt_ad_type`
--

CREATE TABLE IF NOT EXISTS `clt_ad_type` (
  `type_id` tinyint(5) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `sort` int(11) NOT NULL COMMENT '广告位排序'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='广告分类';

--
-- 转存表中的数据 `clt_ad_type`
--

INSERT INTO `clt_ad_type` (`type_id`, `name`, `sort`) VALUES
(1, '【首页】顶部轮播', 1),
(5, '【内页】横幅', 2);

-- --------------------------------------------------------

--
-- 表的结构 `clt_appeal`
--

CREATE TABLE IF NOT EXISTS `clt_appeal` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) DEFAULT NULL COMMENT '申诉订单编号',
  `content` varchar(255) DEFAULT NULL COMMENT '申诉内容',
  `evidence` varchar(255) DEFAULT NULL COMMENT '申诉凭证',
  `time` int(11) DEFAULT NULL COMMENT '创建时间',
  `uid` int(11) DEFAULT NULL COMMENT '申诉用户ID',
  `username` varchar(255) DEFAULT NULL COMMENT '申诉用户名称',
  `status` tinyint(4) DEFAULT '0' COMMENT '申诉状态'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_appeal`
--

INSERT INTO `clt_appeal` (`id`, `order_id`, `content`, `evidence`, `time`, `uid`, `username`, `status`) VALUES
(5, 'T20190731144139183357381', '系统问题', '/uploads/20190731/d709df4eea8138fc6bb679429b807a1a.jpg', 1564565193, 381, '狗狗321', 1),
(6, 'T20190731154636669191350', '款打了', '[object Object]', 1564638952, 350, '15980690081', 1),
(7, 'C20190802155807857209122', '不付款', '/uploads/20190803/58e42ecb5bbfb313ae2df8ca404a8051.png', 1564812905, 122, '15826432901', 1),
(8, 'C20190802155807857209122', '不付款', '/uploads/20190803/58e42ecb5bbfb313ae2df8ca404a8051.png', 1564812905, 122, '15826432901', 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_article`
--

CREATE TABLE IF NOT EXISTS `clt_article` (
  `id` int(11) unsigned NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(80) NOT NULL DEFAULT '',
  `keywords` varchar(120) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `content` text NOT NULL COMMENT '内容',
  `template` varchar(40) NOT NULL DEFAULT '',
  `posid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(100) NOT NULL DEFAULT '',
  `readpoint` smallint(5) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `copyfrom` varchar(255) NOT NULL DEFAULT 'CLTPHP',
  `fromlink` varchar(255) NOT NULL DEFAULT 'http://www.cltphp.com/',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `title_style` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_article`
--

INSERT INTO `clt_article` (`id`, `catid`, `userid`, `username`, `title`, `keywords`, `description`, `content`, `template`, `posid`, `status`, `recommend`, `readgroup`, `readpoint`, `sort`, `hits`, `createtime`, `updatetime`, `copyfrom`, `fromlink`, `thumb`, `title_style`) VALUES
(73, 1, 0, '0', '联系在线客服', '', '', '<p>客服邮箱：<span style="color: rgb(192, 0, 0);"><strong><span style="font-family: &quot;Microsoft Yahei&quot;, verdana; font-size: 14px; font-weight: 700; background-color: rgb(255, 255, 255);">minghuayouzhukf@163.com</span></strong></span><span style="color: rgb(85, 85, 85); font-family: &quot;Microsoft Yahei&quot;, verdana; font-size: 14px; font-weight: 700; background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="background-color: rgb(255, 255, 255); color: rgb(85, 85, 85); font-family: &quot;Microsoft Yahei&quot;, verdana; font-size: 14px; font-weight: 700;">微信客服：<span style="background-color: rgb(255, 255, 255); font-family: &quot;Microsoft Yahei&quot;, verdana; font-size: 14px; font-weight: 700; color: rgb(255, 0, 0);"><strong><span style="font-family: &quot;Microsoft Yahei&quot;, verdana; font-size: 14px; font-weight: 700; background-color: rgb(255, 255, 255);">aaxin88888888888</span></strong></span></span></p>', '', 0, '1', 0, '', 0, 0, 0, 1564659820, 0, 'CLTPHP', 'http://www.cltphp.com/', '', ''),
(70, 1, 0, '0', '为了调动平台推广积极性', '', '', '<p>内侧期间为了带动大家的活跃度与积极性 开始发放部分梅花 其他花种暂不开放 这样有利于平台更有效的推广 特此通知 请大家互相转告&nbsp; 梅花开放时间为16:20至17:20</p>', '', 0, '1', 0, '', 0, 0, 0, 1564294038, 0, 'CLTPHP', 'http://www.cltphp.com/', '', ''),
(71, 1, 0, '0', '名花有主8月1日正式上线', '', '', '<p>名花有主7月27日内测，上线遇到很多问题，团队也不断的进行修复调整，经过这几日的调整修复，平台已经稳定经公司商讨上线时间定为8月1日正式上线。&nbsp;</p>', '', 0, '1', 0, '', 0, 0, 0, 1564316380, 0, 'CLTPHP', 'http://www.cltphp.com/', '', ''),
(74, 1, 0, '0', '名花有主全面扶持！！！', '', '', '<p>即日起注册送60花粉，上级赠送20花粉，每日发布朋友圈用户额外奖励10花粉，添加客服发送朋友圈截图即可获取10花粉.</p>', '', 0, '1', 0, '', 0, 0, 0, 1564804023, 0, 'CLTPHP', 'http://www.cltphp.com/', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `clt_auth_group`
--

CREATE TABLE IF NOT EXISTS `clt_auth_group` (
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '全新ID',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '标题',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `rules` longtext COMMENT '规则',
  `addtime` int(11) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员分组';

--
-- 转存表中的数据 `clt_auth_group`
--

INSERT INTO `clt_auth_group` (`group_id`, `title`, `status`, `rules`, `addtime`) VALUES
(1, '超级管理员', 1, '0,1,2,270,294,15,16,119,120,121,145,17,149,116,117,118,151,181,18,108,114,112,109,110,111,3,5,128,126,127,4,230,232,129,189,190,193,192,240,239,241,243,244,245,242,246,27,29,161,163,164,162,298,38,167,182,169,166,28,48,247,248,31,32,249,250,251,45,170,171,175,174,173,46,176,183,179,178,265,284,288,287,286,285,279,283,282,281,280,289,293,292,291,290,196,197,202,198,252,253,254,255,256,203,205,204,257,272,206,207,212,208,213,258,259,260,261,262,209,215,214,263,273,295,296,297,301,302,306,307,299,300,304,305,', 1465114224),
(2, '总代理', 0, '0,1,2,270,294,15,16,119,120,121,145,17,149,116,117,118,151,181,18,108,114,112,109,110,111,3,5,128,126,127,4,230,232,129,189,190,193,192,240,239,241,243,244,245,242,246,27,29,161,163,164,162,298,38,167,182,169,166,28,48,247,248,31,32,249,250,251,45,170,171,175,174,173,46,176,183,179,178,265,284,288,287,286,285,279,283,282,281,280,289,293,292,291,290,196,197,202,198,252,253,254,255,256,203,205,204,257,272,206,207,212,208,213,258,259,260,261,262,209,215,214,263,273,295,296,297,301,302,306,307,299,300,304,305,', 1564194479);

-- --------------------------------------------------------

--
-- 表的结构 `clt_auth_rule`
--

CREATE TABLE IF NOT EXISTS `clt_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL,
  `href` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `authopen` tinyint(2) NOT NULL DEFAULT '1',
  `icon` varchar(20) DEFAULT NULL COMMENT '样式',
  `condition` char(100) DEFAULT '',
  `pid` int(5) NOT NULL DEFAULT '0' COMMENT '父栏目ID',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `zt` int(1) DEFAULT NULL,
  `menustatus` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=308 DEFAULT CHARSET=utf8 COMMENT='权限节点';

--
-- 转存表中的数据 `clt_auth_rule`
--

INSERT INTO `clt_auth_rule` (`id`, `href`, `title`, `type`, `status`, `authopen`, `icon`, `condition`, `pid`, `sort`, `addtime`, `zt`, `menustatus`) VALUES
(1, 'System', '系统设置', 1, 1, 0, 'icon-cogs', '', 0, 0, 1446535750, 1, 1),
(2, 'System/system', '系统设置', 1, 1, 0, '', '', 1, 1, 1446535789, 1, 0),
(3, 'Database/database', '数据库管理', 1, 1, 0, 'icon-database', '', 0, 2, 1446535805, 1, 0),
(4, 'Database/restore', '还原数据库', 1, 1, 0, '', '', 3, 10, 1446535750, 1, 0),
(5, 'Database/database', '数据库备份', 1, 1, 0, '', '', 3, 1, 1446535834, 1, 0),
(15, 'Auth/adminList', '权限管理', 1, 1, 0, 'icon-lifebuoy', '', 0, 1, 1446535750, 1, 1),
(16, 'Auth/adminList', '管理员列表', 1, 1, 0, '', '', 15, 0, 1446535750, 1, 1),
(17, 'Auth/adminGroup', '用户组列表', 1, 1, 0, '', '', 15, 1, 1446535750, 1, 1),
(18, 'Auth/adminRule', '权限管理', 1, 1, 0, '', '', 15, 2, 1446535750, 1, 1),
(23, 'Help/soft', '软件下载', 1, 1, 0, '', '', 22, 50, 1446711421, 0, 1),
(27, 'Users', '会员管理', 1, 1, 0, 'icon-user', '', 0, 5, 1447231507, 1, 1),
(28, 'Function', '网站功能', 1, 1, 0, 'icon-cog', '', 0, 6, 1447231590, 1, 1),
(29, 'Users/index', '会员列表', 1, 1, 0, '', '', 27, 10, 1447232085, 1, 1),
(31, 'Link/index', '友情链接', 1, 1, 0, '', '', 28, 2, 1447232183, 0, 0),
(32, 'Link/add', '操作-添加', 1, 1, 0, '', '', 31, 1, 1447639935, 0, 0),
(36, 'We/we_menu', '自定义菜单', 1, 1, 0, '', '', 35, 50, 1447842477, 0, 1),
(38, 'Users/userGroup', '会员组', 1, 1, 0, '', '', 27, 50, 1448413248, 1, 1),
(39, 'We/we_menu', '自定义菜单', 1, 1, 0, '', '', 36, 50, 1448501584, 0, 1),
(45, 'Ad/index', '广告管理', 1, 1, 0, '', '', 28, 3, 1450314297, 1, 0),
(46, 'Ad/type', '广告位管理', 1, 1, 0, '', '', 28, 4, 1450314324, 1, 0),
(48, 'Message/index', '留言管理', 1, 1, 0, '', '', 28, 1, 1451267354, 0, 0),
(105, 'System/runsys', '操作-保存', 1, 1, 0, '', '', 6, 50, 1461036331, 1, 0),
(106, 'System/runwesys', '操作-保存', 1, 1, 0, '', '', 10, 50, 1461037680, 0, 0),
(107, 'System/runemail', '操作-保存', 1, 1, 0, '', '', 19, 50, 1461039346, 1, 0),
(108, 'Auth/ruleAdd', '操作-添加', 1, 1, 0, '', '', 18, 0, 1461550835, 1, 0),
(109, 'Auth/ruleState', '操作-状态', 1, 1, 0, '', '', 18, 5, 1461550949, 1, 0),
(110, 'Auth/ruleTz', '操作-验证', 1, 1, 0, '', '', 18, 6, 1461551129, 1, 0),
(111, 'Auth/ruleorder', '操作-排序', 1, 1, 0, '', '', 18, 7, 1461551263, 1, 0),
(112, 'Auth/ruleDel', '操作-删除', 1, 1, 0, '', '', 18, 4, 1461551536, 1, 0),
(114, 'Auth/ruleEdit', '操作-修改', 1, 1, 0, '', '', 18, 2, 1461551913, 1, 1),
(116, 'Auth/groupEdit', '操作-修改', 1, 1, 0, '', '', 17, 3, 1461552326, 1, 1),
(117, 'Auth/groupDel', '操作-删除', 1, 1, 0, '', '', 17, 30, 1461552349, 1, 1),
(118, 'Auth/groupAccess', '操作-权限', 1, 1, 0, '', '', 17, 40, 1461552404, 1, 1),
(119, 'Auth/adminAdd', '操作-添加', 1, 1, 0, '', '', 16, 0, 1461553162, 1, 1),
(120, 'Auth/adminEdit', '操作-修改', 1, 1, 0, '', '', 16, 2, 1461554130, 1, 1),
(121, 'Auth/adminDel', '操作-删除', 1, 1, 0, '', '', 16, 4, 1461554152, 1, 1),
(122, 'System/source_runadd', '操作-添加', 1, 1, 0, '', '', 43, 10, 1461036331, 1, 0),
(123, 'System/source_order', '操作-排序', 1, 1, 0, '', '', 43, 50, 1461037680, 1, 0),
(124, 'System/source_runedit', '操作-改存', 1, 1, 0, '', '', 43, 30, 1461039346, 1, 0),
(125, 'System/source_del', '操作-删除', 1, 1, 0, '', '', 43, 40, 146103934, 1, 0),
(126, 'Database/export', '操作-备份', 1, 1, 0, '', '', 5, 1, 1461550835, 1, 0),
(127, 'Database/optimize', '操作-优化', 1, 1, 0, '', '', 5, 1, 1461550835, 1, 0),
(128, 'Database/repair', '操作-修复', 1, 1, 0, '', '', 5, 1, 1461550835, 1, 0),
(129, 'Database/delSqlFiles', '操作-删除', 1, 1, 0, '', '', 4, 3, 1461550835, 1, 0),
(130, 'System/bxgs_state', '操作-状态', 1, 1, 0, '', '', 67, 5, 1461550835, 1, 0),
(131, 'System/bxgs_edit', '操作-修改', 1, 1, 0, '', '', 67, 1, 1461550835, 1, 0),
(132, 'System/bxgs_runedit', '操作-改存', 1, 1, 0, '', '', 67, 2, 1461550835, 1, 0),
(134, 'System/myinfo_runedit', '个人资料修改', 1, 1, 0, '', '', 68, 1, 1461550835, 1, 0),
(230, 'Database/import', '操作-还原', 1, 1, 0, '', '', 4, 1, 1497423595, 0, 0),
(145, 'Auth/adminState', '操作-状态', 1, 1, 0, '', '', 16, 5, 1461550835, 1, 1),
(149, 'Auth/groupAdd', '操作-添加', 1, 1, 0, '', '', 17, 1, 1461550835, 1, 1),
(151, 'Auth/groupRunaccess', '操作-权存', 1, 1, 0, '', '', 17, 50, 1461550835, 1, 1),
(153, 'System/bxgs_runadd', '操作-添存', 1, 1, 0, '', '', 66, 1, 1461550835, 1, 0),
(240, 'Module/del', '操作-删除', 1, 1, 0, '', '', 190, 4, 1497425850, 0, 0),
(239, 'Module/moduleState', '操作-状态', 1, 1, 0, '', '', 190, 5, 1497425764, 0, 0),
(161, 'Users/usersState', '操作-状态', 1, 1, 0, '', '', 29, 1, 1461550835, 1, 1),
(162, 'Users/delall', '操作-全部删除', 1, 1, 0, '', '', 29, 4, 1461550835, 1, 1),
(163, 'Users/edit', '操作-编辑', 1, 1, 0, '', '', 29, 2, 1461550835, 1, 1),
(164, 'Users/usersDel', '操作-删除', 1, 1, 0, '', '', 29, 3, 1461550835, 1, 1),
(247, 'Message/del', '操作-删除', 1, 1, 0, '', '', 48, 1, 1497427449, 0, 0),
(166, 'Users/groupOrder', '操作-排序', 1, 1, 0, '', '', 38, 50, 1461550835, 1, 0),
(167, 'Users/groupAdd', '操作-添加', 1, 1, 0, '', '', 38, 10, 1461550835, 1, 0),
(169, 'Users/groupDel', '操作-删除', 1, 1, 0, '', '', 38, 30, 1461550835, 1, 1),
(170, 'Ad/add', '操作-添加', 1, 1, 0, '', '', 45, 1, 1461550835, 1, 0),
(171, 'Ad/edit', '操作-修改', 1, 1, 0, '', '', 45, 2, 1461550835, 1, 0),
(173, 'Ad/del', '操作-删除', 1, 1, 0, '', '', 45, 5, 1461550835, 1, 0),
(174, 'Ad/adOrder', '操作-排序', 1, 1, 0, '', '', 45, 4, 1461550835, 1, 0),
(175, 'Ad/editState', '操作-状态', 1, 1, 0, '', '', 45, 3, 1461550835, 1, 0),
(176, 'Ad/addType', '操作-添加', 1, 1, 0, '', '', 46, 1, 1461550835, 1, 0),
(252, 'Template/edit', '操作-编辑', 1, 1, 0, '', '', 197, 3, 1497428906, 0, 0),
(178, 'Ad/delType', '操作-删除', 1, 1, 0, '', '', 46, 4, 1461550835, 1, 0),
(179, 'Ad/typeOrder', '操作-排序', 1, 1, 0, '', '', 46, 3, 1461550835, 1, 0),
(180, 'System/source_edit', '操作-修改', 1, 1, 0, '', '', 43, 20, 1461832933, 1, 0),
(181, 'Auth/groupState', '操作-状态', 1, 1, 0, '', '', 17, 50, 1461834340, 1, 1),
(182, 'Users/groupEdit', '操作-修改', 1, 1, 0, '', '', 38, 15, 1461834780, 1, 1),
(183, 'Ad/editType', '操作-修改', 1, 1, 0, '', '', 46, 2, 1461834988, 1, 0),
(188, 'Plug/donation', '捐赠列表', 1, 1, 0, '', '', 187, 50, 1466563673, 0, 1),
(189, 'Module', '模型管理', 1, 1, 0, 'icon-ungroup', '', 0, 3, 1466825363, 0, 0),
(190, 'Module/index', '模型列表', 1, 1, 0, '', '', 189, 1, 1466826681, 0, 0),
(192, 'Module/edit', '操作-修改', 1, 1, 0, '', '', 190, 2, 1467007920, 0, 0),
(193, 'Module/add', '操作-添加', 1, 1, 0, '', '', 190, 1, 1467007955, 0, 0),
(196, 'Template', '模版管理', 1, 1, 0, 'icon-embed2', '', 0, 7, 1481857304, 0, 0),
(197, 'Template/index', '模版管理', 1, 1, 0, '', '', 196, 1, 1481857540, 0, 1),
(198, 'Template/insert', '操作-添存', 1, 1, 0, '', '', 197, 2, 1481857587, 0, 0),
(202, 'Template/add', '操作-添加', 1, 1, 0, '', '', 197, 1, 1481859447, 0, 0),
(203, 'Debris/index', '碎片管理', 1, 1, 0, '', '', 196, 2, 1484797759, 0, 1),
(204, 'Debris/edit', '操作-编辑', 1, 1, 0, '', '', 203, 2, 1484797849, 0, 0),
(205, 'Debris/add', '操作-添加', 1, 1, 0, '', '', 203, 1, 1484797878, 0, 0),
(206, 'Wechat', '微信管理', 1, 1, 0, 'icon-bubbles2', '', 0, 8, 1487063570, 0, 0),
(207, 'Wechat/config', '公众号管理', 1, 1, 0, '', '', 206, 1, 1487063705, 0, 1),
(208, 'Wechat/menu', '菜单管理', 1, 1, 0, '', '', 206, 2, 1487063765, 0, 1),
(209, 'Wechat/materialmessage', '消息素材', 1, 1, 0, '', '', 206, 3, 1487063834, 0, 1),
(212, 'Wechat/weixin', '操作-设置', 1, 1, 0, '', '', 207, 1, 1487064541, 0, 0),
(213, 'Wechat/addMenu', '操作-添加', 1, 1, 0, '', '', 208, 1, 1487149151, 0, 0),
(214, 'Wechat/editText', '操作-编辑', 1, 1, 0, '', '', 209, 2, 1487233984, 0, 0),
(215, 'Wechat/addText', '操作-添加', 1, 1, 0, '', '', 209, 1, 1487234062, 0, 0),
(232, 'Database/downFile', '操作-下载', 1, 1, 0, '', '', 4, 2, 1497423744, 0, 1),
(241, 'Module/field', '模型字段', 1, 1, 0, '', '', 190, 6, 1497425972, 0, 1),
(242, 'Module/fieldStatus', '操作-状态', 1, 1, 0, '', '', 241, 4, 1497426044, 0, 0),
(243, 'Module/fieldAdd', '操作-添加', 1, 1, 0, '', '', 241, 1, 1497426089, 0, 0),
(244, 'Module/fieldEdit', '操作-修改', 1, 1, 0, '', '', 241, 2, 1497426134, 0, 0),
(245, 'Module/listOrder', '操作-排序', 1, 1, 0, '', '', 241, 3, 1497426179, 0, 0),
(246, 'Module/fieldDel', '操作-删除', 1, 1, 0, '', '', 241, 5, 1497426241, 0, 0),
(248, 'Message/delall', '操作-删除全部', 1, 1, 0, '', '', 48, 2, 1497427534, 0, 0),
(249, 'Link/edit', '操作-编辑', 1, 1, 0, '', '', 31, 2, 1497427694, 0, 0),
(250, 'Link/linkState', '操作-状态', 1, 1, 0, '', '', 31, 3, 1497427734, 0, 0),
(251, 'Link/del', '操作-删除', 1, 1, 0, '', '', 31, 4, 1497427780, 0, 0),
(253, 'Template/update', '操作-改存', 1, 1, 0, '', '', 197, 4, 1497428951, 0, 0),
(254, 'Template/delete', '操作-删除', 1, 1, 0, '', '', 197, 5, 1497429018, 0, 0),
(255, 'Template/images', '媒体文件管理', 1, 1, 0, '', '', 197, 6, 1497429157, 0, 0),
(256, 'Template/imgDel', '操作-文件删除', 1, 1, 0, '', '', 255, 1, 1497429217, 0, 0),
(257, 'Debris/del', '操作-删除', 1, 1, 0, '', '', 203, 3, 1497429416, 0, 0),
(258, 'Wechat/editMenu', '操作-编辑', 1, 1, 0, '', '', 208, 2, 1497429671, 0, 0),
(259, 'Wechat/menuOrder', '操作-排序', 1, 1, 0, '', '', 208, 3, 1497429707, 0, 0),
(260, 'Wechat/menuState', '操作-状态', 1, 1, 0, '', '', 208, 4, 1497429764, 0, 0),
(261, 'Wechat/delMenu', '操作-删除', 1, 1, 0, '', '', 208, 5, 1497429822, 0, 0),
(262, 'Wechat/createMenu', '操作-生成菜单', 1, 1, 0, '', '', 208, 6, 1497429886, 0, 0),
(263, 'Wechat/delText', '操作-删除', 1, 1, 0, '', '', 209, 3, 1497430020, 0, 0),
(265, 'Donation/index', '捐赠管理', 1, 1, 0, '', '', 28, 5, 1498101716, 0, 0),
(273, 'Wechat/replay', '回复设置', 1, 1, 0, '', '', 206, 4, 1508215988, 0, 1),
(270, 'System/email', '邮箱配置', 1, 1, 0, '', '', 1, 2, 1502331829, 0, 0),
(272, 'Debris/type', '碎片分类', 1, 1, 0, '', '', 196, 3, 1504082720, 0, 1),
(279, 'news/index', '最新动态', 1, 1, 0, '', '', 28, 50, 1552462751, NULL, 1),
(280, 'news/del', '最新动态-删除', 1, 1, 0, '', '', 279, 50, 1552530372, NULL, 1),
(281, 'news/delall', '批量删除', 1, 1, 0, '', '', 279, 50, 1552531360, NULL, 1),
(282, 'news/edit', '编辑', 1, 1, 0, '', '', 279, 50, 1552531428, NULL, 1),
(283, 'news/add', '添加', 1, 1, 0, '', '', 279, 50, 1552531468, NULL, 1),
(284, 'service/index', '服务案例', 1, 1, 0, '', '', 28, 50, 1552532602, NULL, 0),
(285, 'service/add', '添加', 1, 1, 0, '', '', 284, 50, 1552532774, NULL, 1),
(286, 'service/edit', '编辑', 1, 1, 0, '', '', 284, 50, 1552532822, NULL, 1),
(287, 'service/del', '删除', 1, 1, 0, '', '', 284, 50, 1552532886, NULL, 1),
(288, 'service/delall', '批量删除', 1, 1, 0, '', '', 284, 50, 1552532918, NULL, 1),
(289, 'course/index', '小程序教程', 1, 1, 0, '', '', 28, 60, 1552552634, NULL, 0),
(290, 'course/add', '添加', 1, 1, 0, '', '', 289, 50, 1552553014, NULL, 1),
(291, 'course/edit', '编辑', 1, 1, 0, '', '', 289, 50, 1552553109, NULL, 1),
(292, 'course/del', '删除', 1, 1, 0, '', '', 289, 50, 1552553165, NULL, 1),
(293, 'course/delall', '批量删除', 1, 1, 0, '', '', 289, 50, 1552553199, NULL, 1),
(294, 'System/system_config', '参数配置', 1, 1, 0, '', '', 1, 3, 1554988847, NULL, 1),
(295, 'Match', '匹配中心', 1, 1, 0, 'icon-embed2', '', 0, 50, 1555122988, NULL, 1),
(296, 'Match/trading_center', '匹配中心', 1, 1, 0, '', '', 295, 50, 1555123045, NULL, 1),
(297, 'Match/manual_match', '手动匹配', 1, 1, 0, '', '', 295, 50, 1555123217, NULL, 1),
(299, 'Finance', '资金明细', 1, 1, 0, 'icon-embed', '', 0, 50, 1555503034, NULL, 1),
(298, 'Users/check_personal_data', '资料审核', 1, 1, 0, '', '', 27, 50, 1555294667, NULL, 1),
(300, 'Finance/history', '资金明细', 1, 1, 0, '', '', 299, 50, 1555503197, NULL, 1),
(301, 'Cucurbitadoll', '葫芦娃', 1, 1, 0, 'icon-list', '', 0, 50, 1560236683, NULL, 1),
(302, 'cucurbita/index', '葫芦娃设置', 1, 1, 0, '', '', 301, 50, 1560236826, NULL, 1),
(304, 'Agent', '代理查询', 1, 1, 0, 'icon-cog', '', 0, 50, 1563340010, NULL, 1),
(305, 'Agent/auth', '代理列表', 1, 1, 0, '', '', 304, 50, 1563340248, NULL, 1),
(306, 'appeal/index', '申诉查询', 1, 1, 0, 'icon-cog', '', 0, 50, 1563440999, NULL, 1),
(307, 'appeal/index', '申诉列表', 1, 1, 1, '', '', 306, 50, 1563442035, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_bankreceivables`
--

CREATE TABLE IF NOT EXISTS `clt_bankreceivables` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `subbranch` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `moren` int(11) DEFAULT '0' COMMENT '1是默认'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_bankreceivables`
--

INSERT INTO `clt_bankreceivables` (`id`, `uid`, `type`, `code`, `name`, `mobile`, `subbranch`, `img`, `create_time`, `moren`) VALUES
(1, 716, '支付宝', '77179475', '王皮皮', '17717637116', '', '/uploads/20190821/611b292b4faa38e4b354b7f0b6c8198a.jpg', 1566390550, 1),
(2, 715, '支付宝', '18408226900', 'wqeq', '18408226900', '', '/uploads/20190821/b659a68cec6812ff8b7d44bf0690fed1.png', 1566390921, 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_category`
--

CREATE TABLE IF NOT EXISTS `clt_category` (
  `id` smallint(5) unsigned NOT NULL,
  `catname` varchar(255) NOT NULL DEFAULT '',
  `catdir` varchar(30) NOT NULL DEFAULT '',
  `parentdir` varchar(50) NOT NULL DEFAULT '',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `moduleid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `module` char(24) NOT NULL DEFAULT '',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `arrchildid` varchar(100) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL DEFAULT '',
  `keywords` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(100) NOT NULL DEFAULT '',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL DEFAULT '',
  `template_list` varchar(20) NOT NULL DEFAULT '',
  `template_show` varchar(20) NOT NULL DEFAULT '',
  `pagesize` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(100) NOT NULL DEFAULT '',
  `listtype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lang` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否预览'
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_category`
--

INSERT INTO `clt_category` (`id`, `catname`, `catdir`, `parentdir`, `parentid`, `moduleid`, `module`, `arrparentid`, `arrchildid`, `type`, `title`, `keywords`, `description`, `sort`, `ishtml`, `ismenu`, `hits`, `image`, `child`, `url`, `template_list`, `template_show`, `pagesize`, `readgroup`, `listtype`, `lang`, `is_show`) VALUES
(1, '最新动态', 'news', '', 0, 2, 'article', '0', '1', 0, '最新动态', '最新动态', '最新动态', 4, 0, 1, 0, '', 1, '', '', '', 0, '1,2,3', 0, 0, 1),
(4, '系统操作', 'system', '', 0, 3, 'picture', '0', '4', 0, 'CLTPHP系统操作', 'CLTPHP系统操作,CLTPHP,CLTPHP内容管理系统', 'CLTPHP系统操作,CLTPHP,CLTPHP内容管理系统', 2, 0, 0, 0, '', 0, '', '', '', 0, '1,2,3', 0, 0, 0),
(14, '文件下载', 'download', '', 0, 5, 'download', '0', '14', 0, '测试下载', '测试下载', '测试下载', 0, 0, 0, 0, '', 0, '', '', '', 10, '1,2,3', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_chongzhi`
--

CREATE TABLE IF NOT EXISTS `clt_chongzhi` (
  `id` int(11) unsigned zerofill NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `money` decimal(12,2) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_chongzhi`
--

INSERT INTO `clt_chongzhi` (`id`, `uid`, `username`, `money`, `createtime`, `type`) VALUES
(00000000001, 716, '17717637116', '10000.00', 1566390768, 'dynamic_wallet');

-- --------------------------------------------------------

--
-- 表的结构 `clt_config`
--

CREATE TABLE IF NOT EXISTS `clt_config` (
  `id` smallint(6) unsigned NOT NULL COMMENT '表id',
  `name` varchar(50) DEFAULT NULL COMMENT '配置的key键名',
  `value` varchar(512) DEFAULT NULL COMMENT '配置的val值',
  `inc_type` varchar(64) DEFAULT NULL COMMENT '配置分组',
  `desc` varchar(50) DEFAULT NULL COMMENT '描述'
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_config`
--

INSERT INTO `clt_config` (`id`, `name`, `value`, `inc_type`, `desc`) VALUES
(16, 'is_mark', '0', 'water', '0'),
(17, 'mark_txt', '', 'water', '0'),
(18, 'mark_img', '/public/upload/public/2017/01-20/10cd966bd5f3549833c09a5c9700a9b8.jpg', 'water', '0'),
(19, 'mark_width', '', 'water', '0'),
(20, 'mark_height', '', 'water', '0'),
(21, 'mark_degree', '54', 'water', '0'),
(22, 'mark_quality', '56', 'water', '0'),
(23, 'sel', '9', 'water', '0'),
(24, 'sms_url', 'https://yunpan.cn/OcRgiKWxZFmjSJ', 'sms', '0'),
(25, 'sms_user', '', 'sms', '0'),
(26, 'sms_pwd', '访问密码 080e', 'sms', '0'),
(27, 'regis_sms_enable', '1', 'sms', '0'),
(28, 'sms_time_out', '1200', 'sms', '0'),
(38, '__hash__', '8d9fea07e44955760d3407524e469255_6ac8706878aa807db7ffb09dd0b02453', 'sms', '0'),
(39, '__hash__', '8d9fea07e44955760d3407524e469255_6ac8706878aa807db7ffb09dd0b02453', 'sms', '0'),
(56, 'sms_appkey', '123456789', 'sms', '0'),
(57, 'sms_secretKey', '123456789', 'sms', '0'),
(58, 'sms_product', '素材火', 'sms', '0'),
(59, 'sms_templateCode', 'SMS_101234567890', 'sms', '0'),
(60, 'smtp_server', 'smtp.qq.com', 'smtp', '0'),
(61, 'smtp_port', '465', 'smtp', '0'),
(62, 'smtp_user', '87775537@qq.com', 'smtp', '0'),
(63, 'smtp_pwd', 'zmmqivflahemiegc', 'smtp', '0'),
(64, 'regis_smtp_enable', '1', 'smtp', '0'),
(65, 'test_eamil', '23456@qq.com', 'smtp', '0'),
(70, 'forget_pwd_sms_enable', '1', 'sms', '0'),
(71, 'bind_mobile_sms_enable', '1', 'sms', '0'),
(72, 'order_add_sms_enable', '1', 'sms', '0'),
(73, 'order_pay_sms_enable', '1', 'sms', '0'),
(74, 'order_shipping_sms_enable', '1', 'sms', '0'),
(88, 'email_id', '南宁东盟软件', 'smtp', '0'),
(89, 'test_eamil_info', ' 您好！这是一封来自素材火的测试邮件！', 'smtp', '0');

-- --------------------------------------------------------

--
-- 表的结构 `clt_cucurbita`
--

CREATE TABLE IF NOT EXISTS `clt_cucurbita` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `adopt_time` varchar(255) NOT NULL COMMENT '领养时间',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '价值',
  `needgourd` int(11) NOT NULL DEFAULT '0' COMMENT '所需葫芦',
  `gains` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pgc` decimal(12,2) NOT NULL DEFAULT '0.00',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL,
  `grow_day` int(11) NOT NULL DEFAULT '0' COMMENT '成长天数',
  `price_one` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_two` decimal(12,2) NOT NULL DEFAULT '0.00',
  `vipneedgourd` int(10) unsigned DEFAULT '0' COMMENT 'VIP所需葫芦'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_cucurbita`
--

INSERT INTO `clt_cucurbita` (`id`, `status`, `title`, `adopt_time`, `price`, `needgourd`, `gains`, `pgc`, `addtime`, `thumb`, `grow_day`, `price_one`, `price_two`, `vipneedgourd`) VALUES
(1, 1, '弥勒佛', '12:00-12:30', '100.00', 2, '6.00', '1.00', 1560239003, '/uploads/20190822/759476b03c5cfa6a7a7d079c7df6f17d.gif', 1, '100.00', '300.00', 4),
(2, 1, '虚空藏菩萨', '14:30-15:00', '900.00', 4, '8.00', '4.00', 1560248072, '/uploads/20190822/3403b50d010e7e3bdf428d382d8cd55b.gif', 3, '301.00', '900.00', 8),
(3, 1, '文殊菩萨', '17:00 -17:30', '1800.00', 10, '11.00', '6.00', 1560248357, '/uploads/20190822/5f071cc804c33178145097c680bdc0fd.gif', 7, '901.00', '1800.00', 20),
(4, 1, '普贤菩萨', '19:30-20:00', '3600.00', 20, '14.00', '8.00', 1560248439, '/uploads/20190822/1592ecb62c6d7273b9b8f901de1aea0a.gif', 9, '1801.00', '3600.00', 40),
(5, 1, '大势至菩萨', '15:00-15:45', '7200.00', 25, '20.00', '10.00', 1560248504, '/uploads/20190822/77e171ed86e49a62aebffd1e1a15671b.gif', 15, '3601.00', '7200.00', 50),
(6, 1, '地藏王菩萨', '17:25-21:40', '1800.00', 3, '25.00', '10.00', 1560248564, '/uploads/20190822/de5fe5d63a94b4ed072c22dc15a7abb7.gif', 20, '901.00', '1800.00', 6);

-- --------------------------------------------------------

--
-- 表的结构 `clt_debris`
--

CREATE TABLE IF NOT EXISTS `clt_debris` (
  `id` int(6) NOT NULL,
  `type_id` int(6) DEFAULT NULL,
  `title` varchar(120) DEFAULT NULL,
  `content` text,
  `addtime` int(13) DEFAULT NULL,
  `sort` int(11) DEFAULT '50'
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_debris`
--

INSERT INTO `clt_debris` (`id`, `type_id`, `title`, `content`, `addtime`, `sort`) VALUES
(15, 1, '我们的差异化', '<p><span style="text-align: center;">CLTPHP内容管理系统给您自由的模型构建权利，让您的想法通过您亲自操作实现。不要再为传统的数据库字段限制而发愁。一步删除，一步增加，您想要的，就是这一步。</span></p>', 1503293255, 1),
(16, 1, '完整的建站理念', '<p><span style="text-align: center;">CLTPHP可以轻松构建模型，让数据库随心而动，让内容表单随意而变。模型和栏目的绑定，是为了让前台页面能更好的为您的想法服务，让您不再为建站留下遗憾。</span></p>', 1503293273, 2),
(17, 1, '简单、高效、低门槛', '<p><span style="text-align: center;">CLTPHP内容管理系统，全程鼠标操作，不用手动建立数据库，不用画网站结构图，也不用打开编译器。网站后台直接</span><span style="text-align: center;">编辑</span><span style="text-align: center;">模版，让网站建设达到前所未有的极致简单。</span></p>', 1503293291, 3);

-- --------------------------------------------------------

--
-- 表的结构 `clt_debris_type`
--

CREATE TABLE IF NOT EXISTS `clt_debris_type` (
  `id` int(11) NOT NULL,
  `title` varchar(120) DEFAULT NULL,
  `sort` int(1) DEFAULT '50'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_debris_type`
--

INSERT INTO `clt_debris_type` (`id`, `title`, `sort`) VALUES
(1, '【首页】中部碎片', 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_donation`
--

CREATE TABLE IF NOT EXISTS `clt_donation` (
  `id` int(11) NOT NULL COMMENT '自增ID',
  `name` varchar(120) NOT NULL DEFAULT '' COMMENT '用户名',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '捐赠金额',
  `addtime` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_dongjie`
--

CREATE TABLE IF NOT EXISTS `clt_dongjie` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `order_id` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci,
  `is_pay` int(2) DEFAULT '0' COMMENT '0未解冻，1已解冻',
  `money` decimal(12,2) DEFAULT '0.00',
  `cid` int(11) DEFAULT '0',
  `c_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tixian` int(11) DEFAULT '0' COMMENT '1是已提现',
  `jiedong_time` int(11) DEFAULT '0',
  `moneyint` decimal(12,2) DEFAULT '0.00' COMMENT '本金加利息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `clt_download`
--

CREATE TABLE IF NOT EXISTS `clt_download` (
  `id` int(11) unsigned NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(120) NOT NULL DEFAULT '',
  `title_style` varchar(225) NOT NULL DEFAULT '',
  `thumb` varchar(225) NOT NULL DEFAULT '',
  `keywords` varchar(120) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `content` text NOT NULL,
  `template` varchar(40) NOT NULL DEFAULT '',
  `posid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(100) NOT NULL DEFAULT '',
  `readpoint` smallint(5) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `files` varchar(80) NOT NULL DEFAULT '',
  `ext` varchar(255) NOT NULL DEFAULT 'zip',
  `size` varchar(255) NOT NULL DEFAULT '',
  `downs` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_download`
--

INSERT INTO `clt_download` (`id`, `catid`, `userid`, `username`, `title`, `title_style`, `thumb`, `keywords`, `description`, `content`, `template`, `posid`, `status`, `recommend`, `readgroup`, `readpoint`, `sort`, `hits`, `createtime`, `updatetime`, `files`, `ext`, `size`, `downs`) VALUES
(3, 14, 1, 'admin', '测试下载一', 'color:;font-weight:normal;', '', '测试下载一', '测试下载一', '请输入……', '0', 0, 1, 0, '', 0, 0, 0, 1529637588, 0, '/uploads/20180622/a6f6381d3bf0f0814790ad4b5b121794.zip', 'zip', '', 0),
(4, 14, 1, 'admin', '测试下载二', 'color:;font-weight:normal;', '', '测试下载二', '测试下载二', '请输入……', '0', 0, 1, 0, '', 0, 0, 0, 1529638055, 0, '/uploads/20180622/795f146c7c9e52414fe9f3b041af583e.zip', 'zip', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_feast`
--

CREATE TABLE IF NOT EXISTS `clt_feast` (
  `id` int(4) NOT NULL COMMENT '自增ID',
  `title` varchar(120) DEFAULT '' COMMENT '标题',
  `open` int(1) DEFAULT '1' COMMENT '是否开启',
  `sort` int(4) DEFAULT '50' COMMENT '排序',
  `addtime` varchar(15) DEFAULT NULL COMMENT '添加时间',
  `feast_date` varchar(20) DEFAULT '' COMMENT '节日日期',
  `type` int(1) DEFAULT '1' COMMENT '1阳历 2农历'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='节日列表';

--
-- 转存表中的数据 `clt_feast`
--

INSERT INTO `clt_feast` (`id`, `title`, `open`, `sort`, `addtime`, `feast_date`, `type`) VALUES
(2, '圣诞节', 1, 50, '1513304012', '12-25', 1),
(3, '中秋节', 1, 2, '1513317857', '07-12', 1),
(4, '七夕', 1, 50, '1532420762', '07-24', 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_feast_element`
--

CREATE TABLE IF NOT EXISTS `clt_feast_element` (
  `id` int(5) NOT NULL COMMENT '自增ID',
  `pid` int(4) DEFAULT NULL COMMENT '父级ID',
  `title` varchar(120) DEFAULT NULL COMMENT '标题',
  `css` text COMMENT 'CSS',
  `js` text COMMENT 'JS',
  `sort` int(5) DEFAULT '50' COMMENT '排序',
  `open` int(1) DEFAULT '1' COMMENT '是否开启',
  `addtime` varchar(15) DEFAULT NULL COMMENT '添加时间'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='节日元素表';

--
-- 转存表中的数据 `clt_feast_element`
--

INSERT INTO `clt_feast_element` (`id`, `pid`, `title`, `css`, `js`, `sort`, `open`, `addtime`) VALUES
(1, 2, '内容雪人', '#content-wrapper{position: relative;}\n#top-left img{width: 150px;}\n#top-left{position: absolute;top: 30px;left: -145px;}', '$("#content-wrapper").append("<div id=top-left><img src=/static/feast/christmas/top-left.png></div>");', 1, 1, '1513309235'),
(2, 2, '主页右下角驯鹿', '#body-right-bottom{position: fixed;bottom: 0;right: 20px;z-index:51}\n#body-right-bottom img{width: 400px;}', '$("body").append("<div id=body-right-bottom><img src=/static/feast/christmas/body-right-bottom.png></div>");', 2, 1, '1513309340'),
(3, 2, '主页左下角圣诞树', '#body-left-bottom{position: fixed;bottom: 0;left:0;z-index:51}\n#body-left-bottom img{width: 200px;}', ' $("body").append("<div id=body-left-bottom><img src=/static/feast/christmas/body-left-bottom.png></div>");', 3, 1, '1513309488'),
(4, 2, '主页右上角铃铛', '#body-top-right{position: fixed;top: 0;right:0;z-index: 100;}\n#body-top-right img{width: 120px;}', ' $("body").append("<div id=body-top-right><img src=/static/feast/christmas/body-top-right.png></div>");', 4, 1, '1513309568'),
(5, 2, '主页左中部圣诞老人', '#body-left-center{position: fixed;top: 300px;left: 0;z-index: 100;}\n#body-left-center img{width: 220px;}', '$("body").append("<div id=body-left-center><img src=/static/feast/christmas/body-left-center.png></div>");', 5, 1, '1513309625'),
(6, 2, '下载栏树叶', '.rfeatured-box{position: relative;}\n#right-one-top-right img{width: 60px;}\n#right-one-top-right{position: absolute;top: 0;right: -10px;}', ' $(".featured-box").append("<div id=right-one-top-right><img src=/static/feast/christmas/right-one-top-right.png></div>");', 6, 1, '1513309980'),
(7, 2, '导航栏雪景', 'header{position: relative;}\n#nav-bg img{}\n#nav-bg{position: absolute;bottom: -15px;height:30px;left: 0;width: 100%;background: url("/static/feast/christmas/nav-bg.png")repeat-x; z-index:50}', '$("header").append("<div id=nav-bg><img src=/static/feast/christmas/nav-bg.png></div>");', 7, 1, '1513310236'),
(8, 2, '主页背景', 'body{background: url("/static/feast/christmas/zbg.png") no-repeat 100% 100%;background-size: 100%;}', '', 50, 1, '1513310497'),
(10, 3, '主页左下角房子', '#body-left-bottom{position: fixed;bottom: 0;left:0;}\n#body-left-bottom img{width: 200px;}', ' $("body").append("<div id=body-left-bottom><img src=/static/feast/zhongqiu/body-left-bottom.png></div>");', 50, 1, '1513320275'),
(11, 3, '左上角文字', '#body-top-left{position: fixed;top:0;left0;z-index: 100;}\n#body-top-left img{width: 350px;}', ' $("body").append("<div id=body-top-left><img src=/static/feast/zhongqiu/body-top-left.png?111></div>");', 50, 1, '1513320569'),
(12, 3, '右上角嫦娥', '#body-top-right{position: fixed;top: 0;right:0;z-index: 100;}\n#body-top-right img{width: 300px;}', ' $("body").append("<div id=body-top-right><img src=/static/feast/zhongqiu/body-top-right.png></div>");', 50, 1, '1513321010'),
(13, 4, '右上角喜鹊', '#body-top-right{position: fixed;top: 0;right:0;z-index: 100;}\n#body-top-right img{width: 300px;}', ' $("body").append("<div id=body-top-right><img src=/static/feast/qixi/bird.png></div>");', 1, 1, '1528689869');

-- --------------------------------------------------------

--
-- 表的结构 `clt_field`
--

CREATE TABLE IF NOT EXISTS `clt_field` (
  `id` smallint(5) unsigned NOT NULL,
  `moduleid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `field` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `tips` varchar(150) NOT NULL DEFAULT '',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `minlength` int(10) unsigned NOT NULL DEFAULT '0',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL DEFAULT '',
  `errormsg` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(20) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `setup` text,
  `ispost` tinyint(1) NOT NULL DEFAULT '0',
  `unpostgroup` varchar(60) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_field`
--

INSERT INTO `clt_field` (`id`, `moduleid`, `field`, `name`, `tips`, `required`, `minlength`, `maxlength`, `pattern`, `errormsg`, `class`, `type`, `setup`, `ispost`, `unpostgroup`, `sort`, `status`, `issystem`) VALUES
(1, 1, 'title', '标题', '', 1, 1, 80, 'defaul', '标题必须为1-80个字符', 'title', 'title', 'array (\n  ''thumb'' => ''1'',\n  ''style'' => ''1'',\n)', 1, '', 1, 1, 1),
(2, 1, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 8, 0, 0),
(3, 1, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', '', 'datetime', '', 1, '', 97, 1, 1),
(4, 1, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 99, 1, 1),
(5, 1, 'status', '状态', '', 0, 0, 0, 'defaul', '', 'status', 'radio', 'array (\n  ''options'' => ''发布|1\n定时发布|0'',\n  ''fieldtype'' => ''varchar'',\n  ''numbertype'' => ''1'',\n  ''default'' => ''1'',\n)', 0, '', 98, 1, 1),
(6, 1, 'content', '内容', '', 1, 0, 0, 'defaul', '', 'content', 'editor', 'array (\n  ''edittype'' => ''UEditor'',\n)', 0, '', 3, 1, 0),
(7, 2, 'catid', '栏目', '', 1, 1, 6, '', '必须选择一个栏目', '', 'catid', '', 1, '', 1, 1, 1),
(8, 2, 'title', '标题', '', 1, 1, 80, 'defaul', '标题必须为1-80个字符', 'title', 'title', 'array (\n  ''thumb'' => ''1'',\n  ''style'' => ''1'',\n)', 1, '', 2, 1, 1),
(9, 2, 'keywords', '关键词', '', 0, 0, 80, '', '', '', 'text', 'array (\n  ''size'' => ''55'',\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 1, '', 3, 1, 1),
(10, 2, 'description', 'SEO简介', '', 0, 0, 0, '', '', '', 'textarea', 'array (\n  ''fieldtype'' => ''mediumtext'',\n  ''rows'' => ''4'',\n  ''cols'' => ''55'',\n  ''default'' => '''',\n)', 1, '', 4, 1, 1),
(11, 2, 'content', '内容', '', 0, 0, 0, 'defaul', '', 'content', 'editor', 'array (\n  ''edittype'' => ''layedit'',\n)', 1, '', 5, 1, 1),
(12, 2, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', 'createtime', 'datetime', '', 1, '', 6, 1, 1),
(13, 2, 'recommend', '允许评论', '', 0, 0, 1, '', '', '', 'radio', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => '''',\n  ''default'' => '''',\n)', 1, '', 10, 0, 0),
(14, 2, 'readpoint', '阅读收费', '', 0, 0, 5, '', '', '', 'number', 'array (\n  ''size'' => ''5'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 11, 0, 0),
(15, 2, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 12, 1, 0),
(16, 2, 'readgroup', '访问权限', '', 0, 0, 0, '', '', '', 'groupid', 'array (\n  ''inputtype'' => ''checkbox'',\n  ''fieldtype'' => ''tinyint'',\n  ''labelwidth'' => ''85'',\n  ''default'' => '''',\n)', 1, '', 13, 1, 1),
(17, 2, 'posid', '推荐位', '', 0, 0, 0, '', '', '', 'posid', '', 1, '', 14, 1, 1),
(18, 2, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 15, 1, 1),
(19, 2, 'status', '状态', '', 0, 0, 0, 'defaul', '', 'status', 'radio', 'array (\n  ''options'' => ''发布|1\n定时发布|2'',\n  ''fieldtype'' => ''varchar'',\n  ''numbertype'' => ''1'',\n  ''default'' => ''1'',\n)', 1, '', 7, 1, 1),
(20, 3, 'catid', '栏目', '', 1, 1, 6, '', '必须选择一个栏目', '', 'catid', '', 1, '', 1, 1, 1),
(21, 3, 'title', '标题', '', 1, 1, 80, 'defaul', '标题必须为1-80个字符', '', 'title', 'array (\n  ''thumb'' => ''0'',\n  ''style'' => ''0'',\n)', 1, '', 2, 1, 1),
(22, 3, 'keywords', '关键词', '', 0, 0, 80, '', '', '', 'text', 'array (\n  ''size'' => ''55'',\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 1, '', 3, 1, 1),
(23, 3, 'description', 'SEO简介', '', 0, 0, 0, '', '', '', 'textarea', 'array (\n  ''fieldtype'' => ''mediumtext'',\n  ''rows'' => ''4'',\n  ''cols'' => ''55'',\n  ''default'' => '''',\n)', 1, '', 4, 1, 1),
(24, 3, 'content', '内容', '', 0, 0, 0, 'defaul', '', 'content', 'editor', 'array (\n  ''edittype'' => ''layedit'',\n)', 1, '', 7, 1, 1),
(25, 3, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', '', 'datetime', '', 1, '', 8, 1, 1),
(26, 3, 'recommend', '允许评论', '', 0, 0, 1, '', '', '', 'radio', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => '''',\n  ''default'' => '''',\n)', 1, '', 10, 0, 0),
(27, 3, 'readpoint', '阅读收费', '', 0, 0, 5, '', '', '', 'number', 'array (\n  ''size'' => ''5'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 11, 0, 0),
(28, 3, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 12, 0, 0),
(29, 3, 'readgroup', '访问权限', '', 0, 0, 0, '', '', '', 'groupid', 'array (\n  ''inputtype'' => ''checkbox'',\n  ''fieldtype'' => ''tinyint'',\n  ''labelwidth'' => ''85'',\n  ''default'' => '''',\n)', 1, '', 13, 0, 1),
(30, 3, 'posid', '推荐位', '', 0, 0, 0, '', '', '', 'posid', '', 1, '', 14, 1, 1),
(31, 3, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 15, 1, 1),
(32, 3, 'status', '状态', '', 0, 0, 0, '', '', '', 'radio', 'array (\n  ''options'' => ''发布|1\r\n定时发布|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => ''75'',\n  ''default'' => ''1'',\n)', 1, '', 9, 1, 1),
(33, 3, 'pic', '图片', '', 1, 0, 0, 'defaul', '', 'pic', 'image', '', 0, '', 5, 1, 0),
(34, 3, 'group', '类型', '', 1, 0, 0, 'defaul', '', 'group', 'select', 'array (\n  ''options'' => ''模型管理|1\n分类管理|2\n内容管理|3'',\n  ''multiple'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n  ''numbertype'' => ''1'',\n  ''size'' => '''',\n  ''default'' => '''',\n)', 0, '', 6, 1, 0),
(35, 4, 'catid', '栏目', '', 1, 1, 6, '', '必须选择一个栏目', '', 'catid', '', 1, '', 1, 1, 1),
(36, 4, 'title', '标题', '', 1, 1, 80, '', '标题必须为1-80个字符', '', 'title', 'array (\n  ''thumb'' => ''1'',\n  ''style'' => ''1'',\n  ''size'' => ''55'',\n)', 1, '', 2, 1, 1),
(37, 4, 'keywords', '关键词', '', 0, 0, 80, '', '', '', 'text', 'array (\n  ''size'' => ''55'',\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 1, '', 3, 1, 1),
(38, 4, 'description', 'SEO简介', '', 0, 0, 0, '', '', '', 'textarea', 'array (\n  ''fieldtype'' => ''mediumtext'',\n  ''rows'' => ''4'',\n  ''cols'' => ''55'',\n  ''default'' => '''',\n)', 1, '', 4, 1, 1),
(39, 4, 'content', '内容', '', 0, 0, 0, 'defaul', '', 'content', 'editor', 'array (\n  ''edittype'' => ''layedit'',\n)', 1, '', 8, 1, 1),
(40, 4, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', '', 'datetime', '', 1, '', 9, 1, 1),
(41, 4, 'status', '状态', '', 0, 0, 0, '', '', '', 'radio', 'array (\n  ''options'' => ''发布|1\r\n定时发布|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => ''75'',\n  ''default'' => ''1'',\n)', 1, '', 10, 1, 1),
(42, 4, 'recommend', '允许评论', '', 0, 0, 1, '', '', '', 'radio', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => '''',\n  ''default'' => '''',\n)', 1, '', 11, 0, 0),
(43, 4, 'readpoint', '阅读收费', '', 0, 0, 5, '', '', '', 'number', 'array (\n  ''size'' => ''5'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 12, 0, 0),
(44, 4, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 13, 0, 0),
(45, 4, 'readgroup', '访问权限', '', 0, 0, 0, '', '', '', 'groupid', 'array (\n  ''inputtype'' => ''checkbox'',\n  ''fieldtype'' => ''tinyint'',\n  ''labelwidth'' => ''85'',\n  ''default'' => '''',\n)', 1, '', 14, 0, 1),
(46, 4, 'posid', '推荐位', '', 0, 0, 0, '', '', '', 'posid', '', 1, '', 15, 1, 1),
(47, 4, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 16, 1, 1),
(48, 4, 'price', '价格', '', 1, 0, 0, 'defaul', '', 'price', 'number', 'array (\n  ''size'' => '''',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''2'',\n  ''default'' => ''0.00'',\n)', 0, '', 5, 1, 0),
(49, 4, 'xinghao', '型号', '', 0, 0, 0, 'defaul', '', '', 'text', 'array (\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 0, '', 6, 1, 0),
(50, 4, 'pics', '图组', '', 0, 0, 0, 'defaul', '', 'pics', 'images', '', 0, '', 7, 1, 0),
(51, 5, 'catid', '栏目', '', 1, 1, 6, '', '必须选择一个栏目', '', 'catid', '', 1, '', 1, 1, 1),
(52, 5, 'title', '标题', '', 1, 1, 80, '', '标题必须为1-80个字符', '', 'title', 'array (\n  ''thumb'' => ''1'',\n  ''style'' => ''1'',\n  ''size'' => ''55'',\n)', 1, '', 2, 1, 1),
(53, 5, 'keywords', '关键词', '', 0, 0, 80, '', '', '', 'text', 'array (\n  ''size'' => ''55'',\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 1, '', 3, 1, 1),
(54, 5, 'description', 'SEO简介', '', 0, 0, 0, '', '', '', 'textarea', 'array (\n  ''fieldtype'' => ''mediumtext'',\n  ''rows'' => ''4'',\n  ''cols'' => ''55'',\n  ''default'' => '''',\n)', 1, '', 4, 1, 1),
(55, 5, 'content', '内容', '', 0, 0, 0, 'defaul', '', 'content', 'editor', 'array (\n  ''edittype'' => ''layedit'',\n)', 1, '', 9, 1, 1),
(56, 5, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', 'createtime', 'datetime', '', 1, '', 10, 1, 1),
(57, 5, 'status', '状态', '', 0, 0, 0, '', '', '', 'radio', 'array (\n  ''options'' => ''发布|1\r\n定时发布|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => ''75'',\n  ''default'' => ''1'',\n)', 1, '', 11, 1, 1),
(58, 5, 'recommend', '允许评论', '', 0, 0, 1, '', '', '', 'radio', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => '''',\n  ''default'' => '''',\n)', 1, '', 12, 0, 0),
(59, 5, 'readpoint', '阅读收费', '', 0, 0, 5, '', '', '', 'number', 'array (\n  ''size'' => ''5'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 13, 0, 0),
(60, 5, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 14, 0, 0),
(61, 5, 'readgroup', '访问权限', '', 0, 0, 0, '', '', '', 'groupid', 'array (\n  ''inputtype'' => ''checkbox'',\n  ''fieldtype'' => ''tinyint'',\n  ''labelwidth'' => ''85'',\n  ''default'' => '''',\n)', 1, '', 15, 0, 1),
(62, 5, 'posid', '推荐位', '', 0, 0, 0, '', '', '', 'posid', '', 1, '', 16, 1, 1),
(63, 5, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 17, 1, 1),
(64, 5, 'files', '上传文件', '', 0, 0, 0, 'defaul', '', 'files', 'file', 'array (\n  ''upload_allowext'' => ''zip,rar,doc,ppt'',\n)', 0, '', 5, 1, 0),
(65, 5, 'ext', '文档类型', '', 0, 0, 0, 'defaul', '', 'ext', 'text', 'array (\n  ''default'' => ''zip'',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 0, '', 6, 1, 0),
(66, 5, 'size', '文档大小', '', 0, 0, 0, 'defaul', '', 'size', 'text', 'array (\n  ''default'' => '''',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 0, '', 7, 1, 0),
(67, 5, 'downs', '下载次数', '', 0, 0, 0, 'defaul', '', '', 'number', 'array (\n  ''size'' => '''',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => '''',\n)', 0, '', 8, 1, 0),
(68, 6, 'title', '标题', '', 1, 1, 80, '', '标题必须为1-80个字符', '', 'title', 'array (\n  ''thumb'' => ''1'',\n  ''style'' => ''1'',\n  ''size'' => ''55'',\n)', 1, '', 2, 1, 1),
(69, 6, 'hits', '点击次数', '', 0, 0, 8, '', '', '', 'number', 'array (\n  ''size'' => ''10'',\n  ''numbertype'' => ''1'',\n  ''decimaldigits'' => ''0'',\n  ''default'' => ''0'',\n)', 1, '', 6, 0, 0),
(70, 6, 'createtime', '发布时间', '', 1, 0, 0, 'date', '', '', 'datetime', '', 1, '', 4, 1, 1),
(71, 6, 'template', '模板', '', 0, 0, 0, '', '', '', 'template', '', 1, '', 7, 1, 1),
(72, 6, 'status', '状态', '', 0, 0, 0, '', '', '', 'radio', 'array (\n  ''options'' => ''发布|1\r\n定时发布|0'',\n  ''fieldtype'' => ''tinyint'',\n  ''numbertype'' => ''1'',\n  ''labelwidth'' => ''75'',\n  ''default'' => ''1'',\n)', 1, '', 5, 1, 1),
(73, 6, 'catid', '分类', '', 1, 0, 0, 'defaul', '', 'catid', 'catid', '', 0, '', 1, 1, 0),
(74, 6, 'info', '简介', '', 1, 0, 0, 'defaul', '', 'info', 'editor', 'array (\n  ''edittype'' => ''layedit'',\n)', 0, '', 3, 1, 0),
(75, 2, 'copyfrom', '来源', '', 0, 0, 0, 'defaul', '', 'copyfrom', 'text', 'array (\n  ''default'' => ''CLTPHP'',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 0, '', 8, 1, 0),
(76, 2, 'fromlink', '来源网址', '', 0, 0, 0, 'defaul', '', 'fromlink', 'text', 'array (\n  ''default'' => ''http://www.cltphp.com/'',\n  ''ispassword'' => ''0'',\n  ''fieldtype'' => ''varchar'',\n)', 0, '', 9, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_history`
--

CREATE TABLE IF NOT EXISTS `clt_history` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `money` decimal(12,2) DEFAULT '0.00' COMMENT '交易金额',
  `surplus` decimal(12,2) DEFAULT NULL COMMENT '交易后剩余',
  `type` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `option` varchar(255) DEFAULT NULL,
  `cid` int(11) DEFAULT '0',
  `c_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_history`
--

INSERT INTO `clt_history` (`id`, `uid`, `username`, `money`, `surplus`, `type`, `remark`, `createtime`, `option`, `cid`, `c_name`) VALUES
(1, 716, '17717637116', '-5.00', NULL, 'aibi', '预约消耗花粉', 1566390569, 'expend', 0, NULL),
(2, 716, '17717637116', '10000.00', NULL, 'dynamic_wallet', '系统充值静动态钱包', 1566390768, 'income', 0, NULL),
(3, 716, '17717637116', '-50.00', NULL, 'dynamic_wallet', '提现售出', 1566390788, 'expend', 0, NULL),
(4, 716, '17717637116', '-1001.00', NULL, 'dynamic_wallet', '提现售出', 1566390817, 'expend', 0, NULL),
(5, 716, '17717637116', '-2.00', NULL, 'aibi', '预约消耗花粉', 1566390827, 'expend', 0, NULL),
(6, 716, '17717637116', '-16.00', NULL, 'aibi', '预约消耗花粉', 1566390839, 'expend', 0, NULL),
(7, 716, '17717637116', '-3.00', NULL, 'aibi', '预约消耗花粉', 1566390843, 'expend', 0, NULL),
(8, 716, '17717637116', '-10.00', NULL, 'aibi', '自动抢消耗花粉', 1566390855, 'expend', 0, NULL),
(9, 715, '18408226900', '-3.00', NULL, 'aibi', '预约消耗花粉', 1566390980, 'expend', 0, NULL),
(10, 715, '18408226900', '-2.00', NULL, 'aibi', '预约消耗花粉', 1566391758, 'expend', 0, NULL),
(11, 715, '18408226900', '-16.00', NULL, 'aibi', '预约消耗花粉', 1566391840, 'expend', 0, NULL),
(12, 715, '18408226900', '-5.00', NULL, 'aibi', '预约消耗花粉', 1566392024, 'expend', 0, NULL),
(13, 715, '18408226900', '-100.00', NULL, 'aibi', '预约消耗花粉', 1566392954, 'expend', 0, NULL),
(14, 716, '17717637116', '2.00', NULL, 'yuyue', '预约失败退回', 1566393628, 'expend', 1, '花中之魁 - 梅花'),
(15, 715, '18408226900', '2.00', NULL, 'yuyue', '预约失败退回', 1566393628, 'expend', 1, '花中之魁 - 梅花'),
(16, 715, '18408226900', '-16.00', NULL, 'aibi', '自动抢消耗花粉', 1566393735, 'expend', 0, NULL),
(17, 716, '17717637116', '-2.00', NULL, 'aibi', '预约消耗花粉', 1566393874, 'expend', 0, NULL),
(18, 716, '17717637116', '2.00', NULL, 'yuyue', '预约失败退回', 1566395683, 'expend', 1, '花中之魁 - 梅花'),
(19, 716, '17717637116', '2.00', NULL, 'yuyue', '预约失败退回', 1566395684, 'expend', 1, '花中之魁 - 梅花'),
(20, 716, '17717637116', '2.00', NULL, 'yuyue', '预约失败退回', 1566395689, 'expend', 1, '花中之魁 - 梅花'),
(21, 715, '14776114977', '-2.00', NULL, 'aibi', '预约消耗花粉', 1566396882, 'expend', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `clt_link`
--

CREATE TABLE IF NOT EXISTS `clt_link` (
  `link_id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '链接名称',
  `url` varchar(200) NOT NULL COMMENT '链接URL',
  `type_id` tinyint(4) DEFAULT NULL COMMENT '所属栏目ID',
  `qq` varchar(20) NOT NULL COMMENT '联系QQ',
  `sort` int(5) NOT NULL DEFAULT '50' COMMENT '排序',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `open` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0禁用1启用'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_link`
--

INSERT INTO `clt_link` (`link_id`, `name`, `url`, `type_id`, `qq`, `sort`, `addtime`, `open`) VALUES
(10, '苏次啊会', 'http://www.sucaihuo.com/', 0, '416148489', 1, 1495183645, 1),
(19, '成都礼品公司', 'http://www.1177_think.net', NULL, '', 50, 1552543517, 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_match`
--

CREATE TABLE IF NOT EXISTS `clt_match` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) DEFAULT NULL COMMENT '订单编号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '排单id',
  `username` varchar(50) DEFAULT NULL COMMENT '排单会员编号',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `match_time` int(11) NOT NULL DEFAULT '0' COMMENT '匹配时间',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `unmatched` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '未匹配金额',
  `is_pay` int(11) NOT NULL DEFAULT '0',
  `currency_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 出场  1静态    2动态',
  `order_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=>排单，1=>提现',
  `finish_time` int(11) DEFAULT '0' COMMENT '完成时间',
  `pay_status` int(11) DEFAULT '0',
  `match_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=>未匹配，1=>部分匹配，2=>全部匹配',
  `is_out` int(11) DEFAULT '0' COMMENT '0=>订单正常，1=》订单违规撤销匹配',
  `total` decimal(12,2) DEFAULT '0.00' COMMENT '订单总额',
  `limit_match` int(11) DEFAULT '0' COMMENT '0未限制，1限制匹配',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '葫芦娃id',
  `appointment` varchar(255) DEFAULT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `pay_time` int(11) DEFAULT '0',
  `shou_time` int(11) DEFAULT '0',
  `is_online` tinyint(1) unsigned DEFAULT '0' COMMENT '是否在线',
  `is_vip` tinyint(1) unsigned DEFAULT '0' COMMENT '是否VIP',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '是否已显示'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `clt_match`
--

INSERT INTO `clt_match` (`id`, `order_id`, `uid`, `username`, `create_time`, `match_time`, `money`, `unmatched`, `is_pay`, `currency_type`, `order_type`, `finish_time`, `pay_status`, `match_status`, `is_out`, `total`, `limit_match`, `cid`, `appointment`, `c_name`, `pay_time`, `shou_time`, `is_online`, `is_vip`, `is_show`) VALUES
(1, 'T20190821212215836828715', 715, '18408226900', 1566393735, 0, '0.00', '0.00', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 5, NULL, '君子之花 - 兰花', 0, 0, 0, 1, 0),
(3, 'T20190821221442485944715', 715, '14776114977', 1566396882, 0, '0.00', '0.00', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 1, NULL, '花中之魁 - 梅花', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_match2`
--

CREATE TABLE IF NOT EXISTS `clt_match2` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) DEFAULT NULL COMMENT '匹配订单编号',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `in_order_id` varchar(200) DEFAULT NULL COMMENT '进场订单编号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '排单id',
  `username` varchar(50) DEFAULT NULL COMMENT '排单会员编号',
  `out_order_id` varchar(200) DEFAULT NULL COMMENT '出场订单编号',
  `bid` int(11) DEFAULT '0' COMMENT '提现id',
  `busername` varchar(200) DEFAULT NULL COMMENT '提现会员编号',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '打款时间',
  `receipt_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认收款时间',
  `pay_status` int(2) NOT NULL DEFAULT '0' COMMENT '0=>未打款，1=>已打款，2=>确认收款',
  `is_pay` int(2) NOT NULL DEFAULT '0',
  `complaint` int(2) NOT NULL DEFAULT '0' COMMENT '0=>无投诉，1=》有投诉',
  `image` text,
  `is_check` int(2) DEFAULT '0' COMMENT '0未检测，1已检测超时收款',
  `pay_number` int(11) DEFAULT '0' COMMENT '进场订单的轮数，用于解冻资金',
  `complaint_time` int(11) DEFAULT '0',
  `appointment` int(11) DEFAULT '0' COMMENT '0正常时间段匹配，1预匹配时间段',
  `cid` int(11) DEFAULT '0',
  `c_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `clt_message`
--

CREATE TABLE IF NOT EXISTS `clt_message` (
  `message_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT '' COMMENT '留言标题',
  `tel` varchar(15) NOT NULL DEFAULT '' COMMENT '留言电话',
  `addtime` varchar(15) NOT NULL COMMENT '留言时间',
  `open` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1=审核 0=不审核',
  `ip` varchar(50) DEFAULT '' COMMENT '留言者IP',
  `content` longtext NOT NULL COMMENT '留言内容',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(50) NOT NULL COMMENT '留言邮箱'
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_message`
--

INSERT INTO `clt_message` (`message_id`, `title`, `tel`, `addtime`, `open`, `ip`, `content`, `name`, `email`) VALUES
(92, '呵呵', '', '1528851199', 0, '127.0.0.1', '为什么还不更新？', 'chichu', '1109305987@qq.com'),
(93, '11', '', '1530629400', 0, '127.0.0.1', '11', '11', '11'),
(94, '11', '', '1530777448', 0, '127.0.0.1', '11', '11', '11'),
(95, '要求克里斯蒂', '', '1552535771', 0, '127.0.0.1', '阿斯蒂芬大扶康阿里肯定舒服奥德赛奥德赛法定收费大师傅阿斯蒂', '小明', '15504781930@qq.com'),
(96, '要求克里斯蒂', '', '1552535772', 0, '127.0.0.1', '阿斯蒂芬大扶康阿里肯定舒服奥德赛奥德赛法定收费大师傅阿斯蒂', '小明', '15504781930@qq.com');

-- --------------------------------------------------------

--
-- 表的结构 `clt_mobile_code`
--

CREATE TABLE IF NOT EXISTS `clt_mobile_code` (
  `uid` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `mobile` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_module`
--

CREATE TABLE IF NOT EXISTS `clt_module` (
  `id` tinyint(3) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `listfields` varchar(255) NOT NULL DEFAULT '',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_module`
--

INSERT INTO `clt_module` (`id`, `title`, `name`, `description`, `type`, `issystem`, `listfields`, `sort`, `status`) VALUES
(1, '单页模型', 'page', '单页面', 1, 0, '*', 0, 1),
(2, '文章模型', 'article', '新闻文章', 1, 0, '*', 0, 1),
(3, '图片模型', 'picture', '图片展示', 1, 0, '*', 0, 1),
(4, '产品模型', 'product', '产品展示', 1, 0, '*', 0, 1),
(5, '下载模型', 'download', '文件下载', 1, 0, '*', 0, 1),
(6, '团队模型', 'team', '员工展示', 1, 0, '*', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_oauth`
--

CREATE TABLE IF NOT EXISTS `clt_oauth` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `type` varchar(50) DEFAULT NULL COMMENT '账号类型',
  `openid` varchar(120) DEFAULT NULL COMMENT '第三方唯一标示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_page`
--

CREATE TABLE IF NOT EXISTS `clt_page` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `title_style` varchar(225) NOT NULL DEFAULT '',
  `thumb` varchar(225) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lang` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `template` varchar(50) DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_picture`
--

CREATE TABLE IF NOT EXISTS `clt_picture` (
  `id` int(11) unsigned NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(80) NOT NULL DEFAULT '',
  `keywords` varchar(120) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `content` text NOT NULL,
  `template` varchar(40) NOT NULL DEFAULT '',
  `posid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(100) NOT NULL DEFAULT '',
  `readpoint` smallint(5) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `pic` varchar(80) NOT NULL DEFAULT '',
  `group` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_picture`
--

INSERT INTO `clt_picture` (`id`, `catid`, `userid`, `username`, `title`, `keywords`, `description`, `content`, `template`, `posid`, `status`, `recommend`, `readgroup`, `readpoint`, `sort`, `hits`, `createtime`, `updatetime`, `pic`, `group`) VALUES
(1, 4, 1, 'admin', '模型列表', '模型列表', '展示网站内容模型，模型是CLTPHP的核心之一。', '<p>展示网站内容模型，模型是CLTPHP的核心之一。</p>', '0', 0, 1, 0, '', 0, 1, 1, 1499761915, 1528699234, '/uploads/20180611/0ce39ef421e7ca7149b2630d93b571ee.png', '1'),
(2, 4, 1, 'admin', '添加模型', '添加模型', '添加模型', '<p>您可以通过后台轻松创建新的新的模型，不拘泥于传统。</p>', '0', 0, 1, 0, '', 0, 2, 0, 1499762188, 1528699288, '/uploads/20180611/e41226ad6f977aeb2418a0f55a0678ef.png', '1'),
(3, 4, 1, 'admin', '模型字段', '模型字段', '模型字段', '<p>您可以任意构建自己的模型字段，从而达到网站内容的高效编辑。</p>', '0', 0, 1, 0, '', 0, 3, 0, 1499762270, 1528699324, '/uploads/20180611/57027c6ab845effea600f6f9695e2db4.png', '1'),
(4, 4, 1, 'admin', '添加字段', '添加字段', '添加字段', '<p>CLTPHP提供了丰富的字段类型，当然您可以扩展出更多的类型。</p>', '0', 0, 1, 0, '', 0, 4, 0, 1499762323, 1528699410, '/uploads/20180611/85f128c3c9488a41b04386e31199ab3f.png', '1'),
(5, 4, 1, 'admin', '栏目列表', '栏目列表', '栏目列表', '<p>栏目编辑，可以让后台编辑明确，也可以使的前台展示更加分明。</p>', '0', 0, 1, 0, '', 0, 5, 0, 1499762369, 1528699472, '/uploads/20180611/2b6456d6725ce4ad1a8dd66b595f1eb9.png', '2'),
(6, 4, 1, 'admin', '添加栏目', '添加栏目', '添加栏目', '<p>添加栏目时绑定模型，以适应网站内容的多样性。</p>', '0', 0, 1, 0, '', 0, 6, 0, 1499762446, 1528699568, '/uploads/20180611/953235f4e44df6dd63de15bb28ea0bc5.png', '2'),
(7, 4, 1, 'admin', '内容列表', '内容列表', '内容列表', '<p>点击栏目名称进入对应的内容列表页，简洁而高效。</p>', '0', 0, 1, 0, '', 0, 7, 0, 1499762523, 1528699605, '/uploads/20180611/fb3193674fb2ea68f2a61d4de0859a0e.png', '3'),
(8, 4, 1, 'admin', '添加内容', '添加内容', '添加内容', '<p>不同栏目的内容编辑页是根据及绑定的模型智能生成的。</p>', '0', 0, 1, 0, '', 0, 8, 0, 1499762754, 1528699629, '/uploads/20180611/ef322c904a47681d32aa4338316bac18.png', '3');

-- --------------------------------------------------------

--
-- 表的结构 `clt_plugin`
--

CREATE TABLE IF NOT EXISTS `clt_plugin` (
  `code` varchar(13) DEFAULT NULL COMMENT '插件编码',
  `name` varchar(55) DEFAULT NULL COMMENT '中文名字',
  `version` varchar(255) DEFAULT NULL COMMENT '插件的版本',
  `author` varchar(30) DEFAULT NULL COMMENT '插件作者',
  `config` text COMMENT '配置信息',
  `config_value` text COMMENT '配置值信息',
  `desc` varchar(255) DEFAULT NULL COMMENT '插件描述',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否启用',
  `type` varchar(50) DEFAULT NULL COMMENT '插件类型 payment支付 login 登陆 shipping物流',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `bank_code` text COMMENT '网银配置信息',
  `scene` tinyint(1) DEFAULT '0' COMMENT '使用场景 0 PC+手机 1 手机 2 PC'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_plugin`
--

INSERT INTO `clt_plugin` (`code`, `name`, `version`, `author`, `config`, `config_value`, `desc`, `status`, `type`, `icon`, `bank_code`, `scene`) VALUES
('qq', 'QQ登陆', '1.0', 'CLTPHP', 'a:5:{i:0;a:4:{s:4:"name";s:5:"appid";s:5:"label";s:5:"appid";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:1;a:4:{s:4:"name";s:6:"appkey";s:5:"label";s:6:"appkey";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:2;a:4:{s:4:"name";s:8:"callback";s:5:"label";s:12:"回调地址";s:4:"type";s:4:"text";s:5:"value";s:37:"http://cltdemo.test/index/callback/qq";}i:3;a:4:{s:4:"name";s:5:"scope";s:5:"label";s:12:"获取字段";s:4:"type";s:8:"textarea";s:5:"value";s:225:"get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr";}i:4;a:4:{s:4:"name";s:11:"errorReport";s:5:"label";s:12:"错误报告";s:4:"type";s:4:"text";s:5:"value";s:4:"true";}}', 'a:5:{s:5:"appid";s:0:"";s:6:"appkey";s:0:"";s:8:"callback";s:37:"http://cltdemo.test/index/callback/qq";s:5:"scope";s:225:"get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr";s:11:"errorReport";s:4:"true";}', 'QQ登陆插件 ', 1, 'login', 'logo.png', 's:0:"";', 0),
('changyan', '畅言评论', '1.0', 'CLTPHP', 'a:3:{i:0;a:4:{s:4:"name";s:6:"app_id";s:5:"label";s:6:"app_id";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:1;a:4:{s:4:"name";s:7:"app_key";s:5:"label";s:7:"app_key";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:2;a:4:{s:4:"name";s:6:"config";s:5:"label";s:6:"config";s:4:"type";s:4:"text";s:5:"value";s:0:"";}}', 'a:8:{s:5:"appid";s:0:"";s:6:"appkey";s:0:"";s:8:"callback";s:37:"http://cltdemo.test/index/callback/qq";s:5:"scope";s:225:"get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr";s:11:"errorReport";s:4:"true";s:6:"app_id";s:0:"";s:7:"app_key";s:0:"";s:6:"config";s:0:"";}', '畅言评论插件 ', 1, 'msg', 'logo.png', 's:0:"";', 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_posid`
--

CREATE TABLE IF NOT EXISTS `clt_posid` (
  `id` tinyint(2) unsigned NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `sort` tinyint(2) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_posid`
--

INSERT INTO `clt_posid` (`id`, `name`, `sort`) VALUES
(1, '首页推荐', 0),
(2, '当前分类推荐', 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_pp_msg`
--

CREATE TABLE IF NOT EXISTS `clt_pp_msg` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(70) NOT NULL DEFAULT '',
  `uread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未读，1已读',
  `msg` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_product`
--

CREATE TABLE IF NOT EXISTS `clt_product` (
  `id` int(11) unsigned NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(120) NOT NULL DEFAULT '',
  `title_style` varchar(225) NOT NULL DEFAULT '',
  `thumb` varchar(225) NOT NULL DEFAULT '',
  `keywords` varchar(120) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `content` text NOT NULL,
  `template` varchar(40) NOT NULL DEFAULT '',
  `posid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(100) NOT NULL DEFAULT '',
  `readpoint` smallint(5) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `xinghao` varchar(255) NOT NULL DEFAULT '',
  `pics` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_region`
--

CREATE TABLE IF NOT EXISTS `clt_region` (
  `id` smallint(5) unsigned NOT NULL,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(120) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_role`
--

CREATE TABLE IF NOT EXISTS `clt_role` (
  `id` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_role`
--

INSERT INTO `clt_role` (`id`, `name`, `status`, `remark`, `pid`, `sort`) VALUES
(1, '超级管理员', 1, '超级管理', 0, 0),
(2, '普通管理员', 1, '普通管理员', 0, 0),
(3, '注册用户', 1, '注册用户', 0, 0),
(4, '游客', 1, '游客', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_role_user`
--

CREATE TABLE IF NOT EXISTS `clt_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT '0',
  `user_id` char(32) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_sendcode`
--

CREATE TABLE IF NOT EXISTS `clt_sendcode` (
  `id` int(11) unsigned NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `sendcode` varchar(20) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `types` tinyint(1) unsigned DEFAULT '0' COMMENT '0=注册,1=增加银行卡,2=修改登陆密码,3=修改二级密码'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_sms_queue`
--

CREATE TABLE IF NOT EXISTS `clt_sms_queue` (
  `id` int(11) NOT NULL,
  `mobile` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `template` int(255) DEFAULT NULL,
  `smsType` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_time` int(11) DEFAULT '0' COMMENT '预约发送时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `clt_system`
--

CREATE TABLE IF NOT EXISTS `clt_system` (
  `id` int(36) unsigned NOT NULL,
  `name` char(36) NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(36) NOT NULL DEFAULT '' COMMENT '网址',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `key` varchar(200) NOT NULL COMMENT '关键字',
  `des` varchar(200) NOT NULL COMMENT '描述',
  `bah` varchar(50) DEFAULT NULL COMMENT '备案号',
  `copyright` varchar(30) DEFAULT NULL COMMENT 'copyright',
  `ads` varchar(120) DEFAULT NULL COMMENT '公司地址',
  `tel` varchar(15) DEFAULT NULL COMMENT '公司电话',
  `email` varchar(50) DEFAULT NULL COMMENT '公司邮箱',
  `logo` varchar(120) DEFAULT NULL COMMENT 'logo',
  `mobile` varchar(10) DEFAULT 'open' COMMENT '是否开启手机端 open 开启 close 关闭',
  `code` varchar(10) DEFAULT 'close' COMMENT '是否开启验证码',
  `wei_code` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_system`
--

INSERT INTO `clt_system` (`id`, `name`, `url`, `title`, `key`, `des`, `bah`, `copyright`, `ads`, `tel`, `email`, `logo`, `mobile`, `code`, `wei_code`, `qq`) VALUES
(1, '心连心', 'http://cs.ao98.com/', '南宁东盟软件', '南宁东盟软件', '南宁东盟软件', '陕ICP备15008093号-3', '2019-209', '广西南宁', '', '', '/uploads/20190316/220af798ac16281473e6e4edeea1907c.png', 'close', 'open', '/uploads/20190314/e2c54574013c60f5f5c33ba85988009a.jpg', '');

-- --------------------------------------------------------

--
-- 表的结构 `clt_system_config`
--

CREATE TABLE IF NOT EXISTS `clt_system_config` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `desc` int(11) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_system_config`
--

INSERT INTO `clt_system_config` (`id`, `title`, `name`, `value`, `desc`, `type`, `remark`) VALUES
(1, '手机号码能注册', 'register', '1', 0, 'match', '一个手机号码能注册账号'),
(2, '激活会员', 'jihuo', '0', 0, 'match', '激活会员所消耗的会员葫芦个数'),
(8, '领导奖设置', 'recommend_bonus', '8I5I3', 0, 'match', '1代|2代|3代|4代|5代   领导奖%'),
(9, '业绩奖', 'yeji', '1I3I5', 0, 'match', '主管%|经理%     业绩奖%  '),
(10, '订单超时', 'time_out', '2|2', 0, 'match', '打款超时（小时）|收款超时（小时）'),
(11, '自动封号', 'auto_lock', '100', 0, 'match', '审核后超过设定天数不排单自动封号'),
(14, '合作短信', 'sms_platform', 'H90603|3aee0a70|3EF7EBEE94B74B01B0069598545C7AF9', 0, 'match', '短信配置'),
(15, '短信签名', 'sign', '祈福香火', 0, 'match', '签名'),
(17, '系统开放时间', 'system_open_time', '8|24|0|非开放时间提示信息|系统数据结算中...', 0, 'match', '开始时间|结束时间|0正常，1系统任何时候都关闭|非开放时间提示信息|关闭系统提示语'),
(18, '是否开启自动挂卖', 'sellautomatic', '1', 0, 'match', '0 为不开启    1为开启自动挂卖'),
(20, '匹配时间段', 'match_time', '8|24|8', 0, 'match', '开始时间|结束时间|超时开始时间，在设定时间段内匹配将按照当前匹配时间计算超时，在非设定时间段内匹配则按照当天8点开始计算，超过则按明天8点，在匹配时间段内不可执行打款操作');

-- --------------------------------------------------------

--
-- 表的结构 `clt_system_history`
--

CREATE TABLE IF NOT EXISTS `clt_system_history` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `money` decimal(12,2) DEFAULT '0.00' COMMENT '交易金额',
  `surplus` decimal(12,2) DEFAULT NULL COMMENT '交易后剩余',
  `type` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `option` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_team`
--

CREATE TABLE IF NOT EXISTS `clt_team` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(120) NOT NULL DEFAULT '',
  `title_style` varchar(225) NOT NULL DEFAULT '',
  `thumb` varchar(225) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lang` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  `template` varchar(50) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_team`
--

INSERT INTO `clt_team` (`id`, `title`, `title_style`, `thumb`, `hits`, `status`, `userid`, `username`, `sort`, `createtime`, `updatetime`, `lang`, `catid`, `info`, `template`) VALUES
(1, '快乐的毛豆豆—前端工程师', 'color:rgb(57, 61, 73);font-weight:normal;', '/uploads/20180613/27f4cfe5854eb4cfdfd87399a60c7cbd.jpg', 0, 1, 1, 'admin', 0, 1499764958, 1528876606, 0, 7, '<p>2年设计、3年前端，从菜鸟到老手，从未停止追求细节的完美。注重细节，追求完美已成为习惯。</p>', NULL),
(2, '褫憷—软件工程师', 'color:rgb(57, 61, 73);font-weight:normal;', '/uploads/20180613/7d4aaaf4c86aac002184dace64cf179e.jpg', 1, 1, 1, 'admin', 0, 1499765015, 1528876594, 0, 7, '<p>5年开发、3年前端，不断的自我建设，来保持向上的状态。</p>', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `clt_transfer_accounts`
--

CREATE TABLE IF NOT EXISTS `clt_transfer_accounts` (
  `id` int(11) NOT NULL,
  `out_userid` int(11) DEFAULT NULL COMMENT '转出用户ID',
  `out_username` varchar(200) DEFAULT NULL COMMENT '转出用户名',
  `in_userid` int(11) DEFAULT NULL COMMENT '转入用户ID',
  `in_username` varchar(200) DEFAULT NULL COMMENT '转入用户名',
  `nums` decimal(12,2) DEFAULT NULL COMMENT '数量',
  `time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `clt_users`
--

CREATE TABLE IF NOT EXISTS `clt_users` (
  `id` int(11) NOT NULL COMMENT '表id',
  `username` varchar(50) NOT NULL COMMENT '第三方返回昵称',
  `email` varchar(60) DEFAULT '' COMMENT '邮件',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `paypwd` varchar(32) DEFAULT NULL COMMENT '支付密码',
  `sex` tinyint(1) unsigned DEFAULT '0' COMMENT '1 男 0 女',
  `birthday` int(11) DEFAULT '0' COMMENT '生日',
  `reg_time` int(10) unsigned DEFAULT '0' COMMENT '注册时间',
  `last_login` int(11) unsigned DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(15) DEFAULT '' COMMENT '最后登录ip',
  `qq` varchar(20) DEFAULT '' COMMENT 'QQ',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号码',
  `mobile_validated` tinyint(3) unsigned DEFAULT '0' COMMENT '是否验证手机',
  `oauth` varchar(10) DEFAULT '' COMMENT '第三方来源 wx weibo alipay',
  `openid` varchar(100) DEFAULT NULL COMMENT '第三方唯一标示',
  `unionid` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `province` int(6) DEFAULT '0' COMMENT '省份',
  `city` int(6) DEFAULT '0' COMMENT '市区',
  `district` int(6) DEFAULT '0' COMMENT '县',
  `email_validated` tinyint(1) unsigned DEFAULT '0' COMMENT '是否验证电子邮箱',
  `level` tinyint(1) DEFAULT '1' COMMENT '会员等级',
  `is_lock` tinyint(1) DEFAULT '0' COMMENT '是否被锁定冻结',
  `lock_time` int(1) DEFAULT '0' COMMENT '锁定时间',
  `token` varchar(64) DEFAULT '' COMMENT '用于app 授权类似于session_id',
  `sign` varchar(255) DEFAULT '' COMMENT '签名',
  `status` varchar(20) DEFAULT 'hide' COMMENT '登录状态',
  `re_id` int(11) DEFAULT NULL,
  `re_name` varchar(255) DEFAULT NULL,
  `re_path` text CHARACTER SET utf8mb4,
  `re_level` int(11) DEFAULT '0',
  `aixinzhongzi` decimal(12,2) DEFAULT '0.00' COMMENT '爱心种子',
  `aibi` decimal(12,2) DEFAULT '0.00' COMMENT '爱币',
  `static_wallet` decimal(12,2) DEFAULT '0.00' COMMENT '静态钱包',
  `dynamic_wallet` decimal(12,2) DEFAULT '0.00' COMMENT '动态钱包',
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_card` varchar(255) DEFAULT NULL,
  `IDcard` varchar(255) DEFAULT NULL,
  `wechat` varchar(255) DEFAULT NULL,
  `alipay` varchar(255) DEFAULT NULL,
  `examine_apply_time` int(11) DEFAULT '0' COMMENT '审核申请时间',
  `examine_agree_time` int(11) DEFAULT '0' COMMENT '审核时间',
  `examine` int(11) DEFAULT '0' COMMENT '0未审核，1申请中，2已审核',
  `active` int(11) DEFAULT '0' COMMENT '0未激活，1已激活',
  `realname` varchar(255) DEFAULT NULL,
  `currency_power` int(11) DEFAULT '0' COMMENT '1提现超级权限',
  `participate_order` int(11) DEFAULT '0' COMMENT '0未参与排单，1已参与排单',
  `last_buy_time` int(11) DEFAULT '0' COMMENT '最后的排单时间',
  `roll_check` int(11) DEFAULT '0' COMMENT '封号5天后团队上滚检测',
  `old_money` decimal(12,2) DEFAULT '0.00' COMMENT '旧系统静态钱包',
  `read_news` int(11) DEFAULT '0' COMMENT '0已阅读公告，1未阅读公告',
  `transfer_power` int(11) DEFAULT '0' COMMENT '1开启后转账不受限制',
  `error_login_time` int(11) DEFAULT '0' COMMENT '用于输错一定次数密码后限制登录',
  `error_count` int(11) DEFAULT '0' COMMENT '用于输错一定次数密码后限制登录',
  `buy_totlemoney` decimal(12,2) DEFAULT '0.00',
  `pgc` decimal(12,2) DEFAULT '0.00',
  `dynamic` decimal(12,2) DEFAULT '0.00' COMMENT '动态累计',
  `staticmoney` decimal(12,2) DEFAULT '0.00',
  `IDcardimg1` varchar(255) DEFAULT NULL,
  `IDcardimg2` varchar(255) DEFAULT NULL,
  `is_yuyue` tinyint(1) DEFAULT '0' COMMENT '0未预约过，1预约过'
) ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_users`
--

INSERT INTO `clt_users` (`id`, `username`, `email`, `password`, `paypwd`, `sex`, `birthday`, `reg_time`, `last_login`, `last_ip`, `qq`, `mobile`, `mobile_validated`, `oauth`, `openid`, `unionid`, `avatar`, `province`, `city`, `district`, `email_validated`, `level`, `is_lock`, `lock_time`, `token`, `sign`, `status`, `re_id`, `re_name`, `re_path`, `re_level`, `aixinzhongzi`, `aibi`, `static_wallet`, `dynamic_wallet`, `bank_name`, `bank_card`, `IDcard`, `wechat`, `alipay`, `examine_apply_time`, `examine_agree_time`, `examine`, `active`, `realname`, `currency_power`, `participate_order`, `last_buy_time`, `roll_check`, `old_money`, `read_news`, `transfer_power`, `error_login_time`, `error_count`, `buy_totlemoney`, `pgc`, `dynamic`, `staticmoney`, `IDcardimg1`, `IDcardimg2`, `is_yuyue`) VALUES
(715, '14776114977', '', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1566386631, 0, '', '', '14776114977', 0, '', NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, '6929520e-9585-4b41-b1f3-ea8d8cdf9bf6', '', 'hide', 76, '17717637115', ',1,19,21,31,76,', 5, '0.00', '99688.00', '0.00', '8397.00', NULL, NULL, '5108211950812121', NULL, NULL, 1566389005, 1566389019, 2, 1, 'wenqian', 0, 1, 1566396882, 0, '0.00', 0, 0, 0, 0, '0.00', '0.00', '0.00', '0.00', '', '', 0),
(716, '17717637116', '', 'dc483e80a7a0bd9ef71d8cf973673924', 'dc483e80a7a0bd9ef71d8cf973673924', 0, 0, 1566388538, 0, '', '', '17717637116', 0, '', NULL, NULL, NULL, 0, 0, 0, 0, 7, 0, 0, '1c0cc893-4889-43c3-b116-e589c78b61e9', '', 'hide', 715, '18408226900', ',1,19,21,31,76,715,', 6, '0.00', '241.00', '0.00', '8949.00', NULL, NULL, '342222199105036415', NULL, NULL, 1566388751, 1566388794, 2, 1, '王皮皮', 0, 1, 1566393874, 0, '0.00', 0, 0, 0, 0, '0.00', '0.00', '0.00', '0.00', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_user_level`
--

CREATE TABLE IF NOT EXISTS `clt_user_level` (
  `level_id` smallint(4) unsigned NOT NULL COMMENT '表id',
  `level_name` varchar(30) DEFAULT NULL COMMENT '头衔名称',
  `sort` int(3) DEFAULT '0' COMMENT '排序',
  `bomlimit` int(5) DEFAULT '0' COMMENT '积分下限',
  `toplimit` int(5) DEFAULT '0' COMMENT '积分上限',
  `dai` int(5) DEFAULT '0' COMMENT '代数'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `clt_user_level`
--

INSERT INTO `clt_user_level` (`level_id`, `level_name`, `sort`, `bomlimit`, `toplimit`, `dai`) VALUES
(1, '信众', 1, 10, 30, 10),
(2, '居士', 2, 15, 50, 10),
(3, '实习推广大使', 4, 10, 30, 3),
(4, '转正推广大使', 5, 30, 100, 5),
(5, '经理推广大使', 7, 2000, 25000, 50),
(6, '董事推广大使', 8, 5000, 50000, 100),
(7, '助理推广大使', 6, 50, 250, 8),
(12, '弟子', 3, 30, 60, 0),
(13, 'w ', 50, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `clt_user_match`
--

CREATE TABLE IF NOT EXISTS `clt_user_match` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `last_pay_time` int(11) DEFAULT '0' COMMENT '最后一次排单时间',
  `last_pay_money` decimal(12,2) DEFAULT '0.00' COMMENT '最后排单金额',
  `last_static_currency` int(11) DEFAULT '0' COMMENT '最后的现金币提现时间',
  `last_dynamic_currency` int(11) DEFAULT '0' COMMENT '最后的静态提现时间',
  `pay_number` int(11) DEFAULT '0' COMMENT '排单次数',
  `area` int(11) DEFAULT NULL COMMENT '排单区域',
  `last_finish_money` decimal(12,2) DEFAULT '0.00' COMMENT '最后一次交易完成的排单金额'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_auth`
--

CREATE TABLE IF NOT EXISTS `clt_wx_auth` (
  `id` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `authorizer_appid` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺的appid  授权之后不用刷新',
  `authorizer_refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺授权之后的刷新token，每月刷新',
  `authorizer_access_token` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺的公众号token，只有2小时',
  `func_info` varchar(1000) NOT NULL DEFAULT '' COMMENT '授权项目',
  `nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号昵称',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号头像url',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号原始账号',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号原始名称',
  `qrcode_url` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号二维码url',
  `auth_time` int(11) DEFAULT '0' COMMENT '授权时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='店铺(实例)微信公众账号授权';

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_config`
--

CREATE TABLE IF NOT EXISTS `clt_wx_config` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '1' COMMENT '实例ID',
  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项WCHAT,QQ,WPAY,ALIPAY...',
  `value` varchar(1000) NOT NULL DEFAULT '' COMMENT '配置值json',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启用 1启用 0不启用',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='第三方配置表';

--
-- 转存表中的数据 `clt_wx_config`
--

INSERT INTO `clt_wx_config` (`id`, `instance_id`, `key`, `value`, `desc`, `is_use`, `create_time`, `modify_time`) VALUES
(1, 0, 'WCHAT', '{"APP_KEY":"","APP_SECRET":"","AUTHORIZE":"http:\\/\\/b2c1.01.niushop.com.cn","CALLBACK":"http:\\/\\/b2c1.01.niushop.com.cn\\/wap\\/Login\\/callback"}', '微信', 0, 1488350947, 1497105440),
(2, 0, 'SHOPWCHAT', '{"appid":"dfdsfdsf90bc7b7a","appsecret":"e5147ce07128asdfds222f628b5c3fe1af2ea5797","token":"dffdf"}', '', 1, 1497088090, 1528690160);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_default_replay`
--

CREATE TABLE IF NOT EXISTS `clt_wx_default_replay` (
  `id` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关注时回复';

--
-- 转存表中的数据 `clt_wx_default_replay`
--

INSERT INTO `clt_wx_default_replay` (`id`, `instance_id`, `reply_media_id`, `sort`, `create_time`, `modify_time`) VALUES
(3, 0, 4, 0, 1528695059, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_fans`
--

CREATE TABLE IF NOT EXISTS `clt_wx_fans` (
  `fans_id` int(11) NOT NULL COMMENT '粉丝ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员编号ID',
  `source_uid` int(11) NOT NULL DEFAULT '0' COMMENT '推广人uid',
  `instance_id` int(11) NOT NULL COMMENT '店铺ID',
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `nickname_decode` varchar(255) DEFAULT '',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` smallint(6) NOT NULL DEFAULT '1' COMMENT '性别',
  `language` varchar(20) NOT NULL DEFAULT '' COMMENT '用户语言',
  `country` varchar(60) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(255) NOT NULL DEFAULT '' COMMENT '行政区/县',
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户的标识，对当前公众号唯一     用户的唯一身份ID',
  `unionid` varchar(255) NOT NULL DEFAULT '' COMMENT '粉丝unionid',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝所在组id',
  `is_subscribe` bigint(1) NOT NULL DEFAULT '1' COMMENT '是否订阅',
  `memo` varchar(255) NOT NULL COMMENT '备注',
  `subscribe_date` int(11) DEFAULT '0' COMMENT '订阅时间',
  `unsubscribe_date` int(11) DEFAULT '0' COMMENT '解订阅时间',
  `update_date` int(11) DEFAULT '0' COMMENT '粉丝信息最后更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='微信公众号获取粉丝列表';

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_follow_replay`
--

CREATE TABLE IF NOT EXISTS `clt_wx_follow_replay` (
  `id` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关注时回复';

--
-- 转存表中的数据 `clt_wx_follow_replay`
--

INSERT INTO `clt_wx_follow_replay` (`id`, `instance_id`, `reply_media_id`, `sort`, `create_time`, `modify_time`) VALUES
(2, 0, 1, 0, 1528695047, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_key_replay`
--

CREATE TABLE IF NOT EXISTS `clt_wx_key_replay` (
  `id` int(10) unsigned NOT NULL,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `key` varchar(255) NOT NULL COMMENT '关键词',
  `match_type` tinyint(4) NOT NULL COMMENT '匹配类型1模糊匹配2全部匹配',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关键词回复';

--
-- 转存表中的数据 `clt_wx_key_replay`
--

INSERT INTO `clt_wx_key_replay` (`id`, `instance_id`, `key`, `match_type`, `reply_media_id`, `sort`, `create_time`, `modify_time`) VALUES
(2, 0, '你好', 1, 3, 0, 1528696514, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_media`
--

CREATE TABLE IF NOT EXISTS `clt_wx_media` (
  `media_id` int(11) unsigned NOT NULL COMMENT '图文消息id',
  `title` varchar(100) DEFAULT NULL,
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '实例id店铺id',
  `type` varchar(255) NOT NULL DEFAULT '1' COMMENT '类型1文本(项表无内容) 2单图文 3多图文',
  `sort` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改日期'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170;

--
-- 转存表中的数据 `clt_wx_media`
--

INSERT INTO `clt_wx_media` (`media_id`, `title`, `instance_id`, `type`, `sort`, `create_time`, `modify_time`) VALUES
(1, '欢迎您来到CLTPHP官方公众号大世界！', 0, '1', 0, 1512551413, 0),
(2, '你好，欢迎来到CLTPHP的世界！', 0, '1', 0, 1512550726, 0),
(3, 'CLTPHP内容管理系统', 0, '2', 0, 1512550547, 0),
(4, 'CLTPHP内容管理系统5.2.2发布', 0, '3', 0, 1528694363, 0),
(5, 'CLTPHP操作开发手册已完全更新', 0, '2', 0, 1528694392, 0),
(6, '1111', 0, '1', 0, 1528694379, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_media_item`
--

CREATE TABLE IF NOT EXISTS `clt_wx_media_item` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `media_id` int(11) NOT NULL COMMENT '图文消息id',
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(50) NOT NULL COMMENT '作者',
  `cover` varchar(200) NOT NULL COMMENT '图文消息封面',
  `show_cover_pic` tinyint(4) NOT NULL DEFAULT '1' COMMENT '封面图片显示在正文中',
  `summary` text,
  `content` text NOT NULL COMMENT '正文',
  `content_source_url` varchar(200) NOT NULL DEFAULT '' COMMENT '图文消息的原文地址，即点击“阅读原文”后的URL',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '阅读次数'
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=712;

--
-- 转存表中的数据 `clt_wx_media_item`
--

INSERT INTO `clt_wx_media_item` (`id`, `media_id`, `title`, `author`, `cover`, `show_cover_pic`, `summary`, `content`, `content_source_url`, `sort`, `hits`) VALUES
(28, 3, 'CLTPHP内容管理系统', 'cltphp', '/uploads/20171206/6dfec00133ee42c5c33cea8ab0cfad8f.png', 1, 'CLTPHP内容管理系统，微信公众平台、APP移动应用设计、HTML5网站API定制开发。大型企业网站、个人博客论坛、手机网站定制开发。更高效、更快捷的进行定制开发。', '<p style="text-indent: 2em;"><span style="text-indent: 2em;">虽然世界上有成千上万的建站系统，但CLTPHP会告诉你，真正高效的建站系统是什么样的。</span><br/></p><p style="text-indent: 2em;"><br/></p><p style="text-indent: 2em;">CLTPHP采用了优美的layui框架，一面极简，一面丰盈。加上angular Js，让数据交互变得更为简洁直白。用最基础的代码，实现最强大的效果，让你欲罢不能！</p><p style="text-indent: 2em;"><br/></p><p style="text-indent: 2em;">CLTPHP采用的ThinkPHP5为基础框架，从而使得CLTPHP的拓展性变的极为强大。从模型构造到栏目建立，再到前台展示，一气呵成，网站后台一条龙式操作，让小白用户能快速掌握CLTPHP管理系统的核心操作，让小白开发者能更好的理解CLTPHP的核心构建价值。</p><p><br/></p>', 'http://www.cltphp.com/', 0, 6),
(29, 2, '你好，欢迎来到CLTPHP的世界！', '', '', 0, '', '', '', 0, 0),
(42, 1, '欢迎您来到CLTPHP官方公众号大世界！', '', '', 0, '', '', '', 0, 0),
(47, 4, 'CLTPHP内容管理系统5.2.2发布', 'chichu', '/uploads/20180611/5df2c8dabd33e0a0672dcb94b51d5ada.jpg', 1, '这是一篇多图文', '<h4 style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-weight: normal; font-stretch: inherit; font-size: 22px; line-height: inherit; font-family: ">CLTPHP5.2.2发布</h4><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: "><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; vertical-align: baseline; margin: 0px; padding: 0px;">修改bug若干</span></p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: "><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px;">下载地址：</span><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline; margin: 0px; padding: 0px;"><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px;"><a href="http://qiniu.cltphp.com/cltphp5.2.2.zip" target="_self" title="CLTPHP5.2.2" style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline; margin: 0px; padding: 0px; color: rgb(0, 176, 80); outline: 0px;"><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px; text-decoration: none;">CLTPHP5.2.2</span></a></span></span></p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px;"><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px;">补丁地址：</span><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px;"><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline; margin: 0px; padding: 0px; color: rgb(0, 176, 80); outline: 0px;"><span style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 24px; vertical-align: baseline; margin: 0px; padding: 0px; text-decoration: none;"><a href="http://qiniu.cltphp.com/CLTPHP5.2.1%E5%88%B05.2.2%E8%A1%A5%E4%B8%81.zip" target="_self" style="box-sizing: border-box; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline; margin: 0px; padding: 0px; color: rgb(0, 176, 80); outline: 0px;">CLTPHP5.2.1到5.2.2升级</a></span></span></span></p>', 'http://www.cltphp.com/newsInfo-44-5.html', 0, 0),
(48, 4, '给我们一点点时间 我们给你一个新突破', 'chichu', '/uploads/20171206/18fd882e982e07e7b35dac5b962ab393.jpg', 0, '给我们一点点时间 我们给你一个新突破', '<p><span style="color: rgb(102, 102, 102); font-family: ">说实话，最近这段时间我们太忙了</span><img src="http://img.baidu.com/hi/jx2/j_0016.gif"/><span style="color: rgb(102, 102, 102); font-family: ">，cltphp的开发，甚至可以说是搁浅了一段时间。不过，各位请耐心等待一下啊，给我们一点点时间，或许不止一点点，我们给你一个新突破。</span></p>', 'http://www.cltphp.com/newsInfo-45-5.html', 0, 0),
(49, 4, 'CLTPHP操作开发手册已完全更新', 'chichu', '/uploads/20171206/db19ac0c46a3ffd4ebf94028024d3036.jpg', 1, 'CLTPHP操作开发手册已完全更新，CLTPHP核心价值，尽在其中。', '<p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: ">CLTPHP操作开发手册已完全更新，CLTPHP核心价值，尽在其中。</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: ">喜欢的朋友可以购买参考</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: ">同时希望CLTPHP的爱好者，可以给我提出更多CLTPHP的不足之处，让CLTPHP更健康的成长。</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: ">手册地址：<a href="https://www.kancloud.cn/chichu/cltphp/" target="_self">https://www.kancloud.cn/chichu/cltphp/</a></p><p><br/></p>', 'http://www.cltphp.com/newsInfo-16-5.html', 0, 0),
(50, 6, '1111', '', '', 0, '', '', '', 0, 0),
(51, 5, 'CLTPHP操作开发手册已完全更新', 'chichu', '/uploads/20180611/12e57c01f2bd9172c8c26de45cb796a6.jpg', 0, 'CLTPHP操作开发手册已完全更新，CLTPHP核心价值，尽在其中。', '<p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; text-indent: 2em;">CLTPHP操作开发手册已完全更新，CLTPHP核心价值，尽在其中。</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; font-family: ">喜欢的朋友可以购买参考</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; text-indent: 2em;">同时希望CLTPHP的爱好者，可以给我提出更多CLTPHP的不足之处，让CLTPHP更健康的成长。</p><p style="box-sizing: border-box; border: 0px; font-variant-numeric: inherit; font-stretch: inherit; font-size: 14px; line-height: 24px; text-indent: 2em;">手册地址：https://www.kancloud.cn/chichu/cltphp/</p><p><br/></p>', 'https://www.kancloud.cn/chichu/cltphp', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_menu`
--

CREATE TABLE IF NOT EXISTS `clt_wx_menu` (
  `menu_id` int(11) NOT NULL COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `menu_name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `ico` varchar(32) NOT NULL DEFAULT '' COMMENT '菜图标单',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单',
  `menu_event_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1普通url 2 图文素材 3 功能',
  `media_id` int(11) NOT NULL DEFAULT '0' COMMENT '图文消息ID',
  `menu_event_url` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单url',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '触发数',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_date` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='微设置->微店菜单';

--
-- 转存表中的数据 `clt_wx_menu`
--

INSERT INTO `clt_wx_menu` (`menu_id`, `instance_id`, `menu_name`, `ico`, `pid`, `menu_event_type`, `media_id`, `menu_event_url`, `hits`, `sort`, `create_date`, `modify_date`) VALUES
(1, 0, '官网', '', 0, 2, 3, 'http://www.cltphp.com/', 0, 1, 1512442512, 0),
(2, 0, '手册', '', 0, 2, 5, 'http://www.cltphp.com/', 0, 2, 1512442543, 0),
(3, 0, '论坛', '', 0, 1, 4, 'http://bbs.sucaihuo.com/', 0, 3, 1512547727, 0);

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_user`
--

CREATE TABLE IF NOT EXISTS `clt_wx_user` (
  `id` int(11) NOT NULL COMMENT '表id',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `wxname` varchar(60) NOT NULL COMMENT '公众号名称',
  `aeskey` varchar(256) NOT NULL DEFAULT '' COMMENT 'aeskey',
  `encode` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'encode',
  `appid` varchar(50) NOT NULL DEFAULT '' COMMENT 'appid',
  `appsecret` varchar(50) NOT NULL DEFAULT '' COMMENT 'appsecret',
  `wxid` varchar(64) NOT NULL COMMENT '公众号原始ID',
  `weixin` char(64) NOT NULL COMMENT '微信号',
  `token` char(255) NOT NULL COMMENT 'token',
  `w_token` varchar(150) NOT NULL DEFAULT '' COMMENT '微信对接token',
  `create_time` int(11) NOT NULL COMMENT 'create_time',
  `updatetime` int(11) NOT NULL COMMENT 'updatetime',
  `tplcontentid` varchar(2) NOT NULL COMMENT '内容模版ID',
  `share_ticket` varchar(150) NOT NULL COMMENT '分享ticket',
  `share_dated` char(15) NOT NULL COMMENT 'share_dated',
  `authorizer_access_token` varchar(200) NOT NULL COMMENT 'authorizer_access_token',
  `authorizer_refresh_token` varchar(200) NOT NULL COMMENT 'authorizer_refresh_token',
  `authorizer_expires` char(10) NOT NULL COMMENT 'authorizer_expires',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `web_access_token` varchar(200) NOT NULL COMMENT '网页授权token',
  `web_refresh_token` varchar(200) NOT NULL COMMENT 'web_refresh_token',
  `web_expires` int(11) NOT NULL COMMENT '过期时间',
  `menu_config` text COMMENT '菜单',
  `wait_access` tinyint(1) DEFAULT '0' COMMENT '微信接入状态,0待接入1已接入',
  `concern` varchar(225) DEFAULT '' COMMENT '关注回复',
  `default` varchar(225) DEFAULT '' COMMENT '默认回复'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='微信公共帐号';

--
-- 转存表中的数据 `clt_wx_user`
--

INSERT INTO `clt_wx_user` (`id`, `uid`, `wxname`, `aeskey`, `encode`, `appid`, `appsecret`, `wxid`, `weixin`, `token`, `w_token`, `create_time`, `updatetime`, `tplcontentid`, `share_ticket`, `share_dated`, `authorizer_access_token`, `authorizer_refresh_token`, `authorizer_expires`, `type`, `web_access_token`, `web_refresh_token`, `web_expires`, `menu_config`, `wait_access`, `concern`, `default`) VALUES
(1, 0, 'CLTPHP', '', 0, 'wx08c8be078e00b88b', '2e6f2d97d60582f21111be7862d14ddc', 'gh_8aacbef4e497', 'chichu12345', 'sdfdsfdsfdsf', 'cltphp', 0, 0, '', '', '', '', '', '', 1, 'eY9W4LLdISpE3UtTfuodgz1HJdBYCMbzZWkiLEhF0Nzvzv2q2DtGIV5h7CPrc0Nd4_kJgKN_FdM3kNaCxfFC1wmu6JLnNoOrmMuy3FK2AhMDLCbAGAXFW', '', 1504242136, '0', 0, '欢迎来到CLTPHP！CLTPHP采用ThinkPHP5作为基础框架，同时采用Layui作为后台界面，使得CLTPHP适用与大型企业网站、个人博客论坛、企业网站、手机网站的定制开发。更高效、更快捷的进行定制开发一直是CLTPHP追求的价值。', '亲！您可以输入关键词来获取您想要知道的内容。（例：手册）');

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_user_msg`
--

CREATE TABLE IF NOT EXISTS `clt_wx_user_msg` (
  `msg_id` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL,
  `msg_type` varchar(255) NOT NULL,
  `content` text,
  `is_replay` int(11) NOT NULL DEFAULT '0' COMMENT '是否回复',
  `create_time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户消息表';

-- --------------------------------------------------------

--
-- 表的结构 `clt_wx_user_msg_replay`
--

CREATE TABLE IF NOT EXISTS `clt_wx_user_msg_replay` (
  `replay_id` int(10) unsigned NOT NULL,
  `msg_id` int(11) NOT NULL,
  `replay_uid` int(11) NOT NULL COMMENT '当前客服uid',
  `replay_type` varchar(255) NOT NULL,
  `content` text,
  `replay_time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户消息回复表';

-- --------------------------------------------------------

--
-- 表的结构 `clt_xfhistory`
--

CREATE TABLE IF NOT EXISTS `clt_xfhistory` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bid` int(11) NOT NULL,
  `busername` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `money` decimal(12,2) NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clt_ad`
--
ALTER TABLE `clt_ad`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `plug_ad_adtypeid` (`type_id`);

--
-- Indexes for table `clt_admin`
--
ALTER TABLE `clt_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `admin_username` (`username`);

--
-- Indexes for table `clt_ad_type`
--
ALTER TABLE `clt_ad_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `clt_appeal`
--
ALTER TABLE `clt_appeal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_article`
--
ALTER TABLE `clt_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`id`,`status`,`sort`),
  ADD KEY `catid` (`id`,`catid`,`status`),
  ADD KEY `listorder` (`id`,`catid`,`status`,`sort`);

--
-- Indexes for table `clt_auth_group`
--
ALTER TABLE `clt_auth_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `clt_auth_rule`
--
ALTER TABLE `clt_auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_bankreceivables`
--
ALTER TABLE `clt_bankreceivables`
  ADD PRIMARY KEY (`id`,`uid`);

--
-- Indexes for table `clt_category`
--
ALTER TABLE `clt_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentid` (`parentid`),
  ADD KEY `listorder` (`sort`);

--
-- Indexes for table `clt_chongzhi`
--
ALTER TABLE `clt_chongzhi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_config`
--
ALTER TABLE `clt_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_cucurbita`
--
ALTER TABLE `clt_cucurbita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_debris`
--
ALTER TABLE `clt_debris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_debris_type`
--
ALTER TABLE `clt_debris_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_donation`
--
ALTER TABLE `clt_donation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_dongjie`
--
ALTER TABLE `clt_dongjie`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `clt_download`
--
ALTER TABLE `clt_download`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`id`,`status`,`sort`),
  ADD KEY `catid` (`id`,`catid`,`status`),
  ADD KEY `listorder` (`id`,`catid`,`status`,`sort`);

--
-- Indexes for table `clt_feast`
--
ALTER TABLE `clt_feast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_feast_element`
--
ALTER TABLE `clt_feast_element`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_field`
--
ALTER TABLE `clt_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_history`
--
ALTER TABLE `clt_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING BTREE;

--
-- Indexes for table `clt_link`
--
ALTER TABLE `clt_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `clt_match`
--
ALTER TABLE `clt_match`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `clt_match2`
--
ALTER TABLE `clt_match2`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `clt_message`
--
ALTER TABLE `clt_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `clt_module`
--
ALTER TABLE `clt_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_oauth`
--
ALTER TABLE `clt_oauth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_page`
--
ALTER TABLE `clt_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_picture`
--
ALTER TABLE `clt_picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`id`,`status`,`sort`),
  ADD KEY `catid` (`id`,`catid`,`status`),
  ADD KEY `listorder` (`id`,`catid`,`status`,`sort`);

--
-- Indexes for table `clt_posid`
--
ALTER TABLE `clt_posid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_pp_msg`
--
ALTER TABLE `clt_pp_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_product`
--
ALTER TABLE `clt_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`id`,`status`,`sort`),
  ADD KEY `catid` (`id`,`catid`,`status`),
  ADD KEY `listorder` (`id`,`catid`,`status`,`sort`);

--
-- Indexes for table `clt_region`
--
ALTER TABLE `clt_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_role`
--
ALTER TABLE `clt_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `clt_role_user`
--
ALTER TABLE `clt_role_user`
  ADD KEY `group_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `clt_sendcode`
--
ALTER TABLE `clt_sendcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_sms_queue`
--
ALTER TABLE `clt_sms_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobile` (`mobile`) USING BTREE;

--
-- Indexes for table `clt_system`
--
ALTER TABLE `clt_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_system_config`
--
ALTER TABLE `clt_system_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_system_history`
--
ALTER TABLE `clt_system_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING BTREE;

--
-- Indexes for table `clt_team`
--
ALTER TABLE `clt_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_transfer_accounts`
--
ALTER TABLE `clt_transfer_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_users`
--
ALTER TABLE `clt_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `clt_user_level`
--
ALTER TABLE `clt_user_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `clt_user_match`
--
ALTER TABLE `clt_user_match`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE;

--
-- Indexes for table `clt_wx_auth`
--
ALTER TABLE `clt_wx_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_wx_config`
--
ALTER TABLE `clt_wx_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_wx_default_replay`
--
ALTER TABLE `clt_wx_default_replay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_wx_fans`
--
ALTER TABLE `clt_wx_fans`
  ADD PRIMARY KEY (`fans_id`),
  ADD KEY `IDX_sys_weixin_fans_openid` (`openid`),
  ADD KEY `IDX_sys_weixin_fans_unionid` (`unionid`);

--
-- Indexes for table `clt_wx_follow_replay`
--
ALTER TABLE `clt_wx_follow_replay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_wx_key_replay`
--
ALTER TABLE `clt_wx_key_replay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clt_wx_media`
--
ALTER TABLE `clt_wx_media`
  ADD PRIMARY KEY (`media_id`),
  ADD UNIQUE KEY `id` (`media_id`);

--
-- Indexes for table `clt_wx_media_item`
--
ALTER TABLE `clt_wx_media_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`media_id`);

--
-- Indexes for table `clt_wx_menu`
--
ALTER TABLE `clt_wx_menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `IDX_biz_shop_menu_orders` (`sort`),
  ADD KEY `IDX_biz_shop_menu_shopId` (`instance_id`);

--
-- Indexes for table `clt_wx_user`
--
ALTER TABLE `clt_wx_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `uid_2` (`uid`);

--
-- Indexes for table `clt_wx_user_msg`
--
ALTER TABLE `clt_wx_user_msg`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `clt_wx_user_msg_replay`
--
ALTER TABLE `clt_wx_user_msg_replay`
  ADD PRIMARY KEY (`replay_id`);

--
-- Indexes for table `clt_xfhistory`
--
ALTER TABLE `clt_xfhistory`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clt_ad`
--
ALTER TABLE `clt_ad`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `clt_admin`
--
ALTER TABLE `clt_admin`
  MODIFY `admin_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `clt_ad_type`
--
ALTER TABLE `clt_ad_type`
  MODIFY `type_id` tinyint(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `clt_appeal`
--
ALTER TABLE `clt_appeal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `clt_article`
--
ALTER TABLE `clt_article`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `clt_auth_group`
--
ALTER TABLE `clt_auth_group`
  MODIFY `group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '全新ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_auth_rule`
--
ALTER TABLE `clt_auth_rule`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=308;
--
-- AUTO_INCREMENT for table `clt_bankreceivables`
--
ALTER TABLE `clt_bankreceivables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_category`
--
ALTER TABLE `clt_category`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `clt_chongzhi`
--
ALTER TABLE `clt_chongzhi`
  MODIFY `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clt_config`
--
ALTER TABLE `clt_config`
  MODIFY `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `clt_cucurbita`
--
ALTER TABLE `clt_cucurbita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `clt_debris`
--
ALTER TABLE `clt_debris`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `clt_debris_type`
--
ALTER TABLE `clt_debris_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `clt_donation`
--
ALTER TABLE `clt_donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID';
--
-- AUTO_INCREMENT for table `clt_dongjie`
--
ALTER TABLE `clt_dongjie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_download`
--
ALTER TABLE `clt_download`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clt_feast`
--
ALTER TABLE `clt_feast`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '自增ID',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clt_feast_element`
--
ALTER TABLE `clt_feast_element`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '自增ID',AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `clt_field`
--
ALTER TABLE `clt_field`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `clt_history`
--
ALTER TABLE `clt_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `clt_link`
--
ALTER TABLE `clt_link`
  MODIFY `link_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `clt_match`
--
ALTER TABLE `clt_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clt_match2`
--
ALTER TABLE `clt_match2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_message`
--
ALTER TABLE `clt_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `clt_module`
--
ALTER TABLE `clt_module`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `clt_oauth`
--
ALTER TABLE `clt_oauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_page`
--
ALTER TABLE `clt_page`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `clt_picture`
--
ALTER TABLE `clt_picture`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `clt_posid`
--
ALTER TABLE `clt_posid`
  MODIFY `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clt_pp_msg`
--
ALTER TABLE `clt_pp_msg`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_product`
--
ALTER TABLE `clt_product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_region`
--
ALTER TABLE `clt_region`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_role`
--
ALTER TABLE `clt_role`
  MODIFY `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clt_sendcode`
--
ALTER TABLE `clt_sendcode`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clt_sms_queue`
--
ALTER TABLE `clt_sms_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_system_config`
--
ALTER TABLE `clt_system_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `clt_system_history`
--
ALTER TABLE `clt_system_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_team`
--
ALTER TABLE `clt_team`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_transfer_accounts`
--
ALTER TABLE `clt_transfer_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_users`
--
ALTER TABLE `clt_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表id',AUTO_INCREMENT=717;
--
-- AUTO_INCREMENT for table `clt_user_level`
--
ALTER TABLE `clt_user_level`
  MODIFY `level_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `clt_user_match`
--
ALTER TABLE `clt_user_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_wx_auth`
--
ALTER TABLE `clt_wx_auth`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_wx_config`
--
ALTER TABLE `clt_wx_config`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_wx_default_replay`
--
ALTER TABLE `clt_wx_default_replay`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clt_wx_fans`
--
ALTER TABLE `clt_wx_fans`
  MODIFY `fans_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '粉丝ID';
--
-- AUTO_INCREMENT for table `clt_wx_follow_replay`
--
ALTER TABLE `clt_wx_follow_replay`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_wx_key_replay`
--
ALTER TABLE `clt_wx_key_replay`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clt_wx_media`
--
ALTER TABLE `clt_wx_media`
  MODIFY `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图文消息id',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `clt_wx_media_item`
--
ALTER TABLE `clt_wx_media_item`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `clt_wx_menu`
--
ALTER TABLE `clt_wx_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clt_wx_user`
--
ALTER TABLE `clt_wx_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clt_wx_user_msg`
--
ALTER TABLE `clt_wx_user_msg`
  MODIFY `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_wx_user_msg_replay`
--
ALTER TABLE `clt_wx_user_msg_replay`
  MODIFY `replay_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clt_xfhistory`
--
ALTER TABLE `clt_xfhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
