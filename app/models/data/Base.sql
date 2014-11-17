-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2014 at 12:42 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Base`
--

-- --------------------------------------------------------

--
-- Table structure for table `ExceptionLog`
--

DROP TABLE IF EXISTS `ExceptionLog`;
CREATE TABLE IF NOT EXISTS `ExceptionLog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object` text COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=87 ;

--
-- Dumping data for table `ExceptionLog`
--

INSERT INTO `ExceptionLog` (`id`, `message`, `location`, `object`, `dateTime`) VALUES
(13, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table ''Base.RequestLog'' doesn''t exist', 'app/lib/Custom/DB.php - line 99', 'exception ''PDOException'' with message ''SQLSTATE[42S02]: Base table or view not found: 1146 Table ''Base.RequestLog'' doesn''t exist'' in /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php:99\nStack trace:\n#0 [internal function]: PDOStatement->execute()\n#1 [internal function]: Phalcon\\Db\\Adapter\\Pdo->executePrepared(Object(PDOStatement), Array, NULL)\n#2 /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php(99): Phalcon\\Db\\Adapter\\Pdo->query(''select *?      ...'', Array)\n#3 /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php(122): DB->_query(''select *?      ...'', Array)\n#4 /home/alyd/workspace/phalconBase/app/models/data/BaseDataModel.php(28): DB->getAll(''select *?      ...'', Array, ''RequestLog'')\n#5 /home/alyd/workspace/phalconBase/app/models/data/RequestLog.php(32): BaseDataModel::_getAll(''select *?      ...'', Array, ''RequestLog'')\n#6 /home/alyd/workspace/phalconBase/tests/models/data/RequestLogTest.php(17): RequestLog::getAll()\n#7 [internal function]: RequestLogTest->testGetAll()\n#8 /usr/share/php/PHPUnit/Framework/TestCase.php(983): ReflectionMethod->invokeArgs(Object(RequestLogTest), Array)\n#9 /usr/share/php/PHPUnit/Framework/TestCase.php(838): PHPUnit_Framework_TestCase->runTest()\n#10 /usr/share/php/PHPUnit/Framework/TestResult.php(648): PHPUnit_Framework_TestCase->runBare()\n#11 /usr/share/php/PHPUnit/Framework/TestCase.php(783): PHPUnit_Framework_TestResult->run(Object(RequestLogTest))\n#12 /usr/share/php/PHPUnit/Framework/TestSuite.php(775): PHPUnit_Framework_TestCase->run(Object(PHPUnit_Framework_TestResult))\n#13 /usr/share/php/PHPUnit/Framework/TestSuite.php(745): PHPUnit_Framework_TestSuite->runTest(Object(RequestLogTest), Object(PHPUnit_Framework_TestResult))\n#14 /usr/share/php/PHPUnit/Framework/TestSuite.php(705): PHPUnit_Framework_TestSuite->run(Object(PHPUnit_Framework_TestResult), false, Array, Array, false)\n#15 /usr/share/php/PHPUnit/TextUI/TestRunner.php(349): PHPUnit_Framework_TestSuite->run(Object(PHPUnit_Framework_TestResult), false, Array, Array, false)\n#16 /usr/share/php/PHPUnit/TextUI/Command.php(176): PHPUnit_TextUI_TestRunner->doRun(Object(PHPUnit_Framework_TestSuite), Array)\n#17 /usr/share/php/PHPUnit/TextUI/Command.php(129): PHPUnit_TextUI_Command->run(Array, true)\n#18 /usr/bin/phpunit(46): PHPUnit_TextUI_Command::main()\n#19 {main}', '2014-11-17 12:27:03'),
(26, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table ''Base.User'' doesn''t exist', 'app/lib/Custom/DB.php - line 99', 'exception ''PDOException'' with message ''SQLSTATE[42S02]: Base table or view not found: 1146 Table ''Base.User'' doesn''t exist'' in /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php:99\nStack trace:\n#0 [internal function]: PDOStatement->execute()\n#1 [internal function]: Phalcon\\Db\\Adapter\\Pdo->executePrepared(Object(PDOStatement), Array, NULL)\n#2 /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php(99): Phalcon\\Db\\Adapter\\Pdo->query(''select *?      ...'', Array)\n#3 /home/alyd/workspace/phalconBase/app/lib/Custom/DB.php(122): DB->_query(''select *?      ...'', Array)\n#4 /home/alyd/workspace/phalconBase/app/models/data/BaseDataModel.php(28): DB->getAll(''select *?      ...'', Array, ''User'')\n#5 /home/alyd/workspace/phalconBase/app/models/data/User.php(33): BaseDataModel::_getAll(''select *?      ...'', Array, ''User'')\n#6 /home/alyd/workspace/phalconBase/tests/models/data/UserTest.php(17): User::getAll()\n#7 [internal function]: UserTest->testGetAll()\n#8 /usr/share/php/PHPUnit/Framework/TestCase.php(983): ReflectionMethod->invokeArgs(Object(UserTest), Array)\n#9 /usr/share/php/PHPUnit/Framework/TestCase.php(838): PHPUnit_Framework_TestCase->runTest()\n#10 /usr/share/php/PHPUnit/Framework/TestResult.php(648): PHPUnit_Framework_TestCase->runBare()\n#11 /usr/share/php/PHPUnit/Framework/TestCase.php(783): PHPUnit_Framework_TestResult->run(Object(UserTest))\n#12 /usr/share/php/PHPUnit/Framework/TestSuite.php(775): PHPUnit_Framework_TestCase->run(Object(PHPUnit_Framework_TestResult))\n#13 /usr/share/php/PHPUnit/Framework/TestSuite.php(745): PHPUnit_Framework_TestSuite->runTest(Object(UserTest), Object(PHPUnit_Framework_TestResult))\n#14 /usr/share/php/PHPUnit/Framework/TestSuite.php(705): PHPUnit_Framework_TestSuite->run(Object(PHPUnit_Framework_TestResult), false, Array, Array, false)\n#15 /usr/share/php/PHPUnit/TextUI/TestRunner.php(349): PHPUnit_Framework_TestSuite->run(Object(PHPUnit_Framework_TestResult), false, Array, Array, false)\n#16 /usr/share/php/PHPUnit/TextUI/Command.php(176): PHPUnit_TextUI_TestRunner->doRun(Object(PHPUnit_Framework_TestSuite), Array)\n#17 /usr/share/php/PHPUnit/TextUI/Command.php(129): PHPUnit_TextUI_Command->run(Array, true)\n#18 /usr/bin/phpunit(46): PHPUnit_TextUI_Command::main()\n#19 {main}', '2014-11-17 12:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `LoginAttempts`
--

DROP TABLE IF EXISTS `LoginAttempts`;
CREATE TABLE IF NOT EXISTS `LoginAttempts` (
  `attemptId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `userSessionId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`attemptId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `RequestLog`
--

DROP TABLE IF EXISTS `RequestLog`;
CREATE TABLE IF NOT EXISTS `RequestLog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `params` text COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` datetime NOT NULL,
  `ipAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userAgent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `userSessionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`ipAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` bigint(10) unsigned NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `username`, `hash`, `firstName`, `lastName`, `email`, `phone`, `address`, `city`, `state`, `zip`, `active`) VALUES
(1, 'aidan', '$2y$10$p0k2UGS15rG6EbMH6j8uqOA07RykokRUi2VDKuEB4euDyZPImbuIO', 'aidan', 'lydon', 'aidanlydon@gmail.com', 7072737789, '240 M St SW #E605', 'Washington', 'DC', '20024', 1);

-- --------------------------------------------------------

--
-- Table structure for table `UserSessions`
--

DROP TABLE IF EXISTS `UserSessions`;
CREATE TABLE IF NOT EXISTS `UserSessions` (
  `userSessionId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phpSessionId` varchar(32) CHARACTER SET utf8 NOT NULL,
  `loginDate` date NOT NULL,
  `loginTime` time NOT NULL,
  `logoutDate` date NOT NULL,
  `logoutTime` time NOT NULL,
  `userState` enum('logged in','logged out') CHARACTER SET utf8 NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`userSessionId`),
  KEY `userID` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
