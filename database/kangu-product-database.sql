-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2016 at 09:46 AM
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
  `advert_transport` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advert_number_bookings` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_advert`
--

INSERT INTO `tbl_advert` (`advert_id`, `fk_user_id`, `advert_description`, `advert_price`, `advert_spots`, `advert_school`, `advert_transport`, `advert_number_bookings`) VALUES
(1, 1, 'Dag ouders! Ik ben Sanne, een 26 jarige zorgkundige die zo nu en dan wat uurtjes vrij heeft. Ik heb veel ervaring met kinderen, in het verleden heb ik gewerkt in een kinderopvang en een buitenschoolse opvang. Ook met pubers kan ik goed overweg. Ik ben een zachtaardig en lief persoon, maar ik sta wel op mijn strepen. Het uurloon vind ik heel moeilijk, daarom dat ik het liefst tot discussie over laat. Meestal vraag ik geen uurloon maar gewoon een oplet loon. Is het voor enkele uurtjes, dan vind ik 20 euro best, is het voor een lange avond, een hele middag, een ganse dag, dan kan daar wat bij komen.', 6, 2, 'Heilig-hartcollege', 'auto', 0),
(2, 2, 'Hallo mama en papa zoekt u een ervaren met verantwoordelijks gevoel toffe kinderoppas? Dan bied ik mij graag aan! \r\nIk doe deze leuke job reeds 1 jaar en heb nog tijd over om jullie te helpen met voorschoolse opvang of tijdens de dag. Ik hoop snel iets van jullie te horen! Tot dan! Ainarra.', 8, 3, 'Heilig-hartcollege', 'fiets', 0),
(3, 3, 'Ik ben een moeder van 4 kinderen die nu volwassen zijn, maar ze wonen niet bij mij en heeft altijd graag kinderopvang. Ik heb slechts een jaar ervaring, maar ik begrijp en ik hou van kinderen. Ik ben een warm en zorgzaam persoon en ik respecteer de aanwijzingen van de ouders. En boven alles heb ik gezond verstand.', 9, 1, 'Heilig-hartcollege', 'fiets', 0),
(4, 4, 'Hallo, Ik ben een spontane, lieve, enthousiaste kinderoppas. die heel betrouwbaar is en een groot verantwoordelijkheidsgevoel heeft. ik heb al meerdere jaren ervaring voorbeeld als de de ouders 2weken op reis waren heb ik ze voor hun gezorgd dag en nacht zelf oppas ik al meerdere jaren ik ben 19 word bijna 20 ben flexibel kan heel goed met kindjes omgaan vind het super om met de kindjes te knutselen gaan wandel Ik ben ook bereid om eventueel enkele huishoudelijke taken op mij te nemen. \r\nIk doe de job ontzettend graag en pas me aan aan de noden & wensen van de ouders. \r\nIk ben alle dagen beschikbaar mvg groet, Pieters.', 5, 2, 'Heilig-hartcollege', 'auto', 0),
(5, 5, 'Hallo, Ik ben 18 jaar en woon in Antwerpen. Ik babysit al van mijn 15 jaar en dit met heel veel liefde en passie. Daarom studeer ik ook Vroedkunde aan Karel de Grote Hogeschool. Ik heb gewerkt in een naschoolse kinderopvang in Antwerpen op woensdagnamiddag als vrijwilliger. 2 jaar geleden heb ik in een pop up kinderopvang gewerkt. In de familie wordt ik ook altijd gevraagd om te babysitten op mijn nichtjes en neefjes. Ik doe niets liever dan voor kinderen te zorgen groot en klein. Het zou fijn zijn dit te kunnen combineren met mijn studies. \r\nHopelijk horen we elkaar snel! ', 6, 3, 'Heilig-hartcollege', 'auto', 0),
(6, 6, 'Ik ben erg ervaren met kinderen. Ik babysit vanaf mijn 16 jaar bij de gezinsbond. \r\nDaarnaast heb ik twee studies achter de rug in de sociale sector. Ik heb in mijn bachelor orthopedagogie gedaan, dus ik heb veel ervaring met kinderen en daarnaast ook met kinderen met bijzondere noden. \r\nNaast babysitten zou ik ook graag huishoudelijk werk doen.', 8, 2, 'Heilig-hartcollege', 'auto', 0),
(7, 7, 'Ik ben erg ervaren met kinderen. Ik babysit vanaf mijn 16 jaar bij de gezinsbond. \r\nDaarnaast heb ik twee studies achter de rug in de sociale sector. Ik heb in mijn bachelor orthopedagogie gedaan, dus ik heb veel ervaring met kinderen en daarnaast ook met kinderen met bijzondere noden. \r\nNaast babysitten zou ik ook graag huishoudelijk werk doen.', 9, 1, 'Heilig-hartcollege', 'auto', 0),
(8, 8, 'Mijn naam is en ik ben momenteel 21 jaar. Ik babysit al een 5-tal jaar en ik heb enkele jaren gewerkt als monitrice op een speelplein. Ik heb ook 6 jaar turnles gegeven maar daar ben ik sinds dit jaar mee gestopt om me meer bezig te kunnen houden met mijn studies. \r\nVooral de jongste kindjes spreken mij enorm aan maar met de ouderen heb ik het tot nu toe ook altijd kunnen vinden. \r\nIk ben in het bezit van een rijbewijs en een auto dus bij het gezin thuis geraken en terug is geen probleem. Indien jullie dit graag willen, kan ik jullie ook altijd een aantal referenties bezorgen. \r\nIk hoop snel iets van jullie te horen! ', 6, 2, 'Heilig-hartcollege', 'openbaar vervoer', 0),
(9, 9, 'Ik heb in het verleden vooral voor mijn kleine neefjes en nichtjes gezorgd, maar nu ze wat ouder worden zoek ik een nieuw gezin waar ik kan instaan voor de zorg van de kinderen wanneer het nodig is. Ik ben een heel vrolijk persoon, en doe niets liever dan spelen en ravotte met kinderen. Als student in de bio-ingenieurswetenschappen kan ik zeker ook helpen met huiswerk indien nodig.', 7, 2, 'Heilig-hartcollege', 'auto', 0),
(10, 10, 'Binnenkort ga ik Gent verkennen door me er te settelen en een job te zoeken. \r\nNaast het vele vrijwilligerswerk met kinderen en het werken in de horeca, rondde ik mijn studies af als opvoeder/begeleider. Door het gevarieerde vrijwilligerswerk dat ik met plezier deed vanaf mijn vijftiende, leerde ik veel bij. Belangrijk vind ik dat kinderen naast de schooluren zich kunnen ontspannen in een familiale en liefdevolle omgeving. \r\nOok supporter ik de eigen ontwikkeling van het kind naar de weg van zelfstandigheid (meehelpen, laten ontdekken, huiswerk,...). Afhankelijk van de leeftijd, de mogelijkheden van het kind en in samenspraak met de ouders. Via deze kinderopvang wil ik mijn favoriete bezigheid verderzetten en samen met jullie, als gezin, nieuwe dingen ontdekken.', 5, 2, 'Heilig-hartcollege', 'auto', 0),
(11, 11, 'Tijdens de week werk ik als leerkracht in het secundair aan het Stedelijk Lyceum Lamoriniere. Graag wil ik na mijn uren een bijverdienste als kinderoppas, zo kan ik mijn schoolwerk en sociaal leven nog steeds goed combineren. \r\nIk ben afgestudeerd als leerkracht verzorgende wat maakt dat ik soms stagebegeleiding geef aan 6 en 7 kinderzorg. Kinderen van verscheidene leeftijden zijn dus geen enkel probleem. ', 6, 2, 'Heilig-hartcollege', 'auto', 0),
(12, 12, 'Ik ben afgestudeerd als maatschappelijk assistente en doe nu de banaba buitengewoon onderwijs. Mijn droom is om met kinderen te werken. Ik heb snel een vertrouwensband met kinderen. Ook ben ik graag creatief bezig met kinderen en vind ik het belangrijk om hen iets bij te brengen. ', 5, 1, 'Heilig-hartcollege', 'auto', 0),
(13, 13, 'Tijdens de week werk ik als leerkracht in het secundair aan het Stedelijk Lyceum Lamoriniere. Graag wil ik na mijn uren een bijverdienste als kinderoppas, zo kan ik mijn schoolwerk en sociaal leven nog steeds goed combineren. \r\nIk ben afgestudeerd als leerkracht verzorgende wat maakt dat ik soms stagebegeleiding geef aan 6 en 7 kinderzorg. Kinderen van verscheidene leeftijden zijn dus geen enkel probleem. ', 8, 1, 'Heilig-hartcollege', 'auto, wandelend', 0),
(14, 14, 'Beste ouders, naast het vele vrijwilligerswerk met kinderen en het werken in de horeca, rondde ik mijn studies af als opvoeder/begeleider. Door het gevarieerde vrijwilligerswerk dat ik met plezier deed vanaf mijn vijftiende, leerde ik veel bij. Belangrijk vind ik dat kinderen naast de schooluren zich kunnen ontspannen in een familiale en liefdevolle omgeving. \r\nOok supporter ik de eigen ontwikkeling van het kind naar de weg van zelfstandigheid (meehelpen, laten ontdekken, huiswerk,...). Afhankelijk van de leeftijd, de mogelijkheden van het kind en in samenspraak met de ouders. Via deze kinderopvang wil ik mijn favoriete bezigheid verderzetten en samen met jullie, als gezin, nieuwe dingen ontdekken.', 9, 2, 'Heilig-hartcollege', 'auto, fiets', 0),
(15, 15, 'Hallo, Ik ben Marlies, ik ben mama van 2 kindjes, ik ben opzoek baar werk als onthaalouder want ik ben verzot op kindjes en heb een attest behaald van kennismakings module voor onthaalouders. Ik heb namelijk ook een attest behaald van levensreddend handelen.\r\n', 9, 2, 'Heilig-hartcollege', 'auto, fiets', 0),
(16, 16, 'Mijn naam is Wendy, ik ben 24 jaar en woonachtig te Aartselaar. Ik heb mijn diploma van kinderverzorgster reeds behaald, ik heb ook nog niet zo heel erg lang geleden mijn attest van levens reddend handelen behaald. Ik zou graag als Nanny/kinderverzorgster willen werken omdat mijn hart bij kinderen ligt. Ik zorg echt zeer graag voor kinderen, en met ze spelen doe ik ook super graag. Als ik met kinderen kan werken voel ik mezelf compleet en een gelukkig persoon. De kinderen zullen dus ook nooit iets tekort komen.', 9, 2, 'Heilig-hartcollege', 'auto, fiets', 0),
(17, 17, 'Hallo, ik ben Karen, single mama van een lief meisje van 6 jaar en fulltime werkzaam in het onderwijs. Ik geef intussen al een aantal jaren les Nederlands aan leerlingen in het middelbaar, maar als student was ik actief in speelpleinwerking en heb ik veel op jonge kinderen gepast. Aangezien ik in de zomermaanden thuis ben en graag met kinderen en jongeren werk, ben ik op zoek naar een job als nanny in de zomer. Eventueel kan dit tijdens het schooljaar ook ''s avonds. Ik ben verantwoordelijk, spontaan en flexibel.', 7, 2, 'Heilig-hartcollege', 'auto', 0),
(18, 18, 'Ik ben Koen 31 jaar oud. Ik ben betrouwbaar eenvoudig en lieveling mens. Ik denk dat kinderen zijn het allergrootste cadeau dat mens kan krijgen en daarom werk ik graag als babysit. Ik heb al een paar jaar ervaring en heb veel kleine vriendjes gemaakt zoals:Marie 6 jaar in Mortsel,Victor 9 jaar in Berchem,Louise 4 jaar in Wilrijk. Nu ik ben op zoek naar een nieuwe vriendje,hopelijk wordt het uw kind.', 8, 1, 'Heilig-hartcollege', 'auto', 0),
(19, 19, 'Hallo iedereen! Mijn naam is karel en ik ben 34 jaar oud. Al vanaf jongs af aan nam ik een verantwoordelijkheid voor jongeren kinderen. Later toen ik 15 werd, begon ik op te passen op veel gezinnen. Ik heb dit altijd met heel veel plezier gedaan buiten school, in de avonden en de weekenden. De leeftijd varieerden van 3 maanden oude baby tot pubers. Ik kan met alle leeftijden overweg, en bedenk voor ieder wel wat wils om te doen! Samen spelletjes spelen, koekjes bakken, avontuurlijke dingen buiten doen en noem het maar op! Ik ben de ideale oppas/nanny omdat ik kinderen een veilig en vertrouwd gevoel geef en er alles aan doe om er samen een leuke tijd van te maken!', 7, 2, 'Heilig-hartcollege', 'auto, fiets, wandelend', 0),
(20, 20, 'Hallo mama en papa zoekt u een ervaren met verantwoordelijks gevoel toffe kinderoppas? Dan bied ik mij graag aan! \r\nIk doe deze leuke job reeds 1 jaar en heb nog tijd over om jullie te helpen met voorschoolse opvang of tijdens de dag. Ik hoop snel iets van jullie te horen! Tot dan! Marleen.', 5, 1, 'Heilig-hartcollege', 'auto, wandelend', 0),
(21, 21, 'Ik ben Lisa 31 jaar oud. Ik ben betrouwbaar eenvoudig en lieveling mens. Ik denk dat kinderen zijn het allergrootste cadeau dat mens kan krijgen en daarom werk ik graag als babysit. Ik heb al een paar jaar ervaring en heb veel kleine vriendjes gemaakt zoals:Marie 6 jaar in Mortsel,Victor 9 jaar in Berchem,Louise 4 jaar in Wilrijk. Nu ik ben op zoek naar een nieuwe vriendje,hopelijk wordt het uw kind.', 9, 3, 'Heilig-hartcollege', 'auto, fiets', 0),
(22, 22, 'Hallo mama en papa zoekt u een ervaren met verantwoordelijks gevoel toffe kinderoppas? Dan bied ik mij graag aan! \r\nIk doe deze leuke job reeds 1 jaar en heb nog tijd over om jullie te helpen met voorschoolse opvang of tijdens de dag. Ik hoop snel iets van jullie te horen! Tot dan! Charles.', 5, 1, 'Heilig-hartcollege', 'auto, wandelend', 0),
(23, 23, 'Ik ben een jonge vrouw van 20 jaar, ik woon op mezelf en ik studeer nog. Ik studeer kinderzorg eind juni 2016 ben ik afgestudeerd. Ik babysit al van mijn 13 jaar bij verschillende gezinnen. Ik heb dus heel veel ervaring met kinderen. Voor mij is het heel belangrijk dat de kinderen ook iets van me leren, bij staan in de ontwikkeling van het kind en ondersteuning geven waar nodig. Veel spelen en knutselen hoort daar dus ook bij! Ik zou graag naast mijn studies ook iets willen bij verdienen, als dat iets zou kunnen zijn dat ik met hart en ziel doe zou dit mooi meegenomen zijn. Ik hoop dat ik een mailtje terug krijg zodat ik jullie gezin eens kan ontmoeten. Mvg, Veronique.', 5, 1, 'Heilig-hartcollege', 'auto, fiets', 0),
(24, 24, 'Hallo, Ik ben Sandra, ik ben mama van 2 kindjes, ik ben opzoek baar werk als onthaalouder want ik ben verzot op kindjes en heb een attest behaald van kennismakings module voor onthaalouders. Ik heb namelijk ook een attest behaald van levensreddend handelen.', 8, 2, 'Heilig-hartcollege', 'auto, openbaar vervoer', 0),
(25, 25, 'Mijn naam is Melissa, ik ben 24 jaar en woonachtig te Aartselaar. \r\nIk heb mijn diploma van kinderverzorgster reeds behaald, ik heb ook nog niet zo heel erg lang geleden mijn attest van levens reddend handelen behaald. Ik zou graag als Nanny/kinderverzorgster willen werken omdat mijn hart bij kinderen ligt. Ik zorg echt zeer graag voor kinderen, en met ze spelen doe ik ook super graag. Als ik met kinderen kan werken voel ik mezelf compleet en een gelukkig persoon. De kinderen zullen dus ook nooit iets tekort komen.', 5, 1, 'Heilig-hartcollege', 'auto, wandelend', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_availability`
--

CREATE TABLE `tbl_availability` (
  `availability_id` int(11) NOT NULL,
  `fk_advert_id` int(11) NOT NULL,
  `availability_date` date NOT NULL,
  `availability_time_start` time NOT NULL,
  `availability_time_end` time NOT NULL,
  `availability_spots` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_availability`
--

INSERT INTO `tbl_availability` (`availability_id`, `fk_advert_id`, `availability_date`, `availability_time_start`, `availability_time_end`, `availability_spots`) VALUES
(7, 0, '2016-03-24', '15:00:00', '19:00:00', 0),
(8, 0, '2016-03-31', '15:30:00', '20:00:00', 0),
(9, 0, '2016-03-29', '15:00:00', '17:00:00', 0),
(10, 13, '2016-03-09', '15:30:00', '19:00:00', 0),
(11, 13, '2016-03-10', '15:30:00', '20:00:00', 0),
(12, 13, '2016-03-11', '15:30:00', '17:00:00', 0),
(13, 14, '2016-03-18', '15:30:00', '19:00:00', 0),
(14, 14, '2016-03-31', '15:30:00', '18:00:00', 0),
(15, 15, '2016-03-18', '15:30:00', '19:00:00', 0),
(16, 15, '2016-03-31', '15:30:00', '18:00:00', 0),
(17, 16, '2016-03-18', '15:30:00', '19:00:00', 0),
(18, 16, '2016-03-31', '15:30:00', '18:00:00', 0),
(19, 17, '2016-03-31', '15:30:00', '19:00:00', 0);

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
  `booking_extra_information` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `booking_status` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_dates`
--

CREATE TABLE `tbl_booking_dates` (
  `booking_date_id` int(11) NOT NULL,
  `fk_booking_id` int(11) NOT NULL,
  `booking_date_format` date NOT NULL
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
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `notification_date` datetime NOT NULL,
  `notification_message` text COLLATE utf8_unicode_ci NOT NULL,
  `notification_status` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unread'
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
  `fk_advert_id` int(11) NOT NULL,
  `service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`service_id`, `fk_advert_id`, `service_name`) VALUES
(13, 26, 'opvang-thuisomgeving'),
(14, 26, 'ophalen-schoolpoort'),
(15, 26, 'voorzien-maaltijd'),
(16, 26, 'hulp-huiswerktaken'),
(17, 13, 'opvang-thuisomgeving'),
(18, 13, 'ophalen-schoolpoort'),
(19, 13, 'vervoer-naschoolse-activiteiten'),
(20, 13, 'voorzien-maaltijd'),
(21, 14, 'opvang-thuisomgeving'),
(22, 14, 'ophalen-schoolpoort'),
(23, 14, 'vervoer-thuis'),
(24, 14, 'vervoer-naschoolse-activiteiten'),
(25, 15, 'opvang-thuisomgeving'),
(26, 15, 'ophalen-schoolpoort'),
(27, 15, 'vervoer-thuis'),
(28, 15, 'vervoer-naschoolse-activiteiten'),
(29, 16, 'opvang-thuisomgeving'),
(30, 16, 'ophalen-schoolpoort'),
(31, 16, 'vervoer-thuis'),
(32, 16, 'vervoer-naschoolse-activiteiten'),
(33, 17, 'opvang-thuisomgeving'),
(34, 17, 'ophalen-schoolpoort'),
(35, 17, 'vervoer-naschoolse-activiteiten'),
(36, 17, 'hulp-huiswerktaken');

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
  `user_home_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_mobile_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_image_path`, `user_firstname`, `user_lastname`, `user_sex_type`, `user_age`, `user_adress`, `user_city`, `user_biography`, `user_email`, `user_password`, `user_facebook_id`, `user_home_number`, `user_mobile_number`) VALUES
(1, '../assets/user-profile-images/maarten-van-loock.png', 'Maarten', 'Van Loock', 'Male', 22, 'Kleistraat 2', 'Heist-op-den-Berg', 'Hallo, ik ben maarten!', 'maartenphone@gmail.com', '$2y$10$vRYw8FUNuPpHlnoFms1UXOyOwsRCH6zHdomeD37GSkuYv2/ZVzEK.', 0, '+32 015 24 68 32', '+32 0477 744 162'),
(2, '../assets/user-profile-images/ainarra-verboven.png', 'Ainarra', 'Verboven', 'Female', 34, 'Lostraat 50', 'Heist-op-den-Berg', 'Hallo ik ben Ainarra!', 'ainarra.verboven@gmail.com', '$2y$10$xu.6utUNhq589d2PUXuN2uXN.oMHMGAr../JLWz3gSAZ3jJDTQ6aK', 0, '+32 015 24 64 48', '+32 0478 134 596'),
(3, '../assets/user-profile-images/anita-verhoeven.png', 'Anita', 'Verhoeven', 'Female', 31, 'Kasteelstraat 14', 'Heist-op-den-Berg', 'Hallo ik ben Anita!', 'anita.verhoeven@gmail.com', '$2y$10$ESpwc7x2aS5r6OTw0PnddO9N8TM.RwoS7/5RKcbs8Cp2jiBl8xIfy', 0, '+32 015 24 67 92', '+32 0474 546 087'),
(4, '../assets/user-profile-images/christel-janssens.png', 'Christel', 'Janssens', 'Female', 36, 'Bosstraat 15', 'Putte', 'Hallo ik ben Christel!', 'christel.janssens@gmail.com', '$2y$10$8MfX.FsawX.FPV60M7lDgejpNZ8bWO2Rs7YmYvl9m5s8BsEyqhwAa', 0, '+32 015 24 83 54', '+32 0477 123 765'),
(5, '../assets/user-profile-images/linda-deraeve.png', 'Linda', 'Deraeve', 'Female', 21, 'Koolstraat 34', 'Mechelen', 'Hallo ik ben Linda!', 'linda.deraeve@gmail.com', '$2y$10$8vEY8DaaIOaR6clF.YRomu/l65zADnbspus/KKdmd6.bBGQ.8L3nm', 0, '+32 015 24 32 94', '+32 0479 832 476'),
(6, '../assets/user-profile-images/marjan-dewaele.png', 'Marjan', 'Dewaele', 'Female', 41, 'Hulststraat 78', 'Lier', 'Hallo ik ben Marjan!', 'marjan.dewaele@gmail.com', '$2y$10$pkc6hLp7snKZsHxGmZoUaeJ26DsGPqh7EFvSyVORvNIaKuorgp0DW', 0, '+32 015 24 31 96', '+32 0477 841 043'),
(7, '../assets/user-profile-images/maya-van-den-broeck.png', 'Maya', 'Van den Broeck', 'Female', 45, 'Schaapstraat 17', 'Putte', 'Hallo ik ben Maya!', 'maya.van.den.broeck@gmail.com', '$2y$10$6zEZyIzw7vGg5ms65bX56.JunL0bTUJbQPJTjkHEyDApfObqLp1hW', 0, '+32 015 28 64 53', '+32 0474 094 321'),
(8, '../assets/user-profile-images/nicole-straatmans.png', 'Nicole', 'Straatmans', 'Female', 34, 'Lintsesteenweg 50', 'Duffel', 'Hallo ik ben Nicole!', 'nicole.straatmans@gmail.com', '$2y$10$WvrJ/tYjkFiRR/7Q6yisXuKqXyCxoP94lReA/94qbHux3uXYV9SDa', 0, '+32 015 24 53 21', '+32 0477 984 763'),
(9, '../assets/user-profile-images/philippe-verstraeten.png', 'Philippe', 'Verstraeten', 'Male', 40, 'Heistraat 45', 'Lier', 'Hallo ik ben Philippe!', 'philippe.verstraeten@gmail.com', '$2y$10$GTnixES4Fxw2bDtWBwO/teDMcE4PxYi1Vdz/1jb2CSn/0.1pUkbpa', 0, '+32 015 24 87 43', '+32 0477 832 513'),
(10, '../assets/user-profile-images/regine-verschalke.png', 'Regine', 'Verschalke', 'Female', 32, 'Kruisstraat 10', 'Lier', 'Hallo ik ben Regine!', 'regine.verschalke@gmail.com', '$2y$10$eZKWRg/gUvLWqDaEbjgJgO5nrO/QLZ4GWsZH/BaKAg6JDMaxB7MT6', 0, '+32 015 24 71 34', '+32 0479 032 487'),
(11, '../assets/user-profile-images/sandra-van-haute.png', 'Sandra', 'Van Haute', 'Female', 37, 'Bergstraat 18', 'Heist-op-den-Berg', 'Hallo ik ben Sandra!', 'sandra.van.haute@gmail.com', '$2y$10$aBf3TrSnLr7UshuygLmefei01u2FbdRb83UaMMqLeNQnAmfoszvi2', 0, '+32 015 24 98 56', '+32 0475 890 432'),
(12, '../assets/user-profile-images/sophia-verstraeten.png', 'Sophia', 'Verstraeten', 'Female', 38, 'Bergstraat 70', 'Heist-op-den-Berg', 'Hallo ik ben Sophia!', 'sophia.verstraeten@gmail.com', '$2y$10$H7UBRNreaymtVKtUp2LL6eJeZShhMQnARPVfia7FfLI5lcre7NoJy', 0, '+32 015 24 67 54', '+32 0477 876 452'),
(13, '../assets/user-profile-images/tanja-vandersteen.png', 'Tanja', 'Vandersteen', 'Female', 42, 'Pachtersdreef 80', 'Putte', 'Hallo ik ben Tanja', 'tanja.vandersteen@gmail.com', '$2y$10$xKNpLSBbOy/Tn84/kUr.uuIZiJbydsSrlHNzxsjRtNuCaM6k7.wRG', 0, '+32 015 24 98 21', '+32 0477 098 675'),
(14, '../assets/user-profile-images/selma-tulmans.png', 'Selma', 'Tulmans', 'Female', 32, 'Dorpsstraat 78', 'Berlaar', 'Hallo ik ben Selma!', 'selma.tulmans@gmail.com', '$2y$10$U.H5pb9UuLRh.yF.aI2xC.RwgRdneq656vfyrulnlX7n3E0s45bqC', 0, '+32 015 24 32 89', '+32 0475 786 385'),
(15, '../assets/user-profile-images/marlies-depraetere.png', 'Marlies', 'Depraetere', 'Female', 51, 'Smidsstraat 89', 'Berlaar', 'Hallo ik ben Marlies!', 'marlies.depraetere@gmail.com', '$2y$10$0WBKtNcLKbeBrCIa7Cppf.Ctpsw.ITK3Jss.09xY//8t0Ivn4FJxW', 0, '+32 015 28 86 21', '+32 0477 986 403'),
(16, '../assets/user-profile-images/wendy-schoenaerts.png', 'Wendy', 'Schoenaerts', 'Female', 35, 'Isschotweg 108', 'Itegem', 'Hallo ik ben Wendy!', 'wendy.schoenaerts@gmail.com', '$2y$10$9hSdhEIrfAwKgQijbEORmeiRXNp1a2QyaTYYPA0imx0Zu176QWxHG', 0, '+32 015 24 31 98', '+32 0477 620 931'),
(17, '../assets/user-profile-images/karen-verhoeven.png', 'Karen', 'Verhoeven', 'Female', 30, 'Hoogstraat 39', 'Beerzel', 'Hallo ik ben Karen!', 'karen.verhoeven@gmail.com', '$2y$10$.D3uQp7hAXMuGu7ejUKv1euk17uSkSBr56bSeMhpv1os4cxawO6P.', 0, '+32 015 24 89 76', '+32 0477 521 863'),
(18, '../assets/user-profile-images/koen-verbruggen.png', 'Koen', 'Verbruggen', 'Male', 30, 'Pompoenstraat 34', 'Wiekevorst', 'Hallo ik ben koen!', 'koen.verbruggen@gmail.com', '$2y$10$bDqjR6idv9oA3vrwAWSgoejFVs7EC.Kkmd5IdIlg9HznzPLFS02XO', 0, '+32 015 24 76 32', '+32 0477 744 321'),
(19, '../assets/user-profile-images/karel-degrote.png', 'Karel', 'Degrote', 'Male', 27, 'Kerkstraat 12', 'Itegem', 'Hallo ik ben Karel!', 'karel.degrote@gmail.com', '$2y$10$yxjJVUVewuUDF9CVJSLcK.crIQ3.pD3fWkk4xKo16JXvdVU.E1IDu', 0, '+32 015 26 98 21', '+32 0478 912 834'),
(20, '../assets/user-profile-images/marleen-ruiters.png', 'Marleen', 'Ruiters', 'Female', 34, 'Herenthoutseweg 89', 'Wiekevorst', 'Hallo ik ben Marleen!', 'marleen.ruiters@gmail.com', '$2y$10$84pf/ACEkZ8tynKXJnqlSOp4U39gU9NMEj3dxXZElzT8J2J7qDc2y', 0, '+32 015 24 09 34', '+32 0477 901 921'),
(21, '../assets/user-profile-images/lisa-aerts.png', 'Lisa', 'Aerts', 'Female', 24, 'Kattestraat 17', 'Beerzel', 'Hallo ik ben Lisa!', 'lisa.aerts@gmail.com', '$2y$10$uOChfuKVmuCmtDJOmSH23eI8r5fUU3/WhCAz5qcGMU749xpHxf8Xy', 0, '+32 015 24 08 31', '+32 0477 731 983'),
(22, '../assets/user-profile-images/charles-guysmans.png', 'Charles', 'Guysmans', 'Male', 32, 'Houwstraat 34', 'Beerzel', 'Hallo ik ben Charles!', 'chales.guysmans@gmail.com', '$2y$10$TEavI40SFkJDvWqZqJQdTeMkni46t7kmGBqqHZZZb.5OAH.5Gij.q', 0, '+32 015 24 08 12', '+32 0477 798 301'),
(23, '../assets/user-profile-images/veronique-moermans.png', 'Veronique', 'Moermans', 'Female', 35, 'Broekweg 17', 'Melkouwen', 'Hallo ik ben Veronique!', 'veronique.moermans@gmail.com', '$2y$10$bSESzfXLnI0Smr7yWlWFRuXrtiMtmZ4i9sCD8qJQHBbf6.YscCdOW', 0, '+32 015 24 01 31', '+32 0477 701 932'),
(24, '../assets/user-profile-images/sandra-verpoortere.png', 'Sandra', 'Verpoortere', 'Female', 26, 'Nijlense steenweg 67', 'Herenthout', 'Hallo ik ben Sandra!', 'sandra.verpoortere@gmail.com', '$2y$10$72je9.tsdB4rJSCtglLYbuKqLlanQ.f3dqWIFBvZpHoNXN4RYaHVa', 0, '+32 015 24 01 32', '+32 0477 744 092'),
(25, '../assets/user-profile-images/charline-messermans.png', 'Charline', 'Messermans', 'Female', 28, 'Heuvelstraat 32', 'Heist-op-den-Berg', 'Hallo ik ben Charline!', 'charline.messermans@gmail.com', '$2y$10$Or6U71IS.dU4HQ10xXAoeewnhyX4foTVF.sc/ulvysB4u/ikUVxyG', 0, '+32 015 28 01 92', '+32 0479 912 394'),
(26, '', 'Walter', 'Decroone', '', 0, '', '', '', 'walter.decroone@gmail.com', '$2y$10$5ot8jx5HsTkwS9ieOP82W.dQewd/YvlmSBVf2aG2A/X2el4VZDQki', 0, '', '');

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
-- Indexes for table `tbl_booking_dates`
--
ALTER TABLE `tbl_booking_dates`
  ADD PRIMARY KEY (`booking_date_id`);

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
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`notification_id`);

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
  MODIFY `advert_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_booking_dates`
--
ALTER TABLE `tbl_booking_dates`
  MODIFY `booking_date_id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `tbl_upvote`
--
ALTER TABLE `tbl_upvote`
  MODIFY `upvote_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tbl_user_child`
--
ALTER TABLE `tbl_user_child`
  MODIFY `user_child_id` int(11) NOT NULL AUTO_INCREMENT;