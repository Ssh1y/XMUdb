CREATE DATABASE IF NOT EXISTS `BLOG`;
USE `BLOG`;

CREATE TABLE IF NOT EXISTS `userinfo` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `gender` varchar(5),
  `intro`  text,
  `email`  char(30),
  `phone_number` char(11),
  `avatar` varchar(255) NULL DEFAULT 'upload/default/default.png',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `note` (
  `noteid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `wordcount`  int(11) NOT NULL,
  `comment_count` int(11) DEFAULT 0,
  `like_count` int(11) DEFAULT 0,
  PRIMARY KEY (`noteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `noteid` int(11) NOT NULL,
  `note_owner` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `like` (
  `likeid` int(11) NOT NULL AUTO_INCREMENT,
  `noteid` int(11) NOT NULL,
  `note_owner` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`likeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `album` (
  `photoid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `announcement` (
  `announcementid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`announcementid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `vote`(
  `voteid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`voteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `options`(
  `voteid` int(11) NOT NULL,
  `o_index` int(11) NOT NULL,
  `o_option` varchar(255) NOT NULL,
  `vcount` int(11) NOT NULL DEFAULT 0,
  CONSTRAINT `voteid_optionid_pk` PRIMARY KEY (`voteid`, `index`),
  CONSTRAINT `options_voteid_fk` FOREIGN KEY (`voteid`) REFERENCES `vote` (`voteid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 外键
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `userinfo` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`noteid`) REFERENCES `note` (`noteid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `userinfo` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`note_owner`) REFERENCES `blog`.`userinfo` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`noteid`) REFERENCES `note` (`noteid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `userinfo` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `userinfo` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 建立索引
ALTER TABLE `note`
  ADD INDEX `userid` (`userid`) USING BTREE;

ALTER TABLE `comment`
  ADD INDEX `noteid` (`noteid`) USING BTREE,
  ADD INDEX `userid` (`userid`) USING BTREE;

ALTER TABLE `like`
  ADD INDEX `noteid` (`noteid`) USING BTREE,
  ADD INDEX `userid` (`userid`) USING BTREE;

ALTER TABLE `album`
  ADD INDEX `userid` (`userid`) USING BTREE;

ALTER TABLE `announcement`
  ADD INDEX `created_at` (`created_at`) USING BTREE;

-- 创建默认用户
INSERT INTO `userinfo` (`userid`, `username`, `passwd`, `created_at`) VALUES (1, '陈伟鸿', 'e10adc3949ba59abbe56e057f20f883e', '2022-06-20 00:00:00');
INSERT INTO `userinfo` (`userid`, `username`, `passwd`, `created_at`) VALUES (2, '曹恒毅', 'e10adc3949ba59abbe56e057f20f883e', '2022-06-20 00:00:00');


-- 创建默认笔记
INSERT INTO `note` (`noteid`, `title`, `content`, `userid`, `created_at`, `wordcount`) VALUES (1, '梦想，最好把它挂在嘴边上', '我发现自己唱歌很好听是在一个萧瑟的黄昏，我走在下班回家的路上。走过一个地下通道时，我突然感觉很累，有些眩晕，于是靠边坐了下来。对面的墙上有一张很大的广告画，画面是碧海蓝天的海岛景色。“真美啊！”我盯着那幅画浮想联翩，嘴里不禁哼起了一首很喜欢的歌——“我要带你到处去飞翔，走遍世界各地去观赏，没有烦恼没有那悲伤，自由自在身心多开朗……”
突然，有个人弯腰在我身前放了十元钱，我一下子蒙了！没有反应过来，呆呆地看着他，他拍了拍我的肩膀说道：“哥们儿！唱得真不错！挺你！”我已记不清他的模样，只记得他的笑容很温暖。他转身离去，我呆呆地看着他的背影消失在通道的尽头。
我拿起那张钞票，上面似乎还留有他的体温。惊喜来得太突然，我还有些恍惚，但模模糊糊有个声音在我心头响起：“我唱歌真的不错，我可以靠唱歌养活自己。”
这样想着想着，我竟有些热血沸腾了，我再也不用忍受那枯燥乏味的工作了！我要做个流浪歌手，去远方自由自在地飞翔！
那一刻我的万丈豪情在地下通道里熊熊燃烧。我买了把吉他，虽然不会弹。我出发了，带着个模糊的梦想：唱着好听的歌，感动很多人，赚很多钱，享受生活。
流浪的过程很不堪，就像北京的天空一样烟尘滚滚，我确实变得很沧桑，残酷的现实让我明白：能给钱的人都是菩萨转世，能给十元钱的人是佛祖再生。
我每天都在操心吃什么住哪里，我很忧郁，这很符合流浪歌手的气质。我也曾试图去酒吧唱歌，那儿给的钱比较多，可他们说我身上的味儿太大，正常地球人都接受不了。
后来我最大的梦想是：有一个带网络带电脑的免费的房间，有一个干净的带热水器的厕所，当然最重要的是免费供应一日三餐，而且有鱼有肉有酒。每个孤寂难当的夜里，我都会想起这个梦。
这时候我总算明白了梦想的作用，就是当我躺在冰冷的水泥地上饥寒交迫时，它可以让我感觉好受点儿。不用为我感到伤悲，命运再次告诉我们：有梦想就会有奇迹，不管你的梦想再怎么卑微。
有一天有一个人找到了我，他说要让我参加一个电视节目——《歌唱梦想秀》。此时，我很庆幸自己有唱歌的天赋，而不是其他例如跳舞、写作、弹琴什么的，电视节目制作人是这么告诉我的。
他真的是个好人，他的笑容很温暖很温暖。他让我讲讲自己的经历。听完后，他撇了撇嘴，认为过于平淡，他提示道：“你就没有什么特殊经历吗？比如为了唱歌呕心沥血剖肝扒肺，比如有个姑娘抛弃一切与你海角天涯，比如受过非人的待遇备受蹂躏……”
我看着他，努力地回想，终究还是迷茫，说道：“没有啊，就是经常为吃饭睡觉操心。我已经一个多月没洗澡了，这个行不行？”他顿了顿，缓慢地略带迟疑地问道：“那你……的父母……有没有……什么……不幸的事情？”“没有，他们活得很好。”“那你的七大姑八大姨们呢？”
我埋头仔细想了想，道：“我三姨去年死于癌症。”他有点兴奋，忙问：“那她跟你关系如何？对你的歌唱事业有没有影响？”我苦恼地叹道：“唉！我就在三岁时见过她一面，那时候我刚学会打酱油。”
他看着我，很遗憾的眼神，叹息道：“可惜啊！可惜啊！”我疑惑地问：“咱不是歌唱梦想秀吗？我只要把歌唱好不就行了吗？”他换了同情的眼神看着我，无语。
为了弥补没有故事可讲的缺憾，我学会了唱几首英文歌，因为节目制作人说会唱歌的中国人不会唱英文歌显得不够档次，是没品位的表现。所以虽然我的英语很烂，但我还是用中文标注法学会了几首英文歌，可能确实我有唱歌的天赋，很多人听过后都称赞我唱出了伦敦郊区味儿。
好了！我已经做好所有准备，斗志昂扬。但是节目制作人拦住了我，说还差一点儿包装。
我对自己流浪歌手的形象还是很有自信的，多自然多正常啊，何必再包装？制作人笑道：“在娱乐圈，正常才是最大的不正常啊！”于是我就被包装成了这个模样——蘑菇头、络腮胡、白背心、花短裤再加一双人字拖。
制作人还告诉了我一个娱乐圈的黄金法则——不求最帅，但求最怪！制作人还指出我唱歌的一个大问题——太温柔。要嘶吼！要呐喊！噪起来！这样才对得起野兽派的造型。
另外制作人还告诉了我很多东西，比如该如何走上舞台、如何自我介绍、如何与评委互动、如何选歌、如何发声、如何表情等等。他真是个好人，我很感谢他。
在他的帮助下，我仿佛看到了自己光明远大的前程，不再风餐露宿，不再漂泊无依，跑车豪宅鲜衣靓妞都在向我招手。
加油吧！为了梦想！差点儿忘了这茬儿，节目制作人曾反复告诫我不要忘了提“梦想”，最好把它挂在嘴边，比唱歌还好听。“为了梦想，为了梦想……”我不停地念叨着，带着笑容走过通道，走上舞台，完美的亮相，完美的鞠躬，完美的自我介绍，完美的话筒，完美的前奏响起，然后完美地……靠！我他妈的怎么不会唱歌了？
', 1, '2022-06-20 00:00:00', 3500);

