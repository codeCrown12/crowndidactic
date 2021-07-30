-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 30, 2021 at 11:23 PM
-- Server version: 10.3.28-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crowndid_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'Active',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`ID`, `firstname`, `lastname`, `email`, `mobile`, `address`, `username`, `passkey`, `Status`, `date`) VALUES
(4, 'King', 'Jacob', 'kingsjacobfrancis@gmail.com', '+2349017259065', 'Emekuku street, D/Line Port Harcourt, Rivers state, Nigeria', 'kingxx24', '$2y$10$D4KfgN89PCpQZRg0eSwJ4OD3buTQcv17uygoa8x.gVpMpMrFWTo1e', 'Active', '2021-06-27'),
(5, 'Simon', 'Dickson', 'simonoche987@gmail.com', '+2348186745958', 'Lagos, Nigeria', 'simon', '$2y$10$OKg44KRkmnrQYWscHPRKnOGY/8daoGFb2qbQv.vT/KsiSVnZzusQa', 'Active', '2021-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'address goes here',
  `course` varchar(255) NOT NULL,
  `app_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`ID`, `school_email`, `firstname`, `lastname`, `email`, `mobile`, `dob`, `address`, `course`, `app_date`) VALUES
(47, 'kingsjacobfrancis@gmail.com', 'Foo', 'Bar', 'kingsjacobfrancis@gmail.com', '08037395645', '2021-07-07', '24 Rumuomasi Port Harcourt Nigeria', 'Android application development using Kotlin', '2021-07-21'),
(49, 'kingsjacobfrancis@gmail.com', 'sunday', 'fadeyi', 'drfabexfoundation363@gmail.com', '08160999989', '2021-07-23', 'deeper life high school', 'Web Development (PHP)', '2021-07-30');

-- --------------------------------------------------------

--
-- Table structure for table `basicusers`
--

CREATE TABLE `basicusers` (
  `NB` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT 'Set mobile number',
  `address` varchar(255) DEFAULT 'address goes here',
  `about` varchar(3600) DEFAULT 'You''re welcome to my school',
  `profileimg` varchar(255) DEFAULT 'uploads/defaultimg.png',
  `caption_text` varchar(255) NOT NULL DEFAULT 'We provide quality education for students',
  `backgroundColor` varchar(255) NOT NULL DEFAULT '#008080',
  `TextColor` varchar(255) NOT NULL DEFAULT '#ffffff',
  `package` varchar(40) NOT NULL DEFAULT 'Basic',
  `weburl` varchar(255) DEFAULT 'Website URL goes here',
  `facebook` varchar(255) NOT NULL DEFAULT 'facebook link',
  `instagram` varchar(255) NOT NULL DEFAULT 'instagram link',
  `twitter` varchar(255) NOT NULL DEFAULT 'twitter link',
  `linkedin` varchar(255) NOT NULL DEFAULT 'linkedIn link',
  `passkey` varchar(255) DEFAULT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Inactive',
  `applications` varchar(15) NOT NULL DEFAULT 'On',
  `temp_id` int(11) NOT NULL DEFAULT 1,
  `app_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basicusers`
--

INSERT INTO `basicusers` (`NB`, `Name`, `category`, `email`, `mobile`, `address`, `about`, `profileimg`, `caption_text`, `backgroundColor`, `TextColor`, `package`, `weburl`, `facebook`, `instagram`, `twitter`, `linkedin`, `passkey`, `Status`, `applications`, `temp_id`, `app_date`) VALUES
(19, 'Crowndidactic', 'Software Development', 'kingsjacobfrancis@gmail.com', '+2349017259065', 'Port Harcourt Rivers state, Nigeria', 'Here at crowndidactic software school, we help train students in software development skills such as web design (HTML, CSS, Javascript), Android application development (with Java and Kotlin), web development (Python, PHP) etc. We help polish our students and make them into Job/industry ready developers.', 'uploads/kingsjacobfrancis@gmail.com.png', 'We provide world class software development training', '#3a6ea1', '#ffffff', 'Basic', 'https://www.crowndidactic.com/', 'https://web.facebook.com/king.jacob.1238', 'instagram link', 'https://twitter.com/Kingjacobxx', 'linkedIn link', '$2y$10$jkMymbueBVGdMue4DoKUd.22I.osmB2NDM7xwGFwGJBLPeqpnUKJa', 'Active', 'On', 2, '2021-05-22'),
(63, 'ORIGINALS', 'Arts and Media', 'simonoche987@gmail.com', '09014938792', '24, Allen Avenue, LA', 'You~re welcome to my school. Just a simple about text information.', 'uploads/simonoche987@gmail.com.png', 'We provide quality education for students, and interested learners', '#04035e', '#8affad', 'Basic', 'Website URL goes here', 'www.facebook.com/originals', 'www.instagram.com/originals', 'www.twitter.com/originals', 'www.linkedIn.com/originals', '$2y$10$fejhAQbr/ncprjji.yXu7.R6pUIyIg/WyZU..mgCU7MsQKUoyhkXa', 'Active', 'On', 1, '2021-06-17'),
(64, 'Starheight International School', 'Primary School', 'amachreeminini1@gmail.com', '08169902887', 'NTA Road, Port Harcourt', 'You\'re welcome to my school', 'uploads/amachreeminini1@gmail.com.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$lkZQCWe3UZrT0EXdZrhF6.5hSXDpN0QL/Sz0Hv6/oYyQS.11yi92u', 'Active', 'On', 1, '2021-06-17'),
(82, 'Michael Enechi Art', 'Arts and Media', 'michaelenechi@gmail.com', 'Set mobile number', 'address goes here', 'You~re welcome to my school', 'uploads/michaelenechi@gmail.com.png', 'We provide quality education for students', '#ebebeb', '#171717', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$GHAQv9X14lT5UUu8VRbDG.ts37QpK0A8VFV3l.lI/LGWz3ay4GDUO', 'Active', 'On', 1, '2021-06-29'),
(85, 'Phos Crypto Arena', 'others', 'olamidephos10@gmail.com', 'Set mobile number', 'address goes here', 'You~re welcome to Phos crypto arena. It aims to provide crypto updates to people, educate people about the crypto space/world and cryptocurrencies..advice people on their investment plan choices..and also to drop updates of good cheap coins with a high percentage yield in return', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$j6uxBYCasPh70Q5I6uumNO9/IKfo/4K5I0vqVb4168Z/gDZwMn6dW', 'Active', 'On', 1, '2021-07-02'),
(86, 'Pathway Educational Consult', 'others', 'pathwayeduconsult@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$fr9MUfypwhcF/V0oYaRWEOEGHc/qjVkOJAgVKQM.POHVKUGEWuIju', 'Active', 'On', 1, '2021-07-02'),
(89, 'Daystar Academy', 'Music', 'seunomitola@gmail.com', 'Set mobile number', 'address goes here', 'You~re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$51lvRUQFmR3MAmTfW.n7H.xjGpeQwQBwFDQFchss95..4I2gHFuNa', 'Active', 'On', 1, '2021-07-03'),
(90, 'MIDE\'S TOUCH', 'Makeup', 'oladetounoyindamola2019@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$JhnV0sMwTv46/ctJoKjF7uIthrGW5tgbVYoYFG8d/u21smbeoms3O', 'Active', 'On', 1, '2021-07-03'),
(91, 'Destiny International Online School', 'Secondary School', 'destinyinternational04@gmail.com', '08111333963', 'address goes here', 'You~re welcome to my school', 'uploads/destinyinternational04@gmail.com.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'www.destinyinternational.com.ng', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$Auk4lcOUfFTsbUJVa0zIp.z9Io1vo/MpGFdDGsSUUnOdZOlSGBz4m', 'Active', 'On', 1, '2021-07-03'),
(94, 'Truth int school', 'Primary School', 'eugeneanderson04675@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$2CHoHZYeXqrvP2D5e/R9yORCZokf188lwFzo51y8wrBUnAClPrRgW', 'Active', 'On', 1, '2021-07-03'),
(95, 'God~s Royals Area', 'Religious studies', 'ogbonnapreshous@gmail.com', '07068583296', 'Everywhere', 'You are welcome to a place where we learn about God and build up as He wants us to.  rnWe learn to manifest His Glory and Fullness at all times and in all areas of our living. We Shine forth the Love of God and bring all people to conform to His Will.rnThis would cause us to live as God~s Royals here on Earth.', 'uploads/ogbonnapreshous@gmail.com.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$j6kqdpylNS0YFu1s/v/Hf.sBiV2FoCdnPuPxPNO//e8IXitR99tU6', 'Active', 'On', 1, '2021-07-03'),
(97, 'Ã€dÃ©Ã²bÃ artz ', 'Arts and Media', 'arimorodavid49@gmail.com', 'Set mobile number', 'address goes here', 'You~re welcome to my school', 'uploads/arimorodavid49@gmail.com.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$EehFwSlKGdTyi8oRxXgjZOfkyT3RPl9xqRyzP871xxkKtQn1u0GUi', 'Active', 'On', 1, '2021-07-04'),
(99, 'KIngs College', 'Fashion and Design', 'cryptoman818@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$8zCcsbaivVTIS6n9IH58XuKfh.TfWQ13d5tKMSCyTThNuavj3..Ee', 'Active', 'On', 1, '2021-07-07'),
(100, 'Presh Math World', 'others', 'ogbonnapreshous7@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$7SW6W./UCR97rD8MfD/NieuxZKDdXQKOsXLFUK6UuZkHt8xqg94wK', 'Inactive', 'On', 1, '2021-07-09'),
(101, 'Ahmed Abdullamid Secondary School', 'Secondary School', 'easyflame202@yahoo.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$dr2KwxP/WGFwx65WNyWc0.g.fvT0KZz/TmaYbou1PXe/VnZp3wKZO', 'Active', 'On', 1, '2021-07-10'),
(102, 'zendesk', 'Business', 'olowuseun4@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'LinkedIn link', '$2y$10$tRYxGYIa8pMeFBvR/xWXJepSVRocRqPcTYjQGnBsv0PzMLKg2XfVe', 'Active', 'On', 1, '2021-07-11'),
(103, 'Teacher', 'Music', 'you@gmail.com', 'Set mobile number', 'address goes here', 'You\'re welcome to my school', 'uploads/defaultimg.png', 'We provide quality education for students', '#008080', '#ffffff', 'Basic', 'Website URL goes here', 'facebook link', 'instagram link', 'twitter link', 'linkedIn link', '$2y$10$GEMoB7y5hr4uoHU9A0x/j.ULInR59BHAmju4WqmjzNZCeTkgb8nOC', 'Inactive', 'On', 1, '2021-07-29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `category` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `category`) VALUES
(1, 'Science and Technology'),
(2, 'Music'),
(3, 'Fashion and Design'),
(4, 'Language'),
(5, 'Software Development'),
(6, 'Business & Finance'),
(7, 'Fitness and health'),
(8, 'Secondary School'),
(9, 'Primary School'),
(11, 'others'),
(12, 'Catering/cooking'),
(13, 'Arts and Media'),
(22, 'Makeup'),
(23, 'Religious studies');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `course` varchar(1000) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `school_email`, `course`, `date`) VALUES
(13, 'kingsjacobfrancis@gmail.com', 'Web Development (PHP)', '2021-07-11'),
(14, 'kingsjacobfrancis@gmail.com', 'Android application development using Kotlin', '2021-07-11'),
(16, 'kingsjacobfrancis@gmail.com', 'Web design (HTML, CSS, Javascript)', '2021-07-12'),
(17, 'kingsjacobfrancis@gmail.com', 'Database management (MySQL, MongoDB)', '2021-07-12');

-- --------------------------------------------------------

--
-- Table structure for table `delete_reasons`
--

CREATE TABLE `delete_reasons` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faqs_table`
--

CREATE TABLE `faqs_table` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faqs_table`
--

INSERT INTO `faqs_table` (`ID`, `school_email`, `question`, `answer`) VALUES
(7, 'simon@gmail.com', 'How to reach us', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus laborum earum tenetur saepe cum perferendis ex vero, obcaecati officia, corrupti asperiores dolor nisi omnis vitae molestias eos sequi explicabo consequuntur.'),
(19, 'dicksonsimon850@gmail.com', 'How many semesters do you run per session', 'There are two semesters per session.'),
(34, 'simonoche987@gmail.com', 'How do I add pictures?', 'Very simple steps'),
(35, 'simonoche987@gmail.com', 'How old is your institution', 'About 12 years old'),
(36, 'kingsjacobfrancis@gmail.com', 'How to apply for lessons ?', 'You can apply to our training center by clicking on the get started page on this page and filling the form that is loaded properly.'),
(38, 'kingsjacobfrancis@gmail.com', 'What happens after I finish filling and submitting the application form ?', 'You will receive emails from us containing instructions on how to proceed with the classes.'),
(41, 'kingsjacobfrancis@gmail.com', 'How can I contact the school?', 'You can send us a message via the contact form on this page, or you can call the numbers displayed on the contact section on this page.'),
(42, 'kingsjacobfrancis@gmail.com', 'What are the fees and durations of the courses listed?', 'The fees and duration of the courses listed will be communicated to you once you finish filling the application form'),
(44, 'kingsjacobfrancis@gmail.com', 'How would the classes be taken ?', 'The classes will be virtual (through zoom). Meetings Links will be sent to all students via the crowndidactic platform. ');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`ID`, `school_email`, `title`, `message`, `date`, `Status`) VALUES
(5, 'kingsjacobfrancis@gmail.com', 'This is another test feedback', 'I am currently testing using a very fun browser', '2021-06-15 08:10 AM', 'Read'),
(6, 'kingsjacobfrancis@gmail.com', 'This is a feedback test', 'This is a testing message from one of the new accounts. I\'m currently testing the application. join me let\'s have some fun', '2021-06-15 19:17 PM', 'Read'),
(7, 'amachreeminini1@gmail.com', 'dnkconcoknscjosnanscjon', 'akc jk am scja nmx c mc ajc a cja cmacnk  jcjrncmas cjka a cja ca  amc ja csm cj rnrnksc  cj msc jm', '2021-06-17 13:44 PM', 'Read'),
(8, 'kingsjacobfrancis@gmail.com', 'Lorem ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2021-06-19 01:08 AM', 'Read'),
(9, 'kingsjacobfrancis@gmail.com', 'This is a feedback a new feed back', 'I know that the strength to completely achieve the dream for my company will be actualized. God bless King. CEO Crowndidactic', '2021-06-20 16:55 PM', 'Read'),
(11, 'ogbonnapreshous@gmail.com', 'Gratitude', 'Thank you for this platform.', '2021-07-03 22:59 PM', 'Read'),
(12, 'kingsjacobfrancis@gmail.com', 'This is a feedback test', 'I am testing to confirm if changes have been made', '2021-07-11 00:35 AM', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `ID` int(11) NOT NULL,
  `school_email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`ID`, `school_email`, `image`, `caption`) VALUES
(106, 'dicksonsimon850@gmail.com', 'gallery/dicksonsimon850@gmail.com2021-04-02603221162.png', 'What! a nice image'),
(122, 'amachreeminini1@gmail.com', 'gallery/amachreeminini1@gmail.com2021-06-17728391571.png', 'What! a nice image'),
(133, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-06-302108290007.png', 'What! a nice image'),
(134, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-06-30350785680.png', 'What! a nice image'),
(135, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-06-30268229792.png', 'What! a nice image'),
(139, 'simonoche987@gmail.com', 'gallery/simonoche987@gmail.com2021-07-01287422179.png', 'What! a nice image'),
(140, 'simonoche987@gmail.com', 'gallery/simonoche987@gmail.com2021-07-01741413596.png', 'What! a nice image'),
(141, 'simonoche987@gmail.com', 'gallery/simonoche987@gmail.com2021-07-01251238631.png', 'What! a nice image'),
(142, 'destinyinternational04@gmail.com', 'gallery/destinyinternational04@gmail.com2021-07-031426600296.png', 'What! a nice image'),
(143, 'arimorodavid49@gmail.com', 'gallery/arimorodavid49@gmail.com2021-07-041970629974.png', 'What! a nice image'),
(144, 'arimorodavid49@gmail.com', 'gallery/arimorodavid49@gmail.com2021-07-04602325584.png', 'What! a nice image'),
(145, 'arimorodavid49@gmail.com', 'gallery/arimorodavid49@gmail.com2021-07-041201377559.png', 'What! a nice image'),
(149, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-07-111319762537.png', 'What! a nice image'),
(150, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-07-11858969039.png', 'What! a nice image'),
(151, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-07-11103413213.png', 'What! a nice image'),
(152, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-07-111539664086.png', 'What! a nice image'),
(153, 'michaelenechi@gmail.com', 'gallery/michaelenechi@gmail.com2021-07-111223400748.png', 'What! a nice image'),
(156, 'kingsjacobfrancis@gmail.com', 'gallery/kingsjacobfrancis@gmail.com2021-07-25756680115.png', 'Nerd vibes'),
(158, 'kingsjacobfrancis@gmail.com', 'gallery/kingsjacobfrancis@gmail.com2021-07-27461228547.png', 'Google staff'),
(160, 'kingsjacobfrancis@gmail.com', 'gallery/kingsjacobfrancis@gmail.com2021-07-271091881818.png', 'man on a bike');

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE `site_info` (
  `ID` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`ID`, `address`, `mobile`, `email`, `facebook`, `instagram`, `linkedin`, `twitter`) VALUES
(1, 'Port Harcourt, Rivers State Nigeria', '+2349017259065, +2348186745958', 'info@crowndidactic.com', 'https://www.facebook.com/Crowndidactic/', 'instagram', 'https://www.linkedin.com/company/crowndidactic', 'https://twitter.com/CrownDidactic?s=09');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `folder_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `themable` varchar(255) NOT NULL,
  `free` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`ID`, `title`, `folder_name`, `image`, `themable`, `free`) VALUES
(1, 'Default theme', 'pageone', 'tempimages/pageone2021-07-241315891047.png', 'yes', 'yes'),
(2, 'Black and white', 'pagetwo', 'tempimages/pagetwo2021-07-24479090385.png', 'no', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `basicusers`
--
ALTER TABLE `basicusers`
  ADD PRIMARY KEY (`NB`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `delete_reasons`
--
ALTER TABLE `delete_reasons`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faqs_table`
--
ALTER TABLE `faqs_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `basicusers`
--
ALTER TABLE `basicusers`
  MODIFY `NB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `delete_reasons`
--
ALTER TABLE `delete_reasons`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faqs_table`
--
ALTER TABLE `faqs_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
