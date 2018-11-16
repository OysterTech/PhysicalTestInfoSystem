CREATE DATABASE IF NOT EXISTS `physical_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `physical_test`;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(1) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` varchar(19) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `height` int(3) NOT NULL COMMENT '身高（单位cm）',
  `weight` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '体重（单位kg）***',
  `vital_capacity` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '肺活量（单位ml）***',
  `50m_race` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '50米跑（单位s）***',
  `stand_jump` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '立定跳远（单位cm）***',
  `sit_reach` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '坐位体前屈（单位cm）***',
  `long_race` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '长跑（M''SS）***',
  `situp` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '仰卧起坐（女，个数）***',
  `pull_up` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '引体向上（男，个数）***',
  `total_score` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0|0.0|不及格' COMMENT '总分***',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='***：格式为 成绩|评分|等级';

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_name` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_delete` int(1) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
