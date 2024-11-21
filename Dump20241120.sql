-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: capstone
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `idaddresses` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(20) DEFAULT NULL,
  `barangay` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `region` varchar(115) DEFAULT NULL,
  `postalCode` int(11) DEFAULT NULL,
  PRIMARY KEY (`idaddresses`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,'Luwasan','Bantog','San Miguiel','6',3008),(2,'Luwasan','Bantog','San Miguel','6',3010),(3,'Luwasan','Bantog','San Miguel','Bulacan',3008),(4,'Luwasan','Bantog','San Miguel','Bulacan',3008),(5,'kanto','sucat','kila maui','ncr',92),(6,'asd','Bantog','San Miguel','6',3008),(7,'Luwasan','Bantog','San Miguel','6',3008),(8,'Luwasan',NULL,NULL,'Bulacan',3010),(9,'Luwasan',NULL,NULL,'Bulacan',3010),(10,'Luwasan','Bantog','San Miguel','Bulacan',3008),(11,'Luwasan','Bantog','San Miguel','Bulacan',3008),(12,'Luwasan','Bantog','San Miguel','Bulacan',3008),(13,'Luwasan','Bantog','San Miguel','6',3010),(14,'Luwasan','Bantog','San Miguel','Bulacan',3008),(15,'Luwasan','Bantog','San Miguel','Bulacan',3008),(16,'Luwasan','Bantog','San Miguel','Bulacan',3008),(17,'Luwasan','Bantog','San Miguel','Bulacan',3010),(18,'Luwasan','Bantog','San Miguel','Bulacan',3008),(19,'Luwasan','Bantog','San Miguel','Bulacan',3010),(20,'Luwasan','Bantog','San Miguel','Bulacan',3008),(21,'Luwasan','Bantog','San Miguel','Bulacan',3008),(22,'Luwasan','Bantog','San Miguel','Bulacan',3010),(23,'Luwasan','Bantog','San Miguel','Bulacan',3010),(24,'Luwasan','Bantog','San Miguel','Bulacan',3008),(25,'Luwasan','Bantog','San Miguel','Bulacan',3010),(26,'Luwasan','Bantog','San Miguel','Bulacan',3010),(27,'Luwasan','Bantog','San Miguel','Bulacan',3010),(28,'Luwasan','Bantog','San Miguel','Bulacan',3010),(29,'Luwasan','Bantog','San Miguel','Bulacan',3010),(30,'Luwasan','Bantog','San Miguel','Bulacan',3008),(31,'Luwasan','Bantog','San Miguel','Bulacan',3010),(32,'Luwasan','Bantog','San Miguel','Bulacan',3010),(33,'kanto','sucat','kila maui','ncr',92),(34,'Cedar','Bambay','Quezon','1',1234);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adoption_application`
--

DROP TABLE IF EXISTS `adoption_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adoption_application` (
  `idadoption_application` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `idpet` int(11) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `transportation_time` varchar(30) DEFAULT NULL,
  `transportation_date` varchar(30) DEFAULT NULL,
  `meridiem` varchar(30) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `id_address` int(11) DEFAULT NULL,
  PRIMARY KEY (`idadoption_application`),
  KEY `id_idx` (`id`),
  KEY `idpet_idx` (`idpet`),
  KEY `id_address_idx` (`id_address`),
  CONSTRAINT `id` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_address` FOREIGN KEY (`id_address`) REFERENCES `users` (`idaddresses`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idpet` FOREIGN KEY (`idpet`) REFERENCES `pet` (`idpet`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adoption_application`
--

LOCK TABLES `adoption_application` WRITE;
/*!40000 ALTER TABLE `adoption_application` DISABLE KEYS */;
INSERT INTO `adoption_application` VALUES (18,65,38,'2024-10-12','Approved','John','Mito','11:30','2024-10-16','PM','2024-10-12 14:16:25',4),(19,79,30,'2024-10-12','Approved','Robbie','Cerezo','12:30','2024-10-08','AM','2024-11-19 16:49:53',4),(20,80,29,'2024-10-13','Approved','bryce','galamay','12:30','2024-10-14','AM','2024-10-13 00:55:05',5),(21,81,31,'2024-10-13','Approved','Pilip','Lorenzo','12:30','2024-10-22','AM','2024-10-13 11:14:25',6),(22,82,30,'2024-10-13','Approved','vannesa','cruz','12:30','2024-10-23','PM','2024-10-13 14:41:31',7),(41,84,35,'2024-11-01','Pending','Hanni','pham','11:30','2024-11-20','AM',NULL,32),(42,84,35,'2024-11-01','Pending','Hanni','pham','11:30','2024-11-20','AM',NULL,32),(43,84,35,'2024-11-01','Pending','Hanni','pham','11:30','2024-11-20','AM',NULL,32),(44,84,35,'2024-11-01','Pending','Hanni','pham','12:30','2024-11-11','AM',NULL,32),(45,84,35,'2024-11-01','Pending','Hanni','pham','11:30','2024-11-11','AM',NULL,32),(46,84,35,'2024-11-01','Pending','Hanni','pham','11:30','2024-10-16','AM',NULL,32),(47,84,35,'2024-11-01','Approved','Hanni','pham','12:30','2024-11-13','AM','2024-11-20 16:30:57',32),(48,67,62,'2024-11-19','Approved','Joseph','Balita','12:30','2024-11-28','AM','2024-11-20 16:17:14',33),(49,89,45,'2024-11-20','Approved','Gerome','Manzano','12:30','2024-11-25','PM','2024-11-20 14:31:04',34);
/*!40000 ALTER TABLE `adoption_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign` (
  `idcampaign` int(11) NOT NULL AUTO_INCREMENT,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `img` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcampaign`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign`
--

LOCK TABLES `campaign` WRITE;
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
INSERT INTO `campaign` VALUES (1,'Paws for Compassion: Stand Against Animal Violence','Paws for Compassion\" is a campaign dedicated to raising awareness about animal violence and advocating for the protection of our furry friends. We aim to educate communities about the impact of animal abuse and promote compassion and empathy towards all living beings. Through educational initiatives, community events, and advocacy efforts, we seek to create a safer world for animals.','Introduction:\r\nEvery year, millions of animals suffer from abuse and neglect. \"Paws for Compassion\" calls upon individuals and communities to take a stand against animal violence and promote kindness towards all creatures.\r\n\r\nKey Objectives:\r\nRaise Awareness: Educate the public about the realities of animal violence and its effects on animals and society.\r\nPromote Prevention: Share resources and strategies to prevent animal abuse and encourage responsible pet ownership.\r\nSupport Rescue Efforts: Collaborate with local shelters and rescue organizations to support animals in need and advocate for their welfare.\r\nInfluence Legislation: Push for stronger laws and regulations against animal cruelty to ensure justice for those who cannot speak for themselves.\r\nHow You Can Help:\r\nEducate Yourself and Others: Share information about animal violence and its impact within your community. Use social media platforms to spread the word.\r\nVolunteer: Get involved with local animal shelters or rescue groups. Your time can make a difference in the lives of abused animals.\r\nReport Abuse: If you witness animal cruelty, report it to the authorities immediately. Speak up for those who cannot speak for themselves.\r\nSupport Legislation: Sign petitions and contact your local representatives to advocate for stronger animal protection laws.\r\nParticipate in Events: Join our community events, workshops, and adoption drives to show your support and help raise funds for animals in need.\r\nConclusion:\r\nTogether, we can create a world where all animals are treated with the kindness and respect they deserve. Join us in the \"Paws for Compassion\" campaign and help us end animal violence today. Your voice matters; let’s make it heard!','campaign_images/Dhga6ia9k1Q6PsDgQB34ZRKhJx9IHDGAl3wygRLb.jpg','2024-10-12 00:44:42','2024-10-12 00:44:42'),(2,'Adopt First: A Loving Home Awaits','Adopt First\" campaign is dedicated to promoting animal adoption as the first choice for anyone looking to bring a pet into their home. By adopting from shelters and rescue organizations, we can give animals a second chance at life while helping to combat the overpopulation crisis in shelters. This campaign aims to raise awareness about the benefits of adoption and encourage compassionate decisions when it comes to pet ownership.','Introduction:\r\nEvery year, millions of animals find themselves in shelters, waiting for a loving home. The \"Adopt First\" campaign encourages prospective pet owners to consider adoption as their first option. By choosing to adopt, you are not only saving a life but also making room for more animals in need.\r\n\r\nKey Objectives:\r\nRaise Awareness: Educate the community about the importance of adopting animals from shelters and the impact it has on reducing pet overpopulation.\r\nPromote the Benefits of Adoption: Highlight the advantages of adopting, such as saving money on initial costs and gaining a loyal companion.\r\nSupport Local Shelters: Collaborate with animal shelters and rescue organizations to promote their adoption events and initiatives.\r\nChange Perceptions: Shift societal views that stigmatize shelter animals as “damaged” or “problematic” by sharing success stories of adopted pets.\r\nHow You Can Help:\r\nConsider Adoption First: Before shopping for a pet, visit local shelters and rescues to meet animals in need of homes.\r\nSpread the Word: Use social media to share information about the benefits of adoption and promote local shelters and their available pets.\r\nVolunteer at Shelters: Offer your time to help care for animals and assist with adoption events. Your support can make a significant difference in their lives.\r\nEducate Others: Talk to friends and family about the importance of adopting pets rather than purchasing from breeders or pet stores.\r\nShare Your Adoption Story: If you have adopted a pet, share your experience to inspire others to consider adoption.\r\nConclusion:\r\nChoosing to adopt rather than buy a pet is a compassionate decision that changes lives. Together, we can create a brighter future for animals in need. Join the \"Adopt First\" campaign and help us spread the message that every pet deserves a loving home. Let\'s make adoption the first choice for every family!','campaign_images/NImlnWq9ZTI2Vcn5KBe7bs0EJ63VEQdXn6QHQn3G.jpg','2024-10-12 03:08:30','2024-10-12 03:08:30'),(3,'Fix It for Fido: Spay and Neuter Awareness Campaign','The \"Fix It for Fido\" campaign aims to educate pet owners about the importance of spaying and neutering their pets. By addressing misconceptions and highlighting the benefits of these procedures, we seek to reduce the number of unwanted litters and help control the pet population. This campaign will also provide resources and support for low-cost spay/neuter services in the community.','1. Awareness Materials:\r\nInfographics: Create easy-to-understand graphics that explain the benefits of spaying and neutering, such as health benefits for pets and reducing the number of homeless animals.\r\nBrochures: Distribute brochures at veterinary clinics, pet stores, and community centers that detail local resources for spay/neuter services.\r\n2. Community Workshops:\r\nHost informational workshops to educate pet owners on the importance of spaying and neutering, addressing common myths and concerns.\r\nInvite veterinarians to speak about the procedures and their health benefits for pets.\r\n3. Partnerships with Local Vets:\r\nCollaborate with local veterinarians to offer discounted or free spay/neuter services during specific periods.\r\nOrganize \"Fix It for Fido\" days where pet owners can bring their animals for surgery at reduced rates.\r\n4. Social Media Campaign:\r\nUtilize social media platforms to share testimonials from pet owners who have spayed or neutered their pets, highlighting positive outcomes.\r\nUse hashtags like #FixItForFido and #SpayNeuterSaveLives to spread awareness and encourage sharing.\r\n5. Community Events:\r\nOrganize a community \"Pet Wellness Day\" where residents can bring their pets for free check-ups, spay/neuter information, and resources.\r\nInclude fun activities like pet contests, educational booths, and giveaways to attract attendees.\r\n6. Incentives for Participation:\r\nCreate a rewards program where pet owners who spay/neuter their pets receive discounts on pet supplies or services at local businesses.','campaign_images/EIVhJh8hiYWBEyjaoq3W3d0E647yjAZZdDy3w4aI.jpg','2024-10-12 03:13:38','2024-10-12 03:13:38');
/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_store`
--

DROP TABLE IF EXISTS `category_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_store` (
  `idcategory_store` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `category_description` text DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcategory_store`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_store`
--

LOCK TABLES `category_store` WRITE;
/*!40000 ALTER TABLE `category_store` DISABLE KEYS */;
INSERT INTO `category_store` VALUES (26,'Temperament','2024-11-08 06:23:41','2024-11-14 17:04:00','Which describes you best?',NULL),(27,'Size','2024-11-17 01:28:39','2024-11-17 09:28:39','When you think about a cozy home environment, what do you envision?',NULL),(28,'Special Treatments','2024-11-19 04:17:54','2024-11-19 12:17:54','When considering your living environment, how adaptable do you feel?',NULL),(29,'Age','2024-11-19 04:18:59','2024-11-19 12:18:59','When you think about the future, what kind of journey do you envision?',NULL),(30,'Gender','2024-11-19 04:19:52','2024-11-19 12:19:52','How do you perceive teamwork in your relationships?',NULL);
/*!40000 ALTER TABLE `category_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employment_info`
--

DROP TABLE IF EXISTS `employment_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employment_info` (
  `idemployment_info` int(11) NOT NULL AUTO_INCREMENT,
  `utility_bills` text DEFAULT NULL,
  `employment_proof` text DEFAULT NULL,
  `income` int(11) DEFAULT NULL,
  `job_title` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idemployment_info`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment_info`
--

LOCK TABLES `employment_info` WRITE;
/*!40000 ALTER TABLE `employment_info` DISABLE KEYS */;
INSERT INTO `employment_info` VALUES (6,'uploads/utility_bills/ouze3jOCTuGf8gz3tknA3SYe5qZWZK3iDCI1LW2c.jpg','uploads/employment_proofs/MjEqu02ethtAmTod1VzsU0SuzsEWHm3z6GhKlPnP.jpg',12000,'IT','2024-11-01 03:56:52','2024-11-01 03:56:52'),(7,'uploads/utility_bills/GCmXCjanQeDxEkzN1TBCObYRtl3dO36b8B3WCxJM.jpg','uploads/employment_proofs/f5oBz90bDwjvliEpLePvG1uffjSixBRxfn1nQYvp.jpg',12000,'IT','2024-11-01 04:04:26','2024-11-01 04:04:26'),(8,'uploads/utility_bills/9kODHbYrnq23DoQQKQLXs3A11zcwU3XEk4ecSrZp.jpg','uploads/employment_proofs/3LfXLs8OZWfoHEqr3Wflf7uZztJ18JqET9mbiMZF.jpg',12000,'IT','2024-11-01 04:12:10','2024-11-01 04:12:10'),(9,'uploads/utility_bills/zlDbjZHAFym1nyqtPzt2H2wt2BqXdlhlrG9wqStR.jpg','uploads/employment_proofs/mlyDVKyELlbZn7IDXzvzVHvpMYdnZ89mJGWurqIv.jpg',12000,'IT','2024-11-01 04:19:11','2024-11-01 04:19:11'),(10,'uploads/utility_bills/speoj4YEeKrQb9w3gdYNfn6u9d4lBYcQqjYdANQf.jpg','uploads/employment_proofs/fzawaezlVSIqpFBy02mEuY35wFOH55laD5Pw0vNX.jpg',12000,'IT','2024-11-01 04:27:57','2024-11-01 04:27:57'),(11,'uploads/utility_bills/HtbOmsc0l9i4E2sb99BY6DCm1pQ0kxQ3D76Jlx0o.jpg','uploads/employment_proofs/JlDJ5RgkcuhDqWh2xteomISrVGEwglO2hawCEO2f.jpg',12000,'IT','2024-11-01 06:17:07','2024-11-01 06:17:07'),(12,'uploads/utility_bills/i39AIGGzxTSaMuUwsKhOEReeKAW8583gkCU5br8N.jpg','uploads/employment_proofs/xUZ6ni2uzW447s87TjpIya3GbE1XdFUkXbUSQs6w.jpg',12000,'IT','2024-11-01 06:19:36','2024-11-01 06:19:36'),(13,'uploads/utility_bills/lWjwepz7QnEJW1xyCNujiBkEt9E57jPQwSPeDwew.png','uploads/employment_proofs/hxDj7VAN3TKZp7VXbnDfKyzN0KALDLkFiPy1KK23.jpg',32,'it','2024-11-19 08:48:43','2024-11-19 08:48:43'),(14,'uploads/utility_bills/tx0iOdfeqJSg8uDSZz9VdMhLOG8tfBYIGlsMcFvq.png','uploads/employment_proofs/iR5rhptOwQH9CnAMYKScFOLg5g9Ic3J5r4NtS7cx.png',2500,'IT','2024-11-20 06:29:46','2024-11-20 06:29:46'),(15,'uploads/utility_bills/CUjawccUmTXYYop1N0MPe5wrqeUIref5VwYv2i8C.png','uploads/employment_proofs/VqoOo8pVCu9xsUOnlfFI6SuBB6JlXGtGhPBhpwYY.png',2500,'IT','2024-11-20 06:29:47','2024-11-20 06:29:47'),(16,'uploads/utility_bills/VDNLX5WipXJhskmm7fbFqJzSWh2sS1ii26imqx9P.png','uploads/employment_proofs/X93egFnW5MuIhra1SayjsOm7KIxY2qL5ONlKQHCX.png',2500,'IT','2024-11-20 06:29:47','2024-11-20 06:29:47'),(17,'uploads/utility_bills/VmZUO9LNZ4QIqu60b1IfnLZMBw7HWRpNRNOdueUP.png','uploads/employment_proofs/2xWVoA2JdwVA938YcDUeTXfKca5wbRRSiGIiiWbc.png',2500,'IT','2024-11-20 06:29:47','2024-11-20 06:29:47'),(18,'uploads/utility_bills/gfthtlEW9ZtWfUOZkLMKAxAPvpVvF4qG1Op4RZl9.png','uploads/employment_proofs/O5dyJOcOCAccj8QnhXHC2X5Zrf5HMy7rcZLC2Ikl.png',2500,'IT','2024-11-20 06:29:47','2024-11-20 06:29:47'),(19,'uploads/utility_bills/XOtF0xbN39vmEGFNuiRuNrFmbAqw2EpJmDmFkhgR.png','uploads/employment_proofs/vdzUREbKMXD9WiP9RLIkSQr0SkwbhHIHa8VLSOdE.png',2500,'IT','2024-11-20 06:29:47','2024-11-20 06:29:47');
/*!40000 ALTER TABLE `employment_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homepage_dyna`
--

DROP TABLE IF EXISTS `homepage_dyna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `homepage_dyna` (
  `idhomepage` int(11) NOT NULL AUTO_INCREMENT,
  `slogan` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idhomepage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_dyna`
--

LOCK TABLES `homepage_dyna` WRITE;
/*!40000 ALTER TABLE `homepage_dyna` DISABLE KEYS */;
/*!40000 ALTER TABLE `homepage_dyna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction`
--

DROP TABLE IF EXISTS `interaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `interaction_type` enum('like','favorite','View') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pet_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  KEY `pet_id_idx` (`pet_id`),
  CONSTRAINT `id_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`idpet`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction`
--

LOCK TABLES `interaction` WRITE;
/*!40000 ALTER TABLE `interaction` DISABLE KEYS */;
INSERT INTO `interaction` VALUES (1,85,'View','2024-11-19 11:49:16','2024-11-19 11:49:16',44),(2,85,'View','2024-11-19 12:00:50','2024-11-19 12:00:50',61),(3,85,'View','2024-11-19 12:00:54','2024-11-19 12:00:54',44),(4,85,'View','2024-11-19 12:00:59','2024-11-19 12:00:59',62),(5,85,'View','2024-11-19 12:01:03','2024-11-19 12:01:03',42),(6,85,'View','2024-11-19 12:01:05','2024-11-19 12:01:05',58),(7,85,'View','2024-11-19 12:01:08','2024-11-19 12:01:08',44),(8,85,'View','2024-11-19 12:01:33','2024-11-19 12:01:33',45),(9,85,'View','2024-11-19 12:01:40','2024-11-19 12:01:40',56),(10,84,'View','2024-11-19 13:27:56','2024-11-19 13:27:56',46),(11,84,'View','2024-11-19 13:28:40','2024-11-19 13:28:40',46),(12,84,'View','2024-11-19 14:25:12','2024-11-19 14:25:12',61),(13,84,'View','2024-11-19 14:32:46','2024-11-19 14:32:46',56),(14,84,'View','2024-11-19 14:52:57','2024-11-19 14:52:57',61),(15,84,'View','2024-11-19 14:53:50','2024-11-19 14:53:50',61),(16,84,'View','2024-11-19 15:01:08','2024-11-19 15:01:08',61),(17,84,'View','2024-11-19 15:03:45','2024-11-19 15:03:45',44),(18,84,'View','2024-11-19 15:03:45','2024-11-19 15:03:45',44),(19,84,'View','2024-11-19 15:03:48','2024-11-19 15:03:48',46),(20,84,'View','2024-11-19 15:03:48','2024-11-19 15:03:48',46),(21,84,'View','2024-11-19 15:04:42','2024-11-19 15:04:42',57),(22,84,'View','2024-11-19 15:04:42','2024-11-19 15:04:42',57),(23,84,'View','2024-11-19 15:04:42','2024-11-19 15:04:42',57),(24,84,'View','2024-11-19 15:04:42','2024-11-19 15:04:42',57),(25,84,'View','2024-11-19 15:04:42','2024-11-19 15:04:42',57),(26,84,'View','2024-11-19 15:04:43','2024-11-19 15:04:43',57),(27,84,'View','2024-11-19 15:04:43','2024-11-19 15:04:43',57),(28,84,'View','2024-11-19 15:04:43','2024-11-19 15:04:43',57),(29,84,'View','2024-11-20 06:22:24','2024-11-20 06:22:24',44),(30,84,'View','2024-11-20 06:22:24','2024-11-20 06:22:24',44),(31,84,'View','2024-11-20 06:22:45','2024-11-20 06:22:45',44),(32,84,'View','2024-11-20 06:22:45','2024-11-20 06:22:45',44),(33,85,'View','2024-11-20 06:23:50','2024-11-20 06:23:50',42),(34,89,'View','2024-11-20 06:27:41','2024-11-20 06:27:41',45),(35,89,'View','2024-11-20 06:27:41','2024-11-20 06:27:41',45),(36,84,'View','2024-11-20 06:35:26','2024-11-20 06:35:26',56),(37,84,'View','2024-11-20 07:25:03','2024-11-20 07:25:03',56),(38,84,'View','2024-11-20 07:25:03','2024-11-20 07:25:03',56),(39,84,'View','2024-11-20 08:06:12','2024-11-20 08:06:12',65),(40,84,'View','2024-11-20 08:06:52','2024-11-20 08:06:52',65),(41,84,'View','2024-11-20 08:08:12','2024-11-20 08:08:12',65),(42,84,'View','2024-11-20 08:09:30','2024-11-20 08:09:30',65),(43,84,'View','2024-11-20 08:44:57','2024-11-20 08:44:57',56);
/*!40000 ALTER TABLE `interaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations_save`
--

DROP TABLE IF EXISTS `locations_save`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations_save` (
  `idlocations_save` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idlocations_save`),
  KEY `id_user` (`user_id`),
  CONSTRAINT `id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_save`
--

LOCK TABLES `locations_save` WRITE;
/*!40000 ALTER TABLE `locations_save` DISABLE KEYS */;
INSERT INTO `locations_save` VALUES (1,66,14.598144,120.999115,'2024-10-08 04:19:27','2024-10-08 04:19:27'),(2,66,14.598144,120.999115,'2024-10-08 04:19:59','2024-10-08 04:19:59'),(3,66,14.598144,120.999115,'2024-10-08 04:20:13','2024-10-08 04:20:13'),(4,66,14.598144,120.999115,'2024-10-08 04:21:09','2024-10-08 04:21:09'),(5,66,14.624378,120.986832,'2024-10-08 04:25:09','2024-10-08 04:25:09'),(6,66,14.624378,120.986832,'2024-10-08 04:25:32','2024-10-08 04:25:32'),(7,66,14.624378,120.986832,'2024-10-08 04:26:02','2024-10-08 04:26:02'),(8,66,14.624378,120.986832,'2024-10-08 04:26:48','2024-10-08 04:26:48'),(9,66,14.598144,120.999115,'2024-10-08 04:27:14','2024-10-08 04:27:14'),(10,66,14.598144,120.999115,'2024-10-08 04:31:26','2024-10-08 04:31:26'),(11,66,14.598144,120.999115,'2024-10-08 04:32:28','2024-10-08 04:32:28'),(12,66,14.624429,120.986855,'2024-10-08 09:01:14','2024-10-08 09:01:14'),(13,66,14.598144,120.999115,'2024-10-08 09:02:30','2024-10-08 09:02:30'),(14,66,14.598144,120.999115,'2024-10-08 09:02:42','2024-10-08 09:02:42'),(15,66,14.598144,120.999115,'2024-10-08 09:03:22','2024-10-08 09:03:22'),(16,66,14.598144,120.999115,'2024-10-08 09:05:11','2024-10-08 09:05:11'),(17,66,14.624429,120.986855,'2024-10-08 09:06:22','2024-10-08 09:06:22'),(18,66,14.598144,120.999115,'2024-10-08 09:08:02','2024-10-08 09:08:02'),(19,66,14.624427,120.986847,'2024-10-08 09:09:26','2024-10-08 09:09:26'),(20,66,14.580342,120.976151,'2024-10-11 04:18:38','2024-10-11 04:18:38'),(21,66,14.585644,120.985321,'2024-10-11 05:02:33','2024-10-11 05:02:33'),(22,65,14.624396,120.986809,'2024-10-12 06:08:02','2024-10-12 06:08:02'),(23,65,14.624405,120.986809,'2024-10-12 06:17:26','2024-10-12 06:17:26'),(24,80,14.598144,120.999115,'2024-10-12 16:56:30','2024-10-12 16:56:30'),(25,65,14.624408,120.986809,'2024-10-12 17:14:53','2024-10-12 17:14:53'),(26,80,14.598144,120.999115,'2024-10-12 17:18:54','2024-10-12 17:18:54'),(27,81,14.580342,120.976151,'2024-10-13 03:18:56','2024-10-13 03:18:56'),(28,82,14.585959,120.985283,'2024-10-13 06:46:15','2024-10-13 06:46:15'),(29,67,14.580342,120.976151,'2024-11-20 08:17:59','2024-11-20 08:17:59'),(30,67,14.585670,120.985260,'2024-11-20 08:26:55','2024-11-20 08:26:55'),(31,65,14.580342,120.976151,'2024-11-20 08:29:58','2024-11-20 08:29:58'),(32,84,14.580342,120.976151,'2024-11-20 08:31:58','2024-11-20 08:31:58');
/*!40000 ALTER TABLE `locations_save` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `idmeetings` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(45) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `join_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmeetings`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `fk_meetings_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (1,'Screening','2024-10-12 18:44:00',30,'https://us05web.zoom.us/j/89493534937?pwd=9hR1vRfTYbSAVOZcGNgbjQX8wPz3ea.1','2024-10-10 10:47:15','2024-10-10 10:47:15',NULL),(2,'Screening','2024-10-12 12:14:00',30,'https://us05web.zoom.us/j/89497484512?pwd=XC8ieoprX3st2tvbF6PxONGU8yge3a.1','2024-10-11 04:15:02','2024-10-11 04:15:02',NULL),(3,'Screening','2024-10-13 13:07:00',30,'https://us05web.zoom.us/j/82800038857?pwd=1UvfGbOzxKe6kmQLZa9zNrE79blcJp.1','2024-10-11 05:07:34','2024-10-11 05:07:34',NULL),(4,'Screening','2024-10-13 13:52:00',30,'https://us05web.zoom.us/j/85663963344?pwd=qn0UuEWJ6aXJrP7HOamMwNlXY0kuvS.1','2024-10-12 05:52:22','2024-10-12 05:52:22',NULL),(5,'Screening','2024-10-13 14:16:00',30,'https://us05web.zoom.us/j/88996849526?pwd=PY6i94TAYbnDUTQa0a0gN4foUdByqI.1','2024-10-12 06:16:39','2024-10-12 06:16:39',NULL),(6,'Screening','2024-10-14 00:55:00',30,'https://us05web.zoom.us/j/86930321278?pwd=ywMajbgaUbdDx7JMtozlDpaH4SW5xb.1','2024-10-12 16:55:27','2024-10-12 16:55:27',NULL),(7,'Screening','2024-10-14 11:14:00',30,'https://us05web.zoom.us/j/87024742519?pwd=ks5ANdkrcE5SfCnmD4im2VXrH7EzTP.1','2024-10-13 03:14:52','2024-10-13 03:14:52',NULL),(8,'Screening','2024-10-20 14:42:00',30,'https://us05web.zoom.us/j/85232776411?pwd=aDnaAS8bnnjnKN1VMNhFb4QwwFBCJq.1','2024-10-13 06:42:20','2024-10-13 06:42:20',NULL),(9,'Screening','2024-11-22 22:31:00',30,'https://us05web.zoom.us/j/84976668421?pwd=aJob3nVQkAMsFDd6e2ilSyra36rDW9.1','2024-11-20 08:31:17','2024-11-20 08:31:17',NULL);
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet`
--

DROP TABLE IF EXISTS `pet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pet` (
  `idpet` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `img` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deteled_at` timestamp NULL DEFAULT NULL,
  `adopted_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpet`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet`
--

LOCK TABLES `pet` WRITE;
/*!40000 ALTER TABLE `pet` DISABLE KEYS */;
INSERT INTO `pet` VALUES (29,'Benjie','pet_images/7ohdWS7jAHzDEPXfzrtTbvT02BuaFyqnR5YKsw3N.jpg','2024-10-06 02:20:41','2024-10-06 02:20:41',NULL,NULL,NULL),(30,'Robbie','pet_images/j3pBOX3DZqmnwdrCwoxnaNuu0CK6tS5mi4mgbhvS.png','2024-10-06 10:06:10','2024-10-06 10:06:10','MATALINO, POGI',NULL,NULL),(31,'Morphine','pet_images/8fddzh4auiVgcis7zLEjyqV8pC3Ib9abnHuMLDho.jpg','2024-10-12 00:59:03','2024-10-12 00:59:03','Cat Nurse',NULL,NULL),(32,'Aryuuko','pet_images/i4rKJmrQYGa0EowVUVPfrxPgm5VuRimQtrxmvxeK.jpg','2024-10-12 01:01:34','2024-10-12 01:01:34','Veteran Dog',NULL,NULL),(33,'Bryce','pet_images/mGz8LqoQwYAFmSMMnscJG63ENhTvVgGeRumcoRSP.jpg','2024-10-12 01:05:29','2024-10-12 01:05:29','Always outside',NULL,NULL),(34,'Lourdreich','pet_images/1bBMVDwqPOdkQMxc37G65cL6NhnXHH7BwKtBpGzy.jpg','2024-10-12 01:07:16','2024-10-12 01:07:16','Have peanut allergy',NULL,NULL),(35,'Madam Peach','pet_images/ENBDwDfGhRDIcXZwncbeI9vGsg7OMKcN7kNDEAHk.jpg','2024-10-12 01:09:26','2024-10-12 01:09:26','Small but terrible',NULL,NULL),(36,'Tine','pet_images/nuIprJp5b6gHfTnDEaSCL2TWDZLkCfQQZxQVbzgu.jpg','2024-10-12 01:13:27','2024-10-12 01:13:27','Like to be around Lourdreich',NULL,NULL),(37,'Horo','pet_images/zWeSksSTkqpQzAkKdo6ceWsgGyoocJA6SkQABwAG.jpg','2024-10-12 01:16:41','2024-10-12 01:16:41','Hermit',NULL,NULL),(38,'Annica','pet_images/UR32GKZMI9NBxvgNj8qWKvivckADyaoBao0KKbMV.png','2024-10-12 01:20:37','2024-10-12 01:20:37','Clingy and mischievous cat',NULL,NULL),(39,'Pobs','pet_images/lwhDzLnvOJYqDjArUSgo54R3FzxLdaTCkqheJvzQ.jpg','2024-10-12 01:55:09','2024-10-12 01:55:09','Very active',NULL,NULL),(40,'Danhill','pet_images/H56bZYduvQkSZU5qiDiuMkgeNyhEu3SX8akrvvFA.jpg','2024-10-12 01:58:03','2024-10-12 01:58:03','Aloof pigeon',NULL,NULL),(41,'Ches','pet_images/2mD8BUfRCLGqHv1IkSpHYhXaQXmMVXdC56CZV9Ky.png','2024-10-12 02:02:01','2024-10-12 02:02:01','Cute',NULL,NULL),(42,'Vayne','pet_images/tZAvxfRvIbvggqRo3vVlKHZMQfjp3FoTu7OSMEng.jpg','2024-11-17 04:23:18','2024-11-17 04:23:18','Small and calm dog',NULL,NULL),(44,'Max','pet_images/7cQpUiyu7ILVJXXuD2RhdTYxymckVjsacF8rzJj3.jpg','2024-11-19 05:18:28','2024-11-19 05:18:28','Max is a laid-back companion who enjoys relaxing walks and quiet evenings. He’s a healthy young adult with a kind heart and loves being around people.',NULL,NULL),(45,'Bella','pet_images/wq5tYhYxy5wPEKzaYgP8wzJIGKNBGTlNByvZiuC6.jpg','2024-11-19 05:19:10','2024-11-19 05:19:10','Bella is a small, affectionate pup recovering from a head injury. She loves snuggling and thrives on attention, making her the perfect lap dog.',NULL,NULL),(46,'Rocky','pet_images/WTBZcbdAYhGmjhazuGs8pP0fds5KSZtgyXUlKXvI.png','2024-11-19 05:19:49','2024-11-19 05:19:49','Rocky might be a senior, but his energy level says otherwise! Despite an eye injury, he’s a playful and loving companion who adores outdoor adventures.',NULL,NULL),(53,'Daisy','pet_images/rukmLaBEvORgBiycp1NIsx65Finbarb2rrwOiEtA.png','2024-11-19 05:28:49','2024-11-19 05:28:49','Daisy is a sweet and gentle girl who loves cozy corners and belly rubs. She’s perfectly healthy and an excellent choice for anyone seeking a quiet companion.',NULL,NULL),(54,'Shadow','pet_images/8Hzr2qZyBY7k1QA87kzo6nYzKIRpfPtedxIQZiXt.jpg','2024-11-19 05:29:29','2024-11-19 05:29:29','Shadow is a unique pet who’s still finding their personality. With some care and recovery from a head injury, Shadow is sure to shine in the right home.',NULL,NULL),(55,'Luna','pet_images/9HQi7amFBPaTYFLAEF5g2f0Acsw1LJxV4tVDCooy.jpg','2024-11-19 05:30:13','2024-11-19 05:30:13','Luna is an active senior who loves playtime and stays young at heart. She’s in great health and is looking for someone to match her zest for life.',NULL,NULL),(56,'Charlie','pet_images/Z5XYMBaBREQg9OSJPISXMcKyWf6MmqcdelFQLlVd.jpg','2024-11-19 05:31:35','2024-11-19 05:31:35','Charlie is a loving young adult who craves human connection. He’s recovering from an eye injury but hasn’t lost his sparkle or his love for cuddles.',NULL,NULL),(57,'Willow','pet_images/PKKlyzq92XdzzVlvcTuhglGTCQgmHWqRgOKQlkQj.jpg','2024-11-19 05:33:31','2024-11-19 05:33:31','Willow is a gentle giant with a quiet demeanor. Currently recovering from a head injury, she’s ready to bring warmth and loyalty to her forever home.',NULL,NULL),(58,'Oliver','pet_images/tkpA624FbsGq4tqgiQQMCLxpyhqQgfaLVHBnGzD1.jpg','2024-11-19 05:34:33','2024-11-19 05:34:33','Oliver is a wise and calm soul who appreciates a relaxed environment. His eye injury doesn’t stop him from enjoying life’s simple pleasures.',NULL,NULL),(59,'Coco','pet_images/gnqmQQjApHpgvFBd7jnNOvqbvGG9kqLiWXsORcUk.jpg','2024-11-19 05:35:26','2024-11-19 05:35:26','Coco is a playful and curious young pup who’s always on the go. He’s healthy and loves discovering new toys and making friends.',NULL,NULL),(60,'Ruby','pet_images/LE28cQOUcaRsFtfWvXPCNf9hoLghicKHOi4c1gUb.jpg','2024-11-19 05:36:14','2024-11-19 05:36:14','Ruby is a gentle, clingy giant who loves staying close to her humans. Despite her eye injury, she’s full of love and enjoys long cuddles.',NULL,NULL),(61,'Milo','pet_images/PR70zgkDG4z5rkUL54UZYzRBspoeVjlLQYiAxHmi.png','2024-11-19 05:36:50','2024-11-19 05:36:50','Milo is a calm and observant senior who’s still recovering from a head injury. He’s looking for a peaceful home where he can feel safe and loved.',NULL,NULL),(62,'Ginger','pet_images/WuxD7t8cx6tReG1ueoUVFBZaOj5oL6NLQZuUuVZr.png','2024-11-19 05:37:19','2024-11-19 05:37:19','Ginger is a calm and affectionate young dog who loves gentle walks and lazy afternoons. He’s healthy and ready to bring joy to his new family.',NULL,NULL),(63,'test','pet_images/SnunDOZ77RbFVl5vpnEmfLvCYD29zWEBkyKYhU33.jpg','2024-11-20 07:07:01','2024-11-20 07:07:01','test1',NULL,NULL),(64,'test','pet_images/UUNg6y8lAdpLqTTcbi8km7wEv3pfx7ATkv71TITL.jpg','2024-11-20 07:08:05','2024-11-20 07:08:05','test hahahsd',NULL,NULL),(65,'test','pet_images/u5MwpFZcjyfSl7a31PkBwTCuwZqjypFx6gg8x2d0.jpg','2024-11-20 07:10:08','2024-11-20 07:10:08','test1',NULL,NULL);
/*!40000 ALTER TABLE `pet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet_categories`
--

DROP TABLE IF EXISTS `pet_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pet_categories` (
  `idpet_categories` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `selected_id` int(11) DEFAULT NULL,
  `pet_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpet_categories`),
  KEY `selected_id_idx` (`selected_id`),
  KEY `pet_id_idx` (`pet_id`),
  CONSTRAINT `pet_id_fk` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`idpet`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `selected_id_fk` FOREIGN KEY (`selected_id`) REFERENCES `selection_store` (`idselection_store`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet_categories`
--

LOCK TABLES `pet_categories` WRITE;
/*!40000 ALTER TABLE `pet_categories` DISABLE KEYS */;
INSERT INTO `pet_categories` VALUES (85,'2024-11-17 04:23:18','2024-11-17 04:23:18',80,42),(86,'2024-11-17 04:23:18','2024-11-17 04:23:18',84,42),(89,'2024-11-19 05:18:28','2024-11-19 05:18:28',80,44),(90,'2024-11-19 05:18:28','2024-11-19 05:18:28',85,44),(91,'2024-11-19 05:18:28','2024-11-19 05:18:28',90,44),(92,'2024-11-19 05:18:28','2024-11-19 05:18:28',92,44),(93,'2024-11-19 05:18:28','2024-11-19 05:18:28',94,44),(94,'2024-11-19 05:19:10','2024-11-19 05:19:10',81,45),(95,'2024-11-19 05:19:10','2024-11-19 05:19:10',84,45),(96,'2024-11-19 05:19:10','2024-11-19 05:19:10',88,45),(97,'2024-11-19 05:19:10','2024-11-19 05:19:10',91,45),(98,'2024-11-19 05:19:10','2024-11-19 05:19:10',96,45),(99,'2024-11-19 05:19:49','2024-11-19 05:19:49',82,46),(100,'2024-11-19 05:19:49','2024-11-19 05:19:49',86,46),(101,'2024-11-19 05:19:49','2024-11-19 05:19:49',89,46),(102,'2024-11-19 05:19:49','2024-11-19 05:19:49',93,46),(103,'2024-11-19 05:19:49','2024-11-19 05:19:49',94,46),(134,'2024-11-19 05:28:49','2024-11-19 05:28:49',80,53),(135,'2024-11-19 05:28:49','2024-11-19 05:28:49',84,53),(136,'2024-11-19 05:28:49','2024-11-19 05:28:49',90,53),(137,'2024-11-19 05:28:49','2024-11-19 05:28:49',91,53),(138,'2024-11-19 05:28:49','2024-11-19 05:28:49',96,53),(139,'2024-11-19 05:29:29','2024-11-19 05:29:29',83,54),(140,'2024-11-19 05:29:29','2024-11-19 05:29:29',86,54),(141,'2024-11-19 05:29:29','2024-11-19 05:29:29',88,54),(142,'2024-11-19 05:29:29','2024-11-19 05:29:29',91,54),(143,'2024-11-19 05:29:29','2024-11-19 05:29:29',94,54),(144,'2024-11-19 05:30:13','2024-11-19 05:30:13',82,55),(145,'2024-11-19 05:30:13','2024-11-19 05:30:13',85,55),(146,'2024-11-19 05:30:13','2024-11-19 05:30:13',90,55),(147,'2024-11-19 05:30:13','2024-11-19 05:30:13',93,55),(148,'2024-11-19 05:30:13','2024-11-19 05:30:13',96,55),(149,'2024-11-19 05:31:35','2024-11-19 05:31:35',81,56),(150,'2024-11-19 05:31:35','2024-11-19 05:31:35',84,56),(151,'2024-11-19 05:31:35','2024-11-19 05:31:35',89,56),(152,'2024-11-19 05:31:35','2024-11-19 05:31:35',92,56),(153,'2024-11-19 05:31:35','2024-11-19 05:31:35',94,56),(154,'2024-11-19 05:33:31','2024-11-19 05:33:31',83,57),(155,'2024-11-19 05:33:31','2024-11-19 05:33:31',86,57),(156,'2024-11-19 05:33:31','2024-11-19 05:33:31',88,57),(157,'2024-11-19 05:33:31','2024-11-19 05:33:31',91,57),(158,'2024-11-19 05:33:31','2024-11-19 05:33:31',96,57),(159,'2024-11-19 05:34:33','2024-11-19 05:34:33',80,58),(160,'2024-11-19 05:34:33','2024-11-19 05:34:33',85,58),(161,'2024-11-19 05:34:33','2024-11-19 05:34:33',89,58),(162,'2024-11-19 05:34:33','2024-11-19 05:34:33',93,58),(163,'2024-11-19 05:34:33','2024-11-19 05:34:33',96,58),(164,'2024-11-19 05:35:26','2024-11-19 05:35:26',82,59),(165,'2024-11-19 05:35:26','2024-11-19 05:35:26',84,59),(166,'2024-11-19 05:35:26','2024-11-19 05:35:26',90,59),(167,'2024-11-19 05:35:26','2024-11-19 05:35:26',91,59),(168,'2024-11-19 05:35:26','2024-11-19 05:35:26',94,59),(169,'2024-11-19 05:36:14','2024-11-19 05:36:14',81,60),(170,'2024-11-19 05:36:14','2024-11-19 05:36:14',86,60),(171,'2024-11-19 05:36:14','2024-11-19 05:36:14',89,60),(172,'2024-11-19 05:36:14','2024-11-19 05:36:14',92,60),(173,'2024-11-19 05:36:14','2024-11-19 05:36:14',96,60),(174,'2024-11-19 05:36:50','2024-11-19 05:36:50',83,61),(175,'2024-11-19 05:36:50','2024-11-19 05:36:50',85,61),(176,'2024-11-19 05:36:50','2024-11-19 05:36:50',88,61),(177,'2024-11-19 05:36:50','2024-11-19 05:36:50',93,61),(178,'2024-11-19 05:36:50','2024-11-19 05:36:50',96,61),(179,'2024-11-19 05:37:19','2024-11-19 05:37:19',80,62),(180,'2024-11-19 05:37:19','2024-11-19 05:37:19',84,62),(181,'2024-11-19 05:37:19','2024-11-19 05:37:19',90,62),(182,'2024-11-19 05:37:19','2024-11-19 05:37:19',91,62),(183,'2024-11-19 05:37:19','2024-11-19 05:37:19',96,62),(184,'2024-11-20 07:07:01','2024-11-20 07:07:01',80,63),(185,'2024-11-20 07:07:01','2024-11-20 07:07:01',84,63),(186,'2024-11-20 07:07:01','2024-11-20 07:07:01',89,63),(187,'2024-11-20 07:07:01','2024-11-20 07:07:01',93,63),(188,'2024-11-20 07:07:01','2024-11-20 07:07:01',94,63),(189,'2024-11-20 07:08:05','2024-11-20 07:08:05',80,64),(190,'2024-11-20 07:08:05','2024-11-20 07:08:05',86,64),(191,'2024-11-20 07:08:05','2024-11-20 07:08:05',90,64),(192,'2024-11-20 07:08:05','2024-11-20 07:08:05',93,64),(193,'2024-11-20 07:08:05','2024-11-20 07:08:05',94,64),(194,'2024-11-20 07:10:08','2024-11-20 07:10:08',80,65),(195,'2024-11-20 07:10:08','2024-11-20 07:10:08',84,65),(196,'2024-11-20 07:10:08','2024-11-20 07:10:08',89,65),(197,'2024-11-20 07:10:08','2024-11-20 07:10:08',91,65),(198,'2024-11-20 07:10:08','2024-11-20 07:10:08',94,65);
/*!40000 ALTER TABLE `pet_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet_image`
--

DROP TABLE IF EXISTS `pet_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pet_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pet_id_idx` (`pet_id`),
  CONSTRAINT `fk_pet_image_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`idpet`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet_image`
--

LOCK TABLES `pet_image` WRITE;
/*!40000 ALTER TABLE `pet_image` DISABLE KEYS */;
INSERT INTO `pet_image` VALUES (1,63,'pet_images/Y566hBVoDpJytZsMcw8nIhE9DAPYGjIdQTtmWllD.png','2024-11-20 07:07:01','2024-11-20 07:07:01',NULL),(2,64,'pet_images/bicDkQ6qhLNeDSiyLm2VbPft4HUv6bLtYLcobPMV.jpg','2024-11-20 07:08:05','2024-11-20 07:08:05',NULL),(3,65,'pet_images/1rns5dA5OqIJBcwYOdJcZE0W1WZUuuUO0j2vWNkS.png','2024-11-20 07:10:08','2024-11-20 07:10:08',NULL),(4,65,'pet_images/3RpVwayuOxmNrX7CaXX48AomAxBZR4g9WqFwvlMB.jpg','2024-11-20 07:10:08','2024-11-20 07:10:08',NULL),(5,65,'pet_images/p6OKRZBlbtv3t8NtRpDykpAfjCm0up6G7PKn2Kcy.jpg','2024-11-20 07:10:08','2024-11-20 07:10:08',NULL);
/*!40000 ALTER TABLE `pet_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet_video`
--

DROP TABLE IF EXISTS `pet_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pet_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) DEFAULT NULL,
  `video_path` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pet_id_idx` (`pet_id`),
  CONSTRAINT `fk_pet_video_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`idpet`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet_video`
--

LOCK TABLES `pet_video` WRITE;
/*!40000 ALTER TABLE `pet_video` DISABLE KEYS */;
INSERT INTO `pet_video` VALUES (1,65,'pet_videos/ObTCTGbZU7g0ICHVTniPxMBMRylxH8vWOmCHmEPC.mp4','2024-11-20 07:10:08','2024-11-20 07:10:08',NULL);
/*!40000 ALTER TABLE `pet_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preference_table`
--

DROP TABLE IF EXISTS `preference_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preference_table` (
  `idpreference` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `selected_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpreference`),
  KEY `selected_id_idx` (`selected_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `selected_id` FOREIGN KEY (`selected_id`) REFERENCES `selection_store` (`idselection_store`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preference_table`
--

LOCK TABLES `preference_table` WRITE;
/*!40000 ALTER TABLE `preference_table` DISABLE KEYS */;
INSERT INTO `preference_table` VALUES (67,'2024-11-17 01:29:21','2024-11-17 02:24:10',80,84),(68,'2024-11-17 01:34:18','2024-11-17 02:45:56',84,84),(69,'2024-11-17 02:45:56','2024-11-17 02:45:56',79,84),(70,'2024-11-19 04:26:20','2024-11-19 04:26:20',81,85),(71,'2024-11-19 04:26:23','2024-11-19 04:26:23',84,85),(72,'2024-11-19 04:26:27','2024-11-19 04:26:27',88,85),(73,'2024-11-19 04:26:31','2024-11-19 04:26:31',91,85),(74,'2024-11-19 04:26:34','2024-11-19 04:26:34',94,85),(75,'2024-11-19 04:37:48','2024-11-19 04:37:48',82,86),(76,'2024-11-19 04:37:56','2024-11-19 04:37:56',86,86),(77,'2024-11-19 04:38:01','2024-11-19 04:38:01',89,86),(78,'2024-11-19 04:38:08','2024-11-19 04:38:08',93,86),(79,'2024-11-19 04:38:11','2024-11-19 04:38:11',94,86),(80,'2024-11-19 04:39:45','2024-11-19 04:39:45',83,87),(81,'2024-11-19 04:39:50','2024-11-19 04:39:50',85,87),(82,'2024-11-19 04:39:53','2024-11-19 04:39:53',88,87),(83,'2024-11-19 04:39:57','2024-11-19 04:39:57',92,87),(84,'2024-11-19 04:40:00','2024-11-19 04:40:00',94,87),(85,'2024-11-19 04:41:55','2024-11-19 04:41:55',81,88),(86,'2024-11-19 04:41:59','2024-11-19 04:41:59',87,88),(87,'2024-11-19 04:42:02','2024-11-19 04:42:02',89,88),(88,'2024-11-19 04:42:06','2024-11-19 04:42:06',91,88),(89,'2024-11-19 04:42:09','2024-11-19 04:42:09',94,88),(90,'2024-11-20 06:25:44','2024-11-20 06:25:44',80,89),(91,'2024-11-20 06:25:56','2024-11-20 06:25:56',84,89),(92,'2024-11-20 06:26:26','2024-11-20 06:26:26',89,89),(93,'2024-11-20 06:27:18','2024-11-20 06:27:18',91,89),(94,'2024-11-20 06:27:25','2024-11-20 06:27:25',94,89);
/*!40000 ALTER TABLE `preference_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `selection_store`
--

DROP TABLE IF EXISTS `selection_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `selection_store` (
  `idselection_store` int(11) NOT NULL AUTO_INCREMENT,
  `selection_name` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `img` text DEFAULT NULL,
  `choice` varchar(45) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idselection_store`),
  KEY `fk_category_id` (`category_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category_store` (`idcategory_store`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `selection_store`
--

LOCK TABLES `selection_store` WRITE;
/*!40000 ALTER TABLE `selection_store` DISABLE KEYS */;
INSERT INTO `selection_store` VALUES (79,'Exercise to maintain my health',26,'2024-11-08 06:24:54','2024-11-08 06:41:24',NULL,'Active','2024-11-08 07:55:02'),(80,'Chill',26,'2024-11-08 06:41:24','2024-11-14 09:04:00',NULL,'Calm',NULL),(81,'Jolly',26,'2024-11-14 09:04:00','2024-11-14 09:04:00',NULL,'Clingy',NULL),(82,'Adventurous',26,'2024-11-14 09:04:00','2024-11-14 09:04:00',NULL,'energetic',NULL),(83,'Not sure',26,'2024-11-14 09:04:00','2024-11-14 09:04:00',NULL,'none',NULL),(84,'A snug space with a few close friends or family members',27,'2024-11-17 01:28:39','2024-11-17 01:28:39',NULL,'Small',NULL),(85,'A lively atmosphere with a good mix of activities and people',27,'2024-11-17 01:28:39','2024-11-17 01:28:39',NULL,'Medium',NULL),(86,'A bustling environment filled with energy and excitement',27,'2024-11-17 01:28:39','2024-11-17 01:28:39',NULL,'Large',NULL),(87,'Anything habitable',27,'2024-11-17 01:28:39','2024-11-17 01:28:39',NULL,'None',NULL),(88,'When considering your living environment, how adaptable do you feel?',28,'2024-11-19 04:17:54','2024-11-19 04:17:54',NULL,'pet with head injury',NULL),(89,'I can adapt to some extent but prefer a routine that suits both my needs and my pet’s',28,'2024-11-19 04:17:54','2024-11-19 04:17:54',NULL,'Pet with an eye injuiry',NULL),(90,'I thrive on spontaneity and prefer an environment that allows for quick changes and activities.',28,'2024-11-19 04:17:54','2024-11-19 04:17:54',NULL,'Healthy Pets',NULL),(91,'I’m excited about nurturing and shaping someone new, helping them grow and learn',29,'2024-11-19 04:18:59','2024-11-19 04:18:59',NULL,'young',NULL),(92,'I prefer a balance between playfulness and maturity, enjoying the best of both worlds',29,'2024-11-19 04:18:59','2024-11-19 04:18:59',NULL,'Young Adult',NULL),(93,'I value wisdom and companionship, finding comfort in established routines and calmness. (',29,'2024-11-19 04:18:59','2024-11-19 04:18:59',NULL,'Senior',NULL),(94,'I like to lead and take charge, often enjoying the thrill of being at the forefront.',30,'2024-11-19 04:19:52','2024-11-19 04:19:52',NULL,'Male',NULL),(95,'I appreciate collaboration and enjoy sharing responsibilities equally.',30,'2024-11-19 04:19:52','2024-11-19 04:19:52',NULL,'None',NULL),(96,'I prefer to follow and support others, providing a solid foundation for the team.',30,'2024-11-19 04:19:52','2024-11-19 04:19:52',NULL,'Female',NULL);
/*!40000 ALTER TABLE `selection_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('b6miWYr3hT42qBXlNoT0Zngyroq0KmkzujuDGmXW',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo5OntzOjY6Il90b2tlbiI7czo0MDoidVZ5b1FuQXBpUEFjYnBTZ2Z5UGY2b0tLSFJLUHdoeVhhRk9LTDF4MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9xciI7fXM6MjoiaWQiO2k6Njc7czo1OiJlbWFpbCI7czoxNToiamVyYnlAZ21haWwuY29tIjtzOjg6InVzZXJSb2xlIjtzOjg6ImlzX3N0YWZmIjtzOjEyOiJhcHBsaWNhbnRfaWQiO3M6MjoiNDciO3M6MTA6ImlkX2FkZHJlc3MiO2k6MzI7czoxNzoiem9vbV9hY2Nlc3NfdG9rZW4iO3M6NjQ0OiJleUp6ZGlJNklqQXdNREF3TVNJc0ltRnNaeUk2SWtoVE5URXlJaXdpZGlJNklqSXVNQ0lzSW10cFpDSTZJamd4TVRjMVlUazRMVFl4TkRFdE5EQmpOQzFoT0dabUxUbGlOV1pqWVRGalpEUTVZaUo5LmV5SjJaWElpT2pFd0xDSmhkV2xrSWpvaVlUVTFOR1kzWlRFeU9XUmpNV1k1T1RNNU5HVXdOV1ZrTURVNU1XVXhNbVEwTURNMU5qSmhZV0V3WTJJNFpERXlNVFl5WldFeE9EYzJPRE00TURRMU5pSXNJbU52WkdVaU9pSmFiMGhZV2pKUWRqTk9lVmhYVVV0cVpVWnVVM2t0YTBGWk5tSjRUMlZxTkhjaUxDSnBjM01pT2lKNmJUcGphV1E2TWtScGVYSTRPV3hSWjJrNVVFbElWMkZuTnpGbFVTSXNJbWR1YnlJNk1Dd2lkSGx3WlNJNk1Dd2lkR2xrSWpvd0xDSmhkV1FpT2lKb2RIUndjem92TDI5aGRYUm9MbnB2YjIwdWRYTWlMQ0oxYVdRaU9pSnVaRkZ4Y3pZM05GUXdkV1ZIUkhCSVFuRTJkRWxSSWl3aWJtSm1Jam94TnpNeU1Ea3hORFl6TENKbGVIQWlPakUzTXpJd09UVXdOak1zSW1saGRDSTZNVGN6TWpBNU1UUTJNeXdpWVdsa0lqb2lka1ZEZHpOc05UTlNNbWw0ZUZacmFFVkVVRVExZHlKOS5yeUhja0xpQmo2UTl3OTdXbHVRM0MyaDNfeUJFN3ZmVnVJWHp0bUdld2V2WW9Yc19sWlpRN2dpWTVDN0FrUVhjS3luUC1LRmVZQkFabUVLbExHbFN2USI7fQ==',1732091560),('G4Kz49caH2y8OY2dxhqFNVYL8RKp8Kcizi4j2HUz',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoickd3ZExWSHdlSERYc25QWnlZNzZFejZFT3Q4RXR0ZktuYlIzbmxQUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXQtdXBsb2FkIjt9czoyOiJpZCI7aTo2NztzOjU6ImVtYWlsIjtzOjE1OiJqZXJieUBnbWFpbC5jb20iO3M6ODoidXNlclJvbGUiO3M6ODoiaXNfc3RhZmYiO30=',1732089911),('kzbSN7Fn9cg3huvdyEu8KppZLsCbhwbCA1L1Sfit',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoib3BUNzRWNnZhNFRTY295ZGtDdjZVRGR0dnhpSlhIdm5nYms5dGdiSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb21wYXRpYmlsaXR5LzY1Ijt9czoyOiJpZCI7aTo4NDtzOjU6ImVtYWlsIjtzOjE1OiJoYW5uaUBnbWFpbC5jb20iO3M6ODoidXNlclJvbGUiO3M6NzoiaXNfdXNlciI7fQ==',1732090171),('pO78BFlHQWzovf8IKnYyga1jkLmvm38hCsxJ2Vx0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiS1NMcDF2cndOZEM0d0p5WTNrekp0ZGR1SFQ5T0Exc2h5NUNIdEtRMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG9wdGlvbi9hcHBseS81NiI7fXM6MjoiaWQiO2k6ODQ7czo1OiJlbWFpbCI7czoxNToiaGFubmlAZ21haWwuY29tIjtzOjg6InVzZXJSb2xlIjtzOjc6ImlzX3VzZXIiO3M6NToicGV0SWQiO3M6MjoiNTYiO30=',1732087505),('s5ksj9WQZaR7tRCzEGYfIui4Gfc4XHBlzs7KSYWg',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoidGQwZ3NQa2xRTjRqaVRsa2JHa1RWeEZydjltQ0pWTGwzM245WXJBTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXQtdXBsb2FkIjt9czoyOiJpZCI7aTo2NztzOjU6ImVtYWlsIjtzOjE1OiJqZXJieUBnbWFpbC5jb20iO3M6ODoidXNlclJvbGUiO3M6ODoiaXNfc3RhZmYiO30=',1732086752),('YdCtvcsKmbbx64uNtr8rgNBoUpNBR5vXeUK4aeaA',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiN2Rzc0NQRFNqVm1jVmZ1Y1UyWmU3dFpVazlzaUFuVFFoa21HRTJpeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lcGFnZSI7fXM6MjoiaWQiO2k6ODQ7czo1OiJlbWFpbCI7czoxNToiaGFubmlAZ21haWwuY29tIjtzOjg6InVzZXJSb2xlIjtzOjc6ImlzX3VzZXIiO30=',1732092476);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `idaddresses` int(11) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `idusertype` int(11) DEFAULT NULL,
  `is_verified` enum('Verified','Not_verified') DEFAULT 'Not_verified',
  `is_online` enum('Online','Offline') DEFAULT 'Offline',
  `phone_no` int(11) DEFAULT NULL,
  `goverment_id` text DEFAULT NULL,
  `id_employment` int(11) DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `selfie` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `idaddresses_idx` (`idaddresses`),
  KEY `idusertype_idx` (`idusertype`),
  KEY `id_employ_idx` (`id_employment`),
  CONSTRAINT `id_employ` FOREIGN KEY (`id_employment`) REFERENCES `employment_info` (`idemployment_info`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idaddresses` FOREIGN KEY (`idaddresses`) REFERENCES `addresses` (`idaddresses`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idusertype` FOREIGN KEY (`idusertype`) REFERENCES `usertype` (`idusertype`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (64,'test@gmail.com',NULL,'$2y$12$LAo3W.6/7holBzT4PzrR8uYwb.Oz2UechEYOI0p/hSoUhsWF9fyFK',NULL,'2024-09-29 06:53:14','2024-09-29 06:53:14',NULL,NULL,'harold','turla','mito',3,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(65,'mikoyaesoloacc@gmail.com',NULL,'$2y$12$ar8jkeC0mgkHmjQ5rD1rSe07Lyvv54a9ZONy1aTFc5FNrExpKhZka',NULL,'2024-09-30 04:18:10','2024-09-30 04:20:04',NULL,2,'John','Turla','Mito',7,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(66,'test@example.com',NULL,'karina123',NULL,'2024-10-05 12:09:27','2024-10-05 12:10:27',NULL,1,'harold','turla','mito',8,'Verified','Online',NULL,NULL,NULL,NULL,NULL),(67,'jerby@gmail.com',NULL,'$2y$12$5Af8VSXGYD82peAGtTgyMOfk65XoysOuVftxkAO3RwE19Vn4Fzykm',NULL,'2024-10-11 23:33:54','2024-11-19 08:48:43',NULL,33,'Joseph','Ernnest','Balita',9,'Verified','Offline',NULL,NULL,13,NULL,NULL),(79,'robbiepogi@gmail.com',NULL,'$2y$12$c31cMqrTIxwFFCcVAqVKdeAPQ9SVWiuWrReFggk1ax0vcqvWaW6Pa',NULL,'2024-10-12 09:52:37','2024-10-12 09:52:59',NULL,4,'Robbie','Dimarucut','Cerezo',21,'Verified','Online',NULL,NULL,NULL,NULL,NULL),(80,'bryce@gmail.com',NULL,'$2y$12$JFLPjBCditwZzHB6sBnSnOlcG64yCKqaBeIQGr8gU9BjzAXMNJ51G',NULL,'2024-10-12 16:51:38','2024-10-12 16:51:59',NULL,5,'bryce','pusod','galamay',22,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(81,'lorenzofhilip7@gmail.com',NULL,'$2y$12$brbLbuNk78SE5ziL67pJd.bWE2U61KZhdPyIW5V56xtR6Oy0XBqr2',NULL,'2024-10-13 03:08:58','2024-10-13 03:09:28',NULL,6,'Pilip','Panesa','Lorenzo',23,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(82,'vannpcruz13@gmail.com',NULL,'$2y$12$bArvKj8vbDhif16Zdj29COYZwr0ZUj7ajvb1TftQgtvxdJRvdl3vC',NULL,'2024-10-13 06:32:43','2024-10-13 06:34:13',NULL,7,'vannesa','Palahang','cruz',24,'Verified','Online',NULL,NULL,NULL,NULL,NULL),(84,'hanni@gmail.com',NULL,'$2y$12$Ra4k9RLuwkYI9JPvc9Bf1OBTl0.HcMlVeto7WmRDWgSK/exKzU9w6',NULL,'2024-10-26 07:55:42','2024-11-01 06:19:55',NULL,32,'Hanni','pham','pham',26,'Verified','Online',NULL,'valid_ids/4YaQBNXeYrQnj7xMW1z8rvTyEuMIPu1asnMx5IZG.jpg',12,'valid_ids/Fd6SprS2xXNntOy7hLYHv5yr0kfAmLUxVU79ZSUE.jpg','selfies/selfie_6724730be784f.png'),(85,'john.smith@example.com',NULL,'$2y$12$TnErFZd5VfxzZ3vTiPv9FuXk5fa8aH7V2v4PeWp0gFUPh4es9bpEi',NULL,'2024-11-19 04:24:41','2024-11-19 04:25:06',NULL,NULL,'John','Michael','Smith',27,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(86,'emily.johnson@example.com',NULL,'$2y$12$EAz0heAeFIjHnK/944zqjOx/08bTEiV3BUe1fGonws.LNXBf14EZm',NULL,'2024-11-19 04:36:59','2024-11-19 04:37:20',NULL,NULL,'Emily','Rose','Johnson',28,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(87,'james.brown@example.com',NULL,'$2y$12$b5sAXpd0nzk/cZzXTHcbCuDy/w3ogOuNvoUzlodzp6eVsKXj/xvGG',NULL,'2024-11-19 04:39:13','2024-11-19 04:39:29',NULL,NULL,'James','David','Brown',29,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(88,'sarah.taylor@example.com',NULL,'$2y$12$KSLAG6JOyHqF1LvqZjkQhemnmc.CurprXCoDHxz3do6RIgubGZCWO',NULL,'2024-11-19 04:41:21','2024-11-19 04:41:37',NULL,NULL,'Sarah','Anne','taylor',30,'Verified','Offline',NULL,NULL,NULL,NULL,NULL),(89,'geromewillmanzano@gmail.com',NULL,'$2y$12$dISI5HL65ryjtQJbMcmlX.ai0I0U3C/eOYQ9ys.OW.KVtRLBdueOq',NULL,'2024-11-20 06:24:37','2024-11-20 06:30:18',NULL,34,'Gerome','Will','Manzano',31,'Verified','Offline',NULL,'valid_ids/fFTmOfj58lbMJY3yrLS4Ew8HtEy2Yr4Dnnhrqsty.jpg',19,'valid_ids/aXDqT9AAeugVslIjfjvDahNVxCUL3udwEMnU9quv.png','selfies/selfie_673d81fa03ce8.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertype` (
  `idusertype` int(11) NOT NULL AUTO_INCREMENT,
  `userRole` enum('is_admin','is_staff','is_user') DEFAULT 'is_user',
  PRIMARY KEY (`idusertype`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'is_admin'),(3,'is_admin'),(4,'is_user'),(5,'is_user'),(6,'is_user'),(7,'is_user'),(8,'is_user'),(9,'is_staff'),(10,'is_user'),(11,'is_user'),(12,'is_user'),(13,'is_user'),(14,'is_user'),(15,'is_user'),(16,'is_user'),(17,'is_user'),(18,'is_user'),(19,'is_user'),(20,'is_user'),(21,'is_user'),(22,'is_user'),(23,'is_user'),(24,'is_user'),(25,'is_user'),(26,'is_user'),(27,'is_user'),(28,'is_user'),(29,'is_user'),(30,'is_user'),(31,'is_user');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-20 16:50:28
