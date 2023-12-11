-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: 172.17.0.2    Database: platform
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_info`
--

DROP TABLE IF EXISTS `admin_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_info` (
  `username` varchar(8) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_info`
--

LOCK TABLES `admin_info` WRITE;
/*!40000 ALTER TABLE `admin_info` DISABLE KEYS */;
INSERT INTO `admin_info` VALUES ('admin','07d58687c2b9a13126a36ddac967bc2d');
/*!40000 ALTER TABLE `admin_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice_info`
--

DROP TABLE IF EXISTS `notice_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `notice` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice_info`
--

LOCK TABLES `notice_info` WRITE;
/*!40000 ALTER TABLE `notice_info` DISABLE KEYS */;
INSERT INTO `notice_info` VALUES (21,'恭喜曾小豪获得《easyweb》题目一血'),(22,'恭喜何振宇获得《easy_basego》题目一血'),(23,'恭喜曾小豪获得《flag在哪呢》题目一血'),(24,'《金砖大赛-网络安全应用-hex》提示已更新'),(25,'恭喜徐鑫杰获得《金砖大赛-网络安全应用-hex》题目一血'),(26,'恭喜曾森林获得《py_bypass》题目一血'),(27,'恭喜曾小豪获得《wifi流量》题目一血'),(28,'恭喜曾小豪获得《代码测试-1》题目一血'),(29,'恭喜曾小豪获得《代码测试-2》题目一血'),(30,'恭喜王玮伦获得《代码测试-3》题目一血');
/*!40000 ALTER TABLE `notice_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platform_user`
--

DROP TABLE IF EXISTS `platform_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `platform_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(8) NOT NULL,
  `login_name` varchar(16) NOT NULL,
  `login_pass` varchar(32) NOT NULL,
  `team_info` varchar(32) NOT NULL,
  `user_date` varchar(10) NOT NULL,
  `company` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platform_user`
--

LOCK TABLES `platform_user` WRITE;
/*!40000 ALTER TABLE `platform_user` DISABLE KEYS */;
INSERT INTO `platform_user` VALUES (43,'曾森林','曾森林','e10adc3949ba59abbe56e057f20f883e','曾森林','2023-10-13','JHXA'),(44,'万粤辉','万粤辉','e10adc3949ba59abbe56e057f20f883e','万粤辉','2023-10-13','JHXA'),(45,'曾小豪','曾小豪','e10adc3949ba59abbe56e057f20f883e','曾小豪','2023-10-13','JHXA'),(46,'何振宇','何振宇','e10adc3949ba59abbe56e057f20f883e','何振宇','2023-10-13','JHXA'),(47,'吴晓洋','吴晓洋','e10adc3949ba59abbe56e057f20f883e','吴晓洋','2023-10-13','JHXA'),(48,'肖伟鸿','肖伟鸿','e10adc3949ba59abbe56e057f20f883e','肖伟鸿','2023-10-13','JHXA'),(49,'曹京赣','曹京赣','e10adc3949ba59abbe56e057f20f883e','曹京赣','2023-10-13','JHXA'),(50,'刘晨旭','刘晨旭','e10adc3949ba59abbe56e057f20f883e','刘晨旭','2023-10-13','JHXA'),(51,'王玮伦','王玮伦','e10adc3949ba59abbe56e057f20f883e','王玮伦','2023-10-13','JHXA'),(52,'汤健','汤健','e10adc3949ba59abbe56e057f20f883e','汤健','2023-10-13','JHXA'),(53,'林杰','林杰','e10adc3949ba59abbe56e057f20f883e','林杰','2023-10-13','JHXA'),(54,'陈怡江','陈怡江','e10adc3949ba59abbe56e057f20f883e','陈怡江','2023-10-13','JHXA'),(55,'胡桂芳','胡桂芳','e10adc3949ba59abbe56e057f20f883e','胡桂芳','2023-10-13','JHXA'),(56,'赖丹','赖丹','e10adc3949ba59abbe56e057f20f883e','赖丹','2023-10-13','JHXA'),(57,'陈思琳','陈思琳','e10adc3949ba59abbe56e057f20f883e','陈思琳','2023-10-13','JHXA'),(58,'温桂珍','温桂珍','e10adc3949ba59abbe56e057f20f883e','温桂珍','2023-10-13','JHXA'),(59,'张盈','张盈','e10adc3949ba59abbe56e057f20f883e','张盈','2023-10-13','JHXA'),(60,'谢阳','谢阳','e10adc3949ba59abbe56e057f20f883e','谢阳','2023-10-13','JHXA'),(61,'黄美燕','黄美燕','e10adc3949ba59abbe56e057f20f883e','黄美燕','2023-10-13','JHXA'),(62,'李艳','李艳','e10adc3949ba59abbe56e057f20f883e','李艳','2023-10-13','JHXA'),(63,'曾群','曾群','e10adc3949ba59abbe56e057f20f883e','曾群','2023-10-13','JHXA'),(64,'周俊','周俊','e10adc3949ba59abbe56e057f20f883e','周俊','2023-10-13','JHXA'),(65,'黄盛林','黄盛林','e10adc3949ba59abbe56e057f20f883e','黄盛林','2023-10-13','JHXA'),(66,'周民瑶','周民瑶','e10adc3949ba59abbe56e057f20f883e','周民瑶','2023-10-13','JHXA'),(67,'test','test','098f6bcd4621d373cade4e832627b4f6','test','2023-10-13','test'),(68,'曾祥德','曾祥德','e10adc3949ba59abbe56e057f20f883e','曾祥德','2023-10-19','JHXA'),(69,'徐鑫杰','徐鑫杰','e10adc3949ba59abbe56e057f20f883e','徐鑫杰','2023-10-19','JHXA'),(70,'饶尉豪','饶尉豪','e10adc3949ba59abbe56e057f20f883e','饶尉豪','2023-10-19','JHXA'),(71,'龚大伟','龚大伟','e10adc3949ba59abbe56e057f20f883e','龚大伟','2023-10-19','JHXA'),(72,'李燕华','李燕华','e10adc3949ba59abbe56e057f20f883e','李燕华','2023-10-19','JHXA'),(73,'管秀浩','管秀浩','e10adc3949ba59abbe56e057f20f883e','管秀浩','2023-10-19','JHXA');
/*!40000 ALTER TABLE `platform_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score_info`
--

DROP TABLE IF EXISTS `score_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `score_info` (
  `team` varchar(32) NOT NULL,
  `sumbit_date` varchar(20) NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score_info`
--

LOCK TABLES `score_info` WRITE;
/*!40000 ALTER TABLE `score_info` DISABLE KEYS */;
INSERT INTO `score_info` VALUES ('曾森林','1697728023',1360),('万粤辉','1697767953',1800),('何振宇','1697718019',310),('吴晓洋','1697183079',0),('肖伟鸿','1697183079',0),('曹京赣','1697767935',1800),('刘晨旭','1697183079',0),('王玮伦','1697730935',1810),('汤健','1697717046',100),('林杰','1697183079',0),('陈怡江','1697183079',0),('胡桂芳','1697724748',500),('赖丹','1697183079',0),('陈思琳','1697183079',0),('温桂珍','1697183079',0),('张盈','1697183079',0),('谢阳','1697183079',0),('黄美燕','1697183079',0),('李艳','1697183079',0),('曾群','1697183080',0),('周俊','1697183080',0),('黄盛林','1697183080',0),('周民瑶','1697183080',0),('test','1697183259',0),('曾小豪','1697767860',1850),('曾祥德','1697715604',0),('徐鑫杰','1697730087',960),('饶尉豪','1697758733',850),('龚大伟','1697718507',600),('李燕华','1697726873',0),('管秀浩','1697727121',0);
/*!40000 ALTER TABLE `score_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_info`
--

DROP TABLE IF EXISTS `subject_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `subject_type` varchar(16) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_score` int NOT NULL,
  `subject_flag` varchar(100) NOT NULL,
  `subject_ip` varchar(64) NOT NULL,
  `subject_de` varchar(500) NOT NULL,
  `subject_file` varchar(100) NOT NULL,
  `subject_tips` varchar(500) NOT NULL,
  `subject_date` varchar(10) NOT NULL,
  `subject_public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_info`
--

LOCK TABLES `subject_info` WRITE;
/*!40000 ALTER TABLE `subject_info` DISABLE KEYS */;
INSERT INTO `subject_info` VALUES (32,'Pwn','代码测试-1',100,'flag{jocker?}','#','解压密码：四位数字','file/代码测试-1.zip','','2023-09-24',1),(33,'Pwn','代码测试-2',200,'flag{f1ag_h3re}','#','解压密码：四位数字','file/代码测试-2.zip','先进行base64解密并赋值到变量中，循环递加i还原flag，最后进行16进制解密','2023-09-24',1),(34,'Pwn','代码测试-3',250,'flag{1234567890}','#','解压密码：四位数字','file/代码测试-3.zip','','2023-09-24',1),(41,'Pwn','wifi流量',400,'flag{192.168.227.133}','#','黑客捕获到了一段wifi流量，请解密这段流量获取到受害者ip，将ip作为flag提交,flag{xxx}','file/longas-01.zip','#','2023-10-07',1),(42,'Web','你在套娃?',300,'flag{oooo0000oooo}','http://10.2.148.243:9000/','反复套娃？','#','来自某个网站请求头为referer','2023-10-08',0),(43,'Misc','好听的音乐',100,'flag{e5353bb7b57578bd4da1c898a8e2d767}','#','#','file/sound.zip','#','2023-10-08',1),(44,'Web','py_bypass',200,'flag{qwe-asd-zxc}','http://10.2.148.243:5000/','#','#','#','2023-10-10',1),(46,'Misc','easy_basego',200,'flag{easy_base_gogogo}','#','','file/easy_basego.zip','','2023-10-12',1),(47,'Misc','flag在哪呢',100,'flag{0987654321}','#','','file/flag在哪里呢.zip','','2023-10-12',1),(48,'Crypto','金砖大赛-网络安全应用-hex',200,'flag{f53ec36e714623290b2418550a5aeda9}','#','5n6q78685n33746q4r544r6p597n4q325n5463784r4459794q7n49354q4749794r4445344r545577595456685n5752684s58303q','#','16进制加密','2023-10-19',1),(49,'Web','easyweb',150,'flag{AXMAAA0098}','http://10.2.148.243:9000/','','#','','2023-10-19',1),(50,'Crypto','EasyRSA',400,'flag{WuHanJiaYou!!!!!!}','#','#','file/EasyRSA.zip','#','2023-10-19',1),(52,'Misc','ICS-风机流量',300,'flag{0bb8}','#','小明是一家新能源汽车制造厂的风机操作员，每天的工作是根据工厂的实时温度输入风机的转数，但由于机器的老化，风机最多能接受2000转/分钟的转速，在当天下班后，检修人员发现风机由于转速过快出现了故障，请根据维修人员捕获的流量包分析当天风机的转速达到了多少转才出现的故障，flag为发送高额转速的Data层的HEX数据。flag格式为:flag{}','file/02.zip','','2023-10-20',1);
/*!40000 ALTER TABLE `subject_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submit_info`
--

DROP TABLE IF EXISTS `submit_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submit_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `team` varchar(32) NOT NULL,
  `subject` varchar(32) NOT NULL,
  `sumbit_date` varchar(20) NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submit_info`
--

LOCK TABLES `submit_info` WRITE;
/*!40000 ALTER TABLE `submit_info` DISABLE KEYS */;
INSERT INTO `submit_info` VALUES (57,'曾小豪','easyweb','1697714564',150),(58,'何振宇','easy_basego','1697715124',200),(59,'曾小豪','flag在哪呢','1697715529',100),(60,'曹京赣','easyweb','1697715634',150),(61,'曾小豪','easy_basego','1697715668',200),(62,'曾森林','easyweb','1697715991',150),(63,'饶尉豪','easy_basego','1697716322',200),(64,'徐鑫杰','easy_basego','1697716452',200),(65,'徐鑫杰','easyweb','1697716672',150),(66,'龚大伟','easy_basego','1697716728',200),(67,'徐鑫杰','金砖大赛-网络安全应用-hex','1697716857',200),(68,'汤健','flag在哪呢','1697717046',100),(69,'曾森林','py_bypass','1697717124',200),(70,'曾森林','easy_basego','1697717178',200),(71,'饶尉豪','金砖大赛-网络安全应用-hex','1697717271',200),(72,'王玮伦','easyweb','1697717280',150),(73,'曾小豪','py_bypass','1697717285',200),(74,'饶尉豪','py_bypass','1697717347',200),(75,'徐鑫杰','py_bypass','1697717537',200),(76,'曹京赣','easy_basego','1697717606',200),(77,'龚大伟','金砖大赛-网络安全应用-hex','1697717703',200),(78,'万粤辉','easy_basego','1697717888',200),(79,'何振宇','flag在哪呢','1697718019',100),(80,'王玮伦','easy_basego','1697718261',200),(81,'龚大伟','py_bypass','1697718507',200),(82,'曹京赣','py_bypass','1697718694',200),(83,'曾森林','flag在哪呢','1697718929',100),(84,'万粤辉','flag在哪呢','1697718944',100),(85,'万粤辉','py_bypass','1697719163',200),(86,'曹京赣','flag在哪呢','1697719251',100),(87,'饶尉豪','easyweb','1697719803',150),(88,'曾小豪','金砖大赛-网络安全应用-hex','1697722520',200),(89,'万粤辉','金砖大赛-网络安全应用-hex','1697722530',200),(90,'王玮伦','金砖大赛-网络安全应用-hex','1697722545',200),(91,'胡桂芳','flag在哪呢','1697722840',100),(92,'曾森林','金砖大赛-网络安全应用-hex','1697722841',200),(93,'王玮伦','flag在哪呢','1697722867',100),(94,'曹京赣','金砖大赛-网络安全应用-hex','1697722916',200),(95,'王玮伦','py_bypass','1697722924',200),(96,'胡桂芳','easy_basego','1697723047',200),(97,'万粤辉','easyweb','1697723413',150),(98,'胡桂芳','py_bypass','1697724748',200),(99,'曾小豪','wifi流量','1697726534',400),(100,'万粤辉','wifi流量','1697726766',400),(101,'曹京赣','wifi流量','1697726801',400),(102,'曾森林','wifi流量','1697726807',400),(103,'王玮伦','wifi流量','1697727079',400),(104,'曾小豪','代码测试-1','1697727828',100),(105,'曾森林','代码测试-1','1697728023',100),(106,'万粤辉','代码测试-1','1697728512',100),(107,'曾小豪','代码测试-2','1697728571',200),(108,'徐鑫杰','代码测试-1','1697728767',100),(109,'万粤辉','代码测试-2','1697729137',200),(110,'王玮伦','代码测试-1','1697729185',100),(111,'曹京赣','代码测试-1','1697729204',100),(112,'曹京赣','代码测试-2','1697729216',200),(113,'王玮伦','代码测试-2','1697729232',200),(114,'徐鑫杰','flag在哪呢','1697730087',100),(115,'王玮伦','代码测试-3','1697730935',250),(116,'饶尉豪','代码测试-1','1697758733',100),(117,'曾小豪','代码测试-3','1697767860',250),(118,'曹京赣','代码测试-3','1697767935',250),(119,'万粤辉','代码测试-3','1697767953',250);
/*!40000 ALTER TABLE `submit_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-20  2:44:58
