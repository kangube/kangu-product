-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2016 at 10:44 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_advert`
--

INSERT INTO `tbl_advert` (`advert_id`, `fk_user_id`, `advert_description`, `advert_price`, `advert_spots`, `advert_school`, `advert_transport`) VALUES
(1, 1, 'Dag ouders! Ik ben Sanne, een 26 jarige zorgkundige die zo nu en dan wat uurtjes vrij heeft. Ik heb veel ervaring met kinderen, in het verleden heb ik gewerkt in een kinderopvang en een buitenschoolse opvang. Ook met pubers kan ik goed overweg. Ik ben een zachtaardig en lief persoon, maar ik sta wel op mijn strepen. Het uurloon vind ik heel moeilijk, daarom dat ik het liefst tot discussie over laat. Meestal vraag ik geen uurloon maar gewoon een oplet loon. Is het voor enkele uurtjes, dan vind ik 20 euro best, is het voor een lange avond, een hele middag, een ganse dag, dan kan daar wat bij komen.', 6, 2, 'Heilig-hartcollege', 'Auto'),
(2, 2, 'Hallo mama en papa zoekt u een ervaren met verantwoordelijks gevoel toffe kinderoppas? Dan bied ik mij graag aan! \r\nIk doe deze leuke job reeds 1 jaar en heb nog tijd over om jullie te helpen met voorschoolse opvang of tijdens de dag. Ik hoop snel iets van jullie te horen! Tot dan! Ainarra.', 8, 3, 'Heilig-hartcollege', 'Fiets'),
(3, 3, 'Ik ben een moeder van 4 kinderen die nu volwassen zijn, maar ze wonen niet bij mij en heeft altijd graag kinderopvang. Ik heb slechts een jaar ervaring, maar ik begrijp en ik hou van kinderen. Ik ben een warm en zorgzaam persoon en ik respecteer de aanwijzingen van de ouders. En boven alles heb ik gezond verstand.', 9, 1, 'Sint-jozefinstituut', 'Fiets'),
(4, 4, 'Hallo, Ik ben een spontane, lieve, enthousiaste kinderoppas. die heel betrouwbaar is en een groot verantwoordelijkheidsgevoel heeft. ik heb al meerdere jaren ervaring voorbeeld als de de ouders 2weken op reis waren heb ik ze voor hun gezorgd dag en nacht zelf oppas ik al meerdere jaren ik ben 19 word bijna 20 ben flexibel kan heel goed met kindjes omgaan vind het super om met de kindjes te knutselen gaan wandel Ik ben ook bereid om eventueel enkele huishoudelijke taken op mij te nemen. \r\nIk doe de job ontzettend graag en pas me aan aan de noden & wensen van de ouders. \r\nIk ben alle dagen beschikbaar mvg groet, Pieters.', 5, 2, 'Sint-augustijn', 'Auto'),
(5, 5, 'Hallo, Ik ben 18 jaar en woon in Antwerpen. Ik babysit al van mijn 15 jaar en dit met heel veel liefde en passie. Daarom studeer ik ook Vroedkunde aan Karel de Grote Hogeschool. Ik heb gewerkt in een naschoolse kinderopvang in Antwerpen op woensdagnamiddag als vrijwilliger. 2 jaar geleden heb ik in een pop up kinderopvang gewerkt. In de familie wordt ik ook altijd gevraagd om te babysitten op mijn nichtjes en neefjes. Ik doe niets liever dan voor kinderen te zorgen groot en klein. Het zou fijn zijn dit te kunnen combineren met mijn studies. \r\nHopelijk horen we elkaar snel! ', 6, 3, 'Regina assumpta', 'Auto'),
(6, 6, 'Ik ben erg ervaren met kinderen. Ik babysit vanaf mijn 16 jaar bij de gezinsbond. \r\nDaarnaast heb ik twee studies achter de rug in de sociale sector. Ik heb in mijn bachelor orthopedagogie gedaan, dus ik heb veel ervaring met kinderen en daarnaast ook met kinderen met bijzondere noden. \r\nNaast babysitten zou ik ook graag huishoudelijk werk doen.', 8, 2, 'Maria Boodschap', 'Auto'),
(7, 7, 'Ik ben erg ervaren met kinderen. Ik babysit vanaf mijn 16 jaar bij de gezinsbond. \r\nDaarnaast heb ik twee studies achter de rug in de sociale sector. Ik heb in mijn bachelor orthopedagogie gedaan, dus ik heb veel ervaring met kinderen en daarnaast ook met kinderen met bijzondere noden. \r\nNaast babysitten zou ik ook graag huishoudelijk werk doen.', 9, 1, 'Sint-jozefinstituut', 'Auto'),
(8, 8, 'Mijn naam is en ik ben momenteel 21 jaar. Ik babysit al een 5-tal jaar en ik heb enkele jaren gewerkt als monitrice op een speelplein. Ik heb ook 6 jaar turnles gegeven maar daar ben ik sinds dit jaar mee gestopt om me meer bezig te kunnen houden met mijn studies. \r\nVooral de jongste kindjes spreken mij enorm aan maar met de ouderen heb ik het tot nu toe ook altijd kunnen vinden. \r\nIk ben in het bezit van een rijbewijs en een auto dus bij het gezin thuis geraken en terug is geen probleem. Indien jullie dit graag willen, kan ik jullie ook altijd een aantal referenties bezorgen. \r\nIk hoop snel iets van jullie te horen! ', 6, 2, 'Ter Leie', 'Openbaar Vervoer'),
(9, 9, 'Ik heb in het verleden vooral voor mijn kleine neefjes en nichtjes gezorgd, maar nu ze wat ouder worden zoek ik een nieuw gezin waar ik kan instaan voor de zorg van de kinderen wanneer het nodig is. Ik ben een heel vrolijk persoon, en doe niets liever dan spelen en ravotte met kinderen. Als student in de bio-ingenieurswetenschappen kan ik zeker ook helpen met huiswerk indien nodig.', 7, 2, 'De Buurt', 'Auto'),
(10, 10, 'Binnenkort ga ik Gent verkennen door me er te settelen en een job te zoeken. \r\nNaast het vele vrijwilligerswerk met kinderen en het werken in de horeca, rondde ik mijn studies af als opvoeder/begeleider. Door het gevarieerde vrijwilligerswerk dat ik met plezier deed vanaf mijn vijftiende, leerde ik veel bij. Belangrijk vind ik dat kinderen naast de schooluren zich kunnen ontspannen in een familiale en liefdevolle omgeving. \r\nOok supporter ik de eigen ontwikkeling van het kind naar de weg van zelfstandigheid (meehelpen, laten ontdekken, huiswerk,...). Afhankelijk van de leeftijd, de mogelijkheden van het kind en in samenspraak met de ouders. Via deze kinderopvang wil ik mijn favoriete bezigheid verderzetten en samen met jullie, als gezin, nieuwe dingen ontdekken.', 5, 2, 'De cocon', 'Auto'),
(11, 11, 'Tijdens de week werk ik als leerkracht in het secundair aan het Stedelijk Lyceum Lamorinière. Graag wil ik na mijn uren een bijverdienste als kinderoppas, zo kan ik mijn schoolwerk en sociaal leven nog steeds goed combineren. \r\nIk ben afgestudeerd als leerkracht verzorgende wat maakt dat ik soms stagebegeleiding geef aan 6 en 7 kinderzorg. Kinderen van verscheidene leeftijden zijn dus geen enkel probleem. ', 6, 2, 'De Buurt', 'Auto'),
(12, 12, '\r\nIk ben afgestudeerd als maatschappelijk assistente en doe nu de banaba buitengewoon onderwijs. \r\nMijn droom is om met kinderen te werken. Ik heb meestal snel een vertrouwensband met kinderen. Ook ben ik graag creatief bezig met kinderen en vind ik het belangrijk om hen iets bij te brengen. ', 5, 1, 'De Buurt', 'Auto'),
(13, 13, 'Zelf heb ik ervaring met verschillende leeftijden, zowel binnen mijn familie als in mijn vrije tijd. De kinderen waar ik oppas, zowel nu als in het verleden, zijn tussen 2 en 14 jaar oud. Ik ben ook animator bij Speelplein het zonnetje in Zonhoven, ook hier heb ik ervaring met verschillende leeftijden. Ik heb verschillende stages gedaan met kinderen, zowel als maatschappelijk assistente en als leerkracht. Ook kinderen met specifieke behoeften schrikken me niet af. ', 7, 3, 'Maria Middelares', 'Auto');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_image_path`, `user_firstname`, `user_lastname`, `user_sex_type`, `user_age`, `user_adress`, `user_city`, `user_biography`, `user_email`, `user_password`, `user_facebook_id`, `user_home_number`, `user_mobile_number`) VALUES
(1, '../assets/user-profile-images/maarten-van-loock.png', 'Maarten', 'Van Loock', 'Male', 22, 'Kleistraat 2', 'Heist-op-den-Berg', 'Hallo, ik ben maarten!', 'maartenphone@gmail.com', '$2y$10$vRYw8FUNuPpHlnoFms1UXOyOwsRCH6zHdomeD37GSkuYv2/ZVzEK.', 0, 477744162, 15246823),
(2, '../assets/user-profile-images/ainarra-verboven.png', 'Ainarra', 'Verboven', 'Female', 34, 'Mechelsesteenweg 34', 'Heist-op-den-Berg', 'Hallo ik ben Ainarra!', 'ainarra.verboven@gmail.com', '$2y$10$xu.6utUNhq589d2PUXuN2uXN.oMHMGAr../JLWz3gSAZ3jJDTQ6aK', 0, 477567890, 15345678),
(3, '../assets/user-profile-images/anita-verhoeven.png', 'Anita', 'Verhoeven', 'Female', 31, 'Kasteelstraat 4', 'Heist-op-den-Berg', 'Hallo ik ben Anita!', 'anita.verhoeven@gmail.com', '$2y$10$ESpwc7x2aS5r6OTw0PnddO9N8TM.RwoS7/5RKcbs8Cp2jiBl8xIfy', 0, 477567890, 15345678),
(4, '../assets/user-profile-images/christel-janssens.png', 'Christel', 'Janssens', 'Female', 36, 'Bosstraat 15', 'Putte', 'Hallo ik ben Christel!', 'christel.janssens@gmail.com', '$2y$10$8MfX.FsawX.FPV60M7lDgejpNZ8bWO2Rs7YmYvl9m5s8BsEyqhwAa', 0, 477567890, 15345678),
(5, '../assets/user-profile-images/linda-deraeve.png', 'Linda', 'Deraeve', 'Female', 21, 'Zandstraat 34', 'Mechelen', 'Hallo ik ben Linda!', 'linda.deraeve@gmail.com', '$2y$10$8vEY8DaaIOaR6clF.YRomu/l65zADnbspus/KKdmd6.bBGQ.8L3nm', 0, 477567890, 15345678),
(6, '../assets/user-profile-images/marjan-dewaele.png', 'Marjan', 'Dewaele', 'Female', 41, 'Waterstraat 78', 'Lier', 'Hallo ik ben Marjan!', 'marjan.dewaele@gmail.com', '$2y$10$pkc6hLp7snKZsHxGmZoUaeJ26DsGPqh7EFvSyVORvNIaKuorgp0DW', 0, 477567890, 15345678),
(7, '../assets/user-profile-images/maya-van-den-broeck.png', 'Maya', 'Van den Broeck', 'Female', 45, 'huismansstraat 7', 'Putte', 'Hallo ik ben Maya!', 'maya.van.den.broeck@gmail.com', '$2y$10$6zEZyIzw7vGg5ms65bX56.JunL0bTUJbQPJTjkHEyDApfObqLp1hW', 0, 477567890, 15345678),
(8, '../assets/user-profile-images/nicole-straatmans.png', 'Nicole', 'Straatmans', 'Female', 34, 'koraalstraat 89', 'Heist-op-den-Berg', 'Hallo ik ben Nicole!', 'nicole.straatmans@gmail.com', '$2y$10$WvrJ/tYjkFiRR/7Q6yisXuKqXyCxoP94lReA/94qbHux3uXYV9SDa', 0, 477567890, 15345678),
(9, '../assets/user-profile-images/philippe-verstraeten.png', 'Philippe', 'Verstraeten', 'Male', 40, 'Topstraat 45', 'Lier', 'Hallo ik ben Philippe!', 'philippe.verstraeten@gmail.com', '$2y$10$GTnixES4Fxw2bDtWBwO/teDMcE4PxYi1Vdz/1jb2CSn/0.1pUkbpa', 0, 477567890, 15345678),
(10, '../assets/user-profile-images/regine-verschalke.png', 'Regine', 'Verschalke', 'Female', 32, 'Zandstraat 10', 'Lier', 'Hallo ik ben Regine!', 'regine.verschalke@gmail.com', '$2y$10$eZKWRg/gUvLWqDaEbjgJgO5nrO/QLZ4GWsZH/BaKAg6JDMaxB7MT6', 0, 477567890, 15345678),
(11, '../assets/user-profile-images/sandra-van-haute.png', 'Sandra', 'Van Haute', 'Female', 37, 'Bergstraat 18', 'Heist-op-den-Berg', 'Hallo ik ben Sandra!', 'sandra.van.haute@gmail.com', '$2y$10$aBf3TrSnLr7UshuygLmefei01u2FbdRb83UaMMqLeNQnAmfoszvi2', 0, 477567890, 15345678),
(12, '../assets/user-profile-images/sophia-verstraeten.png', 'Sophia', 'Verstraeten', 'Female', 38, 'Bergstraat 70', 'Heist-op-den-Berg', 'Hallo ik ben Sophia!', 'sophia.verstraeten@gmail.com', '$2y$10$H7UBRNreaymtVKtUp2LL6eJeZShhMQnARPVfia7FfLI5lcre7NoJy', 0, 477567890, 15345678),
(13, '../assets/user-profile-images/tanja-vandersteen.png', 'Tanja', 'Vandersteen', 'Female', 42, 'Ajuinstraat 80', 'Putte', 'Hallo ik ben Tanja', 'tanja.vandersteen@gmail.com', '$2y$10$xKNpLSBbOy/Tn84/kUr.uuIZiJbydsSrlHNzxsjRtNuCaM6k7.wRG', 0, 477567890, 15345678);

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
  MODIFY `advert_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tbl_user_child`
--
ALTER TABLE `tbl_user_child`
  MODIFY `user_child_id` int(11) NOT NULL AUTO_INCREMENT;