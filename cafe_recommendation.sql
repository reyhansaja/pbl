-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 20, 2026 at 05:59 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_recommendation`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps_embed` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`id`, `user_id`, `name`, `slug`, `about`, `address`, `maps_embed`, `created_at`, `updated_at`) VALUES
(1, 2, 'The Gilded Bean', 'the-gilded-bean', 'The Gilded Bean is more than just a coffee shop. It\'s a cultural melting pot nestled in the heart of the Creative District, supplying the finest single-origin beans alongside artisanal pastries and light meals. Our space is designed to be a sanctuary for the curious mind, a place for the heart and Soul of Exploration. Step inside and discover a world of carefully curated flavors, from exotic pour-overs to decadent espresso-based creations.', 'Jl. Braga No. 58, Bandung, Jawa Barat', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.60881!3d-6.917464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDIuOSJTIDEwN8KwMzYnMzEuNyJF!5e0!3m2!1sid!2sid!4v1234567890\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 3, 'Kopi Nusantara', 'kopi-nusantara', 'Kopi Nusantara merupakan cafe yang mengusung konsep tradisional Indonesia modern. Kami menyajikan kopi-kopi terbaik dari seluruh penjuru nusantara, dari Aceh Gayo hingga Toraja. Suasana yang hangat dengan sentuhan budaya Indonesia akan membuat Anda betah berlama-lama. Nikmati juga aneka kudapan tradisional yang telah kami modernisasi untuk selera masa kini.', 'Jl. Dago No. 123, Bandung, Jawa Barat', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.61881!3d-6.885464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTMnMDcuNyJTIDEwN8KwMzcnMDcuNyJF!5e0!3m2!1sid!2sid!4v1234567890\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 4, 'Brew & Beyond', 'brew-beyond', 'Brew & Beyond is a specialty coffee experience that takes you on a journey through the world of third-wave coffee. Our baristas are trained experts who craft each cup with precision and passion. We source our beans directly from farms on three continents, ensuring that every sip tells a story. The minimalist Scandinavian interior creates the perfect backdrop for focused work or intimate conversations.', 'Jl. Riau No. 45, Bandung, Jawa Barat', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.62881!3d-6.908464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTQnMzAuNSJTIDEwN8KwMzcnNDMuNyJF!5e0!3m2!1sid!2sid!4v1234567890\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 5, 'Rumah Kopi Heritage', 'rumah-kopi-heritage', 'Rumah Kopi Heritage adalah tempat di mana tradisi bertemu inovasi. Terletak di bangunan heritage yang telah direstorasi dengan penuh cinta, cafe kami menawarkan pengalaman ngopi yang tak terlupakan. Menu kami memadukan resep kopi turun-temurun dengan teknik brewing modern. Setiap sudut ruangan menceritakan kisah sejarah kopi Indonesia yang kaya.', 'Jl. Asia Afrika No. 89, Bandung, Jawa Barat', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.60581!3d-6.921464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMTcuMyJTIDEwN8KwMzYnMjAuOSJF!5e0!3m2!1sid!2sid!4v1234567890\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', '2026-04-19 04:00:53', '2026-04-19 04:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_photos`
--

CREATE TABLE `cafe_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `cafe_id` bigint UNSIGNED NOT NULL,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cafe_photos`
--

INSERT INTO `cafe_photos` (`id`, `cafe_id`, `photo_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'cafe-photos/default1.jpg', 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 1, 'cafe-photos/default2.jpg', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 1, 'cafe-photos/default3.jpg', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 2, 'cafe-photos/default4.jpg', 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(5, 2, 'cafe-photos/default5.jpg', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(6, 3, 'cafe-photos/default6.jpg', 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(7, 3, 'cafe-photos/default7.jpg', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(8, 4, 'cafe-photos/default8.jpg', 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(9, 4, 'cafe-photos/default9.jpg', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_schedules`
--

CREATE TABLE `cafe_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `cafe_id` bigint UNSIGNED NOT NULL,
  `day` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cafe_schedules`
--

INSERT INTO `cafe_schedules` (`id`, `cafe_id`, `day`, `open_time`, `close_time`, `is_closed`, `created_at`, `updated_at`) VALUES
(1, 1, 'monday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 1, 'tuesday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 1, 'wednesday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 1, 'thursday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(5, 1, 'friday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(6, 1, 'saturday', '08:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(7, 1, 'sunday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(8, 2, 'monday', '07:00:00', '23:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(9, 2, 'tuesday', '07:00:00', '23:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(10, 2, 'wednesday', '07:00:00', '23:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(11, 2, 'thursday', '07:00:00', '23:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(12, 2, 'friday', '07:00:00', '23:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(13, 2, 'saturday', '08:00:00', '23:59:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(14, 2, 'sunday', '08:00:00', '23:59:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(15, 3, 'monday', NULL, NULL, 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(16, 3, 'tuesday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(17, 3, 'wednesday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(18, 3, 'thursday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(19, 3, 'friday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(20, 3, 'saturday', '09:00:00', '21:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(21, 3, 'sunday', '10:00:00', '18:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(22, 4, 'monday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(23, 4, 'tuesday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(24, 4, 'wednesday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(25, 4, 'thursday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(26, 4, 'friday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(27, 4, 'saturday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(28, 4, 'sunday', '10:00:00', '22:00:00', 0, '2026-04-19 04:00:53', '2026-04-19 04:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cafe_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `cafe_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 6, 2, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 7, 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 7, 4, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(5, 8, 1, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(6, 8, 3, '2026-04-19 04:00:53', '2026-04-19 04:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_01_000001_add_role_to_users_table', 1),
(6, '2024_01_01_000002_create_cafes_table', 1),
(7, '2024_01_01_000003_create_cafe_photos_table', 1),
(8, '2024_01_01_000004_create_cafe_schedules_table', 1),
(9, '2024_01_01_000005_create_reviews_table', 1),
(10, '2024_01_01_000006_create_review_replies_table', 1),
(11, '2024_01_01_000007_create_favorites_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cafe_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `cafe_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 5, 'This place exceeded every expectation. The single-origin coffee from a smallholding in Ethiopia was mind-blowing — juicy, floral, and incredibly complex. The interior is stunning, and the baristas clearly know their craft. A must-visit for any serious coffee lover.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 7, 1, 4, 'Tempatnya sangat nyaman dan estetik. Kopi latte-nya enak banget, tapi harganya agak mahal untuk ukuran Bandung. Overall, worth it untuk pengalaman dan suasananya.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 8, 1, 5, 'The croissants here are divine! And the pour-over coffee is perfectly brewed. The staff is friendly and knowledgeable about their beans. Will definitely come back.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(5, 7, 2, 4, 'Kopi Gayo-nya mantap! Suasananya juga enak banget, ada sentuhan tradisional yang bikin betah. Recommended!', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(6, 6, 3, 4, 'Great third-wave coffee spot. The V60 pour-over was exceptional. Clean, minimalist design makes it perfect for working. WiFi is fast too!', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(7, 8, 3, 5, 'Best specialty coffee in town. The barista took time to explain the flavor notes and brewing method. Such a wonderful experience.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(8, 7, 4, 5, 'Tempat yang luar biasa! Bangunan heritage-nya cantik sekali, dan kopi tubruknya enak banget. Bisa merasakan sejarah di setiap tegukan.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(9, 8, 4, 4, 'The heritage building is absolutely gorgeous. The traditional coffee recipes are unique and delicious. A true gem in the city.', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(10, 6, 2, 5, 'Kopinya mantap', '2026-04-19 04:16:35', '2026-04-19 04:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `review_replies`
--

CREATE TABLE `review_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_replies`
--

INSERT INTO `review_replies` (`id`, `review_id`, `user_id`, `reply`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Thank you so much, Diana! We\'re thrilled you enjoyed the Ethiopian single-origin. Our team puts a lot of love into every cup. Hope to see you again soon! ☕', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 2, 2, 'Terima kasih atas review-nya, Budi! Kami appreciate feedbacknya tentang harga. Kami selalu berusaha memberikan kualitas terbaik. Semoga bisa berkunjung lagi!', '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 8, 5, 'Terima kasih banyak, Budi! Kami bangga bisa menjaga warisan budaya kopi Indonesia melalui tempat ini. Selamat datang kembali kapan saja!', '2026-04-19 04:00:53', '2026-04-19 04:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','owner','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `avatar`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, 'admin@thehearth.com', NULL, '$2y$10$G57w5IDSxchjdqUJHOp6jeqY/f7PD3sRAzBsqyYvXWdTPYXU5WGo6', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(2, 'Marco Rossi', 'owner', NULL, 'marco@thehearth.com', NULL, '$2y$10$pGycKCVcQ6C5c7KXi18./eTROsjEzVDW.sf8M2l.wVO8r8o9dDPEG', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(3, 'Sari Wijaya', 'owner', NULL, 'sari@thehearth.com', NULL, '$2y$10$prcfhuLYcir7VujcAkn5.euk35hAXei0x3D7/0OwnzJOs5cG25VOu', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(4, 'James Chen', 'owner', NULL, 'james@thehearth.com', NULL, '$2y$10$FJOJvgCko3WsrNyNSTl7GeD4ljgKrjyY2HMdZ/afDF/XronERUJn2', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(5, 'Ayu Pratiwi', 'owner', NULL, 'ayu@thehearth.com', NULL, '$2y$10$QlMHiZAhqA4rsGIAIuZaLu5OcrjOR8.swIXfNp4HzIg3UftnUGbZ6', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(6, 'Diana Hartley', 'user', NULL, 'diana@example.com', NULL, '$2y$10$HoUc9Ii5N.CoO.9APS6D..KXBzfx8MLrHBlw6eDQSB5YkJw.Cpd.u', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(7, 'Budi Santoso', 'user', NULL, 'budi@example.com', NULL, '$2y$10$SApjJNUAJZfjXKhSedAbE.OoAanDoNgofHxtU6DCNCRihH.R/3df6', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(8, 'Emily Watson', 'user', NULL, 'emily@example.com', NULL, '$2y$10$DCE74yRFg.Hhw2AjnQ43euigfH3UPfG6IuY/KE0/FVN2oyFoqbZ6.', NULL, '2026-04-19 04:00:53', '2026-04-19 04:00:53'),
(9, 'Test User', 'user', NULL, 'testuser@example.com', NULL, '$2y$10$IFMJcl4LpJWDeIY3YC2vdOcNGTu1DE/yRyRVDZhjb2YyXNb7aIrbC', NULL, '2026-04-19 04:15:49', '2026-04-19 04:15:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cafes_slug_unique` (`slug`),
  ADD KEY `cafes_user_id_foreign` (`user_id`);

--
-- Indexes for table `cafe_photos`
--
ALTER TABLE `cafe_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cafe_photos_cafe_id_foreign` (`cafe_id`);

--
-- Indexes for table `cafe_schedules`
--
ALTER TABLE `cafe_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cafe_schedules_cafe_id_foreign` (`cafe_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_cafe_id_unique` (`user_id`,`cafe_id`),
  ADD KEY `favorites_cafe_id_foreign` (`cafe_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_user_id_cafe_id_unique` (`user_id`,`cafe_id`),
  ADD KEY `reviews_cafe_id_foreign` (`cafe_id`);

--
-- Indexes for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_replies_review_id_foreign` (`review_id`),
  ADD KEY `review_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cafe_photos`
--
ALTER TABLE `cafe_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cafe_schedules`
--
ALTER TABLE `cafe_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `review_replies`
--
ALTER TABLE `review_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cafes`
--
ALTER TABLE `cafes`
  ADD CONSTRAINT `cafes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cafe_photos`
--
ALTER TABLE `cafe_photos`
  ADD CONSTRAINT `cafe_photos_cafe_id_foreign` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cafe_schedules`
--
ALTER TABLE `cafe_schedules`
  ADD CONSTRAINT `cafe_schedules_cafe_id_foreign` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_cafe_id_foreign` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_cafe_id_foreign` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD CONSTRAINT `review_replies_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
