-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2016 at 09:10 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kangu-product`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advert`
--

CREATE TABLE `tbl_advert` (
  `advert_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `advert_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `advert_price` int(2) NOT NULL,
  `advert_spots` int(2) NOT NULL,
  `advert_school` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advert_transport` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_advert`
--

INSERT INTO `tbl_advert` (`advert_id`, `fk_user_id`, `advert_description`, `advert_price`, `advert_spots`, `advert_school`, `advert_transport`) VALUES
(1, 1, 'Dag ouders! Ik ben Sanne, een 26 jarige zorgkundige die zo nu en dan wat uurtjes vrij heeft. Ik heb veel ervaring met kinderen, in het verleden heb ik gewerkt in een kinderopvang en een buitenschoolse opvang. Ook met pubers kan ik goed overweg. Ik ben een zachtaardig en lief persoon, maar ik sta wel op mijn strepen. Het uurloon vind ik heel moeilijk, daarom dat ik het liefst tot discussie over laat. Meestal vraag ik geen uurloon maar gewoon een oplet loon. Is het voor enkele uurtjes, dan vind ik 20 euro best, is het voor een lange avond, een hele middag, een ganse dag, dan kan daar wat bij komen.', 6, 2, 'Heilig-hartcollege', 'auto'),
(2, 1, 'Dag ouders! Ik ben Sanne, een 26 jarige zorgkundige die zo nu en dan wat uurtjes vrij heeft. Ik heb veel ervaring met kinderen, in het verleden heb ik gewerkt in een kinderopvang en een buitenschoolse opvang. Ook met pubers kan ik goed overweg. Ik ben een zachtaardig en lief persoon, maar ik sta wel op mijn strepen. Het uurloon vind ik heel moeilijk, daarom dat ik het liefst tot discussie over laat. Meestal vraag ik geen uurloon maar gewoon een oplet loon. Is het voor enkele uurtjes, dan vind ik 20 euro best, is het voor een lange avond, een hele middag, een ganse dag, dan kan daar wat bij komen.', 8, 3, 'Heilig-hartcollege', 'fiets');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advert_service`
--

CREATE TABLE `tbl_advert_service` (
  `advert_service` int(11) NOT NULL,
  `fk_advert_id` int(11) NOT NULL,
  `fk_service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_availability`
--

CREATE TABLE `tbl_availability` (
  `availability_id` int(11) NOT NULL,
  `fk_advert_id` int(11) NOT NULL,
  `availability_date` date NOT NULL,
  `availability_time_start` time NOT NULL,
  `availability_time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `booking_id` int(11) NOT NULL,
  `fk_advert_id` int(11) NOT NULL,
  `fk_booker_user_id` int(11) NOT NULL,
  `fk_renter_user_id` int(11) NOT NULL,
  `booking_number_spots` int(11) NOT NULL,
  `booking_price` int(11) NOT NULL,
  `booking_extra_information` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_child`
--

CREATE TABLE `tbl_child` (
  `child_id` int(11) NOT NULL,
  `child_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `child_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `child_age` int(3) NOT NULL,
  `child_school` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `child_class` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_facebook`
--

CREATE TABLE `tbl_facebook` (
  `facebook_id` int(11) NOT NULL,
  `fk_friend_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorite_advert`
--

CREATE TABLE `tbl_favorite_advert` (
  `favorite_advert_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_advert_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friend`
--

CREATE TABLE `tbl_friend` (
  `friend_id` int(11) NOT NULL,
  `friend_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friend_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `review_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `review_date` date NOT NULL,
  `review_rating` int(3) NOT NULL,
  `review_description` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE `tbl_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_availability` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_upvote`
--

CREATE TABLE `tbl_upvote` (
  `upvote_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_review_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_image_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_sex_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_age` int(3) NOT NULL,
  `user_adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_biography` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_facebook_id` int(30) NOT NULL,
  `user_home_number` int(11) NOT NULL,
  `user_mobile_number` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_image_path`, `user_firstname`, `user_lastname`, `user_sex_type`, `user_age`, `user_adress`, `user_city`, `user_biography`, `user_email`, `user_password`, `user_facebook_id`, `user_home_number`, `user_mobile_number`) VALUES
(1, '../assets/user-profile-images/maarten-van-loock.png', 'Maarten', 'Van Loock', 'Male', 22, 'Kleistraat 2', 'Heist-op-den-Berg', 'Hallo, ik ben maarten!', 'maartenphone@gmail.com', '$2y$10$vRYw8FUNuPpHlnoFms1UXOyOwsRCH6zHdomeD37GSkuYv2/ZVzEK.', 0, 477744162, 15246823);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_child`
--

CREATE TABLE `tbl_user_child` (
  `user_child_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_advert`
--
ALTER TABLE `tbl_advert`
  ADD PRIMARY KEY (`advert_id`);

--
-- Indexes for table `tbl_advert_service`
--
ALTER TABLE `tbl_advert_service`
  ADD PRIMARY KEY (`advert_service`);

--
-- Indexes for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  ADD PRIMARY KEY (`availability_id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `tbl_child`
--
ALTER TABLE `tbl_child`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `tbl_facebook`
--
ALTER TABLE `tbl_facebook`
  ADD PRIMARY KEY (`facebook_id`);

--
-- Indexes for table `tbl_favorite_advert`
--
ALTER TABLE `tbl_favorite_advert`
  ADD PRIMARY KEY (`favorite_advert_id`);

--
-- Indexes for table `tbl_friend`
--
ALTER TABLE `tbl_friend`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tbl_service`
--
ALTER TABLE `tbl_service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `tbl_upvote`
--
ALTER TABLE `tbl_upvote`
  ADD PRIMARY KEY (`upvote_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_child`
--
ALTER TABLE `tbl_user_child`
  ADD PRIMARY KEY (`user_child_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_advert`
--
ALTER TABLE `tbl_advert`
  MODIFY `advert_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_advert_service`
--
ALTER TABLE `tbl_advert_service`
  MODIFY `advert_service` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_child`
--
ALTER TABLE `tbl_child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_facebook`
--
ALTER TABLE `tbl_facebook`
  MODIFY `facebook_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_favorite_advert`
--
ALTER TABLE `tbl_favorite_advert`
  MODIFY `favorite_advert_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_friend`
--
ALTER TABLE `tbl_friend`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_upvote`
--
ALTER TABLE `tbl_upvote`
  MODIFY `upvote_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_user_child`
--
ALTER TABLE `tbl_user_child`
  MODIFY `user_child_id` int(11) NOT NULL AUTO_INCREMENT;