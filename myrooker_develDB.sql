-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2019 at 07:51 PM
-- Server version: 5.6.43
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myrooker_develDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `aid` int(11) NOT NULL,
  `fname` varchar(80) NOT NULL,
  `lname` varchar(80) NOT NULL,
  `level` int(11) NOT NULL,
  `active` enum('1','2') NOT NULL DEFAULT '2',
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`aid`, `fname`, `lname`, `level`, `active`, `date`) VALUES
(1, 'Rek', 'Ed', 1, '1', '2018-03-14 06:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `aplid` int(11) NOT NULL,
  `inid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `accepted` enum('0','1') NOT NULL DEFAULT '0',
  `code` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`aplid`, `inid`, `stid`, `accepted`, `code`, `date`) VALUES
(1, 1, 1, '1', 'VauxTash-20180507-351561', '2018-05-05 00:00:00'),
(2, 1, 2, '0', NULL, '2018-05-05 00:00:00'),
(4, 2, 1, '0', NULL, '2018-05-07 06:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `appusers`
--

CREATE TABLE `appusers` (
  `apid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `user_type` enum('s','c','a') NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `firebase` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appusers`
--

INSERT INTO `appusers` (`apid`, `userid`, `email`, `password`, `user_type`, `token`, `firebase`) VALUES
(1, 1, 'reked@live.com', 'e10adc3949ba59abbe56e057f20f883e', 's', '4f8dfeb2166ae73964daec689a5e1e7c', NULL),
(2, 1, 'rek@rook.com', 'fcea920f7412b5da7be0cf42b8c93759', 'a', '8abd581365f746e8e69952a4513744d9', NULL),
(3, 2, 'ebenezer.ferguson@outlook.com', '7bdfde34aed5bcd8153311febf846694', 's', '1f00305455d5e7a2ee991b766c335b44', NULL),
(4, 8, 'rocher.e7@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'c', 'be02dd6965210af31e4f5f8234e08ec0', ''),
(5, 3, 'mriq1997@gmail.com', '73c6ca0186fc6e2a23574b606c37d3b6', 'a', '73c6ca0186fc6e2a23574b606c37d3b6', NULL),
(6, 4, 'ebbyferguson.guav@gmail.com', '7bdfde34aed5bcd8153311febf846694', 's', '3ee85e03a04a9bf6a7b4aabefc3a2af0', NULL),
(7, 5, 'kofirook@gmail.com', '73c6ca0186fc6e2a23574b606c37d3b6', 's', '84d88a3ae49b25af9ab0b9b3a78e3cee', NULL),
(8, 8, 'testcompany@gmail.com', '73c6ca0186fc6e2a23574b606c37d3b6', 'c', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `cid` int(11) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `bio` text NOT NULL,
  `logo` varchar(80) DEFAULT NULL,
  `active` enum('0','1','2') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `passcode` varchar(100) DEFAULT NULL,
  `subscription` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`cid`, `cname`, `location`, `address`, `email`, `bio`, `logo`, `active`, `date`, `passcode`, `subscription`) VALUES
(1, 'MTN', 'Ring Road, Accra, Ghana', 'ghana', 'kofirook@mtn.com.gh', 'Telecommunication Company', 'mtn.jpg', '2', '2019-03-18 00:00:00', NULL, '2019-04-30 00:00:00'),
(2, 'ONE957 Inc', 'Accra', 'Airport West', NULL, 'Tech Company', 'rookComp1fbe843d6e9ddd3.jpg', '1', '2018-03-20 10:38:19', NULL, '2018-03-15 00:00:00'),
(3, 'ManUp', 'Accra', 'P.O. Box MD 545, Ministries', 'reked@live.com', 'Fantasy Premier League ', 'rookComp9aa85a1e47a7cc9.png', '2', '2018-03-20 23:40:42', '001a55ac618b4084f88aa24f4fc83fd2', '2018-03-18 00:00:00'),
(8, 'VauxTash', 'Accra', 'Independence Square', 'testcompany@gmail.com', 'Oil Company', 'company6cacb79c69.jpg', '1', '2019-03-18 00:56:21', '73c6ca0186fc6e2a23574b606c37d3b6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` char(2) NOT NULL,
  `country_name` varchar(80) NOT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `phonecode`) VALUES
(1, 'AF', 'Afghanistan', 93),
(2, 'AL', 'Albania', 355),
(3, 'DZ', 'Algeria', 213),
(4, 'AS', 'American Samoa', 1684),
(5, 'AD', 'Andorra', 376),
(6, 'AO', 'Angola', 244),
(7, 'AI', 'Anguilla', 1264),
(8, 'AQ', 'Antarctica', 0),
(9, 'AG', 'Antigua and Barbuda', 1268),
(10, 'AR', 'Argentina', 54),
(11, 'AM', 'Armenia', 374),
(12, 'AW', 'Aruba', 297),
(13, 'AU', 'Australia', 61),
(14, 'AT', 'Austria', 43),
(15, 'AZ', 'Azerbaijan', 994),
(16, 'BS', 'Bahamas', 1242),
(17, 'BH', 'Bahrain', 973),
(18, 'BD', 'Bangladesh', 880),
(19, 'BB', 'Barbados', 1246),
(20, 'BY', 'Belarus', 375),
(21, 'BE', 'Belgium', 32),
(22, 'BZ', 'Belize', 501),
(23, 'BJ', 'Benin', 229),
(24, 'BM', 'Bermuda', 1441),
(25, 'BT', 'Bhutan', 975),
(26, 'BO', 'Bolivia', 591),
(27, 'BA', 'Bosnia and Herzegovina', 387),
(28, 'BW', 'Botswana', 267),
(29, 'BV', 'Bouvet Island', 0),
(30, 'BR', 'Brazil', 55),
(31, 'IO', 'British Indian Ocean Territory', 246),
(32, 'BN', 'Brunei Darussalam', 673),
(33, 'BG', 'Bulgaria', 359),
(34, 'BF', 'Burkina Faso', 226),
(35, 'BI', 'Burundi', 257),
(36, 'KH', 'Cambodia', 855),
(37, 'CM', 'Cameroon', 237),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 238),
(40, 'KY', 'Cayman Islands', 1345),
(41, 'CF', 'Central African Republic', 236),
(42, 'TD', 'Chad', 235),
(43, 'CL', 'Chile', 56),
(44, 'CN', 'China', 86),
(45, 'CX', 'Christmas Island', 61),
(46, 'CC', 'Cocos (Keeling) Islands', 672),
(47, 'CO', 'Colombia', 57),
(48, 'KM', 'Comoros', 269),
(49, 'CG', 'Congo', 242),
(50, 'CD', 'Congo, the Democratic Republic of the', 242),
(51, 'CK', 'Cook Islands', 682),
(52, 'CR', 'Costa Rica', 506),
(53, 'CI', 'Cote D\'Ivoire', 225),
(54, 'HR', 'Croatia', 385),
(55, 'CU', 'Cuba', 53),
(56, 'CY', 'Cyprus', 357),
(57, 'CZ', 'Czech Republic', 420),
(58, 'DK', 'Denmark', 45),
(59, 'DJ', 'Djibouti', 253),
(60, 'DM', 'Dominica', 1767),
(61, 'DO', 'Dominican Republic', 1809),
(62, 'EC', 'Ecuador', 593),
(63, 'EG', 'Egypt', 20),
(64, 'SV', 'El Salvador', 503),
(65, 'GQ', 'Equatorial Guinea', 240),
(66, 'ER', 'Eritrea', 291),
(67, 'EE', 'Estonia', 372),
(68, 'ET', 'Ethiopia', 251),
(69, 'FK', 'Falkland Islands (Malvinas)', 500),
(70, 'FO', 'Faroe Islands', 298),
(71, 'FJ', 'Fiji', 679),
(72, 'FI', 'Finland', 358),
(73, 'FR', 'France', 33),
(74, 'GF', 'French Guiana', 594),
(75, 'PF', 'French Polynesia', 689),
(76, 'TF', 'French Southern Territories', 0),
(77, 'GA', 'Gabon', 241),
(78, 'GM', 'Gambia', 220),
(79, 'GE', 'Georgia', 995),
(80, 'DE', 'Germany', 49),
(81, 'GH', 'Ghana', 233),
(82, 'GI', 'Gibraltar', 350),
(83, 'GR', 'Greece', 30),
(84, 'GL', 'Greenland', 299),
(85, 'GD', 'Grenada', 1473),
(86, 'GP', 'Guadeloupe', 590),
(87, 'GU', 'Guam', 1671),
(88, 'GT', 'Guatemala', 502),
(89, 'GN', 'Guinea', 224),
(90, 'GW', 'Guinea-Bissau', 245),
(91, 'GY', 'Guyana', 592),
(92, 'HT', 'Haiti', 509),
(93, 'HM', 'Heard Island and Mcdonald Islands', 0),
(94, 'VA', 'Holy See (Vatican City State)', 39),
(95, 'HN', 'Honduras', 504),
(96, 'HK', 'Hong Kong', 852),
(97, 'HU', 'Hungary', 36),
(98, 'IS', 'Iceland', 354),
(99, 'IN', 'India', 91),
(100, 'ID', 'Indonesia', 62),
(101, 'IR', 'Iran, Islamic Republic of', 98),
(102, 'IQ', 'Iraq', 964),
(103, 'IE', 'Ireland', 353),
(104, 'IL', 'Israel', 972),
(105, 'IT', 'Italy', 39),
(106, 'JM', 'Jamaica', 1876),
(107, 'JP', 'Japan', 81),
(108, 'JO', 'Jordan', 962),
(109, 'KZ', 'Kazakhstan', 7),
(110, 'KE', 'Kenya', 254),
(111, 'KI', 'Kiribati', 686),
(112, 'KP', 'Korea, Democratic People\'s Republic of', 850),
(113, 'KR', 'Korea, Republic of', 82),
(114, 'KW', 'Kuwait', 965),
(115, 'KG', 'Kyrgyzstan', 996),
(116, 'LA', 'Lao People\'s Democratic Republic', 856),
(117, 'LV', 'Latvia', 371),
(118, 'LB', 'Lebanon', 961),
(119, 'LS', 'Lesotho', 266),
(120, 'LR', 'Liberia', 231),
(121, 'LY', 'Libyan Arab Jamahiriya', 218),
(122, 'LI', 'Liechtenstein', 423),
(123, 'LT', 'Lithuania', 370),
(124, 'LU', 'Luxembourg', 352),
(125, 'MO', 'Macao', 853),
(126, 'MK', 'Macedonia, the Former Yugoslav Republic of', 389),
(127, 'MG', 'Madagascar', 261),
(128, 'MW', 'Malawi', 265),
(129, 'MY', 'Malaysia', 60),
(130, 'MV', 'Maldives', 960),
(131, 'ML', 'Mali', 223),
(132, 'MT', 'Malta', 356),
(133, 'MH', 'Marshall Islands', 692),
(134, 'MQ', 'Martinique', 596),
(135, 'MR', 'Mauritania', 222),
(136, 'MU', 'Mauritius', 230),
(137, 'YT', 'Mayotte', 269),
(138, 'MX', 'Mexico', 52),
(139, 'FM', 'Micronesia, Federated States of', 691),
(140, 'MD', 'Moldova, Republic of', 373),
(141, 'MC', 'Monaco', 377),
(142, 'MN', 'Mongolia', 976),
(143, 'MS', 'Montserrat', 1664),
(144, 'MA', 'Morocco', 212),
(145, 'MZ', 'Mozambique', 258),
(146, 'MM', 'Myanmar', 95),
(147, 'NA', 'Namibia', 264),
(148, 'NR', 'Nauru', 674),
(149, 'NP', 'Nepal', 977),
(150, 'NL', 'Netherlands', 31),
(151, 'AN', 'Netherlands Antilles', 599),
(152, 'NC', 'New Caledonia', 687),
(153, 'NZ', 'New Zealand', 64),
(154, 'NI', 'Nicaragua', 505),
(155, 'NE', 'Niger', 227),
(156, 'NG', 'Nigeria', 234),
(157, 'NU', 'Niue', 683),
(158, 'NF', 'Norfolk Island', 672),
(159, 'MP', 'Northern Mariana Islands', 1670),
(160, 'NO', 'Norway', 47),
(161, 'OM', 'Oman', 968),
(162, 'PK', 'Pakistan', 92),
(163, 'PW', 'Palau', 680),
(164, 'PS', 'Palestinian Territory, Occupied', 970),
(165, 'PA', 'Panama', 507),
(166, 'PG', 'Papua New Guinea', 675),
(167, 'PY', 'Paraguay', 595),
(168, 'PE', 'Peru', 51),
(169, 'PH', 'Philippines', 63),
(170, 'PN', 'Pitcairn', 0),
(171, 'PL', 'Poland', 48),
(172, 'PT', 'Portugal', 351),
(173, 'PR', 'Puerto Rico', 1787),
(174, 'QA', 'Qatar', 974),
(175, 'RE', 'Reunion', 262),
(176, 'RO', 'Romania', 40),
(177, 'RU', 'Russian Federation', 70),
(178, 'RW', 'Rwanda', 250),
(179, 'SH', 'Saint Helena', 290),
(180, 'KN', 'Saint Kitts and Nevis', 1869),
(181, 'LC', 'Saint Lucia', 1758),
(182, 'PM', 'Saint Pierre and Miquelon', 508),
(183, 'VC', 'Saint Vincent and the Grenadines', 1784),
(184, 'WS', 'Samoa', 684),
(185, 'SM', 'San Marino', 378),
(186, 'ST', 'Sao Tome and Principe', 239),
(187, 'SA', 'Saudi Arabia', 966),
(188, 'SN', 'Senegal', 221),
(189, 'CS', 'Serbia and Montenegro', 381),
(190, 'SC', 'Seychelles', 248),
(191, 'SL', 'Sierra Leone', 232),
(192, 'SG', 'Singapore', 65),
(193, 'SK', 'Slovakia', 421),
(194, 'SI', 'Slovenia', 386),
(195, 'SB', 'Solomon Islands', 677),
(196, 'SO', 'Somalia', 252),
(197, 'ZA', 'South Africa', 27),
(198, 'GS', 'South Georgia and the South Sandwich Islands', 0),
(199, 'ES', 'Spain', 34),
(200, 'LK', 'Sri Lanka', 94),
(201, 'SD', 'Sudan', 249),
(202, 'SR', 'Suriname', 597),
(203, 'SJ', 'Svalbard and Jan Mayen', 47),
(204, 'SZ', 'Swaziland', 268),
(205, 'SE', 'Sweden', 46),
(206, 'CH', 'Switzerland', 41),
(207, 'SY', 'Syrian Arab Republic', 963),
(208, 'TW', 'Taiwan, Province of China', 886),
(209, 'TJ', 'Tajikistan', 992),
(210, 'TZ', 'Tanzania, United Republic of', 255),
(211, 'TH', 'Thailand', 66),
(212, 'TL', 'Timor-Leste', 670),
(213, 'TG', 'Togo', 228),
(214, 'TK', 'Tokelau', 690),
(215, 'TO', 'Tonga', 676),
(216, 'TT', 'Trinidad and Tobago', 1868),
(217, 'TN', 'Tunisia', 216),
(218, 'TR', 'Turkey', 90),
(219, 'TM', 'Turkmenistan', 7370),
(220, 'TC', 'Turks and Caicos Islands', 1649),
(221, 'TV', 'Tuvalu', 688),
(222, 'UG', 'Uganda', 256),
(223, 'UA', 'Ukraine', 380),
(224, 'AE', 'United Arab Emirates', 971),
(225, 'GB', 'United Kingdom', 44),
(226, 'US', 'United States', 1),
(227, 'UM', 'United States Minor Outlying Islands', 1),
(228, 'UY', 'Uruguay', 598),
(229, 'UZ', 'Uzbekistan', 998),
(230, 'VU', 'Vanuatu', 678),
(231, 'VE', 'Venezuela', 58),
(232, 'VN', 'Viet Nam', 84),
(233, 'VG', 'Virgin Islands, British', 1284),
(234, 'VI', 'Virgin Islands, U.s.', 1340),
(235, 'WF', 'Wallis and Futuna', 681),
(236, 'EH', 'Western Sahara', 212),
(237, 'YE', 'Yemen', 967),
(238, 'ZM', 'Zambia', 260),
(239, 'ZW', 'Zimbabwe', 263);

-- --------------------------------------------------------

--
-- Table structure for table `cv_education`
--

CREATE TABLE `cv_education` (
  `ceid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `school` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `field` varchar(100) NOT NULL,
  `finish` int(4) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_education`
--

INSERT INTO `cv_education` (`ceid`, `stid`, `school`, `location`, `degree`, `field`, `finish`, `date`) VALUES
(1, 1, 'Valley View University', 'Oyibi - Accra', 'Bachelor of Science', 'Computer Science', 2018, '2018-04-22 01:42:57'),
(3, 1, 'Pentecost Senior High School', 'Koforidua - Eastern Region', 'High School Diploma', 'General Science', 2011, '2018-05-25 09:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `cv_hobbies`
--

CREATE TABLE `cv_hobbies` (
  `chid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `hobbies` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_hobbies`
--

INSERT INTO `cv_hobbies` (`chid`, `stid`, `hobbies`, `date`) VALUES
(1, 1, 'fast all day with the codes man', '2018-04-22 03:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `cv_prof`
--

CREATE TABLE `cv_prof` (
  `cpid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `summary` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_prof`
--

INSERT INTO `cv_prof` (`cpid`, `stid`, `summary`, `date`) VALUES
(1, 1, 'Creative Developer with a 5-year background in building and implementing functional programs. Excellent problem-solving skills with a keen eye for detail.', '2018-05-25 09:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `cv_service`
--

CREATE TABLE `cv_service` (
  `csvid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `service` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_service`
--

INSERT INTO `cv_service` (`csvid`, `stid`, `service`, `date`) VALUES
(1, 1, 'i worked in the Ghana for like baby to mr man', '2018-04-22 02:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `cv_skills`
--

CREATE TABLE `cv_skills` (
  `csid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `skill` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_skills`
--

INSERT INTO `cv_skills` (`csid`, `stid`, `skill`, `date`) VALUES
(7, 1, 'Advanced problem solving skills', '2018-05-25 09:31:36'),
(5, 1, 'Data management', '2018-05-25 09:30:46'),
(6, 1, 'Team leadership', '2018-05-25 09:31:21'),
(8, 1, 'API design knowledge', '2018-05-25 09:31:49'),
(9, 1, 'Android Development, PHP and JavaScript experience', '2018-05-25 09:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `cv_work`
--

CREATE TABLE `cv_work` (
  `cwid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `employer` varchar(100) NOT NULL,
  `duties` text,
  `country` varchar(100) NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `current` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv_work`
--

INSERT INTO `cv_work` (`cwid`, `stid`, `job_title`, `employer`, `duties`, `country`, `start`, `end`, `current`, `date`) VALUES
(12, 1, 'Lead Developer', 'ONE957 Inc.', 'Built databases and table structures following n-tier architecture methodology for web applications.', 'Ghana', '2015-05-01', NULL, '1', '2018-05-25 09:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `inid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `starts` date NOT NULL,
  `ends` date NOT NULL,
  `created` datetime NOT NULL,
  `deleted` enum('0','1') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`inid`, `cid`, `title`, `description`, `starts`, `ends`, `created`, `deleted`) VALUES
(1, 8, 'Software Developers needed', 'We are looking for software developers to intern in out company. Developers should be conversant with C++, PHP and Java', '2018-05-10', '2018-05-08', '2018-05-05 00:00:00', '0'),
(2, 8, 'Testing Feature', 'testing this feature to know if it works well', '2018-05-08', '2018-05-09', '2018-05-07 02:08:48', '0');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `nid` int(11) NOT NULL,
  `apid` int(11) NOT NULL,
  `ntype` enum('t','i','a') NOT NULL,
  `note_id` varchar(100) NOT NULL,
  `note` varchar(200) NOT NULL,
  `seen` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`nid`, `apid`, `ntype`, `note_id`, `note`, `seen`, `date`) VALUES
(1, 1, 't', '9', '<b>Maka Beads</b> uploaded a new task.', '1', '2018-04-28 12:48:12'),
(5, 1, 'i', 'i=1', '<b>VauxTash</b> accepted you for an internship.', '1', '2018-05-07 07:02:30'),
(4, 4, 'i', 'i=2&st=rek', '<b>rek</b> applied for an internship.', '1', '2018-05-07 06:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_change_keys`
--

CREATE TABLE `password_change_keys` (
  `pckid` int(11) NOT NULL,
  `apid` int(11) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_code`
--

CREATE TABLE `phone_code` (
  `pcid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phone_code`
--

INSERT INTO `phone_code` (`pcid`, `uid`, `code`) VALUES
(4, 3, '70016'),
(5, 4, '93410');

-- --------------------------------------------------------

--
-- Table structure for table `solution`
--

CREATE TABLE `solution` (
  `sid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `summary` text,
  `file` varchar(100) DEFAULT NULL,
  `rate` int(11) DEFAULT '0',
  `submission` int(11) NOT NULL DEFAULT '0',
  `attempt` int(11) NOT NULL DEFAULT '0',
  `speed` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(100) DEFAULT NULL,
  `status` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `send_date` datetime DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solution`
--

INSERT INTO `solution` (`sid`, `stid`, `tid`, `summary`, `file`, `rate`, `submission`, `attempt`, `speed`, `remark`, `status`, `send_date`, `date`) VALUES
(1, 1, 1, 'testing', 'rookSol4064be59f84a656.docx', 3, 1, 1, 0, NULL, '2', '2018-03-11 11:52:30', '2018-03-10 11:10:44'),
(3, 1, 2, NULL, NULL, 0, 0, 0, 0, NULL, '3', NULL, '2018-03-26 23:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stid` int(11) NOT NULL,
  `fname` varchar(80) NOT NULL,
  `lname` varchar(80) NOT NULL,
  `gender` enum('f','m') NOT NULL,
  `dob` date NOT NULL,
  `school` varchar(100) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `active` enum('0','1','2') NOT NULL DEFAULT '0',
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal` varchar(100) DEFAULT NULL,
  `country` int(11) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `subscription` datetime DEFAULT NULL,
  `welcome` enum('0','1') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stid`, `fname`, `lname`, `gender`, `dob`, `school`, `program`, `year`, `username`, `active`, `city`, `state`, `postal`, `country`, `phone`, `avatar`, `date`, `subscription`, `welcome`) VALUES
(1, 'Roger', 'Edwin', 'm', '1992-09-20', 'Valley View University', 'Bsc. Computer Science', 2018, 'rek', '1', 'Accra', 'Greater Accra', '', 81, '233207150717', 'rookie63955f69db.png', '2018-02-13 01:43:29', '2018-06-15 00:00:00', '1'),
(2, 'Ebenezer', 'Ferguson', 'm', '1995-06-30', NULL, NULL, NULL, 'Fiifi', '0', NULL, NULL, NULL, 81, '233279308920', '', '2018-03-20 23:58:14', NULL, '0'),
(3, 'Delmwin', 'Baeka', 'm', '1997-02-20', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, 81, '233503878809', '', '2018-03-21 15:20:43', NULL, '0'),
(4, 'Bans', 'Richard', 'm', '1995-06-30', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 81, '233279308920', '', '2018-03-24 14:24:32', NULL, '0'),
(5, 'Kofi', 'Rook', 'm', '1997-02-20', 'University of Rook', 'BSc. Coding Like A Champ', 2050, 'kofirook', '1', NULL, NULL, NULL, 81, '233503878809', NULL, '2019-03-18 19:05:50', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `sbid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribe`
--

INSERT INTO `subscribe` (`sbid`, `stid`, `cid`, `date`) VALUES
(5, 1, 1, '2018-02-21 14:41:19'),
(11, 1, 8, '2018-04-04 23:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `tid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `summary` text NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `delete_task` enum('0','1') NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`tid`, `cid`, `title`, `summary`, `file`, `days`, `delete_task`, `date`) VALUES
(1, 8, 'Sample One', 'Testing the task summary to see if it works Testing the task summary to see if it works Testing the task summary to see if it works Testing the task summary to see if it works Testing the task summary to see if it works', '', 5, '1', '2018-02-21 00:00:00'),
(2, 8, 'Testing Feature', 'This is to test if the create task feature works ', 'rookTask767374d232f9320.docx', 5, '1', '2018-03-26 21:50:17'),
(9, 8, 'Notification test', 'Testing the notification feature', 'rookTask217564c1a48f1be.docx', 5, '1', '2018-04-28 12:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tid` int(11) NOT NULL,
  `wallet` varchar(30) NOT NULL,
  `wallet_type` enum('t','m') NOT NULL,
  `apid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `invoice_num` varchar(80) NOT NULL,
  `transaction_num` varchar(80) DEFAULT NULL,
  `status` enum('f','p','s') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`tid`, `wallet`, `wallet_type`, `apid`, `amount`, `invoice_num`, `transaction_num`, `status`, `date`) VALUES
(2, '0207150717', 'm', 1, '10.00', '204787105', '', 'f', '2018-04-23 01:16:39'),
(3, '0207150717', 'm', 1, '10.00', '204787108', NULL, 'p', '2018-04-23 01:18:06'),
(4, '0207150717', 'm', 1, '10.00', '204787109', NULL, 'p', '2018-04-23 01:18:44'),
(5, '0207150717', 'm', 1, '10.00', '204787119', NULL, 'p', '2018-04-23 01:25:02'),
(6, '0207150717', 'm', 1, '10.00', '204787125', NULL, 'p', '2018-04-23 01:26:22'),
(7, '0207150717', 'm', 1, '10.00', '204787155', NULL, 'p', '2018-04-23 01:44:11'),
(8, '0207150717', 'm', 1, '10.00', '204787157', NULL, 'p', '2018-04-23 01:47:47'),
(9, '0207150717', 'm', 1, '10.00', '204787159', NULL, 'p', '2018-04-23 01:49:29'),
(10, '0207150717', 'm', 1, '10.00', '204787173', NULL, 'p', '2018-04-23 02:07:56'),
(11, '0207150717', 'm', 1, '10.00', '204787184', NULL, 'p', '2018-04-23 02:13:27'),
(12, '0207150717', 'm', 1, '10.00', '204787186', NULL, 'p', '2018-04-23 02:38:37'),
(13, '0207150717', 'm', 1, '10.00', '204787187', NULL, 'p', '2018-04-23 02:39:36'),
(14, '0207150717', 'm', 1, '10.00', '204787188', NULL, 'f', '2018-04-23 02:40:59'),
(15, '0557936683', 'm', 1, '10.00', '204787190', NULL, 'f', '2018-04-23 02:45:42'),
(16, '0557936683', 'm', 1, '10.00', '204787191', NULL, 'f', '2018-04-23 02:49:46'),
(17, '0557936683', 'm', 1, '1.00', '204787194', ' MTN185ADD4B11B2EFE', 's', '2018-04-23 02:52:25'),
(18, '0557936683', 'm', 1, '1.00', '204787195', ' MTN185ADD4BB2B09ED', 's', '2018-04-23 02:55:27'),
(19, '0574017761', 't', 1, '1.00', 'PLUS201804235204682', NULL, 'f', '2018-04-23 02:57:05'),
(20, '0207150717', 'm', 1, '1.00', '204787225', NULL, 'f', '2018-04-23 04:15:19'),
(21, '0557936683', 'm', 1, '1.00', '204787226', ' MTN185ADD5E94646C9', 's', '2018-04-23 04:15:41'),
(22, '0207150717', 'm', 4, '1.00', '204787538', NULL, 'f', '2018-04-23 06:06:36'),
(23, '0557936683', 'm', 4, '1.00', '204787541', ' MTN185ADD789B63C6A', 's', '2018-04-23 06:07:02'),
(24, '0557936683', 'm', 4, '1.00', '204787632', ' MTN185ADD804FBA94D', 's', '2018-04-23 06:39:56'),
(25, '0557936683', 'm', 4, '1.00', '204787640', ' MTN185ADD80B2D3FD4', 's', '2018-04-23 06:41:34'),
(26, '0557936683', 'm', 4, '1.00', '204787646', ' MTN185ADD80E303604', 's', '2018-04-23 06:42:24'),
(27, '0557936683', 'm', 4, '1.00', '204787651', ' MTN185ADD8132E1401', 's', '2018-04-23 06:43:25'),
(28, '0557936683', 'm', 4, '1.00', '204787658', ' MTN185ADD81964DD88', 's', '2018-04-23 06:45:00'),
(29, '0557936683', 'm', 4, '1.00', '204787674', ' MTN185ADD82299219A', 's', '2018-04-23 06:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `watches`
--

CREATE TABLE `watches` (
  `wid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `stid` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `watches`
--

INSERT INTO `watches` (`wid`, `cid`, `stid`, `date`) VALUES
(3, 8, 1, '2018-04-17 12:52:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`aplid`);

--
-- Indexes for table `appusers`
--
ALTER TABLE `appusers`
  ADD PRIMARY KEY (`apid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `firebase` (`firebase`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `passcode` (`passcode`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cv_education`
--
ALTER TABLE `cv_education`
  ADD PRIMARY KEY (`ceid`);

--
-- Indexes for table `cv_hobbies`
--
ALTER TABLE `cv_hobbies`
  ADD PRIMARY KEY (`chid`);

--
-- Indexes for table `cv_prof`
--
ALTER TABLE `cv_prof`
  ADD PRIMARY KEY (`cpid`);

--
-- Indexes for table `cv_service`
--
ALTER TABLE `cv_service`
  ADD PRIMARY KEY (`csvid`);

--
-- Indexes for table `cv_skills`
--
ALTER TABLE `cv_skills`
  ADD PRIMARY KEY (`csid`);

--
-- Indexes for table `cv_work`
--
ALTER TABLE `cv_work`
  ADD PRIMARY KEY (`cwid`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`inid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `password_change_keys`
--
ALTER TABLE `password_change_keys`
  ADD PRIMARY KEY (`pckid`);

--
-- Indexes for table `phone_code`
--
ALTER TABLE `phone_code`
  ADD PRIMARY KEY (`pcid`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `solution`
--
ALTER TABLE `solution`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`sbid`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `invoice_num` (`invoice_num`),
  ADD UNIQUE KEY `transaction_num` (`transaction_num`);

--
-- Indexes for table `watches`
--
ALTER TABLE `watches`
  ADD PRIMARY KEY (`wid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `aplid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appusers`
--
ALTER TABLE `appusers`
  MODIFY `apid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `cv_education`
--
ALTER TABLE `cv_education`
  MODIFY `ceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cv_hobbies`
--
ALTER TABLE `cv_hobbies`
  MODIFY `chid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cv_prof`
--
ALTER TABLE `cv_prof`
  MODIFY `cpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cv_service`
--
ALTER TABLE `cv_service`
  MODIFY `csvid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cv_skills`
--
ALTER TABLE `cv_skills`
  MODIFY `csid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cv_work`
--
ALTER TABLE `cv_work`
  MODIFY `cwid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `inid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_change_keys`
--
ALTER TABLE `password_change_keys`
  MODIFY `pckid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_code`
--
ALTER TABLE `phone_code`
  MODIFY `pcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `solution`
--
ALTER TABLE `solution`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `sbid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `watches`
--
ALTER TABLE `watches`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
