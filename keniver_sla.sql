-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 03 月 02 日 13:39
-- 伺服器版本: 5.5.37-MariaDB
-- PHP 版本： 5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `keniver_sla`
--

-- --------------------------------------------------------

--
-- 資料表結構 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
`cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `teacher` int(11) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course`
--

INSERT INTO `course` (`cid`, `name`, `time`, `teacher`, `class`) VALUES
(1, '雞蛋糕', '["T3","T4"]', 4, 'MA101'),
(2, '司康餅', '["M3","M4","F5"]', 4, 'MA102'),
(3, '麻糬', '["F6", "F7"]', 3, 'MA201'),
(4, '天使蛋糕', '["W1","W3","F7","F8"]', 4, 'MA101'),
(5, '24小時Programer', '["R1","R2","R3","R4"]', 3, 'MA102');

-- --------------------------------------------------------

--
-- 資料表結構 `course_file`
--

CREATE TABLE IF NOT EXISTS `course_file` (
`cfid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `path` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course_file`
--

INSERT INTO `course_file` (`cfid`, `cid`, `path`, `name`) VALUES
(1, 1, '0001/building.png', '只是張圖'),
(2, 2, '0001/seo.pdf', '教你如何SEO');

-- --------------------------------------------------------

--
-- 資料表結構 `course_schedule`
--

CREATE TABLE IF NOT EXISTS `course_schedule` (
`csid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `d` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course_schedule`
--

INSERT INTO `course_schedule` (`csid`, `cid`, `y`, `m`, `d`, `text`) VALUES
(1, 1, 2015, 2, 18, '過年'),
(2, 3, 2015, 3, 15, ' 期中考'),
(3, 2, 2015, 1, 1, ' 跨年'),
(4, 1, 2015, 6, 1, ' 期末考');

-- --------------------------------------------------------

--
-- 資料表結構 `course_session`
--

CREATE TABLE IF NOT EXISTS `course_session` (
`csid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `ssid` int(11) NOT NULL,
  `rollcall` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course_session`
--

INSERT INTO `course_session` (`csid`, `cid`, `ssid`, `rollcall`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `course_textbook`
--

CREATE TABLE IF NOT EXISTS `course_textbook` (
`ctbid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `path` text NOT NULL,
  `file_list` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course_textbook`
--

INSERT INTO `course_textbook` (`ctbid`, `cid`, `path`, `file_list`, `name`) VALUES
(1, 1, '0001/crawler_detection', '["crawler detection - pre.001.jpg",\r\n"crawler detection - pre.002.jpg",\r\n"crawler detection - pre.003.jpg",\r\n"crawler detection - pre.004.jpg",\r\n"crawler detection - pre.005.jpg",\r\n"crawler detection - pre.006.jpg",\r\n"crawler detection - pre.007.jpg",\r\n"crawler detection - pre.008.jpg",\r\n"crawler detection - pre.009.jpg",\r\n"crawler detection - pre.010.jpg",\r\n"crawler detection - pre.011.jpg",\r\n"crawler detection - pre.012.jpg",\r\n"crawler detection - pre.013.jpg"]\r\n', '爬蟲大全'),
(2, 4, '0001/crawler_detection', '["crawler detection - pre.001.jpg",\r\n"crawler detection - pre.002.jpg",\r\n"crawler detection - pre.003.jpg",\r\n"crawler detection - pre.004.jpg",\r\n"crawler detection - pre.005.jpg",\r\n"crawler detection - pre.006.jpg",\r\n"crawler detection - pre.007.jpg",\r\n"crawler detection - pre.008.jpg",\r\n"crawler detection - pre.009.jpg",\r\n"crawler detection - pre.010.jpg",\r\n"crawler detection - pre.011.jpg",\r\n"crawler detection - pre.012.jpg",\r\n"crawler detection - pre.013.jpg"]\r\n', '爬蟲大大全');

-- --------------------------------------------------------

--
-- 資料表結構 `course_user`
--

CREATE TABLE IF NOT EXISTS `course_user` (
`cuid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `course_user`
--

INSERT INTO `course_user` (`cuid`, `cid`, `uid`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 1),
(5, 3, 2),
(6, 4, 1),
(7, 5, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `rollcall`
--

CREATE TABLE IF NOT EXISTS `rollcall` (
`rcid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `rollcall`
--

INSERT INTO `rollcall` (`rcid`, `cid`, `time`) VALUES
(1, 1, 123),
(2, 1, 456),
(3, 1, 789),
(4, 1, 123456);

-- --------------------------------------------------------

--
-- 資料表結構 `rollcall_record`
--

CREATE TABLE IF NOT EXISTS `rollcall_record` (
`rcrid` int(11) NOT NULL,
  `rcid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `rollcall_record`
--

INSERT INTO `rollcall_record` (`rcrid`, `rcid`, `uid`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 4, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`ssid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `textbook` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `session`
--

INSERT INTO `session` (`ssid`, `cid`, `textbook`, `page`, `date`) VALUES
(1, 1, 1, 5, 1424802619);

-- --------------------------------------------------------

--
-- 資料表結構 `ssid`
--

CREATE TABLE IF NOT EXISTS `ssid` (
`sid` int(11) NOT NULL,
  `ssid` varchar(255) NOT NULL,
  `bssid` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `ssid`
--

INSERT INTO `ssid` (`sid`, `ssid`, `bssid`, `place`, `position`) VALUES
(1, 'MA101', '00:E0:4C:81:96:D2', 'MA101', '[193,135]'),
(2, 'MA102', '00:E0:4C:81:96:D3', 'MA102', '[400,440]'),
(3, 'MA103', '00:E0:4C:81:96:C2', 'MA103', '[0,0]'),
(4, 'MA201', '00:E0:4C:81:96:C3', 'MA201', '[0,0]'),
(5, 'PG', '00:E0:4C:81:96:C1', 'PlayGround', '[0,0]'),
(6, 'Guest', '00:E0:4C:81:96:D1', '', '[200,460]');

-- --------------------------------------------------------

--
-- 資料表結構 `token`
--

CREATE TABLE IF NOT EXISTS `token` (
`tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `token`
--

INSERT INTO `token` (`tid`, `uid`, `token`) VALUES
(1, 1, '4ce85f5ec71b01e304474e63907349f1'),
(2, 2, '97ce7769f205887f468acebbfaa738bb');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`uid` int(11) NOT NULL,
  `level` enum('student','teacher','admin','') NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`uid`, `level`, `username`, `password`, `name`) VALUES
(1, 'student', 'magic_girl', '81dc9bdb52d04dc20036dbd8313ed055', '魔法少女'),
(2, 'student', 'magic_mama', '81dc9bdb52d04dc20036dbd8313ed055', '魔法媽媽'),
(3, 'teacher', 'super_24hr', '81dc9bdb52d04dc20036dbd8313ed055', '超級Programer'),
(4, 'teacher', 'holakiki', '81dc9bdb52d04dc20036dbd8313ed055', 'Holakiki');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`cid`);

--
-- 資料表索引 `course_file`
--
ALTER TABLE `course_file`
 ADD PRIMARY KEY (`cfid`);

--
-- 資料表索引 `course_schedule`
--
ALTER TABLE `course_schedule`
 ADD PRIMARY KEY (`csid`);

--
-- 資料表索引 `course_session`
--
ALTER TABLE `course_session`
 ADD PRIMARY KEY (`csid`);

--
-- 資料表索引 `course_textbook`
--
ALTER TABLE `course_textbook`
 ADD PRIMARY KEY (`ctbid`);

--
-- 資料表索引 `course_user`
--
ALTER TABLE `course_user`
 ADD PRIMARY KEY (`cuid`);

--
-- 資料表索引 `rollcall`
--
ALTER TABLE `rollcall`
 ADD PRIMARY KEY (`rcid`);

--
-- 資料表索引 `rollcall_record`
--
ALTER TABLE `rollcall_record`
 ADD PRIMARY KEY (`rcrid`);

--
-- 資料表索引 `session`
--
ALTER TABLE `session`
 ADD PRIMARY KEY (`ssid`);

--
-- 資料表索引 `ssid`
--
ALTER TABLE `ssid`
 ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `token`
--
ALTER TABLE `token`
 ADD PRIMARY KEY (`tid`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`uid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `course`
--
ALTER TABLE `course`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `course_file`
--
ALTER TABLE `course_file`
MODIFY `cfid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `course_schedule`
--
ALTER TABLE `course_schedule`
MODIFY `csid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `course_session`
--
ALTER TABLE `course_session`
MODIFY `csid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `course_textbook`
--
ALTER TABLE `course_textbook`
MODIFY `ctbid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `course_user`
--
ALTER TABLE `course_user`
MODIFY `cuid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `rollcall`
--
ALTER TABLE `rollcall`
MODIFY `rcid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `rollcall_record`
--
ALTER TABLE `rollcall_record`
MODIFY `rcrid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `session`
--
ALTER TABLE `session`
MODIFY `ssid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `ssid`
--
ALTER TABLE `ssid`
MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `token`
--
ALTER TABLE `token`
MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
