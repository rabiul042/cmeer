-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2020 at 11:14 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmeer`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `batch_code` int(11) NOT NULL,
  `start_index` int(11) NOT NULL,
  `end_index` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `fee_type` varchar(255) NOT NULL,
  `admission_fee` int(11) NOT NULL DEFAULT 0,
  `lecture_sheet_discount` int(11) NOT NULL DEFAULT 0,
  `old_student_discount` int(11) NOT NULL DEFAULT 0,
  `payment_times` int(11) NOT NULL,
  `minimum_payment` int(11) NOT NULL COMMENT '%',
  `details` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `name`, `batch_code`, `start_index`, `end_index`, `institute_id`, `course_id`, `subject_id`, `branch_id`, `fee_type`, `admission_fee`, `lecture_sheet_discount`, `old_student_discount`, `payment_times`, `minimum_payment`, `details`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'New Batch-1', 11, 1, 100, 1, 1, NULL, 1, 'Batch', 10, 0, 0, 1, 100, '<p>Will be added latter...!!!</p>', 1, '2020-07-22 04:39:56', 13, '2020-09-04 23:19:56', 10);

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules`
--

CREATE TABLE `batches_schedules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tag_line` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_details` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `paper` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `initial_date` timestamp NULL DEFAULT NULL,
  `service_package_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `executive_id` int(11) DEFAULT NULL,
  `support_stuff_id` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0 = False, 1 = True',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batches_schedules`
--

INSERT INTO `batches_schedules` (`id`, `name`, `tag_line`, `address`, `contact_details`, `type`, `paper`, `year`, `session_id`, `institute_id`, `course_id`, `faculty_id`, `subject_id`, `batch_id`, `initial_date`, `service_package_id`, `room_id`, `executive_id`, `support_stuff_id`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Special Schedule for Batch Name', 'Online Exam & Lecture Class Schedule', 'Rangpur', '017777777777', NULL, NULL, 2020, 7, 1, 1, NULL, NULL, 1, '2020-09-08 18:00:00', NULL, 1, NULL, NULL, 1, '2020-09-05 11:28:09', 10, '2020-09-05 05:28:09', 10);

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_lecture_exam`
--

CREATE TABLE `batches_schedules_lecture_exam` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `schedule_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slot_id` int(11) NOT NULL,
  `topic_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `batches_schedules_lecture_exam`
--

INSERT INTO `batches_schedules_lecture_exam` (`id`, `schedule_id`, `schedule_date`, `slot_id`, `topic_id`, `teacher_id`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(10, 1, '2020-09-09', 1, ', 1', 0, 0, '2020-09-05 23:23:53', 0, '2020-09-05 23:23:53', NULL),
(11, 1, '2020-09-16', 1, ', 1, 2', 0, 0, '2020-09-05 23:23:53', 0, '2020-09-05 23:23:53', NULL),
(12, 1, '2020-09-24', 1, ', 1', 0, 0, '2020-09-05 23:23:53', 0, '2020-09-05 23:23:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_lecture_exam_topics`
--

CREATE TABLE `batches_schedules_lecture_exam_topics` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `lecture_exam_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_slots`
--

CREATE TABLE `batches_schedules_slots` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `slot_type` int(11) NOT NULL,
  `start_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `batches_schedules_slots`
--

INSERT INTO `batches_schedules_slots` (`id`, `schedule_id`, `slot_type`, `start_time`, `end_time`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 1, 1, '3:40 PM', '3:40 PM', 1, '2020-09-05 05:28:09', 10, '2020-09-05 05:28:09', NULL),
(4, 1, 3, '3:40 PM', '3:40 PM', 1, '2020-09-05 05:28:09', 10, '2020-09-05 05:28:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_slot_types`
--

CREATE TABLE `batches_schedules_slot_types` (
  `id` int(11) NOT NULL,
  `slot_type` int(11) NOT NULL,
  `slot_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `batches_schedules_slot_types`
--

INSERT INTO `batches_schedules_slot_types` (`id`, `slot_type`, `slot_name`) VALUES
(1, 1, 'Lecture'),
(2, 2, 'Exam'),
(3, 3, 'Break'),
(4, 4, 'Subject Final'),
(5, 5, 'Mock Test'),
(6, 6, 'Solve'),
(7, 7, 'Subject Final & Mock Test');

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_subjects`
--

CREATE TABLE `batches_schedules_subjects` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches_schedules_week_days`
--

CREATE TABLE `batches_schedules_week_days` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `batches_schedules_week_days`
--

INSERT INTO `batches_schedules_week_days` (`id`, `schedule_id`, `day_id`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 1, 3, 1, '2020-09-05 05:28:09', 10, '2020-09-05 05:28:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `batch_discipline_fees`
--

CREATE TABLE `batch_discipline_fees` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `admission_fee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `batch_shifting`
--

CREATE TABLE `batch_shifting` (
  `id` int(11) NOT NULL,
  `doctor_course_id` int(11) NOT NULL,
  `old_batch_id` int(11) NOT NULL,
  `new_batch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bcps_faculties`
--

CREATE TABLE `bcps_faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `omr_code` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`) VALUES
(1, 'Online');

-- --------------------------------------------------------

--
-- Table structure for table `coming_by`
--

CREATE TABLE `coming_by` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(70) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(80) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `institute_id`, `course_code`, `course_price`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Certificate Course on Hypertension', 1, '1', NULL, '2020-09-03 13:02:29', '13', '2020-09-03 13:02:29', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_session`
--

CREATE TABLE `course_session` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_session`
--

INSERT INTO `course_session` (`id`, `course_id`, `session_id`) VALUES
(4, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(2) UNSIGNED NOT NULL,
  `division_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `bn_name`, `lat`, `lon`, `website`) VALUES
(1, 3, 'Dhaka', 'ঢাকা', 23.7115253, 90.4111451, 'www.dhaka.gov.bd'),
(2, 3, 'Faridpur', 'ফরিদপুর', 23.6070822, 89.8429406, 'www.faridpur.gov.bd'),
(3, 3, 'Gazipur', 'গাজীপুর', 24.0022858, 90.4264283, 'www.gazipur.gov.bd'),
(4, 3, 'Gopalganj', 'গোপালগঞ্জ', 23.0050857, 89.8266059, 'www.gopalganj.gov.bd'),
(5, 8, 'Jamalpur', 'জামালপুর', 24.937533, 89.937775, 'www.jamalpur.gov.bd'),
(6, 3, 'Kishoreganj', 'কিশোরগঞ্জ', 24.444937, 90.776575, 'www.kishoreganj.gov.bd'),
(7, 3, 'Madaripur', 'মাদারীপুর', 23.164102, 90.1896805, 'www.madaripur.gov.bd'),
(8, 3, 'Manikganj', 'মানিকগঞ্জ', 0, 0, 'www.manikganj.gov.bd'),
(9, 3, 'Munshiganj', 'মুন্সিগঞ্জ', 0, 0, 'www.munshiganj.gov.bd'),
(10, 8, 'Mymensingh', 'ময়মনসিংহ', 0, 0, 'www.mymensingh.gov.bd'),
(11, 3, 'Narayanganj', 'নারায়াণগঞ্জ', 23.63366, 90.496482, 'www.narayanganj.gov.bd'),
(12, 3, 'Narsingdi', 'নরসিংদী', 23.932233, 90.71541, 'www.narsingdi.gov.bd'),
(13, 8, 'Netrokona', 'নেত্রকোণা', 24.870955, 90.727887, 'www.netrokona.gov.bd'),
(14, 3, 'Rajbari', 'রাজবাড়ি', 23.7574305, 89.6444665, 'www.rajbari.gov.bd'),
(15, 3, 'Shariatpur', 'শরীয়তপুর', 0, 0, 'www.shariatpur.gov.bd'),
(16, 8, 'Sherpur', 'শেরপুর', 25.0204933, 90.0152966, 'www.sherpur.gov.bd'),
(17, 3, 'Tangail', 'টাঙ্গাইল', 0, 0, 'www.tangail.gov.bd'),
(18, 5, 'Bogura', 'বগুড়া', 24.8465228, 89.377755, 'www.bogra.gov.bd'),
(19, 5, 'Joypurhat', 'জয়পুরহাট', 0, 0, 'www.joypurhat.gov.bd'),
(20, 5, 'Naogaon', 'নওগাঁ', 0, 0, 'www.naogaon.gov.bd'),
(21, 5, 'Natore', 'নাটোর', 24.420556, 89.000282, 'www.natore.gov.bd'),
(22, 5, 'Nawabganj', 'নবাবগঞ্জ', 24.5965034, 88.2775122, 'www.chapainawabganj.gov.bd'),
(23, 5, 'Pabna', 'পাবনা', 23.998524, 89.233645, 'www.pabna.gov.bd'),
(24, 5, 'Rajshahi', 'রাজশাহী', 0, 0, 'www.rajshahi.gov.bd'),
(25, 5, 'Sirajgonj', 'সিরাজগঞ্জ', 24.4533978, 89.7006815, 'www.sirajganj.gov.bd'),
(26, 6, 'Dinajpur', 'দিনাজপুর', 25.6217061, 88.6354504, 'www.dinajpur.gov.bd'),
(27, 6, 'Gaibandha', 'গাইবান্ধা', 25.328751, 89.528088, 'www.gaibandha.gov.bd'),
(28, 6, 'Kurigram', 'কুড়িগ্রাম', 25.805445, 89.636174, 'www.kurigram.gov.bd'),
(29, 6, 'Lalmonirhat', 'লালমনিরহাট', 0, 0, 'www.lalmonirhat.gov.bd'),
(30, 6, 'Nilphamari', 'নীলফামারী', 25.931794, 88.856006, 'www.nilphamari.gov.bd'),
(31, 6, 'Panchagarh', 'পঞ্চগড়', 26.3411, 88.5541606, 'www.panchagarh.gov.bd'),
(32, 6, 'Rangpur', 'রংপুর', 25.7558096, 89.244462, 'www.rangpur.gov.bd'),
(33, 6, 'Thakurgaon', 'ঠাকুরগাঁও', 26.0336945, 88.4616834, 'www.thakurgaon.gov.bd'),
(34, 1, 'Barguna', 'বরগুনা', 0, 0, 'www.barguna.gov.bd'),
(35, 1, 'Barishal', 'বরিশাল', 0, 0, 'www.barisal.gov.bd'),
(36, 1, 'Bhola', 'ভোলা', 22.685923, 90.648179, 'www.bhola.gov.bd'),
(37, 1, 'Jhalokati', 'ঝালকাঠি', 0, 0, 'www.jhalakathi.gov.bd'),
(38, 1, 'Patuakhali', 'পটুয়াখালী', 22.3596316, 90.3298712, 'www.patuakhali.gov.bd'),
(39, 1, 'Pirojpur', 'পিরোজপুর', 0, 0, 'www.pirojpur.gov.bd'),
(40, 2, 'Bandarban', 'বান্দরবান', 22.1953275, 92.2183773, 'www.bandarban.gov.bd'),
(41, 2, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', 23.9570904, 91.1119286, 'www.brahmanbaria.gov.bd'),
(42, 2, 'Chandpur', 'চাঁদপুর', 23.2332585, 90.6712912, 'www.chandpur.gov.bd'),
(43, 2, 'Chattogram', 'চট্টগ্রাম', 22.335109, 91.834073, 'www.chittagong.gov.bd'),
(44, 2, 'Cumilla', 'কুমিল্লা', 23.4682747, 91.1788135, 'www.comilla.gov.bd'),
(45, 2, 'Cox\'s Bazar', 'কক্স বাজার', 0, 0, 'www.coxsbazar.gov.bd'),
(46, 2, 'Feni', 'ফেনী', 23.023231, 91.3840844, 'www.feni.gov.bd'),
(47, 2, 'Khagrachari', 'খাগড়াছড়ি', 23.119285, 91.984663, 'www.khagrachhari.gov.bd'),
(48, 2, 'Lakshmipur', 'লক্ষ্মীপুর', 22.942477, 90.841184, 'www.lakshmipur.gov.bd'),
(49, 2, 'Noakhali', 'নোয়াখালী', 22.869563, 91.099398, 'www.noakhali.gov.bd'),
(50, 2, 'Rangamati', 'রাঙ্গামাটি', 0, 0, 'www.rangamati.gov.bd'),
(51, 7, 'Habiganj', 'হবিগঞ্জ', 24.374945, 91.41553, 'www.habiganj.gov.bd'),
(52, 7, 'Maulvibazar', 'মৌলভীবাজার', 24.482934, 91.777417, 'www.moulvibazar.gov.bd'),
(53, 7, 'Sunamganj', 'সুনামগঞ্জ', 25.0658042, 91.3950115, 'www.sunamganj.gov.bd'),
(54, 7, 'Sylhet', 'সিলেট', 24.8897956, 91.8697894, 'www.sylhet.gov.bd'),
(55, 4, 'Bagerhat', 'বাগেরহাট', 22.651568, 89.785938, 'www.bagerhat.gov.bd'),
(56, 4, 'Chuadanga', 'চুয়াডাঙ্গা', 23.6401961, 88.841841, 'www.chuadanga.gov.bd'),
(57, 4, 'Jashore', 'যশোর', 23.16643, 89.2081126, 'www.jessore.gov.bd'),
(58, 4, 'Jhenaidah', 'ঝিনাইদহ', 23.5448176, 89.1539213, 'www.jhenaidah.gov.bd'),
(59, 4, 'Khulna', 'খুলনা', 22.815774, 89.568679, 'www.khulna.gov.bd'),
(60, 4, 'Kushtia', 'কুষ্টিয়া', 23.901258, 89.120482, 'www.kushtia.gov.bd'),
(61, 4, 'Magura', 'মাগুরা', 23.487337, 89.419956, 'www.magura.gov.bd'),
(62, 4, 'Meherpur', 'মেহেরপুর', 23.762213, 88.631821, 'www.meherpur.gov.bd'),
(63, 4, 'Narail', 'নড়াইল', 23.172534, 89.512672, 'www.narail.gov.bd'),
(64, 4, 'Satkhira', 'সাতক্ষীরা', 0, 0, 'www.satkhira.gov.bd');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `bn_name`) VALUES
(1, 'Barishal', 'বরিশাল'),
(2, 'Chattogram', 'চট্টগ্রাম'),
(3, 'Dhaka', 'ঢাকা'),
(4, 'Khulna', 'খুলনা'),
(5, 'Rajshahi', 'রাজশাহী'),
(6, 'Rangpur', 'রংপুর'),
(7, 'Sylhet', 'সিলেট'),
(8, 'Mymensingh', 'ময়মনসিংহ');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rcp_reg_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bmdc_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `main_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_college_id` int(11) DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spouse_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chamber_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `permanent_division_id` int(11) DEFAULT NULL,
  `permanent_district_id` int(11) DEFAULT NULL,
  `permanent_upazila_id` int(11) DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `present_division_id` int(11) DEFAULT NULL,
  `present_district_id` int(11) DEFAULT NULL,
  `present_upazila_id` int(11) DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sign` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `date_of_birth`, `gender`, `rcp_reg_no`, `bmdc_no`, `main_password`, `remember_token`, `password`, `mobile_number`, `email`, `medical_college_id`, `blood_group`, `facebook_id`, `father_name`, `mother_name`, `spouse_name`, `job_description`, `nid`, `passport`, `chamber_address`, `permanent_division_id`, `permanent_district_id`, `permanent_upazila_id`, `permanent_address`, `present_division_id`, `present_district_id`, `present_upazila_id`, `present_address`, `photo`, `sign`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(14, 'MD SAIFUL ISLAM', NULL, NULL, NULL, '', '123456', 'IC9MhGwOwKgGhsJHRjpI2OaGIrXTxHmVtvydzH9OO6oMHkOiDeyZeJ0YPTCt', '$2y$10$bptfe8zAFSxohQXCvtRdqed512BOmM7YRA65c439tByz5ennDqwMC', '01713459946', 'msi132043@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-09-04 00:10:15', 0, '2020-09-04 06:16:57', NULL),
(15, 'Md Shafiul Alam', NULL, NULL, NULL, '123456', '123456', 'yMHUDyXSUc0hdNYUZSWpmHz7Fj2YQm4Uh193f4I5HAE8eotFjq6f9aGvV4Tz', '$2y$10$yVMC/tbxx00dfLvXZ.Al/OdVXKeTzMro2io82SFozZHr9O.qv8pmq', '01777777777', 'princeofcoding@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 1, '2020-09-04 21:53:03', 0, '2020-09-04 23:26:56', NULL),
(16, 'Md. Anwar Hossain', NULL, NULL, NULL, '', '12345678', 'zGAqaU7B4BIfe6GKjjpItaQGAWqt8nOPYWQYf56P77o4sr9liHafXNp6JexT', '$2y$10$BBmMc3FwRBcN9S2.fMnxy.M/N1jiNhHeJmetm.06NjuL3upnWQ2pu', '01730448610', 'anwarhtncr@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-09-12 08:03:02', 0, '2020-09-12 14:05:38', NULL),
(17, 'MONIRUZZAMAN MONIR', NULL, NULL, NULL, '', 'wkRvGTxJX6KrMvZ', '', '$2y$10$qOGuyl5t8dONbGJqKomEx.FQ4IExqmKRjx9pLz86t4lW.SGuftspK', '01784910673', 'monir112761@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-09-12 10:24:29', 0, '2020-09-12 10:24:29', NULL),
(18, 'MD. MAHDI HASAN', NULL, NULL, NULL, '', 'Nokia112', '', '$2y$10$KmNwxxQ6eymn2dQAV.N00uiVcioZln6cQw8Nz0v2Z628IxYrH689y', '01747012978', 'mahdi.gouv@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-09-27 03:32:25', 0, '2020-09-27 03:32:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctors_courses`
--

CREATE TABLE `doctors_courses` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `reg_no_first_part` varchar(255) NOT NULL,
  `reg_no_last_part` varchar(255) NOT NULL,
  `reg_no_last_part_int` int(11) NOT NULL,
  `reg_type` varchar(255) NOT NULL,
  `refer_by` varchar(255) DEFAULT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_price` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL COMMENT 'No Payment, In Progress, Completed',
  `year` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `service_package_id` int(11) NOT NULL,
  `admission_type` varchar(255) NOT NULL,
  `coming_by_id` int(11) DEFAULT NULL,
  `is_discipline_changed` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_trash` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `bmdc_no` varchar(255) NOT NULL,
  `created_attt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors_courses`
--

INSERT INTO `doctors_courses` (`id`, `doctor_id`, `reg_no`, `reg_no_first_part`, `reg_no_last_part`, `reg_no_last_part_int`, `reg_type`, `refer_by`, `institute_id`, `course_id`, `faculty_id`, `subject_id`, `branch_id`, `batch_id`, `course_price`, `payment_status`, `year`, `session_id`, `service_package_id`, `admission_type`, `coming_by_id`, `is_discipline_changed`, `status`, `is_trash`, `created_at`, `created_by`, `updated_at`, `updated_by`, `bmdc_no`, `created_attt`) VALUES
(6, 11, '20711001', '20711', '001', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'No Payment', 2020, 8, 0, '', NULL, 0, 1, 1, '2020-07-24 08:44:00', 0, '2020-09-05 05:36:28', NULL, '', '2020-07-24 14:44:00'),
(7, 13, '20711002', '20711', '002', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'No Payment', 2020, 8, 0, '', NULL, 0, 1, 1, '2020-09-03 07:16:57', 0, '2020-09-05 05:36:31', NULL, '', '2020-09-03 13:16:57'),
(8, 14, '20711003', '20711', '003', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'Completed', 2020, 8, 0, '', NULL, 0, 1, 1, '2020-09-04 00:10:45', 1, '2020-09-05 05:36:35', NULL, '', '2020-09-04 06:10:45'),
(10, 15, '20711004', '20711', '004', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'No Payment', 2020, 8, 0, '', NULL, 0, 1, 1, '2020-09-05 05:31:33', 10, '2020-09-05 05:47:12', NULL, '', '2020-09-05 11:31:33'),
(11, 15, '20711005', '20711', '005', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'No Payment', 2020, 8, 0, '', NULL, 0, 1, 1, '2020-09-05 05:47:34', 10, '2020-09-05 05:53:24', NULL, '', '2020-09-05 11:47:34'),
(12, 15, '20111006', '20111', '006', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'Completed', 2020, 7, 0, '', NULL, 0, 1, 0, '2020-09-05 05:54:02', 10, '2020-09-05 23:24:26', NULL, '', '2020-09-05 11:54:02'),
(13, 17, '20711006', '20711', '006', 0, '', NULL, 1, 1, NULL, 1, 1, 1, 10, 'No Payment', 2020, 8, 0, '', NULL, 0, 1, 0, '2020-09-12 10:25:05', 0, '2020-09-12 10:25:05', NULL, '', '2020-09-12 16:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_answers`
--

CREATE TABLE `doctor_answers` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `doctor_course_id` int(11) DEFAULT NULL,
  `answer` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_asks`
--

CREATE TABLE `doctor_asks` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `doctor_course_id` int(11) NOT NULL,
  `lecture_video_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_ask_reply`
--

CREATE TABLE `doctor_ask_reply` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_by` varchar(255) NOT NULL COMMENT 'doctor,admin',
  `message` text NOT NULL,
  `doctor_ask_id` int(11) NOT NULL,
  `is_read` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_complain`
--

CREATE TABLE `doctor_complain` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `complain` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_complains`
--

CREATE TABLE `doctor_complains` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_complain_reply`
--

CREATE TABLE `doctor_complain_reply` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_by` varchar(255) NOT NULL COMMENT 'doctor,admin',
  `message` text NOT NULL,
  `doctor_complain_id` int(11) NOT NULL,
  `is_read` varchar(255) NOT NULL DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_complain_replys`
--

CREATE TABLE `doctor_complain_replys` (
  `id` int(11) NOT NULL,
  `complain_id` int(11) NOT NULL,
  `reply_by` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_course_payment`
--

CREATE TABLE `doctor_course_payment` (
  `id` int(11) NOT NULL,
  `doctor_course_id` int(11) DEFAULT NULL,
  `trans_id` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_serial` varchar(255) NOT NULL COMMENT '1st,2nd',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_course_payment`
--

INSERT INTO `doctor_course_payment` (`id`, `doctor_course_id`, `trans_id`, `amount`, `payment_serial`, `created_at`, `updated_at`) VALUES
(1, 4, 'KX7GN7S9G199', 10, '1', '2020-07-23 01:12:00', '2020-07-23 01:12:00'),
(2, 5, 'KX7GN5SBHGXF', 10, '1', '2020-07-23 02:45:37', '2020-07-23 02:45:37'),
(3, 6, 'KX7GO7T62OLZ', 10, '1', '2020-07-24 08:45:26', '2020-07-24 08:45:26'),
(4, 10, 'KX7I53K25A5B', 10, '1', '2020-09-05 05:32:37', '2020-09-05 05:32:37'),
(5, 11, 'KX7I52K2KUMS', 10, '1', '2020-09-05 05:48:37', '2020-09-05 05:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notice`
--

CREATE TABLE `doctor_notice` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `notice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `is_free` int(11) NOT NULL,
  `sif_only` varchar(255) NOT NULL,
  `exam_details` text DEFAULT NULL,
  `question_type_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `year` varchar(20) NOT NULL,
  `session_id` int(11) NOT NULL,
  `paper` varchar(20) DEFAULT 'NULL',
  `exam_type_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `is_print` varchar(255) NOT NULL DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_topic`
--

CREATE TABLE `exam_topic` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `executives_stuffs`
--

CREATE TABLE `executives_stuffs` (
  `id` int(11) NOT NULL,
  `exe_stuff_id` varchar(25) NOT NULL,
  `name` varchar(70) NOT NULL,
  `emp_type` int(1) NOT NULL,
  `joining_date` date NOT NULL,
  `fath_name` varchar(70) NOT NULL,
  `mother_name` varchar(70) NOT NULL,
  `dob` date NOT NULL,
  `gender` int(1) NOT NULL,
  `religion` int(1) NOT NULL,
  `nationality` varchar(12) NOT NULL,
  `na_id` varchar(25) NOT NULL,
  `pass_no` varchar(30) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `spouse_name` varchar(50) NOT NULL,
  `pouse_mobile` varchar(15) NOT NULL,
  `blood_gro` varchar(6) NOT NULL,
  `per_divi` varchar(10) NOT NULL,
  `per_dist` varchar(10) NOT NULL,
  `per_thana` varchar(10) NOT NULL,
  `per_address` varchar(10) NOT NULL,
  `mai_divi` varchar(10) NOT NULL,
  `mai_dist` varchar(11) NOT NULL,
  `mai_thana` varchar(10) NOT NULL,
  `mai_address` varchar(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(25) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(25) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_code` int(10) NOT NULL,
  `faculty_code` int(11) NOT NULL,
  `faculty_omr_code` varchar(255) DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(80) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(10) NOT NULL,
  `name` varchar(80) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`, `type`, `status`) VALUES
(1, 'Hypertension and Research Center, Rangpur', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lecture_sheet_batch`
--

CREATE TABLE `lecture_sheet_batch` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_sheet_batch_post`
--

CREATE TABLE `lecture_sheet_batch_post` (
  `id` int(11) NOT NULL,
  `lecture_sheet_batch_id` int(11) NOT NULL,
  `lecture_sheet_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_sheet_post`
--

CREATE TABLE `lecture_sheet_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_sheet_topics`
--

CREATE TABLE `lecture_sheet_topics` (
  `id` int(11) NOT NULL,
  `lecture_sheet_batch_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_video`
--

CREATE TABLE `lecture_video` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lecture_address` varchar(255) NOT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `topic_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '''active''',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_video_batch`
--

CREATE TABLE `lecture_video_batch` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_video_batch_lecture_video`
--

CREATE TABLE `lecture_video_batch_lecture_video` (
  `id` int(11) NOT NULL,
  `lecture_video_batch_id` int(11) NOT NULL,
  `lecture_video_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_video_discipline`
--

CREATE TABLE `lecture_video_discipline` (
  `id` int(11) NOT NULL,
  `lecture_video_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_video_row`
--

CREATE TABLE `lecture_video_row` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lecture_address` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '''active''',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medical_colleges`
--

CREATE TABLE `medical_colleges` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES
(1, 1, 'App\\User'),
(1, 9, 'App\\User'),
(1, 10, 'App\\User'),
(1, 13, 'App\\User'),
(1, 14, 'App\\User'),
(1, 16, 'App\\User'),
(1, 27, 'App\\User'),
(1, 28, 'App\\User'),
(1, 31, 'App\\User'),
(1, 35, 'App\\User'),
(1, 72, 'App\\User'),
(1, 73, 'App\\User'),
(1, 81, 'App\\User'),
(1, 82, 'App\\User'),
(1, 83, 'App\\User'),
(2, 24, 'App\\User'),
(2, 25, 'App\\User'),
(2, 32, 'App\\User'),
(2, 33, 'App\\User'),
(2, 35, 'App\\User'),
(3, 1, 'App\\User'),
(3, 35, 'App\\User'),
(4, 49, 'App\\User'),
(4, 55, 'App\\User'),
(5, 53, 'App\\User'),
(6, 12, 'App\\User'),
(6, 35, 'App\\User'),
(7, 18, 'App\\User'),
(7, 29, 'App\\User'),
(7, 34, 'App\\User'),
(7, 36, 'App\\User'),
(8, 35, 'App\\User'),
(9, 35, 'App\\User'),
(10, 33, 'App\\User'),
(10, 35, 'App\\User'),
(11, 32, 'App\\User'),
(11, 35, 'App\\User'),
(12, 18, 'App\\User'),
(12, 35, 'App\\User'),
(13, 33, 'App\\User'),
(13, 35, 'App\\User'),
(14, 35, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `notice` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `type` varchar(1) NOT NULL COMMENT 'I=Individual, A=All, B=Batch',
  `year` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` varchar(70) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(70) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam`
--

CREATE TABLE `online_exam` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_comm_code` varchar(255) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT '''active''',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_batch`
--

CREATE TABLE `online_exam_batch` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_batch_online_exam`
--

CREATE TABLE `online_exam_batch_online_exam` (
  `id` int(11) NOT NULL,
  `online_exam_batch_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_common_codes`
--

CREATE TABLE `online_exam_common_codes` (
  `id` int(11) NOT NULL,
  `exam_comm_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_discipline`
--

CREATE TABLE `online_exam_discipline` (
  `id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_links`
--

CREATE TABLE `online_exam_links` (
  `id` int(11) NOT NULL,
  `exam_comm_code_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_lecture_addresses`
--

CREATE TABLE `online_lecture_addresses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lecture_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `pdf_file` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_lecture_links`
--

CREATE TABLE `online_lecture_links` (
  `id` int(11) NOT NULL,
  `lecture_address_id` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('rabiulitclan@gmail.com', '$2y$10$RzQXj/LcuDAs6z8SlFhTH.PfAMxmbeBRvRHvcDsGiJ/Argiu5B4SC', '2020-02-15 00:09:43'),
('rawnaq7098@gmail.com', '$2y$10$4Ty/ys2IuXHqZFQouSsMdOqAKxITxFQfkM0m3WuMflsYgFroNWn.i', '2020-03-17 22:55:51'),
('princeofcoding@gmail.com', '$2y$10$GH5SGbdOnFQeB8LCNzOKCu0P350rV1C5nd7rKaxnFzGqoPE/Uxx4G', '2020-03-17 23:27:30'),
('rabiul0420@gmail.com', '$2y$10$06z76YnF1iTR4VhnHCbfjuZpjuTMekzr5geMx/A.jgdaG/oEBQ0JW', '2020-03-19 07:07:12'),
('orthy.jum@gmail.com', '$2y$10$djMWYL.YoaWquiErIRvH1O8COWco22kx4ToChuzFnB5l6LC1pqFQq', '2020-03-20 04:55:39'),
('lailakamrun20691@gmail.com', '$2y$10$y.z.Ib9pipO69fCUKRP5NuxRcK0Np17e57N0U9HeOeKQzE.ZVHVMK', '2020-03-20 10:38:17'),
('zulfikerwub@gmail.com', '$2y$10$liMGIHA69OJzsOCgM3ESDOn0LnUhy5CtABhvhcGa/Y1QOdKyygKOG', '2020-03-21 00:47:32'),
('genesis.istiaq@gmail.com', '$2y$10$8tCLXZ/uleeWI6OONiQcYuR.15OLmRzFASf5HUhHDbRezgL85U7UK', '2020-04-12 08:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets_doctor`
--

CREATE TABLE `password_resets_doctor` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets_doctor`
--

INSERT INTO `password_resets_doctor` (`email`, `token`, `created_at`) VALUES
('shafayet.hossain104@gmail.com', '$2y$10$aVLJLR80UUHm0qjzU84Kde0OLyRJRy4Yen3tp5YhK3HDRL7p.DRwK', '2020-03-23 10:46:13'),
('muntahaafrose1994@gmail.com', '$2y$10$8Fs0r/IB.MUcpxSbKjsTMerdk//P4GKsWsnE/0NkKHDIPAwzuG.RS', '2020-03-23 11:41:19'),
('bbkb.bgc62@gmail.com', '$2y$10$wtrumqV80DLvuQy6QxhwNeGU2usFHZkrP36edo0r28rqzM7Oc.062', '2020-03-23 12:58:41'),
('shihabisiraz66419@gmail.com', '$2y$10$L4sabvqAgNcBmgl2Mz7fleiPqtGS5vjn6zwTImZax3iqMrY6q782y', '2020-03-23 22:48:25'),
('dreameribrahim23@gmail.com', '$2y$10$XjN2CsUA6sfX7hdgSjwUFOw94mngNp4de/gCM2jRfmhQDX208AIzi', '2020-03-23 22:51:43'),
('dr.sajol.nm@gmail.com', '$2y$10$fkn7e290KNwqzkgZ91Ob5ewtq5Hf7yKIUztD803JLitYKwB6raYfe', '2020-03-23 22:54:34'),
('lims6367@gmail.com', '$2y$10$xhU7lKOgglaRQFKO4u7XQujYRiRN7F0vNGiQUhRc0pxwaCJ5XRcHe', '2020-03-24 03:53:06'),
('hossainmohammadrabiul@gmail.com', '$2y$10$Yqn0Q/ILg3vxDkCpw.kB1eCJ4FCSIBW2VY.uI0iT8LkZsujzkEjCW', '2020-03-24 05:34:39'),
('arpita.comc@gmail.com', '$2y$10$Qk5rfkl9k0hwb8AvyHxgQ.XWNx6Rp1EuC.XzOH9WlyXnK6orGwqcW', '2020-03-24 08:10:29'),
('Myhtc088@gmail.com', '$2y$10$Q2fWB2Sa..gc6njJmzDPUuWku6XG2Pre1aH1KGkYllSnBHPgiMzzC', '2020-03-24 08:34:26'),
('rhidoytalukder@gmail.com', '$2y$10$6a3Z0Nu4xDLFO6icto9Y.uKZPThbWgLjS4AksITB3E.m.0qrOeWSm', '2020-03-24 08:51:17'),
('tesmearatrisha@gmail.com', '$2y$10$2sHL0n8rhONXr7OmD436BOTz.vSTJM/IeYs6k1X07LnC3j4aNfaDm', '2020-03-24 09:23:58'),
('sazia5569@gmail.com', '$2y$10$sEqyFuePMxLuAkHsHRkonupfLPgb./a.NG3kFxEaa4saqlutA2thS', '2020-03-24 10:12:16'),
('dr.kaiserdu@gmail.com', '$2y$10$T/N4JVkK04M2XGoxTaRTYePbO4bcBHTxA4zc8fv2vlYSgFQWFxTwu', '2020-03-24 11:43:00'),
('abirsarker30@gmail.com', '$2y$10$6FmFxTSrPwLAdfD/LyUieOWmwXuuMketr3vRQcssbDjThuVrsvhjO', '2020-03-24 11:54:15'),
('farhanatanjin1395@gmail.com', '$2y$10$PlV53W/1TI0lb4ubZrPyyuMOiLk23FZlbFmHOlSDq36xKvQTIZBaK', '2020-03-25 01:30:50'),
('amiramir8757@gmail.com', '$2y$10$zfNn76dtWeiqVGbpTEuq/OFRZIsngct21PdcsMPoo3NJh4IdJyD1y', '2020-03-25 03:26:21'),
('anunimc07@gmail.com', '$2y$10$yQpJW9tVLkEfwWhIL4yqrOP/I41dIZ/an1VK/qsg6NVlPWmgBHa9G', '2020-03-25 07:51:11'),
('stasneem88@yahoo.com', '$2y$10$Abs.Swj3v5vIKsO7Uc803./i9SNKHzTxThe.9rDXuVhp36DWSfJxe', '2020-03-25 08:15:13'),
('romanahabibkona@gmail.com', '$2y$10$1pNcKc0hzxJm3ZKVA0.q8ueJP3Kdhn19oCthG6PrWTtPs.GKZTKpu', '2020-03-25 10:16:58'),
('zarin1086@gmail.com', '$2y$10$uICvbcli7IN4VahHg7K49uQ7cBa7nFRlvGIslljCk/MntoBvH4RtK', '2020-03-25 22:37:05'),
('sabrinanabi8@gmail.com', '$2y$10$RNG/vgj9z4r1pN73c4bjmuGrhA4T0Na1i.NpXGaKdKhn6JuOz8Ph2', '2020-03-26 01:45:29'),
('mm5635391@gmail.com', '$2y$10$t/qZ/.8s8MHin.1u1Y5djO6V5RiA5e14L2HhDlEy94VLNyhLIHgGy', '2020-03-27 05:55:22'),
('imranhossainab26@gmail.com', '$2y$10$BWsOm4szZjpN0knbfewhcObrox8NmX156ZiSHFriIzZoJlyhgB/hO', '2020-03-28 02:26:25'),
('drpriya912@gmail.com', '$2y$10$lBrVYQPUZdA9jEoTnqS7m.cuCvwHsEECdhqzQ834lOtm8HkD2Me3m', '2020-03-28 04:36:31'),
('nobeldr2018@gmail.com', '$2y$10$VC0e/KPuwWDwyA4lOweBjuglEczUCvKoTS7wfGAMkDRbJI1SqX7JO', '2020-03-28 05:04:43'),
('imrulkayes1991@gmail.com', '$2y$10$.rNcm3OPertzql4fbdbUfe9.dMHSip6tnoadOhNjs.RuRpBJey38C', '2020-03-28 10:25:19'),
('khansunnah3359@gmail.com', '$2y$10$n4teeIxABrpfGGy3n0oZ3edwR4KpPNOczG6lWMD6Wrz8yA82AkZO.', '2020-03-29 09:44:31'),
('afsanaanukyamc@gmail.com', '$2y$10$iIKvWcoQ91D4ZVcwmLI.S.MKYztXvsX/MRO1plBT9AyKD8hZy4/o6', '2020-03-30 05:41:44'),
('sharminshormi96@gmail.com', '$2y$10$psIwSk5mvtEwA53K6CO6JefVH8G4BOWqPDEcwk9MU6imK80.wEOuq', '2020-03-31 02:35:15'),
('farhanaislambarsha05@gmail.com', '$2y$10$SaO/1Psbtbh6TcyaO/v2Su1ph3e0Iy/cHSZCHbUCoe71byJ52Ff52', '2020-04-01 04:05:32'),
('Realriad18@gmail.com', '$2y$10$XbuePQ4ylX.Z8J.RkeDWtua.cJ1oQohFWyOIPPe5ClxzH1P0.aOri', '2020-04-03 04:41:25'),
('Jack16856@gmail.com', '$2y$10$d63uTPxQ6hiQpmwpdMLU9eENv5CdR83XnTNJEdTwW.0iS2DFfdNha', '2020-04-04 09:15:57'),
('ahmedsadeq26@gmail.com', '$2y$10$WNWNJixtc7/aSHg.kcGul.1kCR.4EKd4Y60ifxmgpqHoWweXQmqbK', '2020-04-05 15:00:48'),
('tanuja.richi@gmail.com', '$2y$10$Qev1PYzCH9Od89AUoEuZju85eios7OBA0dJdf1qj8L2n3dmHtyckG', '2020-04-06 08:32:40'),
('sirajum46@gmail.com', '$2y$10$gfn58KziVkDybouIjmEJGexca41uAaI.fF9tVXUS.AYL5SaW6WpCu', '2020-04-11 07:08:33'),
('Redwon123@gmail.com', '$2y$10$6yNFtFxwDE/ZbZb5h1bYXOYdVvbcrBtVTGPBtAhx3q3H3UOzT/xWK', '2020-04-11 07:46:13'),
('m.s.hasan254@gmail.com', '$2y$10$EzOusc7S9ZfXOib.nak.f.dMBSwc.Z91YMVwfz/GQicR3cDP0FHeW', '2020-04-11 08:06:03'),
('saeedul1991@gmail.com', '$2y$10$rrYqBeI6SUHCFwMyZ7uSfOu/jMgX5izemgK9UHUU4pRt9/Ka/opCe', '2020-04-12 05:11:58'),
('nuzhat.bd200931@gmail.com', '$2y$10$LUvsR12BPyNWgBKAlzgDE.H..RCVEnC5hPjq4d/orY/8SRUxIo1Ym', '2020-04-12 05:43:20'),
('drmahabbet1992@gmail.com', '$2y$10$XY43nXWtxByRkGJtmAQgO.zUL2SGeGXelIVLjgsjphcErHOlFs6lS', '2020-04-12 08:52:11'),
('drmahimaislam@gmail.com', '$2y$10$nypEeQsF3Ite7966bEMvQOT8O1NAdz7rUMRFbyKvbcn4zr8wl3Fba', '2020-04-12 09:35:00'),
('ayeshashakila36@gmail.com', '$2y$10$/sIBVUA1vOFOoSBmMEmBnumZc5kdgCtKU2rW9OsA20savu7WNUITq', '2020-04-13 03:00:00'),
('drkaziarafin@gmail.com', '$2y$10$i0nJOwmwaXm5QwX5FC//tefvqd0StS1TvC9ubXbH40mE5FYgj3MDC', '2020-04-13 03:29:33'),
('nsamawat513@gmail.com', '$2y$10$S0geqv6OguuDDYEvnFuow.KI1StoomRT.w29lstkzeNTNRWjgtooC', '2020-04-13 04:32:13'),
('fatemaasha2055@gmail.com', '$2y$10$a1DNa17C3O47/EN5I0A5OOt1EM0axNFimd1WiQg80XqkXUGR8SkH6', '2020-04-13 04:41:09'),
('mahbubrahman814@gmail.com', '$2y$10$KS1dPazawZ0b5ylK4G.qSOCaLf4RudXhfvklGhjI75TG6/iP8T6A6', '2020-04-13 04:44:39'),
('askhan01035@gmail.com', '$2y$10$MqQ6DOzfFANedB9xfD6Nv.rgKbXFQzf9NR0fu8j6W5NGpB1hI6N9a', '2020-04-13 05:00:14'),
('jihad.mamun.net@gmail.com', '$2y$10$lZ8/QV18KYbFvNfI1MumvOkBdgMqg338vShrGn4tMI./Un7qZ.2cW', '2020-04-13 23:49:52'),
('afsanaalam15@yahoo.com', '$2y$10$2VGBPPIRIq3zngDQUaoztOxlUeDBVxrjy2hXtVQKGmiXWh23Q887u', '2020-04-13 23:50:02'),
('rashed.szmc.4121@gmail.com', '$2y$10$BMKp2l8iVu0tgqacS1fRrug0uIwzhXZjlWpMZonLpsA80HkTzdCeW', '2020-04-14 00:55:52'),
('raseltutul333@gmail.com', '$2y$10$U6eYOWrqrpLLh4jBU2LZ6ucybSUmYQo8E0aiYzXou8gqBXoQNgdMq', '2020-04-14 02:06:44'),
('masumahamed15@gmail.com', '$2y$10$.y1lsleMYtGUTFX/HVMmOOU/.eIyfb9d/gzBlq6fdTmRWKMRwINBS', '2020-04-14 02:14:47'),
('morshadajahanmitu@gmail.com', '$2y$10$AxeRkCtM83uc9UtYxrcsPeZaMCJbnce5Z8v8heBPqi.p9SrborXPa', '2020-04-14 08:53:26'),
('shottershenani@gmail.com', '$2y$10$K70EityrVYVirNVfn8A5r.MRH77yb5W07e4dqy8bOQ.5dPdqDjm3m', '2020-04-15 03:03:20'),
('farhana246zaman@gmail.com', '$2y$10$xiM2174q6JgtOhbrYQrDU.0EKdy7KJnITNkW2imss1uJwVTlcyfda', '2020-04-15 06:57:47'),
('md.tanvirahmed917@gmail.com', '$2y$10$ksG.PFh6gf2MhRlsir/JIeU6u69r.oHNLNJdArDnQ2Z01VJOIv35W', '2020-04-15 07:31:07'),
('planeta.shawlin@gmail.com', '$2y$10$ReMvn1GKyQP9hbDnwWDcruGKgEsJzKJQnDjDnMteSH67PWls3YFVm', '2020-04-15 09:12:55'),
('somadas.2611@gmail.com', '$2y$10$/8XuW/.nhoDa/EOfxMrDU.8erhG4iBw1wsjhw4vEzH5y2Whtb6x9.', '2020-04-15 22:45:51'),
('tajul.khn@gmail.com', '$2y$10$hFQX475Na3dniKaNOsHNNOzfW8XywDofUh8xW5lSKLAup7V.qAwQW', '2020-04-16 20:48:50'),
('smsohelranahimel@gmail.com', '$2y$10$v7LaaeYUS/J3aknvBrUISOs4va8Qdsf9.0tcPAFz6cZ7F3jfbxwNW', '2020-04-17 03:09:31'),
('zahidraj1078@gmail.com', '$2y$10$IiKrQA65rwFNtOtrYyfi4.FFY5Vy5Ss/2YVo5.mW8owwjLiPZRc6i', '2020-04-17 03:31:23'),
('ruhinarashid5@gmail.com', '$2y$10$uNuWduaBZdLmMhqlyQLfzuRvQ6LZlTzy0wK27.gWombTDB0CgOJx6', '2020-04-17 03:36:40'),
('zabeen25nadia@gmail.com', '$2y$10$El9AbFsKJN/GLu3uIGNSZOXuDu.PtquFBZzbs9EHZ1cH4BP4YOwEq', '2020-04-17 04:41:49'),
('mumujoyeta@gmail.com', '$2y$10$FS4BAFckpDFBakbOBH9L3ut6WqPdHXAQrE/FxnJs2JmnrKmBeUTIa', '2020-04-17 13:23:57'),
('drnoemail@gmail.com', '$2y$10$fbbsCwr2oJNGaBNh0UmvMO3P3OX2IDycc2ty/oU4xt2xbIig9jGFW', '2020-04-18 03:21:41'),
('dr.palash86@gmail.com', '$2y$10$H.dFJCUraBrFJPEy.e3kg.gPnLr.gFBhcIMOG1j36z1ARLegN0DAO', '2020-04-18 20:45:25'),
('anamikaproma21@gmail.com', '$2y$10$0oLDRlbh7OIYPFiHxD9pWe5hVfCaAQayUTFvDLqRk79OSZAYGMqX.', '2020-04-19 10:25:23'),
('saba10121990@gmail.com', '$2y$10$K/orMbuD2skdYAINmpZCNOl43NPJg10QRXGQkGwuP8jnUdD60AwX.', '2020-04-19 12:15:32'),
('islam.sadia94@gmail.com', '$2y$10$PAuOfB3VqkJuLNvWgIzyAuhsO65MoEBb73Sj4i1NoSxAckUBOoE5O', '2020-04-19 14:05:08'),
('tmridwanimc13@gmail.com', '$2y$10$8/1/OxIEFoeAo9GdBWYNt.Br98uhZa9Vx6ZkGdDwETnaKnAHweJEO', '2020-04-19 21:15:08'),
('osmanganidr14278986@gmail.com', '$2y$10$86Oc4.mb.K7BAH6m2A804.vmpKEaFAyEDYX0DmQa0DSPUFBFUwGIK', '2020-04-20 01:48:49'),
('rumanahafiz21@gmail.com', '$2y$10$dux1TYS0X4AA/R6x3SVP2OMxuuTCVgVjEhf5YLlFk3apZsI/uAKz6', '2020-04-20 03:33:37'),
('Kabiajotey@gmail.com', '$2y$10$0dufpQ3DQIvTmlusd8kpvenE7/N5hE3syeLY5MMpN6jmjtmyD1JlC', '2020-04-20 08:18:39'),
('sheikhjakia09@gmail.com', '$2y$10$uBrGeSPpVaMxId0C9uCff.EJeEJ6iTRI7iJnr/u6vvUziAsH/Y4zq', '2020-04-20 11:10:10'),
('rumpajsr89@gmail.com', '$2y$10$zk7CYyYdCOYgTpDpF0HlC.F2a.DYDvSI7JdbcgrT0mPLgqPqmEJ2.', '2020-04-21 01:35:01'),
('kabirsm1982@gmail.com', '$2y$10$HVa5Pet9KVcUVRsjpi4uheTCqFB7yHHNzr6yyOCXhC8jOXv.vTC.a', '2020-04-22 01:38:40'),
('amar.pritul@gmail.com', '$2y$10$vK/pPs.FNIG5XZaMrH5ZL.fPRHmoJpSEkqFZtHZLWvQ3/bMuDKZBW', '2020-04-22 02:05:43'),
('Sarowar.Jc@gmail.com', '$2y$10$L8Kol3UT7u75MbFoSdjl9.dU98Y8VdBZPpWXr0BG7RiLfGTJkYetq', '2020-04-22 08:04:42'),
('redwanayon8@gmail.com', '$2y$10$VltBFPU5Eo5iFwrn53WlD.2zHqYudewVSFpyumAnT4bgfZLCmjTVO', '2020-04-22 12:54:28'),
('sarojbala7342@gmail.com', '$2y$10$CW3K0ZKas4AVr6/WH8RJgeiujS4/gbssHW2Ru66GU1PFfSurK.4YK', '2020-04-22 22:58:10'),
('ishtiaqueasif36@gmail.com', '$2y$10$o1AwlxJLvwVjmr6UE0FDw.fECU7JFcYDped6VtzHpsZDjBqsC3hKG', '2020-04-23 09:17:11'),
('rajiamomo66@gmail.com', '$2y$10$VMqvUyupXBxFcpzEZ6hqVeTlcErjAn6CoTXgnO0BJ6kpXRzaH5GYK', '2020-04-23 09:42:47'),
('zafarrony2015@gmail.com', '$2y$10$/ao6/wi6Oqctjs8VpgPdE.nlUrZhL7c4j0hQ2Js5KPr9WMzYJoprC', '2020-04-23 11:31:02'),
('SHAHIDRAHATHOSSAIN@GMAIL.COM', '$2y$10$6fxJdz/b7UTG2nDMocBX7eQkOfaEgJg5DLqLqoHd78/JJ42/k/YVu', '2020-04-23 21:17:01'),
('tanzidaakter69@gmail.com', '$2y$10$jaqAY9Akd8XekzOgRO51GeyP7U/jC00xzMxRFn56FV4sAxtt/S7vq', '2020-04-24 06:01:44'),
('raselemc3@gmail.com', '$2y$10$IKUTq6XEg0dEwh617NIR1eR8Pgk37hpcnqIw1EWQk.n5x052..wd2', '2020-04-24 11:43:50'),
('afiazannatun86@gmail.com', '$2y$10$wGd9szlIscRNy6JoUAwGA.H1gmRi26Z3vYtPDQHBqhffFMp0k0I4a', '2020-04-24 23:29:02'),
('tanvirshahariar21@gmail.com', '$2y$10$H3b.hbcLGLkmS9tMeqN3xuwlp3P5N9k1pypREGNUHy1gp4jTanq0S', '2020-04-26 06:02:09'),
('drshabnamrdc@gmail.com', '$2y$10$ggJ8ZxS17PGDcuB70SpUA.5LrvYuLgcnx1IkAzEvqnBFm4PtFAMR.', '2020-04-28 04:46:09'),
('sarkerds87@gmail.com', '$2y$10$LvJeeRzzZmiOQBVYp81T5ubyTgjJ0rU.jFS.EA8okUWYzsrZH91ZW', '2020-04-30 15:03:40'),
('tutuliverpool@gmail.com', '$2y$10$R4D7JcvarR9Mx7A/X9cuGuov5WqxQBafjwq/Jr2ArH6.jvGvivMjO', '2020-05-01 17:05:57'),
('bmasaduzzaman22@gmail.com', '$2y$10$P0R83NeqjiP1iWMqx9XyS.c5uBOuOBdbd.775GlywO3bfTb4rgaOO', '2020-05-03 02:34:25'),
('mrnadjmc17@gmail.com', '$2y$10$gzKzN.JygdsSNITcOS/O/OIHL8KWPzW1dAMDiED78/S1/JkHFSosC', '2020-05-03 07:32:13'),
('abdullahmc2007@gmail.com', '$2y$10$aSvmK.pIcupILhLSIiMbKe6mTrx.q5vadhhEGHCg/4/Ua5P8kyfM.', '2020-05-04 12:15:11'),
('zakariabinhamid@gmail.com', '$2y$10$2QSYLuLvS5GelFRcQO19lufEak3JQuHgZbcFAIrRZUVJWdmhEcu4u', '2020-05-06 03:16:16'),
('mdkutubsikder08@gmail.com', '$2y$10$FVFopGKLQoG2URF10z.3p.rwKgaAkWt6W44e8sSyUfKSTOeNdO43G', '2020-05-07 02:26:41'),
('sohelhossain774@gmail.com', '$2y$10$uAd5IfXgwkRPkTStLv8v8.j70MV9X/bywX5T2dxy8WaudqXnuyJqu', '2020-05-07 05:30:37'),
('naim.kyamc@gmail.com', '$2y$10$yqAK77rXzGmFIfxoDq1t4.t26FSL9BDp5/u9pO5ezvYgXZwDgBgTC', '2020-05-07 07:37:50'),
('upal.kmc69@gmail.com', '$2y$10$57JXQA2.y1FunlDlDqs6pOLd9pG35uGwyhkEuwo6BsBTZTmXHSoSu', '2020-05-07 07:52:53'),
('barniniroy110@gmail.com', '$2y$10$qOqlprw.Jb0ZDG7/tFvkIOSRXJQmcLWZaTINNrmoKE4B3/3PYP7R.', '2020-05-07 08:04:49'),
('majumdarabeer@gmail.com', '$2y$10$llLIpYTUB5XUkzFBfP6tn.qsKLYew7dQM51XcvABxWlmpxedR8FN2', '2020-05-07 08:35:57'),
('sharminferdousjuthi@gmail.com', '$2y$10$UH1qIvoEJvzWRt6hFS5zUOI7jhKRv0MzzB21EW4cFgyVS8NiTblTC', '2020-05-07 08:37:48'),
('faruqueomar008@gmail.com', '$2y$10$7z8eTs3fnGPwKeQD46PuhehUgsBqdnvBhSWlDN3IjMh2CPOyEelYC', '2020-05-07 09:14:09'),
('rupak.roy60.rr@gmail.com', '$2y$10$1Wq0yyP3u6c6NK33.Xz3pO42ly6QhAaAHHY/PWVhZhqKRmr88XI1K', '2020-05-07 10:25:17'),
('minhajulkayes1212@gmail.com', '$2y$10$Ptt9TPBjdM.HeeXYkJLWl.6rxcU1FwQdAiUfzyYcE5WUiKKPL2e8a', '2020-05-07 15:51:34'),
('dr.sanji08@gmail.com', '$2y$10$tWi2k9P2LjNWbjojLA9zGeV1Wtuzq5xyFSWwTR2WiZuQr6i8QsDFS', '2020-05-07 16:40:17'),
('drisratzahan89@gmail.com', '$2y$10$qhpGjauIQeWhOk5Oa9DC7u1qWhwA.GnX0fhG67HHdyGbbyEFmT4Zq', '2020-05-07 23:20:44'),
('ziniaajam@gmail.com', '$2y$10$.RsgxSH6BiXebVzmRfj5qukwR47mVg5cFNBf5SBpQHpryKKPnYWt6', '2020-05-08 00:52:58'),
('crucionirvana68@gmail.com', '$2y$10$Ic8HlByyYdhLz8EhV5dTTul2Gb2aksWzNuCcZ0oHtr8ED2eL4KPxq', '2020-05-08 03:25:57'),
('drsourav68@gmail.com', '$2y$10$9zteKuoFYoVwhS94Z8GlGO7lTOHAbD2Up0aWdtOB3y2TJQHlxnSyq', '2020-05-08 12:38:02'),
('tareq.shsmc08@gmail.com', '$2y$10$g6Q571nQdgKLgU25n2EDO.30oAhXQBSERP3P42ikod0CmrdtfAQfm', '2020-05-08 21:33:29'),
('akifa28sultana@gmail.com', '$2y$10$XBkcMEpIQuLg4rbYvQZ/b.1KNm58MBq3vsifKgjbx6jZ2E1kXdg4i', '2020-05-09 00:04:23'),
('bublee.k61@gmail.com', '$2y$10$Y5VtV/y8FRiro56OlDXvW.sQftKP0PhOgA0fbNTI6qPwjOtReJvxK', '2020-05-09 03:42:57'),
('dr.farzanamily@gmail.com', '$2y$10$xeZPj0wnx0p7v40J002m3uupavlq.R3pTEvuBeXUPWlR7GFufEC7K', '2020-05-09 08:58:32'),
('siddiquerobinn30@gmail.com', '$2y$10$NHVZr38mBNW0vv6ysytJj./.3ZsQoSJgDzkDovrMnX.7KlgNUHh3S', '2020-05-09 10:37:05'),
('abdullahalmamun9293@gmail.com', '$2y$10$n8SOUnrhcrbC2U9SmkVw3OjvYXj2mPkvx.LhkIocMVf5kLgcHzobi', '2020-05-09 14:12:16'),
('atanusola12@gmail.com', '$2y$10$jjWyuaEp8tKUxggsfeGq9ustaeZHRA0efSpSSGFZvg.ye8j3zNOFS', '2020-05-09 23:19:29'),
('mailto.juthi@gmail.com', '$2y$10$ClPzoQj/XQOPTF3Za7qWvOV57syFFDbNoisecfYt7MgfIgOCYVAIu', '2020-05-10 02:21:39'),
('dr.firoz.mahmud2009@gmail.com', '$2y$10$7kp2iW3bWaKoM3BSc8NcGO0BwQIzot.kSPPYobLGYnMJkHJZ0DlrC', '2020-05-10 02:33:53'),
('mafruhaafrin17@gmail.com', '$2y$10$T5fEV0rF698Wo1mICbuD9.6qsa/3KL7ergctFFwQRlJNtZ/th0lcS', '2020-05-10 02:36:24'),
('shahadatmmc48@gmail.com', '$2y$10$aX500qUiFWhnuq/y7VX1GO.dUX21Y1kF419RduQrALKqOXxLvDOF6', '2020-05-10 02:58:56'),
('mdsabbirahmed128@gmail.com', '$2y$10$velK43dvmvh7BQIGWwzDzuDD.VZCkr/NVNBJVyEyevTIfm.U6ATs.', '2020-05-10 03:59:05'),
('jannatoishe18@gmail.com', '$2y$10$6u.NnIwjYzATij.f4pZCFO4CPPW37AcrElI0f30f/4Hk/ewuI8CPS', '2020-05-10 07:58:57'),
('tahsin.rahim@gmail.com', '$2y$10$Tj1LenkugxbAebvPVPaxCeQ.wB8qNY6vaokL7yfzmercyBp/RB0Vm', '2020-05-10 13:15:34'),
('ememoni2@gmail.com', '$2y$10$obEKLmVT51GpZJSNu0/fvOa6c2DNIUPlecjLNhcspDcFQ.QNInVXm', '2020-05-10 13:57:49'),
('nurulalamrpmc@gmail.com', '$2y$10$7dILXKvthkf0H1cQoYZNfeMld8M8gYHsSs12t5lVUl83c1dS3BbEG', '2020-05-10 14:02:50'),
('dr.haqsmc@gmail.com', '$2y$10$OcRJwR9kDYvjy62FDP5W3OoPbrHnb524Tvf1cSAV43sEhDSt.cZKG', '2020-05-10 14:35:53'),
('dislam71@yahoo.com', '$2y$10$1Vjpi.pwI51p5RlXoDK6pegq8WCvh9inwMrYWBO5HO/YMgdVKRT2C', '2020-05-10 15:48:35'),
('dr.fatema.smc1@gmail.com', '$2y$10$VmPpGDNOp0dtn9JoASfzpOv7j0sRqRHGtv6yHdQbxWKlphsk00Zri', '2020-05-10 16:30:37'),
('Onamika.217@gmail.com', '$2y$10$jZUF.zqDli0G7/0VFuweuuuAoMnOXnevPXkt6c2NqjqN.jOwIiDjq', '2020-05-10 18:05:25'),
('aksaha2077@gmail.com', '$2y$10$Ry4R3ivNJ84egNZuylk6xudSirTHBm7qMUJ7TWofbVKnuzENcBcX2', '2020-05-10 21:14:05'),
('ismailkazy15@gmail.com', '$2y$10$Jg8S1Qd3oAcy.gsNOCc7xeWAmOwqtgIR8W0guGqsUxZcQ8OnGMOwq', '2020-05-10 23:04:18'),
('drafrinnoor@gmail.com', '$2y$10$gWnF5BgtjsOW9wHawbKIzuuxBcpy1BT2sMEfIJ5M9uLdvIUEPi/4K', '2020-05-11 00:11:34'),
('snigdha.fmc@gmail.com', '$2y$10$uaKS1aZq/XMRZ.7WH0Pfv.r4KUfB4JFT5uPW4TkmhJjeDWDx0id0q', '2020-05-11 01:08:57'),
('drnishat63@gmail.com', '$2y$10$HN6YkMw00L7juYQ5EjJO6u4nCIdS1sOgO.i5yNswy7SQwTBwuHxAS', '2020-05-11 01:38:34'),
('tanzil834@gmail.com', '$2y$10$iG2lEza7wF8qQNZcwaWy5ehg2OtbFq4ejWdCr.dF8zuVYXKLqeQZ.', '2020-05-11 02:48:53'),
('kanizfatemajhalak500@gmail.com', '$2y$10$A2VNxVlkENvkQIfSOEnxhOxrmco0bFYjRhgr6/R891pPxUaB7Q4IK', '2020-05-11 03:06:07'),
('mohammadali3885@gmail.com', '$2y$10$fCQ3qum4/RZ29Pk.KSTfuuEuZO.X2GmL/Hz9x0Fv09Td6y6MgkWty', '2020-05-11 04:38:42'),
('synafe888@gmail.com', '$2y$10$Ex4GZz6314N2YMTKsRIa3eUmVei1WjoTslWYWE.dlPPs5ZOnXkTMm', '2020-05-11 07:04:56'),
('tasnia.jinia77@gmail.com', '$2y$10$sY2R3nHueNAov/YpkE9hj.2CBueofNowfdwphDxGNY0k3nbqzfACG', '2020-05-11 09:43:08'),
('dr.maksudur4074@gmail.com', '$2y$10$VFJkALYoM5NF9C68QloJPeMEWGNxjgrZLFcFrK9ssfU8z/4.SgYE.', '2020-05-11 12:21:51'),
('fneema07@yahoo.com', '$2y$10$ADL5Nbp6yt8ZyjegAl9/Ee9p5/CHdWwVUE3Z1KAyhK4K1uJxP.fAS', '2020-05-11 22:40:32'),
('ahmedazizrmc@gmail.com', '$2y$10$u52J51hAaRdu90zs9py63eYa8QoBP1folt5ikkbzq8PJNK4y9tE0W', '2020-05-12 02:00:06'),
('abuyusuf016@gmail.com', '$2y$10$5Knr3Yk4rkKOFCrTaKpMeuNJGBJoqJD7f/TEIjaVDzRB5i0q0bFle', '2020-05-12 04:09:47'),
('himueyamun.eh@gmail.com', '$2y$10$GbewHkcxF68X//RYNX860uWckX2yN3bhCzJ6HdrcTXpUUQ5fpoT0a', '2020-05-12 08:25:07'),
('abusadat003@gmail.com', '$2y$10$AnzwDCpTTpkLZKOX3a0U2OTkciSXx/TcBUrmDsH5JZAV.XKlWM2Bm', '2020-05-12 08:29:46'),
('ahsankazi.kmc@gmail.com', '$2y$10$xzLEM1ESquG2wxFoYYDyS.uzD.q39YsLWdqkTgNnAs/qqF3fbbxfS', '2020-05-12 10:12:37'),
('zobaer9@gmail.com', '$2y$10$9O7m0CthiJIcaBOs8b/kGeyE5.4vumXGSmExSThrT6Zv9.RwgUu6C', '2020-05-12 10:14:13'),
('shanta.mou04@gmail.com', '$2y$10$aGyZcDbHx5rgH7vn0cwnrOuAPTyTuvNVKlTNbSjZy92i42ngwfH6.', '2020-05-12 11:02:17'),
('saddam01196@gmail.com', '$2y$10$lByheX7ExnqcePqSkLGnyukWePglCrFCB44UKKDeHFKNYro27LgSO', '2020-05-12 16:55:54'),
('nowrin.ferdous93@gmail.com', '$2y$10$VqDda8VL4z/CRUkQ18izseTVfzVNpEbdJOu7tI5YNb4wpR72X8TEO', '2020-05-12 23:04:34'),
('drshahrukhmalik@gmail.com', '$2y$10$Xzb0DGNBKsRAscbQFtKJ8ugDkZCjhzjnXPR2lNdnBtldI8iQfWmdK', '2020-05-13 00:57:25'),
('hasan101472@gmail.com', '$2y$10$8moJT37sMu2IsJweg07gPOwIz9kRS8HL2yLxsAvBbQSHAUmFQrTUS', '2020-05-13 01:23:07'),
('soniajannat49@gmail.com', '$2y$10$8y/.fHDeWIlOE99lxSzxb.0PaK5PUy5jDX4enSYg6mJJ6uQoCQ4lO', '2020-05-13 02:56:47'),
('dr.m.a.masum616@gmail.com', '$2y$10$avhZhjAAx7..ztxfH5iqo.NzwqQyp/shajgNGBYhYKd.NRTCFS/dq', '2020-05-13 07:21:34'),
('sohel.suchana@gmail.com', '$2y$10$4BS6YNOS4xom0AIhBQiJd.ZiGwdj2NF3wiseR0OGOcrr2sZfu2DOW', '2020-05-13 10:37:32'),
('mahfuza3152@gmail.com', '$2y$10$BuIrMWEDV92./74OoQ.aqedVPH6eC4CuUSkHs/J54HAi6gaHSNY5O', '2020-05-13 11:05:24'),
('dr.m.a.nazim1@gmail.com', '$2y$10$CVczg/R02uop1/.500/4bubKpWl.CeUJv.N3ZSk9bHAsH1hJ8pRM6', '2020-05-13 22:50:13'),
('antora.alam27@gmail.com', '$2y$10$jHnFTr2sZ7iciaWQfc2UyegTX2wnZVrB9191Jpz8P9WiDTpOM0oiG', '2020-05-14 05:06:47'),
('fahmitushi@gmail.com', '$2y$10$Vyq8yZFDhu7CVlLaeimMyeX5h.epcPHFSHyrL2EmNqMGNdcjKAa1a', '2020-05-14 18:31:33'),
('drsadia.nimc@gmail.com', '$2y$10$72xiunkcuA7fhV7FT4pwWuiFvJMhxB7.4wBxoMXH3VP.tmqCZzdja', '2020-05-14 20:24:37'),
('saadatemc4@GMAIL.COM', '$2y$10$l5Kze2Yj/mQHchV5Mgc//u.Rs6TuZP53RsxyjhwlViKmNvoDb6HRO', '2020-05-15 02:09:36'),
('prony.rimi@gmail.com', '$2y$10$aJ/KINifQkL9RPLMUF.3zujizt9SUU5gRybtCnVOcxNFHuWmiK.A.', '2020-05-15 02:11:02'),
('lopa.birdem@gmail.com', '$2y$10$EIY/cxv2BUrknmq8uRPsTe6.Alnd.n4Nht3s2.cY6oIxRSYQY06pq', '2020-05-15 02:38:10'),
('refatkabir8@gmail.com', '$2y$10$3e8Mg2tw/urpMmuqcXDr3OnUbVoZtswIZUbg6fz/eP7WbrTxUfRS6', '2020-05-15 05:55:24'),
('Fazler33@gmail.com', '$2y$10$.RNZQAEDBP2Q2bK.evM.8edZyfSkGhak82htdPHqr0tJ9E5YaYigW', '2020-05-15 07:48:10'),
('shahjabbinifty@gmail.com', '$2y$10$KO3Ctxze0VXXNQmsecFrmuZjJp8mN6pESN0C2GEMC9E1vCFy1SvSy', '2020-05-15 08:10:29'),
('sahasajiv@gmail.com', '$2y$10$xvCfLjHqLdi1JetlRj/zSeO7.hJNfj58bKcuy.PVQHJRu4.WlOCRy', '2020-05-15 08:34:24'),
('mr.meahrab@gmail.com', '$2y$10$uyxe7n3jUJob2qcs6pnTcOBi96GSCsJiX1hbGDfDe8ai9F0m3nkhC', '2020-05-15 11:07:18'),
('hafij.kmc.123@gmail.com', '$2y$10$8D4BM9fixNlZIwtreVWRne4EnclYK8hRLB3.5qxLYE95PS7NollCC', '2020-05-15 15:22:53'),
('tanzinachowdhury101@yahoo.com', '$2y$10$0vmdy4ns.lSblNg7VWrW7e6WeI.wb9UaobFOT/RrjyjB5kLvccXUS', '2020-05-15 23:29:00'),
('mohshiularefinroney@gmail.com', '$2y$10$jPIcj3BkTEtMoolvOYWm0uj0FZIIxaNoTPGsxB2xDoF9SuZQIj1B6', '2020-05-16 05:56:39'),
('drpoll@gmail.com', '$2y$10$N7jXYAW4PSreGXH0AyogBuygUTHSYo7RYXBQS2vEv5/bLP0GrQEkS', '2020-05-16 08:55:35'),
('dr_hr_shimul@yahoo.com', '$2y$10$xnrFqwxafNCfIUlQoKDPi.9UXhTAhRpdHZ73SuqoQqwR23hoVv3Dm', '2020-05-16 09:36:33'),
('ehsanhossainimran39@gmail.com', '$2y$10$3HIU.I7MHj4uCS9u8GWMretZ1o/zcvu8xokSc3q1JEZStz4/0G5Ua', '2020-05-16 10:30:19'),
('rima.farhana45@gmail.com', '$2y$10$IVZTknTZzetOY5FCxsuyzOC.geU23Q2saOknz4BXoLry7fkPR34IK', '2020-05-17 01:26:21'),
('rawsan.cmc@gmail.com', '$2y$10$bVyLze7LZz7Wsm.6uCToxuvRIl5mzIJDessUZ2VeD3HIwJQgCL0e6', '2020-05-17 01:54:15'),
('wasimamostary@gmail.com', '$2y$10$oBmUoR01XVbxSbjEMmclCuutM9cLJSmK2R4jZexpRdi8Ph2d6xpqu', '2020-05-17 02:06:17'),
('mahmud.cmc@gmail.com', '$2y$10$G7z/x8JRwb6Y2gw2rDn/.uptRjZjB16VxCcgnDm3tXHfj8PFu1Kz.', '2020-05-17 03:18:34'),
('torunibmc@gmail.com', '$2y$10$WE7R6NftQbvU4UtRAKT4peEy3DLqWHsAvV7EUCD6AC.v9eZamo5xi', '2020-05-17 07:06:16'),
('nahartoma7@gmail.com', '$2y$10$UN2BF2acGsd4TwmgShVy3uBur8NL/rELTxOjEuHXFoYoSscYtIfFy', '2020-05-17 09:14:57'),
('dr.s.m.arafat@gmail.com', '$2y$10$aBa2hoPTN.LNEpKlrPjksuklVPcOgWjpjPDo/KQ5MtYYXaLozl59a', '2020-05-17 09:19:59'),
('rizwans.sauro@gmail.com', '$2y$10$fAg6dhthtRVizWqTh6U1EeoB1NwzD9YIeirsO6yXXhS1ixhvl8VU6', '2020-05-17 12:11:41'),
('sidab33@gmail.com', '$2y$10$AbWcPmY1ZQ6gntOn9vfZ7elxCEn9zwvMbJR87ZniSWSg2FQsDjicO', '2020-05-17 19:26:37'),
('faruqshsmc@gmail.com', '$2y$10$DlrrWCTO21auCv7HtMxxguYU0cxIB1ckNcapgSJ.WTvbrst..UxhC', '2020-05-18 01:06:55'),
('dr.nadirabegumnancy@gmail.com', '$2y$10$IsXnG1RPb4gJ.hLg1fxmKe9rZVPdA5v9alSwDvrQvjLAVhZxq1vZ2', '2020-05-18 08:17:47'),
('xexnamakash@gmail.com', '$2y$10$dScA8j9wBf61VRl2PsPwxuRXA/lwd.9gxGn31pxVkw2TJAmNMUave', '2020-05-18 09:17:56'),
('ahmadmridul@gmail.com', '$2y$10$EjvTWuiQsuLl27yMMmoNUuVJEYzfREzc21EoClgsgUxEMRFhKZpkG', '2020-05-19 05:20:55'),
('skrazibhasnat79@gmail.com', '$2y$10$I/AdIMSZHVAlamV/cphQj.WbWSq5Y4VQANKY2e8jxpIICK6nYu5UK', '2020-05-19 23:58:10'),
('farjanajhumi124@gmail.com', '$2y$10$CzuNp/Db/S3C3NtxVMOe2.bVlpnrdzZVVI.dr2i.T/Abrr/sCuLVi', '2020-05-20 02:21:54'),
('mzanabab@gmail.com', '$2y$10$eUX1JXxu6v63vsZZ1aStLOLtbiIV08c4VTdustEFCZeKfPWcwl45m', '2020-05-20 02:22:09'),
('ornabhara@gmail.com', '$2y$10$0RSXYWCdnZOsrFqQOP4x1.Gxnbi3w4Itigz6.tu3IYnngL8/Ereci', '2020-05-20 04:07:25'),
('sazamm50mmc@gmail.com', '$2y$10$FmPqRQhdoj.a5/CILWiTcuS8oMve0OHLogpSQrgWVUi2dHm.TI7gS', '2020-05-20 08:04:00'),
('asifdrmc@gmail.com', '$2y$10$mKrpfDHD8V4IXctT2cfOXuEpq7zrwL4jyKmGVZeHiEKbVBKJFNw2m', '2020-05-20 11:35:49'),
('jishan.dnmc@gmail.com', '$2y$10$.bNTHgP2Rsuwhpxe2MK9TeuFLanGDUmBXxO7rEecGzRKuKeIg1mBq', '2020-05-21 09:14:07'),
('imranrobel88@gmail.com', '$2y$10$xXYMWAdM7f.ve3ZJC7ifb.P3dYQzvTX/0T30/7RImeiZj0DwDUXhm', '2020-05-21 18:41:21'),
('imranuddinrobel88@gmail.com', '$2y$10$Ix/7M/d9plCxX0eOUF6Lf.urx6YR63L7fPDYu2YsOREZemF/KTg0K', '2020-05-22 02:56:02'),
('biancaafroz777@gmail.com', '$2y$10$Z7fq4akV3kptkf98f6NeueExRu/7vVHsSAMNiCakkdKW3OpglZad.', '2020-05-22 04:19:19'),
('simi.munira@gmail.com', '$2y$10$u5xwWCO4JanB9giOiHXQRutXAwNTHIrTmi5kYRSmSetQkQYbYB2R2', '2020-05-22 13:46:14'),
('71mkzaman@gmail.com', '$2y$10$l7RatjiAzF9hD8w3xmnDfu0qVsLU4BXkncl712rTfWYVFskoRCsGK', '2020-05-27 22:45:49'),
('brishti.9898@gmail.com', '$2y$10$qN5x7Cg8brUbfebWnCKv7uDtxUTtaU5r4lMnDkxKttbv0Rx.JbB1m', '2020-05-28 05:24:33'),
('musabbir.8736@gmail.com', '$2y$10$59drGPPNX1c5cXFOWsJwmeKGWp6gR7.qIuo6EfTUqMKT.MA.HS/RS', '2020-05-28 10:58:05'),
('nazia.rb@gmail.com', '$2y$10$e1kh0hYcHzNyDTxlr9B1hOW3A5BqcqLjJ3zBIDJov5gDFdlMgv8LK', '2020-05-28 23:25:11'),
('skrafianoor@gmail.com', '$2y$10$MtvAv9Zxcbnesp4IlDONFOwznz8ZAP2UHQXCWRzz0Pop4rWUIPAhu', '2020-05-29 01:15:38'),
('dr.muradalmahmud@gmail.com', '$2y$10$06sfm2YG2IULnMBonLtCvuPuBvhki82VeKXCRxqGkVUiovjhqfI0.', '2020-05-29 06:27:45'),
('srs.shorna@gmail.com', '$2y$10$r3vuv5wAsfvlxXE3k0Ay4ezqrbhN74pcmb8JZ2qGb74.4RMrjgRw2', '2020-05-29 11:30:01'),
('easinarafathmalik@gmail.com', '$2y$10$24mRLoTp3SqyQLG2nY2Ere4kSZJf7gjd8VESndoxF1Mq9p5hxZYVi', '2020-05-30 07:59:33'),
('sohelrana54rmc@gmail.com', '$2y$10$h2jz4rbdCi.3AuF.S3s5LOCtHUILyQGgfuRu2jql9MN3X4VEqXG5i', '2020-05-31 01:45:32'),
('dr.rajeemustahid@gmail.com', '$2y$10$tALhneb1ZoTcpPLn2DdP/.vlwYwts/I90qCZRlHn.TA8UhfBTkq1W', '2020-05-31 03:03:31'),
('sirat07@gmail.com', '$2y$10$C.yPwckX9ad2zCqSdjPtNeJ/ze4kjcXMxHR.X0RnnfBeKL2kNMm4a', '2020-05-31 05:15:23'),
('nusrattina9@gmail.com', '$2y$10$jE0BC2N1LsVvkPakvn60MuN9Roa1SyaPDvfAjtpHORiawEQ5IEch.', '2020-05-31 11:18:39'),
('drtipusultan134@gmail.com', '$2y$10$kxvrWy1DsE6TyqU9fry5YOrxhm9bOBw8hikdlb01YsukOJMD2H5Je', '2020-05-31 12:08:06'),
('raju99comc@gmail.com', '$2y$10$.YqnN6/Jg.Kjq7M3rp/a.OL01UrOOyi8CEUsvQB8WuF.OSu8lcsMW', '2020-06-01 05:08:37'),
('ummasalmaliza07938@gmail.com', '$2y$10$FSFoo12He0H7zHX8LpKnkelp338HgG5kcfa.UyqQfpZV4CuTaa5AO', '2020-06-01 08:02:15'),
('tushararif14@gmail.com', '$2y$10$RasLHzYcHIbJPYyAp3gvhO9N2iaS10r/IEDs8Qy0w5TY6kcGKPtKO', '2020-06-01 11:20:24'),
('tauhidhoque49@gmail.com', '$2y$10$sOUoKL4zcFJZ7dcY.wbmFO9Vb9xeGcBjxKzpDMdKTTVUg3SCWURea', '2020-06-01 17:34:18'),
('aliafsersohel@gmail.com', '$2y$10$C.wJRHmwMaZCAxuO9D.m9.Le4j8Dw1/kX/0h0D66zCec19sGoHPP.', '2020-06-01 21:53:46'),
('tahsin000@gmail.com', '$2y$10$ZzQmI2ksLz3aPj57VklnmePGnXVzh9fbiuXqm8rTEbbH66Wss5O9i', '2020-06-02 03:38:05'),
('ya.ali007@yahoo.com', '$2y$10$Is4u.2PHq0s4Gg6r4zSVmeu26aAPERduuMxxyRgeP4kMYC51bzRLK', '2020-06-02 22:28:58'),
('dr.syduzzamansuman@gmail.com', '$2y$10$ik/R1Isjum2elPN2lpzv4umRvvGlc17YnEyLR3DWm3b6RyU.y/Xqy', '2020-06-03 03:38:10'),
('tasneemtahsina@gmail.com', '$2y$10$ehFp5SzvZWf6bsdj06vN5uBA7OABCmBfncxxK9pEJ0nWdDb6sStd.', '2020-06-03 07:02:30'),
('sadrinahasnin@gmail.com', '$2y$10$/OAvYXrSpcJ9fJwH.CWoXuf6OYOSOBiEjYShaNUYe4vlARJwnTSRe', '2020-06-03 09:29:01'),
('doctorroybd@gmail.com', '$2y$10$yXLi474HCZKwf8DX3cwzIO5nYyqm516OOQRCwXKFxpklKiE8Y9YX.', '2020-06-03 09:42:07'),
('almahfuzs@gmail.com', '$2y$10$CR8lxeo.ToZNUOgMJg8lZeD/IcwHxk7Jy05imxi86cTss8SKmhiYi', '2020-06-03 11:06:47'),
('shishir11745@gmail.com', '$2y$10$PkWEM1eyzlotjc.0cWc9JOZkn13ZbkTtMakW6dp5bqNxROCMygAuu', '2020-06-03 11:27:35'),
('drmohsinsyl@gmail.com', '$2y$10$vEMeFS2QFbJ2rvW2CqYIVeHCJnOfP0Y6nLp7aAbo84szl4L9maxTy', '2020-06-03 23:03:31'),
('fahmida1795@gmail.com', '$2y$10$ahzXz2iVY1D3O7G7vTCh.uUDj7X2626F4YMWq/DvErqCR9DzllY2W', '2020-06-03 23:18:57'),
('minhajulislamsaikat@gmail.com', '$2y$10$DDirqYvi.eVOJ.yWF1PkM.iyMQ8TrdCRAEH8pQr1kzTmW6d7YDehS', '2020-06-04 02:57:34'),
('Shanjida1996shantu@gmail.com', '$2y$10$6EJR02DugP15NRBp.cTxZOqwGmsbU0/O8r72mgqXYHXHrlfSYXDg2', '2020-06-04 03:32:46'),
('kanizneel57@gmail.com', '$2y$10$4YYsgHbT3G1hlkRJk7NHz.aiaCwYM60QqcDHjuQfzIL37bPylca86', '2020-06-04 05:35:02'),
('partho45@gmail.com', '$2y$10$08hENVqxf.8YqrMSi6rgleUYxDryYjn.Celh9YI77a7cENbDCkbi2', '2020-06-04 07:46:34'),
('nobeen360@gmail.com', '$2y$10$gJraTnKvvdM2iAp3Xy9FfOHJlmm0mxblpgrUtA/J/vZPvLlQOuEzS', '2020-06-04 09:56:42'),
('jakiajamil39@gmail.com', '$2y$10$lUOPRg5DHcUvKhF53wfxSOLvjGW2BqxOT/JOWFc7DtVZ5GaaQA90u', '2020-06-04 14:18:36'),
('drmdjashimuddin1511@gmail.com', '$2y$10$Wdpdu0bj1E1XVYIRDqpAFuRbVEudETHpqktOKCHeeGGIKFPnKisxm', '2020-06-05 00:25:29'),
('thinklearntrybelievework@gmail.com', '$2y$10$aGLI/Ba9LFm0NuKBkIJneeMP4qapkwFKGTIpPwGSnclK7fRXWw0T.', '2020-06-05 02:24:49'),
('sakeraakhter@yahoo.com', '$2y$10$Ss0HWPYjMFq7QRQ81pi6MO1eG8k81ZRxJdC/Pc4/6M3zuA24xOe6i', '2020-06-05 03:09:13'),
('m2a.imc@gmail.com', '$2y$10$iC8NmNGRt2pQdrk3rXjIbuk/PHjQDjaL8h.WSV7PWslJvT1Bb.7om', '2020-06-05 10:42:15'),
('mizandoc93@gmail.com', '$2y$10$6M0Bg3Kgh3S.FuyYF35WXevxB4h1jIFL9RKy7gJbADAWacFgAXFvi', '2020-06-05 21:48:31'),
('dr.ishtiaq000@gmail.com', '$2y$10$y66l9A5KQju04GwiqL4S1.WOfqowTWpME/bP/.W8U0kwKlFXnY4aO', '2020-06-06 04:00:34'),
('www.anannydutta@gmail.com', '$2y$10$zmNoZIxoZ58JdYEqN9agN.n2xnBzggpswYE3nyu2lwfO7Gx4t7su2', '2020-06-07 02:58:12'),
('a.nahiyan@gmail.com', '$2y$10$iUCUCYVdki0tubnqAAki0OgKHqfXiA4OD7qVOszj2Hlk2bQq3fN0O', '2020-06-07 04:27:00'),
('samirajaliltanni@yahoo.com', '$2y$10$JTEWpPIsEua8DJDt8YImoei5DG5ZFnWiUGIAbO9Ky573bwDwsBl3y', '2020-06-07 23:06:12'),
('samiratanni82@gmail.com', '$2y$10$KW/FojWvkfR/rW6jghyhbeKJu43r..0R2tzIKgp8cZUkNgkJ7BQU6', '2020-06-07 23:13:43'),
('shawon38mollah@gmail.com', '$2y$10$VGfqDAB7omp9tDC2AqseYeb.p7y4OX4QWjViGk.HkJnLiFZelSJBK', '2020-06-08 00:54:31'),
('rokibhasan3551@gmail.com', '$2y$10$XiXN4XHHyDFkwaUSSeIkSelQdvpl40CkSOxuWYxK8F/jNb.cI.6hG', '2020-06-08 12:34:26'),
('drtausik.bd@gmail.com', '$2y$10$NqdvrV6JAVQvrvMsp825pOxX2plkpUyt8fwrgqmsMAW/EzbR32RhO', '2020-06-08 12:54:48'),
('wmfhd369@gmail.com', '$2y$10$03QW4Luh33BUr7YIvz./pOpmi7RdIa1KPQFEvV/xlgqZNoMSIUIGO', '2020-06-08 12:58:26'),
('fatemarima168@gmail.com', '$2y$10$BARKwMPZWisFfyZtn7U9YeyFoENTuRt6MYH.Nf8VcD355cJ2u4tfu', '2020-06-09 00:00:41'),
('sultanarokeya96@gmail.com', '$2y$10$0q3EjpN7oL5UiKKVb18zWuBpJJKPRc2qFoXh94/xc33986f61hIIu', '2020-06-09 09:15:52'),
('tahjinahmed909@gmail.com', '$2y$10$FspePJaRXBu/THFPyRt5lOGGr0m8vf9JHuAYEdGosqlquQor1zvc2', '2020-06-09 23:29:35'),
('shorabhossainszmc@gmail.com', '$2y$10$HTErkQIBPn.0R1LN8WU6vuNnc6L8p3ZlmKkzChqKK050g4cvBFlzS', '2020-06-10 00:59:34'),
('isratcdc18@gmail.com', '$2y$10$3b8uUulZDGYkwra2O2NFnOhXNQFcqgDZ1wCZUEU63A0yKqSXbiXQe', '2020-06-10 08:03:08'),
('shafiashanta5@gmail.com', '$2y$10$FMCy1Etyww64brc6cN/RrOyeiB74SHPl9AGQJvOuTKe6nXYJZUi3O', '2020-06-11 00:57:13'),
('shifatrpmc42@gmail.com', '$2y$10$HRI1SXPw3O2YFVZzIuTZf.zgaKsqqhXWEZy1HhGxAxjRUHJARPHwa', '2020-06-11 02:51:40'),
('faisalrmc54@gmail.com', '$2y$10$9sqqNINrszYvOFOh0ZAQQOnSif9crkvZI/PN8Aet8hUZd133N2Kb.', '2020-06-11 03:49:51'),
('ebrahimjoy43@gmail.com', '$2y$10$Z48Ue.NnJo81L.Wnngrt0u70XZgAtY8.tX.XiGNQ.w8ti.SjLwW/K', '2020-06-11 04:14:23'),
('asmsayemtanvir20@gmail.com', '$2y$10$9UsKrQFFCzjOJDSX2bo/mOv9i5G4O8sKVn3DAuhMGdqi2k4zaUZme', '2020-06-11 04:42:15'),
('alamgirreza46@gmail.com', '$2y$10$aO4sW8fNtbgfzoTgWfJkYughx.6Kvhj7nEVXlz66abtpYlYh0JrBK', '2020-06-11 11:41:42'),
('mohena63@gmail.com', '$2y$10$y0ZsoT4iQ2SE9DsxvhFTuOkQpJwW2Vv7Bl0FSmPUk.1DIzl/8WJ9.', '2020-06-12 03:50:42'),
('sisharif54@gmail.com', '$2y$10$PP3a8wmJobBFJ2QBCZCTSO.kD1q4kSw4wagEoXmriUXZzf9eq1dlC', '2020-06-12 04:52:51'),
('taufikatanni.rpmc42@gmail.com', '$2y$10$w.h9eG2whdsn82mWT4R9ROXqUgOhs1z6oBUL7VRkAYWjwqVJ0feRS', '2020-06-12 06:22:38'),
('tomajimc@gmail.com', '$2y$10$f3D4XrZeIsZ1j6Hl8umo5u8nYNeonxekXx56NzPrsrJsecUZZdu9K', '2020-06-12 22:50:18'),
('mrifar@gmail.com', '$2y$10$lHhvt9MZGc8HcIj7eqEDy..6Ti3URTsD46N9XPOEO82HPi2DNfL/2', '2020-06-13 00:03:17'),
('kachiafifa@gmail.com', '$2y$10$nRp39DfjsE.G9xLbSiF5AesYaxkZyDXCFHmwwcAqab/t6mId848PS', '2020-06-13 00:09:22'),
('happynusrat0@gmail.com', '$2y$10$1vY.3cjFdEW4vts/dJoORuL8mE2qo/wTgE3oUMeShhtrc2EpJb5sK', '2020-06-13 00:38:05'),
('ratriakter01@gmail.com', '$2y$10$FC2cMWSSLkASiXNk.wvhH.w0YanlAGp58sSPbDYyRpse01boafQ5S', '2020-06-13 00:43:44'),
('hosnearamoni97@gmail.com', '$2y$10$q1LPslixIEP56/a1JhIV.uiN84XXaj7rlKgU9lzBRRXqT2X5YSNQ.', '2020-06-13 01:02:48'),
('dipp20155555@gmail.com', '$2y$10$8g/AMiAS.azYcHxVWz3Vtefo2iFutUjCfKBOTIoFwQTNrO6.9o.E2', '2020-06-13 02:29:04'),
('sarwafnawar@gmail.com', '$2y$10$ctARJmVIlAmwXv6oTjOcM.o7BcPEelil0n3w6/0/lOi7ayxPjY8N2', '2020-06-13 04:25:42'),
('raselmorshed1798@gmail.com', '$2y$10$7jByqYWjB9K07ZRFaH3Jl.Gbi.mIackpqSanQsO61N6N7IoubofH.', '2020-06-13 08:36:14'),
('Emabinteyounus@gmail.com', '$2y$10$WffZAFra6cYAQa2dgLcab.a2WhkYy24omAkzx/2t3j89KXAsONigm', '2020-06-13 19:59:18'),
('dr.emabinteyounus@gmail.com', '$2y$10$1aYwWf5erNqBQAuiSglA2elWBnRGI9SH4jPMPmiOLpWJWqZDRFq4S', '2020-06-13 20:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `reg_no` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `trans_id` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `parent_id`, `guard_name`, `created_at`, `updated_at`) VALUES
(45, 'Doctors', 0, 'web', '2020-01-18 03:03:24', '2020-01-18 03:03:24'),
(46, 'Doctor Add', 45, 'web', '2020-01-18 03:28:19', '2020-01-18 03:28:19'),
(47, 'Doctor Edit', 45, 'web', '2020-01-18 03:28:32', '2020-01-18 03:29:26'),
(48, 'Doctor Delete', 45, 'web', '2020-01-18 03:28:48', '2020-01-18 03:28:48'),
(49, 'Settings', 0, 'web', '2020-01-19 02:26:15', '2020-01-19 02:26:15'),
(50, 'Institutes', 49, 'web', '2020-01-19 02:26:30', '2020-01-19 02:26:30'),
(51, 'Courses', 49, 'web', '2020-01-19 02:26:43', '2020-01-19 02:26:43'),
(52, 'Questions', 0, 'web', '2020-01-19 02:36:20', '2020-01-19 02:36:20'),
(56, 'Doctors Courses', 0, 'web', '2020-02-14 03:53:46', '2020-02-14 03:53:46'),
(57, 'Doctors Course Add', 56, 'web', '2020-02-14 03:55:00', '2020-02-14 03:55:00'),
(58, 'Doctors Course Edit', 56, 'web', '2020-02-14 03:55:31', '2020-02-14 03:55:31'),
(59, 'Doctors Course Delete', 56, 'web', '2020-02-14 03:55:43', '2020-02-14 03:55:43'),
(60, 'Faculty', 49, 'web', '2020-02-14 03:57:13', '2020-02-14 03:57:13'),
(61, 'Subject', 49, 'web', '2020-02-14 03:57:51', '2020-02-14 03:57:51'),
(62, 'Batch', 49, 'web', '2020-02-14 03:58:19', '2020-02-14 03:58:19'),
(63, 'Service Package', 0, 'web', '2020-02-14 03:59:20', '2020-02-14 03:59:20'),
(64, 'Service Package Add', 63, 'web', '2020-02-14 03:59:29', '2020-02-14 03:59:29'),
(65, 'Service Package Edit', 63, 'web', '2020-02-14 03:59:40', '2020-02-14 03:59:40'),
(66, 'Service Package Delete', 63, 'web', '2020-02-14 03:59:50', '2020-02-14 03:59:50'),
(67, 'Coming By', 0, 'web', '2020-02-14 04:01:49', '2020-02-14 04:01:49'),
(68, 'Coming By Add', 67, 'web', '2020-02-14 04:02:05', '2020-02-14 04:02:05'),
(69, 'Coming By Edit', 67, 'web', '2020-02-14 04:02:28', '2020-02-14 04:02:28'),
(70, 'Coming By Delete', 67, 'web', '2020-02-14 04:02:39', '2020-02-14 04:02:39'),
(71, 'MCQ Question', 52, 'web', '2020-02-14 04:04:48', '2020-02-14 04:04:48'),
(72, 'SBA Question', 52, 'web', '2020-02-14 04:05:09', '2020-02-14 04:05:09'),
(73, 'Question Type', 52, 'web', '2020-02-14 04:05:24', '2020-02-14 04:05:24'),
(74, 'Exams', 0, 'web', '2020-02-14 04:05:52', '2020-02-14 04:05:52'),
(75, 'Exam Add', 74, 'web', '2020-02-14 04:06:09', '2020-02-14 04:06:09'),
(76, 'Exam Edit', 74, 'web', '2020-02-14 04:06:20', '2020-02-14 04:06:20'),
(77, 'Exam Delete', 74, 'web', '2020-02-14 04:06:32', '2020-02-14 04:06:32'),
(78, 'Topics', 0, 'web', '2020-02-14 04:06:55', '2020-02-14 04:07:24'),
(79, 'Topic Add', 78, 'web', '2020-02-14 04:08:06', '2020-02-14 04:08:06'),
(80, 'Topic Edit', 78, 'web', '2020-02-14 04:08:17', '2020-02-14 04:08:17'),
(81, 'Topic Delete', 78, 'web', '2020-02-14 04:08:41', '2020-02-14 04:08:41'),
(82, 'Teachers', 0, 'web', '2020-02-14 04:09:41', '2020-02-14 04:09:41'),
(83, 'Teacher Add', 82, 'web', '2020-02-14 04:09:52', '2020-02-14 04:09:52'),
(84, 'Teacher Edit', 82, 'web', '2020-02-14 04:10:05', '2020-02-14 04:10:05'),
(85, 'Teacher Delete', 82, 'web', '2020-02-14 04:10:16', '2020-02-14 04:10:16'),
(86, 'Doctor Show', 45, 'web', '2020-03-11 00:56:05', '2020-03-11 00:56:05'),
(87, 'Batch Schedule', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(88, 'Batch Schedule Add', 87, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(89, 'Batch Schedule Print', 87, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(90, 'Batch Schedule Edit', 87, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(91, 'Batch Schedule Delete', 87, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(92, 'Exam Common Code', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(93, 'Exam Common Code Add', 92, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(94, 'Exam Common Code Edit', 92, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(95, 'Exam Common Code Delete', 92, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(96, 'Online Exam Links', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(97, 'Online Exam Links Add', 96, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(98, 'Online Exam Links Edit', 96, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(99, 'Online Exam Links Delete', 96, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(100, 'Pages', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(101, 'Pages Add', 100, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(102, 'Pages Edit', 100, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(103, 'Pages Delete', 100, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(119, 'Lecture Video Management', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(120, 'Lecture Video', 119, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(121, 'Lecture Video Batch', 119, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(122, 'Lecture Sheet Management', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(123, 'Lecture Sheet', 122, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(124, 'Lecture Sheet Link', 122, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(125, 'Room', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(126, 'Room Add', 125, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(127, 'Room Edit', 125, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(128, 'Room Delete', 125, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(129, 'Doctor Question', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(130, 'Doctor Complain', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00'),
(131, 'Report', 0, 'web', '2020-03-20 18:00:00', '2020-03-20 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT 'mcq=1,sba=2',
  `question_title` text NOT NULL,
  `correct_ans` varchar(5) NOT NULL,
  `question_in_year` varchar(90) DEFAULT NULL,
  `discussion` text NOT NULL,
  `reference` text NOT NULL,
  `heading` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(30) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question_ans`
--

CREATE TABLE `question_ans` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(500) NOT NULL,
  `sl_no` varchar(2) NOT NULL,
  `correct_ans` varchar(5) DEFAULT NULL COMMENT 'only for mcq , only T,F'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE `question_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mcq_number` int(11) NOT NULL,
  `mcq_mark` float(10,2) NOT NULL,
  `mcq_negative_mark` float NOT NULL,
  `sba_number` int(11) NOT NULL,
  `sba_mark` float(10,2) NOT NULL,
  `sba_negative_mark` float(10,2) NOT NULL,
  `pass_mark` int(11) NOT NULL,
  `full_mark` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_paper` varchar(155) NOT NULL,
  `is_faculty` varchar(155) NOT NULL,
  `paper_faculty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `doctor_course_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `examination_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `candidate_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_id` int(11) NOT NULL,
  `paper_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `correct_mark` float(10,2) NOT NULL,
  `negative_mark` float(10,2) NOT NULL,
  `obtained_mark` float(10,2) NOT NULL,
  `obtained_mark_decimal` int(11) NOT NULL,
  `wrong_answers` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', '2018-04-21 22:34:11', '2018-04-21 22:34:11'),
(2, 'Doctors Data Entry', 'web', '2018-04-21 22:58:52', '2020-02-24 05:48:04'),
(3, 'users', 'web', '2018-04-23 04:57:15', '2018-04-23 04:57:15'),
(6, 'Questions', 'web', '2018-07-26 23:00:36', '2020-02-24 05:48:51'),
(7, 'Super Admin', 'web', '2020-02-24 05:36:50', '2020-02-24 05:46:43'),
(8, 'Exams', 'web', '2020-02-24 05:49:26', '2020-02-24 05:49:26'),
(9, 'edit option', 'web', '2020-03-27 01:15:07', '2020-03-27 01:15:07'),
(10, 'batch schhedule view', 'web', '2020-03-27 23:47:26', '2020-03-27 23:47:26'),
(11, 'Complain & Reply', 'web', '2020-04-24 17:33:07', '2020-04-24 17:33:07'),
(12, 'Dr.s\' Course Delete', 'web', '2020-05-13 03:10:59', '2020-05-13 03:10:59'),
(13, 'Report View', 'web', '2020-05-29 21:57:37', '2020-05-29 21:57:37'),
(14, 'Viewer', 'web', '2020-06-01 05:06:26', '2020-06-01 05:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(45, 1),
(45, 2),
(45, 7),
(45, 9),
(45, 14),
(46, 1),
(46, 2),
(46, 7),
(47, 1),
(47, 2),
(47, 7),
(47, 9),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(52, 6),
(52, 7),
(56, 1),
(56, 2),
(56, 7),
(56, 9),
(56, 12),
(56, 14),
(57, 1),
(57, 2),
(57, 7),
(58, 1),
(58, 2),
(58, 7),
(58, 9),
(58, 12),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(71, 6),
(71, 7),
(72, 1),
(72, 6),
(72, 7),
(73, 1),
(73, 6),
(73, 7),
(74, 1),
(74, 7),
(74, 8),
(74, 14),
(75, 1),
(75, 7),
(75, 8),
(76, 1),
(76, 7),
(76, 8),
(77, 1),
(78, 1),
(78, 7),
(78, 14),
(79, 1),
(79, 7),
(80, 1),
(80, 7),
(81, 1),
(82, 1),
(82, 7),
(82, 14),
(83, 1),
(83, 7),
(84, 1),
(84, 7),
(85, 1),
(86, 1),
(86, 2),
(86, 7),
(87, 1),
(87, 7),
(87, 10),
(87, 14),
(88, 1),
(88, 7),
(89, 1),
(89, 7),
(89, 10),
(90, 1),
(90, 7),
(91, 1),
(92, 1),
(92, 7),
(92, 14),
(93, 1),
(93, 7),
(94, 1),
(94, 7),
(95, 1),
(96, 1),
(96, 7),
(96, 14),
(97, 1),
(97, 7),
(98, 1),
(98, 7),
(99, 1),
(100, 1),
(100, 7),
(100, 14),
(101, 1),
(101, 7),
(102, 1),
(102, 7),
(103, 1),
(103, 14),
(119, 1),
(119, 7),
(119, 14),
(120, 1),
(120, 7),
(121, 1),
(121, 7),
(122, 1),
(122, 7),
(122, 14),
(123, 1),
(123, 7),
(124, 1),
(124, 7),
(125, 1),
(125, 7),
(126, 1),
(126, 7),
(127, 1),
(127, 7),
(128, 1),
(129, 1),
(129, 7),
(130, 1),
(130, 7),
(130, 11),
(131, 1),
(131, 7),
(131, 13);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_types`
--

CREATE TABLE `rooms_types` (
  `id` int(10) NOT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `floor` varchar(40) NOT NULL,
  `room_name` varchar(40) NOT NULL,
  `capacity` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(35) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(35) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms_types`
--

INSERT INTO `rooms_types` (`id`, `Location`, `floor`, `room_name`, `capacity`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Building 01', '1', 'Room 101', 50, '2020-09-03 23:42:49', '1', '2020-09-04 05:42:49', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `service_packages`
--

CREATE TABLE `service_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_packages`
--

INSERT INTO `service_packages` (`id`, `name`, `status`) VALUES
(1, 'Demo Package', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `session_code` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `duration`, `session_code`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(7, 'January(Jan-Jul)', 'January-July', 1, 1, '2020-05-06 16:19:41', 1, '2020-05-06 10:19:41', 13),
(8, 'July(Jul-Jan)', 'July-January', 7, 1, '2020-05-02 10:32:43', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `course_code` int(2) NOT NULL,
  `faculty_code` int(2) DEFAULT 0,
  `name` varchar(90) NOT NULL,
  `subject_omr_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(40) NOT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `institute_id`, `course_id`, `faculty_id`, `course_code`, `faculty_code`, `name`, `subject_omr_code`, `created_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 1, 1, NULL, 0, 0, 'Medicine', '0', '2020-09-03 13:03:12', '13', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `bmdc_no` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `passport` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `bmdc_no`, `phone`, `email`, `gender`, `nid`, `passport`, `address`, `status`, `created_at`, `updated_at`) VALUES
(0, 'MD Mohmud Ali', 'A12345', '01700000000', 'example@example.com', 'Male', NULL, NULL, NULL, 1, '2020-09-04 00:32:15', '2020-09-04 00:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_id` varchar(25) NOT NULL,
  `tec_name` varchar(70) NOT NULL,
  `fath_name` varchar(70) NOT NULL,
  `mother_name` varchar(70) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `joining_date` date NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `religion` varchar(1) DEFAULT NULL,
  `nationality` varchar(12) DEFAULT NULL,
  `na_id` varchar(25) DEFAULT NULL,
  `pass_no` varchar(30) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `bmdc_no` varchar(30) NOT NULL,
  `per_add` varchar(120) DEFAULT NULL,
  `mai_add` varchar(120) DEFAULT NULL,
  `spouse_name` varchar(50) DEFAULT NULL,
  `pouse_mobile` varchar(15) DEFAULT NULL,
  `blood_gro` varchar(6) DEFAULT NULL,
  `per_divi` varchar(10) DEFAULT NULL,
  `per_dist` varchar(10) DEFAULT NULL,
  `per_thana` varchar(10) DEFAULT NULL,
  `per_address` varchar(50) DEFAULT NULL,
  `mai_divi` varchar(10) DEFAULT NULL,
  `mai_dist` varchar(10) DEFAULT NULL,
  `mai_thana` varchar(10) DEFAULT NULL,
  `mai_address` varchar(50) DEFAULT NULL,
  `photo` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(25) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(25) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL DEFAULT 0,
  `subject_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `course_id`, `faculty_id`, `subject_id`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 0, 0, 'Respiratory Medicine', 1, '2020-09-05 03:40:57', 10, '2020-09-05 03:40:57', NULL),
(2, 1, 0, 0, 'Respiratory Medicine 2', 1, '2020-09-05 03:41:09', 10, '2020-09-05 03:41:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

CREATE TABLE `upazilas` (
  `id` int(2) UNSIGNED NOT NULL,
  `district_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `upazilas`
--

INSERT INTO `upazilas` (`id`, `district_id`, `name`, `bn_name`) VALUES
(1, 34, 'Amtali Upazila', 'আমতলী'),
(2, 34, 'Bamna Upazila', 'বামনা'),
(3, 34, 'Barguna Sadar Upazila', 'বরগুনা সদর'),
(4, 34, 'Betagi Upazila', 'বেতাগি'),
(5, 34, 'Patharghata Upazila', 'পাথরঘাটা'),
(6, 34, 'Taltali Upazila', 'তালতলী'),
(7, 35, 'Muladi Upazila', 'মুলাদি'),
(8, 35, 'Babuganj Upazila', 'বাবুগঞ্জ'),
(9, 35, 'Agailjhara Upazila', 'আগাইলঝরা'),
(10, 35, 'Barisal Sadar Upazila', 'বরিশাল সদর'),
(11, 35, 'Bakerganj Upazila', 'বাকেরগঞ্জ'),
(12, 35, 'Banaripara Upazila', 'বানাড়িপারা'),
(13, 35, 'Gaurnadi Upazila', 'গৌরনদী'),
(14, 35, 'Hizla Upazila', 'হিজলা'),
(15, 35, 'Mehendiganj Upazila', 'মেহেদিগঞ্জ '),
(16, 35, 'Wazirpur Upazila', 'ওয়াজিরপুর'),
(17, 36, 'Bhola Sadar Upazila', 'ভোলা সদর'),
(18, 36, 'Burhanuddin Upazila', 'বুরহানউদ্দিন'),
(19, 36, 'Char Fasson Upazila', 'চর ফ্যাশন'),
(20, 36, 'Daulatkhan Upazila', 'দৌলতখান'),
(21, 36, 'Lalmohan Upazila', 'লালমোহন'),
(22, 36, 'Manpura Upazila', 'মনপুরা'),
(23, 36, 'Tazumuddin Upazila', 'তাজুমুদ্দিন'),
(24, 37, 'Jhalokati Sadar Upazila', 'ঝালকাঠি সদর'),
(25, 37, 'Kathalia Upazila', 'কাঁঠালিয়া'),
(26, 37, 'Nalchity Upazila', 'নালচিতি'),
(27, 37, 'Rajapur Upazila', 'রাজাপুর'),
(28, 38, 'Bauphal Upazila', 'বাউফল'),
(29, 38, 'Dashmina Upazila', 'দশমিনা'),
(30, 38, 'Galachipa Upazila', 'গলাচিপা'),
(31, 38, 'Kalapara Upazila', 'কালাপারা'),
(32, 38, 'Mirzaganj Upazila', 'মির্জাগঞ্জ '),
(33, 38, 'Patuakhali Sadar Upazila', 'পটুয়াখালী সদর'),
(34, 38, 'Dumki Upazila', 'ডুমকি'),
(35, 38, 'Rangabali Upazila', 'রাঙ্গাবালি'),
(36, 39, 'Bhandaria', 'ভ্যান্ডারিয়া'),
(37, 39, 'Kaukhali', 'কাউখালি'),
(38, 39, 'Mathbaria', 'মাঠবাড়িয়া'),
(39, 39, 'Nazirpur', 'নাজিরপুর'),
(40, 39, 'Nesarabad', 'নেসারাবাদ'),
(41, 39, 'Pirojpur Sadar', 'পিরোজপুর সদর'),
(42, 39, 'Zianagar', 'জিয়ানগর'),
(43, 40, 'Bandarban Sadar', 'বান্দরবন সদর'),
(44, 40, 'Thanchi', 'থানচি'),
(45, 40, 'Lama', 'লামা'),
(46, 40, 'Naikhongchhari', 'নাইখংছড়ি '),
(47, 40, 'Ali kadam', 'আলী কদম'),
(48, 40, 'Rowangchhari', 'রউয়াংছড়ি '),
(49, 40, 'Ruma', 'রুমা'),
(50, 41, 'Brahmanbaria Sadar Upazila', 'ব্রাহ্মণবাড়িয়া সদর'),
(51, 41, 'Ashuganj Upazila', 'আশুগঞ্জ'),
(52, 41, 'Nasirnagar Upazila', 'নাসির নগর'),
(53, 41, 'Nabinagar Upazila', 'নবীনগর'),
(54, 41, 'Sarail Upazila', 'সরাইল'),
(55, 41, 'Shahbazpur Town', 'শাহবাজপুর টাউন'),
(56, 41, 'Kasba Upazila', 'কসবা'),
(57, 41, 'Akhaura Upazila', 'আখাউরা'),
(58, 41, 'Bancharampur Upazila', 'বাঞ্ছারামপুর'),
(59, 41, 'Bijoynagar Upazila', 'বিজয় নগর'),
(60, 42, 'Chandpur Sadar', 'চাঁদপুর সদর'),
(61, 42, 'Faridganj', 'ফরিদগঞ্জ'),
(62, 42, 'Haimchar', 'হাইমচর'),
(63, 42, 'Haziganj', 'হাজীগঞ্জ'),
(64, 42, 'Kachua', 'কচুয়া'),
(65, 42, 'Matlab Uttar', 'মতলব উত্তর'),
(66, 42, 'Matlab Dakkhin', 'মতলব দক্ষিণ'),
(67, 42, 'Shahrasti', 'শাহরাস্তি'),
(68, 43, 'Anwara Upazila', 'আনোয়ারা'),
(69, 43, 'Banshkhali Upazila', 'বাশখালি'),
(70, 43, 'Boalkhali Upazila', 'বোয়ালখালি'),
(71, 43, 'Chandanaish Upazila', 'চন্দনাইশ'),
(72, 43, 'Fatikchhari Upazila', 'ফটিকছড়ি'),
(73, 43, 'Hathazari Upazila', 'হাঠহাজারী'),
(74, 43, 'Lohagara Upazila', 'লোহাগারা'),
(75, 43, 'Mirsharai Upazila', 'মিরসরাই'),
(76, 43, 'Patiya Upazila', 'পটিয়া'),
(77, 43, 'Rangunia Upazila', 'রাঙ্গুনিয়া'),
(78, 43, 'Raozan Upazila', 'রাউজান'),
(79, 43, 'Sandwip Upazila', 'সন্দ্বীপ'),
(80, 43, 'Satkania Upazila', 'সাতকানিয়া'),
(81, 43, 'Sitakunda Upazila', 'সীতাকুণ্ড'),
(82, 44, 'Barura Upazila', 'বড়ুরা'),
(83, 44, 'Brahmanpara Upazila', 'ব্রাহ্মণপাড়া'),
(84, 44, 'Burichong Upazila', 'বুড়িচং'),
(85, 44, 'Chandina Upazila', 'চান্দিনা'),
(86, 44, 'Chauddagram Upazila', 'চৌদ্দগ্রাম'),
(87, 44, 'Daudkandi Upazila', 'দাউদকান্দি'),
(88, 44, 'Debidwar Upazila', 'দেবীদ্বার'),
(89, 44, 'Homna Upazila', 'হোমনা'),
(90, 44, 'Comilla Sadar Upazila', 'কুমিল্লা সদর'),
(91, 44, 'Laksam Upazila', 'লাকসাম'),
(92, 44, 'Monohorgonj Upazila', 'মনোহরগঞ্জ'),
(93, 44, 'Meghna Upazila', 'মেঘনা'),
(94, 44, 'Muradnagar Upazila', 'মুরাদনগর'),
(95, 44, 'Nangalkot Upazila', 'নাঙ্গালকোট'),
(96, 44, 'Comilla Sadar South Upazila', 'কুমিল্লা সদর দক্ষিণ'),
(97, 44, 'Titas Upazila', 'তিতাস'),
(98, 45, 'Chakaria Upazila', 'চকরিয়া'),
(100, 45, 'Cox\'s Bazar Sadar Upazila', 'কক্স বাজার সদর'),
(101, 45, 'Kutubdia Upazila', 'কুতুবদিয়া'),
(102, 45, 'Maheshkhali Upazila', 'মহেশখালী'),
(103, 45, 'Ramu Upazila', 'রামু'),
(104, 45, 'Teknaf Upazila', 'টেকনাফ'),
(105, 45, 'Ukhia Upazila', 'উখিয়া'),
(106, 45, 'Pekua Upazila', 'পেকুয়া'),
(107, 46, 'Feni Sadar', 'ফেনী সদর'),
(108, 46, 'Chagalnaiya', 'ছাগল নাইয়া'),
(109, 46, 'Daganbhyan', 'দাগানভিয়া'),
(110, 46, 'Parshuram', 'পরশুরাম'),
(111, 46, 'Fhulgazi', 'ফুলগাজি'),
(112, 46, 'Sonagazi', 'সোনাগাজি'),
(113, 47, 'Dighinala Upazila', 'দিঘিনালা '),
(114, 47, 'Khagrachhari Upazila', 'খাগড়াছড়ি'),
(115, 47, 'Lakshmichhari Upazila', 'লক্ষ্মীছড়ি'),
(116, 47, 'Mahalchhari Upazila', 'মহলছড়ি'),
(117, 47, 'Manikchhari Upazila', 'মানিকছড়ি'),
(118, 47, 'Matiranga Upazila', 'মাটিরাঙ্গা'),
(119, 47, 'Panchhari Upazila', 'পানছড়ি'),
(120, 47, 'Ramgarh Upazila', 'রামগড়'),
(121, 48, 'Lakshmipur Sadar Upazila', 'লক্ষ্মীপুর সদর'),
(122, 48, 'Raipur Upazila', 'রায়পুর'),
(123, 48, 'Ramganj Upazila', 'রামগঞ্জ'),
(124, 48, 'Ramgati Upazila', 'রামগতি'),
(125, 48, 'Komol Nagar Upazila', 'কমল নগর'),
(126, 49, 'Noakhali Sadar Upazila', 'নোয়াখালী সদর'),
(127, 49, 'Begumganj Upazila', 'বেগমগঞ্জ'),
(128, 49, 'Chatkhil Upazila', 'চাটখিল'),
(129, 49, 'Companyganj Upazila', 'কোম্পানীগঞ্জ'),
(130, 49, 'Shenbag Upazila', 'শেনবাগ'),
(131, 49, 'Hatia Upazila', 'হাতিয়া'),
(132, 49, 'Kobirhat Upazila', 'কবিরহাট '),
(133, 49, 'Sonaimuri Upazila', 'সোনাইমুরি'),
(134, 49, 'Suborno Char Upazila', 'সুবর্ণ চর '),
(135, 50, 'Rangamati Sadar Upazila', 'রাঙ্গামাটি সদর'),
(136, 50, 'Belaichhari Upazila', 'বেলাইছড়ি'),
(137, 50, 'Bagaichhari Upazila', 'বাঘাইছড়ি'),
(138, 50, 'Barkal Upazila', 'বরকল'),
(139, 50, 'Juraichhari Upazila', 'জুরাইছড়ি'),
(140, 50, 'Rajasthali Upazila', 'রাজাস্থলি'),
(141, 50, 'Kaptai Upazila', 'কাপ্তাই'),
(142, 50, 'Langadu Upazila', 'লাঙ্গাডু'),
(143, 50, 'Nannerchar Upazila', 'নান্নেরচর '),
(144, 50, 'Kaukhali Upazila', 'কাউখালি'),
(145, 1, 'Dhamrai Upazila', 'ধামরাই'),
(146, 1, 'Dohar Upazila', 'দোহার'),
(147, 1, 'Keraniganj Upazila', 'কেরানীগঞ্জ'),
(148, 1, 'Nawabganj Upazila', 'নবাবগঞ্জ'),
(149, 1, 'Savar Upazila', 'সাভার'),
(150, 2, 'Faridpur Sadar Upazila', 'ফরিদপুর সদর'),
(151, 2, 'Boalmari Upazila', 'বোয়ালমারী'),
(152, 2, 'Alfadanga Upazila', 'আলফাডাঙ্গা'),
(153, 2, 'Madhukhali Upazila', 'মধুখালি'),
(154, 2, 'Bhanga Upazila', 'ভাঙ্গা'),
(155, 2, 'Nagarkanda Upazila', 'নগরকান্ড'),
(156, 2, 'Charbhadrasan Upazila', 'চরভদ্রাসন '),
(157, 2, 'Sadarpur Upazila', 'সদরপুর'),
(158, 2, 'Shaltha Upazila', 'শালথা'),
(159, 3, 'Gazipur Sadar-Joydebpur', 'গাজীপুর সদর'),
(160, 3, 'Kaliakior', 'কালিয়াকৈর'),
(161, 3, 'Kapasia', 'কাপাসিয়া'),
(162, 3, 'Sripur', 'শ্রীপুর'),
(163, 3, 'Kaliganj', 'কালীগঞ্জ'),
(164, 3, 'Tongi', 'টঙ্গি'),
(165, 4, 'Gopalganj Sadar Upazila', 'গোপালগঞ্জ সদর'),
(166, 4, 'Kashiani Upazila', 'কাশিয়ানি'),
(167, 4, 'Kotalipara Upazila', 'কোটালিপাড়া'),
(168, 4, 'Muksudpur Upazila', 'মুকসুদপুর'),
(169, 4, 'Tungipara Upazila', 'টুঙ্গিপাড়া'),
(170, 5, 'Dewanganj Upazila', 'দেওয়ানগঞ্জ'),
(171, 5, 'Baksiganj Upazila', 'বকসিগঞ্জ'),
(172, 5, 'Islampur Upazila', 'ইসলামপুর'),
(173, 5, 'Jamalpur Sadar Upazila', 'জামালপুর সদর'),
(174, 5, 'Madarganj Upazila', 'মাদারগঞ্জ'),
(175, 5, 'Melandaha Upazila', 'মেলানদাহা'),
(176, 5, 'Sarishabari Upazila', 'সরিষাবাড়ি '),
(177, 5, 'Narundi Police I.C', 'নারুন্দি'),
(178, 6, 'Astagram Upazila', 'অষ্টগ্রাম'),
(179, 6, 'Bajitpur Upazila', 'বাজিতপুর'),
(180, 6, 'Bhairab Upazila', 'ভৈরব'),
(181, 6, 'Hossainpur Upazila', 'হোসেনপুর '),
(182, 6, 'Itna Upazila', 'ইটনা'),
(183, 6, 'Karimganj Upazila', 'করিমগঞ্জ'),
(184, 6, 'Katiadi Upazila', 'কতিয়াদি'),
(185, 6, 'Kishoreganj Sadar Upazila', 'কিশোরগঞ্জ সদর'),
(186, 6, 'Kuliarchar Upazila', 'কুলিয়ারচর'),
(187, 6, 'Mithamain Upazila', 'মিঠামাইন'),
(188, 6, 'Nikli Upazila', 'নিকলি'),
(189, 6, 'Pakundia Upazila', 'পাকুন্ডা'),
(190, 6, 'Tarail Upazila', 'তাড়াইল'),
(191, 7, 'Madaripur Sadar', 'মাদারীপুর সদর'),
(192, 7, 'Kalkini', 'কালকিনি'),
(193, 7, 'Rajoir', 'রাজইর'),
(194, 7, 'Shibchar', 'শিবচর'),
(195, 8, 'Manikganj Sadar Upazila', 'মানিকগঞ্জ সদর'),
(196, 8, 'Singair Upazila', 'সিঙ্গাইর'),
(197, 8, 'Shibalaya Upazila', 'শিবালয়'),
(198, 8, 'Saturia Upazila', 'সাঠুরিয়া'),
(199, 8, 'Harirampur Upazila', 'হরিরামপুর'),
(200, 8, 'Ghior Upazila', 'ঘিওর'),
(201, 8, 'Daulatpur Upazila', 'দৌলতপুর'),
(202, 9, 'Lohajang Upazila', 'লোহাজং'),
(203, 9, 'Sreenagar Upazila', 'শ্রীনগর'),
(204, 9, 'Munshiganj Sadar Upazila', 'মুন্সিগঞ্জ সদর'),
(205, 9, 'Sirajdikhan Upazila', 'সিরাজদিখান'),
(206, 9, 'Tongibari Upazila', 'টঙ্গিবাড়ি'),
(207, 9, 'Gazaria Upazila', 'গজারিয়া'),
(208, 10, 'Bhaluka', 'ভালুকা'),
(209, 10, 'Trishal', 'ত্রিশাল'),
(210, 10, 'Haluaghat', 'হালুয়াঘাট'),
(211, 10, 'Muktagachha', 'মুক্তাগাছা'),
(212, 10, 'Dhobaura', 'ধবারুয়া'),
(213, 10, 'Fulbaria', 'ফুলবাড়িয়া'),
(214, 10, 'Gaffargaon', 'গফরগাঁও'),
(215, 10, 'Gauripur', 'গৌরিপুর'),
(216, 10, 'Ishwarganj', 'ঈশ্বরগঞ্জ'),
(217, 10, 'Mymensingh Sadar', 'ময়মনসিং সদর'),
(218, 10, 'Nandail', 'নন্দাইল'),
(219, 10, 'Phulpur', 'ফুলপুর'),
(220, 11, 'Araihazar Upazila', 'আড়াইহাজার'),
(221, 11, 'Sonargaon Upazila', 'সোনারগাঁও'),
(222, 11, 'Bandar', 'বান্দার'),
(223, 11, 'Naryanganj Sadar Upazila', 'নারায়ানগঞ্জ সদর'),
(224, 11, 'Rupganj Upazila', 'রূপগঞ্জ'),
(225, 11, 'Siddirgonj Upazila', 'সিদ্ধিরগঞ্জ'),
(226, 12, 'Belabo Upazila', 'বেলাবো'),
(227, 12, 'Monohardi Upazila', 'মনোহরদি'),
(228, 12, 'Narsingdi Sadar Upazila', 'নরসিংদী সদর'),
(229, 12, 'Palash Upazila', 'পলাশ'),
(230, 12, 'Raipura Upazila, Narsingdi', 'রায়পুর'),
(231, 12, 'Shibpur Upazila', 'শিবপুর'),
(232, 13, 'Kendua Upazilla', 'কেন্দুয়া'),
(233, 13, 'Atpara Upazilla', 'আটপাড়া'),
(234, 13, 'Barhatta Upazilla', 'বরহাট্টা'),
(235, 13, 'Durgapur Upazilla', 'দুর্গাপুর'),
(236, 13, 'Kalmakanda Upazilla', 'কলমাকান্দা'),
(237, 13, 'Madan Upazilla', 'মদন'),
(238, 13, 'Mohanganj Upazilla', 'মোহনগঞ্জ'),
(239, 13, 'Netrakona-S Upazilla', 'নেত্রকোনা সদর'),
(240, 13, 'Purbadhala Upazilla', 'পূর্বধলা'),
(241, 13, 'Khaliajuri Upazilla', 'খালিয়াজুরি'),
(242, 14, 'Baliakandi Upazila', 'বালিয়াকান্দি'),
(243, 14, 'Goalandaghat Upazila', 'গোয়ালন্দ ঘাট'),
(244, 14, 'Pangsha Upazila', 'পাংশা'),
(245, 14, 'Kalukhali Upazila', 'কালুখালি'),
(246, 14, 'Rajbari Sadar Upazila', 'রাজবাড়ি সদর'),
(247, 15, 'Shariatpur Sadar -Palong', 'শরীয়তপুর সদর '),
(248, 15, 'Damudya Upazila', 'দামুদিয়া'),
(249, 15, 'Naria Upazila', 'নড়িয়া'),
(250, 15, 'Jajira Upazila', 'জাজিরা'),
(251, 15, 'Bhedarganj Upazila', 'ভেদারগঞ্জ'),
(252, 15, 'Gosairhat Upazila', 'গোসাইর হাট '),
(253, 16, 'Jhenaigati Upazila', 'ঝিনাইগাতি'),
(254, 16, 'Nakla Upazila', 'নাকলা'),
(255, 16, 'Nalitabari Upazila', 'নালিতাবাড়ি'),
(256, 16, 'Sherpur Sadar Upazila', 'শেরপুর সদর'),
(257, 16, 'Sreebardi Upazila', 'শ্রীবরদি'),
(258, 17, 'Tangail Sadar Upazila', 'টাঙ্গাইল সদর'),
(259, 17, 'Sakhipur Upazila', 'সখিপুর'),
(260, 17, 'Basail Upazila', 'বসাইল'),
(261, 17, 'Madhupur Upazila', 'মধুপুর'),
(262, 17, 'Ghatail Upazila', 'ঘাটাইল'),
(263, 17, 'Kalihati Upazila', 'কালিহাতি'),
(264, 17, 'Nagarpur Upazila', 'নগরপুর'),
(265, 17, 'Mirzapur Upazila', 'মির্জাপুর'),
(266, 17, 'Gopalpur Upazila', 'গোপালপুর'),
(267, 17, 'Delduar Upazila', 'দেলদুয়ার'),
(268, 17, 'Bhuapur Upazila', 'ভুয়াপুর'),
(269, 17, 'Dhanbari Upazila', 'ধানবাড়ি'),
(270, 55, 'Bagerhat Sadar Upazila', 'বাগেরহাট সদর'),
(271, 55, 'Chitalmari Upazila', 'চিতলমাড়ি'),
(272, 55, 'Fakirhat Upazila', 'ফকিরহাট'),
(273, 55, 'Kachua Upazila', 'কচুয়া'),
(274, 55, 'Mollahat Upazila', 'মোল্লাহাট '),
(275, 55, 'Mongla Upazila', 'মংলা'),
(276, 55, 'Morrelganj Upazila', 'মরেলগঞ্জ'),
(277, 55, 'Rampal Upazila', 'রামপাল'),
(278, 55, 'Sarankhola Upazila', 'স্মরণখোলা'),
(279, 56, 'Damurhuda Upazila', 'দামুরহুদা'),
(280, 56, 'Chuadanga-S Upazila', 'চুয়াডাঙ্গা সদর'),
(281, 56, 'Jibannagar Upazila', 'জীবন নগর '),
(282, 56, 'Alamdanga Upazila', 'আলমডাঙ্গা'),
(283, 57, 'Abhaynagar Upazila', 'অভয়নগর'),
(284, 57, 'Keshabpur Upazila', 'কেশবপুর'),
(285, 57, 'Bagherpara Upazila', 'বাঘের পাড়া '),
(286, 57, 'Jessore Sadar Upazila', 'যশোর সদর'),
(287, 57, 'Chaugachha Upazila', 'চৌগাছা'),
(288, 57, 'Manirampur Upazila', 'মনিরামপুর '),
(289, 57, 'Jhikargachha Upazila', 'ঝিকরগাছা'),
(290, 57, 'Sharsha Upazila', 'সারশা'),
(291, 58, 'Jhenaidah Sadar Upazila', 'ঝিনাইদহ সদর'),
(292, 58, 'Maheshpur Upazila', 'মহেশপুর'),
(293, 58, 'Kaliganj Upazila', 'কালীগঞ্জ'),
(294, 58, 'Kotchandpur Upazila', 'কোট চাঁদপুর '),
(295, 58, 'Shailkupa Upazila', 'শৈলকুপা'),
(296, 58, 'Harinakunda Upazila', 'হাড়িনাকুন্দা'),
(297, 59, 'Terokhada Upazila', 'তেরোখাদা'),
(298, 59, 'Batiaghata Upazila', 'বাটিয়াঘাটা '),
(299, 59, 'Dacope Upazila', 'ডাকপে'),
(300, 59, 'Dumuria Upazila', 'ডুমুরিয়া'),
(301, 59, 'Dighalia Upazila', 'দিঘলিয়া'),
(302, 59, 'Koyra Upazila', 'কয়ড়া'),
(303, 59, 'Paikgachha Upazila', 'পাইকগাছা'),
(304, 59, 'Phultala Upazila', 'ফুলতলা'),
(305, 59, 'Rupsa Upazila', 'রূপসা'),
(306, 60, 'Kushtia Sadar', 'কুষ্টিয়া সদর'),
(307, 60, 'Kumarkhali', 'কুমারখালি'),
(308, 60, 'Daulatpur', 'দৌলতপুর'),
(309, 60, 'Mirpur', 'মিরপুর'),
(310, 60, 'Bheramara', 'ভেরামারা'),
(311, 60, 'Khoksa', 'খোকসা'),
(312, 61, 'Magura Sadar Upazila', 'মাগুরা সদর'),
(313, 61, 'Mohammadpur Upazila', 'মোহাম্মাদপুর'),
(314, 61, 'Shalikha Upazila', 'শালিখা'),
(315, 61, 'Sreepur Upazila', 'শ্রীপুর'),
(316, 62, 'angni Upazila', 'আংনি'),
(317, 62, 'Mujib Nagar Upazila', 'মুজিব নগর'),
(318, 62, 'Meherpur-S Upazila', 'মেহেরপুর সদর'),
(319, 63, 'Narail-S Upazilla', 'নড়াইল সদর'),
(320, 63, 'Lohagara Upazilla', 'লোহাগাড়া'),
(321, 63, 'Kalia Upazilla', 'কালিয়া'),
(322, 64, 'Satkhira Sadar Upazila', 'সাতক্ষীরা সদর'),
(323, 64, 'Assasuni Upazila', 'আসসাশুনি '),
(324, 64, 'Debhata Upazila', 'দেভাটা'),
(325, 64, 'Tala Upazila', 'তালা'),
(326, 64, 'Kalaroa Upazila', 'কলরোয়া'),
(327, 64, 'Kaliganj Upazila', 'কালীগঞ্জ'),
(328, 64, 'Shyamnagar Upazila', 'শ্যামনগর'),
(329, 18, 'Adamdighi', 'আদমদিঘী'),
(330, 18, 'Bogra Sadar', 'বগুড়া সদর'),
(331, 18, 'Sherpur', 'শেরপুর'),
(332, 18, 'Dhunat', 'ধুনট'),
(333, 18, 'Dhupchanchia', 'দুপচাচিয়া'),
(334, 18, 'Gabtali', 'গাবতলি'),
(335, 18, 'Kahaloo', 'কাহালু'),
(336, 18, 'Nandigram', 'নন্দিগ্রাম'),
(337, 18, 'Sahajanpur', 'শাহজাহানপুর'),
(338, 18, 'Sariakandi', 'সারিয়াকান্দি'),
(339, 18, 'Shibganj', 'শিবগঞ্জ'),
(340, 18, 'Sonatala', 'সোনাতলা'),
(341, 19, 'Joypurhat S', 'জয়পুরহাট সদর'),
(342, 19, 'Akkelpur', 'আক্কেলপুর'),
(343, 19, 'Kalai', 'কালাই'),
(344, 19, 'Khetlal', 'খেতলাল'),
(345, 19, 'Panchbibi', 'পাঁচবিবি'),
(346, 20, 'Naogaon Sadar Upazila', 'নওগাঁ সদর'),
(347, 20, 'Mohadevpur Upazila', 'মহাদেবপুর'),
(348, 20, 'Manda Upazila', 'মান্দা'),
(349, 20, 'Niamatpur Upazila', 'নিয়ামতপুর'),
(350, 20, 'Atrai Upazila', 'আত্রাই'),
(351, 20, 'Raninagar Upazila', 'রাণীনগর'),
(352, 20, 'Patnitala Upazila', 'পত্নীতলা'),
(353, 20, 'Dhamoirhat Upazila', 'ধামইরহাট '),
(354, 20, 'Sapahar Upazila', 'সাপাহার'),
(355, 20, 'Porsha Upazila', 'পোরশা'),
(356, 20, 'Badalgachhi Upazila', 'বদলগাছি'),
(357, 21, 'Natore Sadar Upazila', 'নাটোর সদর'),
(358, 21, 'Baraigram Upazila', 'বড়াইগ্রাম'),
(359, 21, 'Bagatipara Upazila', 'বাগাতিপাড়া'),
(360, 21, 'Lalpur Upazila', 'লালপুর'),
(361, 21, 'Natore Sadar Upazila', 'নাটোর সদর'),
(362, 21, 'Baraigram Upazila', 'বড়াই গ্রাম'),
(363, 22, 'Bholahat Upazila', 'ভোলাহাট'),
(364, 22, 'Gomastapur Upazila', 'গোমস্তাপুর'),
(365, 22, 'Nachole Upazila', 'নাচোল'),
(366, 22, 'Nawabganj Sadar Upazila', 'নবাবগঞ্জ সদর'),
(367, 22, 'Shibganj Upazila', 'শিবগঞ্জ'),
(368, 23, 'Atgharia Upazila', 'আটঘরিয়া'),
(369, 23, 'Bera Upazila', 'বেড়া'),
(370, 23, 'Bhangura Upazila', 'ভাঙ্গুরা'),
(371, 23, 'Chatmohar Upazila', 'চাটমোহর'),
(372, 23, 'Faridpur Upazila', 'ফরিদপুর'),
(373, 23, 'Ishwardi Upazila', 'ঈশ্বরদী'),
(374, 23, 'Pabna Sadar Upazila', 'পাবনা সদর'),
(375, 23, 'Santhia Upazila', 'সাথিয়া'),
(376, 23, 'Sujanagar Upazila', 'সুজানগর'),
(377, 24, 'Bagha', 'বাঘা'),
(378, 24, 'Bagmara', 'বাগমারা'),
(379, 24, 'Charghat', 'চারঘাট'),
(380, 24, 'Durgapur', 'দুর্গাপুর'),
(381, 24, 'Godagari', 'গোদাগারি'),
(382, 24, 'Mohanpur', 'মোহনপুর'),
(383, 24, 'Paba', 'পবা'),
(384, 24, 'Puthia', 'পুঠিয়া'),
(385, 24, 'Tanore', 'তানোর'),
(386, 25, 'Sirajganj Sadar Upazila', 'সিরাজগঞ্জ সদর'),
(387, 25, 'Belkuchi Upazila', 'বেলকুচি'),
(388, 25, 'Chauhali Upazila', 'চৌহালি'),
(389, 25, 'Kamarkhanda Upazila', 'কামারখান্দা'),
(390, 25, 'Kazipur Upazila', 'কাজীপুর'),
(391, 25, 'Raiganj Upazila', 'রায়গঞ্জ'),
(392, 25, 'Shahjadpur Upazila', 'শাহজাদপুর'),
(393, 25, 'Tarash Upazila', 'তারাশ'),
(394, 25, 'Ullahpara Upazila', 'উল্লাপাড়া'),
(395, 26, 'Birampur Upazila', 'বিরামপুর'),
(396, 26, 'Birganj', 'বীরগঞ্জ'),
(397, 26, 'Biral Upazila', 'বিড়াল'),
(398, 26, 'Bochaganj Upazila', 'বোচাগঞ্জ'),
(399, 26, 'Chirirbandar Upazila', 'চিরিরবন্দর'),
(400, 26, 'Phulbari Upazila', 'ফুলবাড়ি'),
(401, 26, 'Ghoraghat Upazila', 'ঘোড়াঘাট'),
(402, 26, 'Hakimpur Upazila', 'হাকিমপুর'),
(403, 26, 'Kaharole Upazila', 'কাহারোল'),
(404, 26, 'Khansama Upazila', 'খানসামা'),
(405, 26, 'Dinajpur Sadar Upazila', 'দিনাজপুর সদর'),
(406, 26, 'Nawabganj', 'নবাবগঞ্জ'),
(407, 26, 'Parbatipur Upazila', 'পার্বতীপুর'),
(408, 27, 'Fulchhari', 'ফুলছড়ি'),
(409, 27, 'Gaibandha sadar', 'গাইবান্ধা সদর'),
(410, 27, 'Gobindaganj', 'গোবিন্দগঞ্জ'),
(411, 27, 'Palashbari', 'পলাশবাড়ী'),
(412, 27, 'Sadullapur', 'সাদুল্যাপুর'),
(413, 27, 'Saghata', 'সাঘাটা'),
(414, 27, 'Sundarganj', 'সুন্দরগঞ্জ'),
(415, 28, 'Kurigram Sadar', 'কুড়িগ্রাম সদর'),
(416, 28, 'Nageshwari', 'নাগেশ্বরী'),
(417, 28, 'Bhurungamari', 'ভুরুঙ্গামারি'),
(418, 28, 'Phulbari', 'ফুলবাড়ি'),
(419, 28, 'Rajarhat', 'রাজারহাট'),
(420, 28, 'Ulipur', 'উলিপুর'),
(421, 28, 'Chilmari', 'চিলমারি'),
(422, 28, 'Rowmari', 'রউমারি'),
(423, 28, 'Char Rajibpur', 'চর রাজিবপুর'),
(424, 29, 'Lalmanirhat Sadar', 'লালমনিরহাট সদর'),
(425, 29, 'Aditmari', 'আদিতমারি'),
(426, 29, 'Kaliganj', 'কালীগঞ্জ'),
(427, 29, 'Hatibandha', 'হাতিবান্ধা'),
(428, 29, 'Patgram', 'পাটগ্রাম'),
(429, 30, 'Nilphamari Sadar', 'নীলফামারী সদর'),
(430, 30, 'Saidpur', 'সৈয়দপুর'),
(431, 30, 'Jaldhaka', 'জলঢাকা'),
(432, 30, 'Kishoreganj', 'কিশোরগঞ্জ'),
(433, 30, 'Domar', 'ডোমার'),
(434, 30, 'Dimla', 'ডিমলা'),
(435, 31, 'Panchagarh Sadar', 'পঞ্চগড় সদর'),
(436, 31, 'Debiganj', 'দেবীগঞ্জ'),
(437, 31, 'Boda', 'বোদা'),
(438, 31, 'Atwari', 'আটোয়ারি'),
(439, 31, 'Tetulia', 'তেতুলিয়া'),
(440, 32, 'Badarganj', 'বদরগঞ্জ'),
(441, 32, 'Mithapukur', 'মিঠাপুকুর'),
(442, 32, 'Gangachara', 'গঙ্গাচরা'),
(443, 32, 'Kaunia', 'কাউনিয়া'),
(444, 32, 'Rangpur Sadar', 'রংপুর সদর'),
(445, 32, 'Pirgachha', 'পীরগাছা'),
(446, 32, 'Pirganj', 'পীরগঞ্জ'),
(447, 32, 'Taraganj', 'তারাগঞ্জ'),
(448, 33, 'Thakurgaon Sadar Upazila', 'ঠাকুরগাঁও সদর'),
(449, 33, 'Pirganj Upazila', 'পীরগঞ্জ'),
(450, 33, 'Baliadangi Upazila', 'বালিয়াডাঙ্গি'),
(451, 33, 'Haripur Upazila', 'হরিপুর'),
(452, 33, 'Ranisankail Upazila', 'রাণীসংকইল'),
(453, 51, 'Ajmiriganj', 'আজমিরিগঞ্জ'),
(454, 51, 'Baniachang', 'বানিয়াচং'),
(455, 51, 'Bahubal', 'বাহুবল'),
(456, 51, 'Chunarughat', 'চুনারুঘাট'),
(457, 51, 'Habiganj Sadar', 'হবিগঞ্জ সদর'),
(458, 51, 'Lakhai', 'লাক্ষাই'),
(459, 51, 'Madhabpur', 'মাধবপুর'),
(460, 51, 'Nabiganj', 'নবীগঞ্জ'),
(461, 51, 'Shaistagonj Upazila', 'শায়েস্তাগঞ্জ'),
(462, 52, 'Moulvibazar Sadar', 'মৌলভীবাজার'),
(463, 52, 'Barlekha', 'বড়লেখা'),
(464, 52, 'Juri', 'জুড়ি'),
(465, 52, 'Kamalganj', 'কামালগঞ্জ'),
(466, 52, 'Kulaura', 'কুলাউরা'),
(467, 52, 'Rajnagar', 'রাজনগর'),
(468, 52, 'Sreemangal', 'শ্রীমঙ্গল'),
(469, 53, 'Bishwamvarpur', 'বিসশম্ভারপুর'),
(470, 53, 'Chhatak', 'ছাতক'),
(471, 53, 'Derai', 'দেড়াই'),
(472, 53, 'Dharampasha', 'ধরমপাশা'),
(473, 53, 'Dowarabazar', 'দোয়ারাবাজার'),
(474, 53, 'Jagannathpur', 'জগন্নাথপুর'),
(475, 53, 'Jamalganj', 'জামালগঞ্জ'),
(476, 53, 'Sulla', 'সুল্লা'),
(477, 53, 'Sunamganj Sadar', 'সুনামগঞ্জ সদর'),
(478, 53, 'Shanthiganj', 'শান্তিগঞ্জ'),
(479, 53, 'Tahirpur', 'তাহিরপুর'),
(480, 54, 'Sylhet Sadar', 'সিলেট সদর'),
(481, 54, 'Beanibazar', 'বেয়ানিবাজার'),
(482, 54, 'Bishwanath', 'বিশ্বনাথ'),
(483, 54, 'Dakshin Surma Upazila', 'দক্ষিণ সুরমা'),
(484, 54, 'Balaganj', 'বালাগঞ্জ'),
(485, 54, 'Companiganj', 'কোম্পানিগঞ্জ'),
(486, 54, 'Fenchuganj', 'ফেঞ্চুগঞ্জ'),
(487, 54, 'Golapganj', 'গোলাপগঞ্জ'),
(488, 54, 'Gowainghat', 'গোয়াইনঘাট'),
(489, 54, 'Jaintiapur', 'জয়ন্তপুর'),
(490, 54, 'Kanaighat', 'কানাইঘাট'),
(491, 54, 'Zakiganj', 'জাকিগঞ্জ'),
(492, 54, 'Nobigonj', 'নবীগঞ্জ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `two_factor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `type`, `two_factor`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'rabiul islam', 'rabiul0420@gmail.com', '0173833333', '$2y$10$axgwcGXMIO5ZA9bxpLEiyOLo0kSyRw3Y8zEq8EutCZz7rXcHg.CBq', 2, 'No', 1, 'pqDgulQrYYoiDBEIJXhxFgqzWHXIronW3cUQvkcyNuREOY4PynfYlvIp3u54', '2019-11-02 03:48:57', '2020-04-17 03:05:10'),
(10, 'Md Shafiul Alam', 'princeofcoding@gmail.com', '8801770000099', '$2y$10$OIlFA/5ePGAwOr30iIoDK.BJJaY5OzgXOop5pWRBKrzGhAV4J9DYS', 2, 'No', 1, 'ppsAAprbM0AOdjkflUwEbGk3DHMQtZfAFMZiIihGSUc7owt1tukQLI9rOc12', '2020-02-13 04:27:31', '2020-06-07 05:15:23'),
(12, 'Rabiul Itclan', 'rabiulitclan@gmail.com', '88668', '$2y$10$0OSPP/TNjOj1C5w8eMEfLeX0r5oBUvDxLZ0H/96h3F.gvc.Oe9XPa', 2, 'Yes', 1, 'nO5xv7xULd8JEmGkRZT7bPzK8uA1v7UTwuInywsX3PVUp7hRvXiZWdoGOBjJ', '2020-02-15 00:01:15', '2020-02-24 05:40:55'),
(13, 'Sheikh Mohammad Ullah', 'mohammad.sb38@gmail.com', '8801711219253', '$2y$10$eOtgdHXVl/VskeJ7ibmh/erwVTwnnEKsUHkNzOB2ZEy/Q3Wo6z4zK', 2, 'No', 1, 'WCLSrkPDVzcsF5UKpIWQxDtZuhRDsoBlj24300VInToaNvniKYIn4nY1gbPV', '2020-02-17 00:51:47', '2020-04-17 08:10:34'),
(14, 'Nasir Mahmud', 'genesis.nashir@gmail.com', '01676122140', '$2y$10$Tr07hYspvbhf5IAcThLdneqYQThF.Tbo2PIEy7wsoCvEfK4riaq1O', 2, 'No', 1, 'hnQRvSWd8ErVhyl8ByeRkZayqOUVZk6l5oagY6DBUgGOZ4AsxBjsH17aABVr', '2020-02-17 03:26:24', '2020-03-07 07:03:10'),
(16, 'Khandoker Matiur', 'genesis.mithu@gmail.com', '8801404432500', '$2y$10$1oW7lIdqg9brzEi67U1noOVWLf5KgdHP.8e4T5hDwSC/KZE2YaFqy', 2, 'No', 1, 'MGKT4hK3VmG4AT0ojtABAMuIgYAXBrRvq71ufBMt0ubBObkwqqQG0joDhAgr', '2020-02-24 05:45:44', '2020-03-20 03:38:37'),
(18, 'Habibur Rahman', 'habibur.genesis@gmail.com', '8801404432516', '$2y$10$IBtiavs7/YYaEpRfjpSw.e8efuIoAdKEV9pIodUa5qJmWgQzfN5rO', 2, 'No', 1, 'RGFgn2GfEBAReWf37DnxKe6jYRVgSMnAdltXv9Qoow2EK8S3ceyvcJ7MXDGJ', '2020-03-20 05:48:26', '2020-03-20 05:48:43'),
(24, 'Liton', 'litionali100@gmail.com', '8801756008231', '$2y$10$bhlbUwhI.xgkdvsXJkUF3eK9Jd/03CrojRMAlyYMnrRAznWfylNb6', 2, 'No', 1, 'UL19iwLweN5hX7uzb7npWkgomSKG5cJHfo3JeW7qTR46CGa5bLH7yiKJjjxt', '2020-03-23 04:16:12', '2020-03-23 04:16:49'),
(25, 'OVI', 'khanmmhovi@gmail.com', '8801305398495', '$2y$10$RH1hxV2w4tbdGATxZkKpeussTEIn9ItXWYIuz0rkN0iUZpEwK/LJa', 2, 'No', 1, 'kho2hxyFlG8qtSDoxnvHM8IuDijvFO0oOD2OqO8rc8ZdzmWWts91rzYpGlv8', '2020-03-23 04:32:33', '2020-03-23 04:32:57'),
(27, 'DR. MOHAMMAD SUJAN SHARIF', 'neurosharif@gmail.com', 'neurosharif@gmail.com', '$2y$10$oBjLoBjLKMhEfOBfPJv2fuHsK6X8oLNoZKAcC13O5eiGK82JpbOD2', 2, 'No', 1, 'LSGXDriEGqA0Pm62xaYI2Qxb646spRquf6kzTyKQLzASRVAE5qJI60PGpE6f', '2020-04-03 02:02:11', '2020-06-05 13:28:16'),
(28, 'Saiful Islam Bhuiyan', 'genesis.dr.saiful@gmail.com', '8801404432525', '$2y$10$rFnoIWh.DhyCl5gkqy3lVOAHcW1hrlBfU9qbnWIHWe06L9PXgrIKa', 2, 'No', 1, 'VDT3JMJBQCvilqRH3lMuyjNtUtdGCiLk3AzbJ37iBBYNe0cL25oNWKcIxtww', '2020-04-11 13:23:22', '2020-04-11 13:24:46'),
(29, 'Fariduzzaman', 'farid.bghri@gmail.com', '8801312002021', '$2y$10$RnGKu.Jpigw0Jdn.fD5B5OcwQG0Ki1lSh2KjyXiu7l3zy.PjWOz4q', 2, 'No', 1, 'Vkr1UqJDvVWMm6Jvw6vDkFPMl8uD9Zwn9W4vYAfwJG2QKoT4QmRYGhH4wByQ', '2020-04-13 23:33:48', '2020-04-13 23:34:27'),
(31, 'Saiful Islam', 'msi132043@gmail.com', '8801713459946', '$2y$10$WFEQi04XiiZV82ehmb2dceTgTV/Npk.0GR7iMFzQfvRHbrOaJEf4W', 2, 'No', 1, 'HuoATPbyF8bsCEI30mZQ1JuOrRgTWsZSVW406qHxI1dRtlG8KayrehVPOtWH', '2020-05-07 03:22:59', '2020-05-08 02:48:41'),
(32, 'Mozahidul Haque', 'genesismozahed@gmail.com', '8801517826607', '$2y$10$MBMSD25TJxF7w61MUTsNdeJwbXRfB/JOFQbexqX5aMb8svSugBk/.', 2, 'No', 1, '9bnGT3SM5Ajm4L4x8EhcFxUWiksmWDQFG18nf3toXWDIr90rU8N9pMSlApyM', '2020-05-13 03:07:50', '2020-05-13 03:09:41'),
(33, 'Abdur Rahman', 'publication.genesis@gmail.com', '8801404432518', '$2y$10$M4KIlGtZ6b1Fq7Say/idvOj8SBB7OjSQxHcA77xXGWl0H3wBIVHka', 2, 'No', 1, 'zMj1LL9A6BYBfLAxCWYGIbQLbplb5CIOpGaUA0RDGjcYJibvQnmbNzUZAznw', '2020-05-16 23:08:47', '2020-05-29 22:00:03'),
(34, 'Kaosar Ali', 'alibd90@gmail.com', '8801718152224', '$2y$10$9MHCSkHhCtlm8an80PtPI.uCaA.9K2zqtOsd0MIumiU/Ixr2EtzSC', 2, 'Yes', 1, NULL, '2020-05-21 00:01:43', '2020-06-07 04:42:42'),
(35, 'Genesis Guest', 'nasifsadik2000@gmail.com', '8801724748864', '$2y$10$0oCkdej/O4VLH1ysCssAW.JDz6n.cVAbEqEnwRPaYOaxm0lxauOxi', 2, 'No', 1, 'nU0XmAgvO8KqWWpa3XCIzA0jvmcfI1TMC6L3yf9qHmQCQZLW1fkR622ppPzW', '2020-06-01 05:03:44', '2020-06-09 00:34:49'),
(36, 'Syfur Rahman', 'genesis.syfur@gmail.com', '8801404432509', '$2y$10$0x2pnc1voLMr.aQ7KxCTnewKnu7fpfDQJpH/3EJNux.8nv0TRIQR.', 2, 'No', 1, NULL, '2020-06-13 03:30:58', '2020-06-13 03:31:37');

-- --------------------------------------------------------

--
-- Table structure for table `week_days`
--

CREATE TABLE `week_days` (
  `id` int(11) NOT NULL,
  `wd_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `week_days`
--

INSERT INTO `week_days` (`id`, `wd_id`, `name`) VALUES
(1, 0, 'Monday'),
(2, 1, 'Tuesday'),
(3, 2, 'Wednesday'),
(4, 3, 'Thursday'),
(5, 4, 'Friday'),
(6, 5, 'Saturday'),
(7, 6, 'Sunday');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules`
--
ALTER TABLE `batches_schedules`
  ADD PRIMARY KEY (`id`,`status`);

--
-- Indexes for table `batches_schedules_lecture_exam`
--
ALTER TABLE `batches_schedules_lecture_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules_lecture_exam_topics`
--
ALTER TABLE `batches_schedules_lecture_exam_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules_slots`
--
ALTER TABLE `batches_schedules_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules_slot_types`
--
ALTER TABLE `batches_schedules_slot_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules_subjects`
--
ALTER TABLE `batches_schedules_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches_schedules_week_days`
--
ALTER TABLE `batches_schedules_week_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_discipline_fees`
--
ALTER TABLE `batch_discipline_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_shifting`
--
ALTER TABLE `batch_shifting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bcps_faculties`
--
ALTER TABLE `bcps_faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coming_by`
--
ALTER TABLE `coming_by`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_session`
--
ALTER TABLE `course_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors_courses`
--
ALTER TABLE `doctors_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_answers`
--
ALTER TABLE `doctor_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_asks`
--
ALTER TABLE `doctor_asks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_ask_reply`
--
ALTER TABLE `doctor_ask_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_complain`
--
ALTER TABLE `doctor_complain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_complains`
--
ALTER TABLE `doctor_complains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_complain_reply`
--
ALTER TABLE `doctor_complain_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_complain_replys`
--
ALTER TABLE `doctor_complain_replys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_course_payment`
--
ALTER TABLE `doctor_course_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Indexes for table `doctor_notice`
--
ALTER TABLE `doctor_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_sheet_batch`
--
ALTER TABLE `lecture_sheet_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_sheet_batch_post`
--
ALTER TABLE `lecture_sheet_batch_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_sheet_post`
--
ALTER TABLE `lecture_sheet_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_sheet_topics`
--
ALTER TABLE `lecture_sheet_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_video`
--
ALTER TABLE `lecture_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_video_batch`
--
ALTER TABLE `lecture_video_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_video_batch_lecture_video`
--
ALTER TABLE `lecture_video_batch_lecture_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_video_discipline`
--
ALTER TABLE `lecture_video_discipline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_video_row`
--
ALTER TABLE `lecture_video_row`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_colleges`
--
ALTER TABLE `medical_colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam`
--
ALTER TABLE `online_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_batch`
--
ALTER TABLE `online_exam_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_batch_online_exam`
--
ALTER TABLE `online_exam_batch_online_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_common_codes`
--
ALTER TABLE `online_exam_common_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_discipline`
--
ALTER TABLE `online_exam_discipline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_links`
--
ALTER TABLE `online_exam_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_lecture_addresses`
--
ALTER TABLE `online_lecture_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_lecture_links`
--
ALTER TABLE `online_lecture_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets_doctor`
--
ALTER TABLE `password_resets_doctor`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_ans`
--
ALTER TABLE `question_ans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_ref_id` (`question_id`) USING BTREE;

--
-- Indexes for table `question_types`
--
ALTER TABLE `question_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms_types`
--
ALTER TABLE `rooms_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_packages`
--
ALTER TABLE `service_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week_days`
--
ALTER TABLE `week_days`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches_schedules`
--
ALTER TABLE `batches_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches_schedules_lecture_exam`
--
ALTER TABLE `batches_schedules_lecture_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `batches_schedules_lecture_exam_topics`
--
ALTER TABLE `batches_schedules_lecture_exam_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches_schedules_slots`
--
ALTER TABLE `batches_schedules_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batches_schedules_slot_types`
--
ALTER TABLE `batches_schedules_slot_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `batches_schedules_subjects`
--
ALTER TABLE `batches_schedules_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches_schedules_week_days`
--
ALTER TABLE `batches_schedules_week_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batch_discipline_fees`
--
ALTER TABLE `batch_discipline_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch_shifting`
--
ALTER TABLE `batch_shifting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bcps_faculties`
--
ALTER TABLE `bcps_faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coming_by`
--
ALTER TABLE `coming_by`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_session`
--
ALTER TABLE `course_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `doctors_courses`
--
ALTER TABLE `doctors_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctor_answers`
--
ALTER TABLE `doctor_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_asks`
--
ALTER TABLE `doctor_asks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_ask_reply`
--
ALTER TABLE `doctor_ask_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_complain`
--
ALTER TABLE `doctor_complain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_complains`
--
ALTER TABLE `doctor_complains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_complain_reply`
--
ALTER TABLE `doctor_complain_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_complain_replys`
--
ALTER TABLE `doctor_complain_replys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_course_payment`
--
ALTER TABLE `doctor_course_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor_notice`
--
ALTER TABLE `doctor_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lecture_sheet_batch`
--
ALTER TABLE `lecture_sheet_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_sheet_batch_post`
--
ALTER TABLE `lecture_sheet_batch_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_sheet_post`
--
ALTER TABLE `lecture_sheet_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_sheet_topics`
--
ALTER TABLE `lecture_sheet_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_video`
--
ALTER TABLE `lecture_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_video_batch`
--
ALTER TABLE `lecture_video_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_video_batch_lecture_video`
--
ALTER TABLE `lecture_video_batch_lecture_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_video_discipline`
--
ALTER TABLE `lecture_video_discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_video_row`
--
ALTER TABLE `lecture_video_row`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_colleges`
--
ALTER TABLE `medical_colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam`
--
ALTER TABLE `online_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_batch`
--
ALTER TABLE `online_exam_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_batch_online_exam`
--
ALTER TABLE `online_exam_batch_online_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_common_codes`
--
ALTER TABLE `online_exam_common_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_discipline`
--
ALTER TABLE `online_exam_discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_links`
--
ALTER TABLE `online_exam_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_lecture_addresses`
--
ALTER TABLE `online_lecture_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_lecture_links`
--
ALTER TABLE `online_lecture_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_ans`
--
ALTER TABLE `question_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rooms_types`
--
ALTER TABLE `rooms_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_packages`
--
ALTER TABLE `service_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `week_days`
--
ALTER TABLE `week_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
