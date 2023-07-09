-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2023 at 04:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_pj`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_tb`
--

CREATE TABLE `bank_tb` (
  `bank_id` int(3) NOT NULL COMMENT 'รหัสรายการบัญชีธนาคาร',
  `sell_id` int(4) NOT NULL COMMENT 'รหัสผู้ขาย',
  `bank_name` varchar(30) NOT NULL COMMENT 'ชื่อธนาคาร',
  `bank_number` varchar(25) NOT NULL COMMENT 'เลขที่บัญชีธนาคาร',
  `bank_account` varchar(50) NOT NULL COMMENT 'ชื่อบัญชีธนาคาร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bank_tb`
--

INSERT INTO `bank_tb` (`bank_id`, `sell_id`, `bank_name`, `bank_number`, `bank_account`) VALUES
(1, 1, 'ธนาคารไทยพาณิชย์', 'dhdth', 'sgdr'),
(2, 2, 'ธนาคารกรุงไทย', '025478455', 'ซานฟา'),
(3, 3, 'ธนาคารกรุงไทย', '5754555959', 'เผด็จศึก แจ้งบุรี'),
(4, 5, 'ธนาคารกรุงไทย', '5754555959', 'sgdr'),
(9, 9, 'ธนาคารกรุงไทย', '2555775666', 'พระอาทิตย์ ซันคร็อพ '),
(10, 11, 'ธนาคารกรุงไทย', '2555775666', 'พระอาทิตย์ ซันคร็อพ '),
(11, 13, 'ธนาคารกรุงไทย', '2555775666', 'พระอาทิตย์ ซันคร็อพ '),
(16, 6, 'ธนาคารไทยพาณิชย์', '12033548612', 'ณัฐพงศ์ ตันเจริญ');

-- --------------------------------------------------------

--
-- Table structure for table `category_tb`
--

CREATE TABLE `category_tb` (
  `category_id` int(3) NOT NULL COMMENT 'รหัสประเภทของสินค้า',
  `category_name` varchar(50) NOT NULL COMMENT 'ชื่อประเภทสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category_tb`
--

INSERT INTO `category_tb` (`category_id`, `category_name`) VALUES
(1, 'ใบตัดหญ้า'),
(2, 'ชุดเสื้อสูบ'),
(3, 'หัวเกียร์'),
(4, 'ใบตัดข้าว'),
(5, 'น็อตสกรู'),
(6, 'เชือกเอ็น'),
(7, 'จานตัดหญ้า'),
(8, 'คาบู'),
(9, 'อะไหล่เครื่องพ่นปุ๋ย'),
(10, 'ยางกันสะเทือน'),
(11, 'ปั๊มน้ำ'),
(12, 'เครื่องตัดหญ้า'),
(13, 'เมล็ดพันธุ์'),
(14, 'ยากำจัดวัชพืช'),
(15, 'ปุ๋ยเคมี');

-- --------------------------------------------------------

--
-- Table structure for table `contract_tb`
--

CREATE TABLE `contract_tb` (
  `contract_code` int(6) NOT NULL COMMENT 'รหัสสัญญาการซื้อขาย',
  `date_contract` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ทำสัญญา',
  `employee_id` int(11) NOT NULL COMMENT 'รหัสพนักงาน (เจ้าของร้าน) ',
  `sales_list_id` int(6) DEFAULT NULL COMMENT 'รหัสรายการขาย',
  `customer_prefix` varchar(6) NOT NULL COMMENT 'คำนำหน้าชื่อ ',
  `customer_firstname` varchar(50) NOT NULL COMMENT 'ชื่อ ',
  `customer_lastname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `customer_img` varchar(25) NOT NULL COMMENT 'เลขบัตรประชาชน',
  `date_send` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ส่งมอบของให้',
  `price_send` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'ราคาที่ตกลงกันไว้ในวันที่ส่งมอบ',
  `product_detail` text NOT NULL COMMENT 'รายละเอียดสินค้า',
  `baht` int(6) NOT NULL COMMENT 'บาท',
  `stang` int(6) NOT NULL COMMENT 'สตางค์',
  `stangt` varchar(255) NOT NULL COMMENT 'สตางค์ไทย',
  `contract_details` text NOT NULL COMMENT 'ข้อตกลงของสัญญา',
  `contract_attachment` varchar(255) DEFAULT NULL COMMENT 'ไฟล์แนบสัญญา',
  `date_due` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ครบกำหนด',
  `outstanding` float NOT NULL COMMENT 'คงค้าง',
  `promise_status` int(5) NOT NULL DEFAULT 0 COMMENT 'สถานะสัญญาซื้อขาย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contract_tb`
--

INSERT INTO `contract_tb` (`contract_code`, `date_contract`, `employee_id`, `sales_list_id`, `customer_prefix`, `customer_firstname`, `customer_lastname`, `customer_img`, `date_send`, `price_send`, `product_detail`, `baht`, `stang`, `stangt`, `contract_details`, `contract_attachment`, `date_due`, `outstanding`, `promise_status`) VALUES
(1, '2022-11-13 16:57:03', 1, 6, 'นางสาว', 'ธัญญารัตน์', 'เคล้าสี', '1319900683582', '2022-11-13 16:57:03', '2022-11-13 16:57:03', 'gx35\r\nคาร์บูเรเตอร์ 070\r\nข้อต่อสตัดเกลียว M10\r\nคาร์บูเรเตอร์ YD 3800\r\nคาร์บูเรเตอร์ 070\r\nจานยึดใบมีดตัดหญ้าสะพายบ่า\r\nจานรองใบมีดเครื่องตัดหญ้า\r\nชุดเสื้อสูบ + ลูกสูบ TL33 ใช้ก\r\nชุดหัวเกียร์ ตัดหญ้า 28 มม. \r\nจานเอ็นตัดหญ้า \r\nชุดเฟืองเกียร์(1ชุดมี3ชิ้น:เพล\r\nซันคร็อพ\r\nคาร์บูเรเตอร์ 070\r\nชุดเสื้อสูบเครื่องตัดหญ้า\r\nซันคร็อพ NB\r\nซันคร็อพโซน\r\n', 13825, 0, 'หนึ่งหมื่นสามพันแปดร้อยยี่สิบห้าบาทถ้วน', '', NULL, '2023-03-13 16:57:03', 0, 1),
(2, '2023-03-11 17:02:01', 1, 7, 'นาย', 'เผด็จศึก', 'แจ้งบุรี', '1149900610471', '2023-03-11 17:02:01', '2023-03-11 17:02:01', 'cg\r\ngx35\r\nข้อต่อสตัดเกลียว M10\r\nคาร์บูเรเตอร์ 070\r\nคาร์บูเรเตอร์ YD 3800\r\nคาร์บูเรเตอร์ 070\r\n', 12850, 0, 'หนึ่งหมื่นสองพันแปดร้อยห้าสิบบาทถ้วน', '', NULL, '2023-07-11 17:02:01', 0, 0),
(3, '2023-03-11 17:04:54', 1, 8, 'นางสาว', 'ธัญญารัตน์', 'เคล้าสี', '1319900683582', '2023-03-11 17:04:54', '2023-06-30 17:04:54', 'cg\r\ngx35\r\nข้อต่อสตัดเกลียว M10\r\nคาร์บูเรเตอร์ 070\r\nคาร์บูเรเตอร์ 070\r\nจานยึดใบมีดตัดหญ้าสะพายบ่า\r\nคาร์บูเรเตอร์ YD 3800\r\nจานรองใบมีดเครื่องตัดหญ้า\r\nชุดเฟืองเกียร์(1ชุดมี3ชิ้น:เพล\r\nชุดหัวเกียร์ ตัดหญ้า 28 มม. \r\nชุดเสื้อสูบ + ลูกสูบ TL33 ใช้ก\r\nซันโปร700\r\nซันคาล่า\r\nซันฟิต\r\n', 18331, 0, 'หนึ่งหมื่นแปดพันสามร้อยสามสิบเอ็ดบาทถ้วน', '', NULL, '2023-07-11 17:04:54', 0, 0),
(4, '2023-03-11 17:04:56', 1, 9, 'นางสาว', 'ธัญญารัตน์', 'เคล้าสี', '1319900683582', '2023-03-11 17:04:56', '2023-06-30 17:04:56', 'cg\r\ngx35\r\nข้อต่อสตัดเกลียว M10\r\nคาร์บูเรเตอร์ 070\r\nคาร์บูเรเตอร์ 070\r\nจานยึดใบมีดตัดหญ้าสะพายบ่า\r\nคาร์บูเรเตอร์ YD 3800\r\nจานรองใบมีดเครื่องตัดหญ้า\r\nชุดเฟืองเกียร์(1ชุดมี3ชิ้น:เพล\r\nชุดหัวเกียร์ ตัดหญ้า 28 มม. \r\nชุดเสื้อสูบ + ลูกสูบ TL33 ใช้ก\r\nซันโปร700\r\nซันคาล่า\r\nซันฟิต\r\n', 18331, 0, 'หนึ่งหมื่นแปดพันสามร้อยสามสิบเอ็ดบาทถ้วน', '', NULL, '2023-07-11 17:04:56', 0, 0),
(5, '2023-03-17 14:10:00', 1, 15, 'นาย', 'เผด็จศึก', 'แจ้งบุรี', '1149900610471', '2023-03-17 14:10:00', '2023-03-17 14:10:00', 'CG\r\nHonda Gx35\r\n', 9800, 0, 'เก้าพันแปดร้อยบาทถ้วน', '', NULL, '2023-07-17 14:10:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `costprice_tb`
--

CREATE TABLE `costprice_tb` (
  `unique_id` int(2) NOT NULL COMMENT 'ค่าอัตลักษณ์',
  `order_id` int(6) NOT NULL COMMENT 'รหัสรายการใบสั่งซื้อ',
  `product_id` int(2) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `cost_price` int(6) NOT NULL COMMENT 'ราคาทุน',
  `costprice_dt` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ซื้อสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `costprice_tb`
--

INSERT INTO `costprice_tb` (`unique_id`, `order_id`, `product_id`, `cost_price`, `costprice_dt`) VALUES
(19, 1, 1, 19, '2023-03-06'),
(20, 1, 2, 17, '2023-03-06'),
(21, 1, 3, 18, '2023-03-06'),
(22, 2, 1, 15, '2023-03-11'),
(23, 2, 2, 16, '2023-03-11'),
(24, 2, 3, 15, '2023-03-11'),
(34, 7, 3, 17, '2023-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `debt_payment_details_tb`
--

CREATE TABLE `debt_payment_details_tb` (
  `unique_id` int(5) NOT NULL COMMENT 'ค่าเอกลักษณ์',
  `contract_code` int(6) NOT NULL COMMENT 'รหัสสัญญาการซื้อขาย',
  `repayment_date` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ชำระ',
  `payment` varchar(20) NOT NULL COMMENT 'วิธีการชำระ',
  `payment_amount` float NOT NULL DEFAULT 0 COMMENT 'ยอดที่ชำระ',
  `deduct_principal` float NOT NULL DEFAULT 0 COMMENT 'หักเงินต้น',
  `less_interest` float NOT NULL DEFAULT 0 COMMENT 'หักดอกเบี้ย',
  `outstanding` float NOT NULL DEFAULT 0 COMMENT 'คงค้าง',
  `slip_img` varchar(255) DEFAULT NULL COMMENT 'ไฟล์หลักฐานการชำระเงิน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `debt_payment_details_tb`
--

INSERT INTO `debt_payment_details_tb` (`unique_id`, `contract_code`, `repayment_date`, `payment`, `payment_amount`, `deduct_principal`, `less_interest`, `outstanding`, `slip_img`) VALUES
(1, 1, '2022-11-13', '', 0, 0, 0, 13825, NULL),
(2, 2, '2023-03-11', '', 0, 0, 0, 12850, NULL),
(3, 3, '2023-03-11', '', 0, 0, 0, 18331, NULL),
(4, 4, '2023-03-11', '', 0, 0, 0, 18331, NULL),
(5, 1, '2023-02-11', 'เงินสด', 10000, 10000, 0, 3825, ''),
(6, 2, '2023-03-11', 'เงินสด', 12850, 12850, 0, 0, ''),
(7, 1, '2023-03-17', 'เงินสด', 3902, 3748, 77, 0, ''),
(8, 4, '2023-03-17', 'เงินสด', 18331, 18331, 0, 0, ''),
(9, 3, '2023-03-17', 'เงินสด', 18331, 18331, 0, 0, ''),
(10, 4, '2023-03-17', '', 0, 0, 0, 9800, NULL),
(11, 4, '2023-03-17', '', 0, 0, 0, 9800, NULL),
(12, 5, '2023-03-17', '', 0, 0, 0, 9800, NULL),
(13, 5, '2023-03-17', 'เงินสด', 9800, 9800, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `employeebank_tb`
--

CREATE TABLE `employeebank_tb` (
  `bank_id` int(3) NOT NULL COMMENT 'รหัสรายการบัญชีธนาคาร',
  `employee_id` int(4) NOT NULL COMMENT 'รหัสพนักงาน',
  `bank_name` varchar(30) NOT NULL COMMENT 'ชื่อธนาคาร',
  `bank_number` varchar(25) NOT NULL COMMENT 'เลขที่บัญชี',
  `bank_account` varchar(50) NOT NULL COMMENT 'ชื่อบัญชี	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeebank_tb`
--

INSERT INTO `employeebank_tb` (`bank_id`, `employee_id`, `bank_name`, `bank_number`, `bank_account`) VALUES
(1, 1, 'ธนาคารไทยพาณิชย์', '12325545445', 'วิทูรย์ ศิริยุทธ์'),
(4, 2, 'ธนาคารไทยพาณิชย์', '2563485692', 'เรณู แจ้งบุรี'),
(5, 3, 'ธนาคารกรุงเทพ', '2255636966', 'เผด็จศึก แจ้งบุรี'),
(6, 34, 'ธนาคารไทยพาณิชย์', '7392698919', 'ธัญญารัตน์ เคล้าสี'),
(7, 36, 'ธนาคารกรุงเทพ', 'กานจนา รักดี', '1155448888'),
(8, 36, 'ธนาคารไทยพาณิชย์', '6639635985', 'กานจนา รักดี'),
(9, 42, 'ธนาคารกรุงไทย', '1111111111', 'สมรรถชัย จันทรัตน์'),
(10, 44, 'ธนาคารกรุงไทย', '2222222222', 'วัฒนา พันธ์ลำเจียก'),
(11, 46, 'ธนาคารกรุงไทย', '33333333333', 'เดชรัชต์ ใจถวิล'),
(12, 48, 'ธนาคารกรุงไทย', '1111111111', 'สมรรถชัย จันทรัตน์'),
(13, 50, 'ธนาคารกรุงไทย', '2222222222', 'วัฒนา พันธ์ลำเจียก'),
(14, 52, 'ธนาคารกรุงไทย', '33333333333', 'เดชรัชต์ ใจถวิล');

-- --------------------------------------------------------

--
-- Table structure for table `employee_tb`
--

CREATE TABLE `employee_tb` (
  `employee_id` int(11) NOT NULL COMMENT 'รหัสพนักงานขาย',
  `employee_model` varchar(20) NOT NULL COMMENT 'รูปแบบพนักงาน',
  `employee_startwork_dt` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เข้าทำงาน',
  `employee_prefix` varchar(6) NOT NULL COMMENT 'คำนำหน้าชื่อ',
  `employee_firstname` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `employee_lastname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `employee_address` varchar(200) NOT NULL COMMENT 'ที่อยู่',
  `employee_birthday` date NOT NULL COMMENT 'วันเกิด',
  `employee_card_id` varchar(25) NOT NULL COMMENT 'บัตรประชาชน',
  `employee_telephone` varchar(20) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `employee_email` varchar(70) NOT NULL COMMENT 'อีเมล',
  `employee_card_id_copy` varchar(255) NOT NULL COMMENT 'สำเนาบัตรประชาชน',
  `employee_address_copy` varchar(255) NOT NULL COMMENT 'สำเนาทะเบียนบ้าน',
  `employee_status` tinyint(2) NOT NULL DEFAULT 1 COMMENT 'สถานะพนักงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee_tb`
--

INSERT INTO `employee_tb` (`employee_id`, `employee_model`, `employee_startwork_dt`, `employee_prefix`, `employee_firstname`, `employee_lastname`, `employee_address`, `employee_birthday`, `employee_card_id`, `employee_telephone`, `employee_email`, `employee_card_id_copy`, `employee_address_copy`, `employee_status`) VALUES
(1, 'พนักงานประจำ', '2006-12-01', 'นาย', 'วิทูรย์', 'ศิริยุทธ์', '111111wdjkeeuuiedguey8d1', '1960-05-14', '1111111111111', '0899871930', 'vitoon.1405@hotmail.com', './file/employee/id/keglqnAmSwBcS9L1v43YqQtfH.jpg', './file/employee/address/XqPRk3mEWKpWKc9q25GfKdBJv.png', 1),
(2, 'พนักงานประจำ', '2008-01-20', 'นาง', 'เรณู', 'แจ้งบุรี', '111111111111111111111', '2022-11-24', '1149900610471', '0839108289', 'niramolsiriyuth@gmail.com', './file/employee/id/kVBWihuh3z659p2wo6uh25vwm.jpg', './file/employee/address/zchRfsJPRGOxDo5aS1YB6xjm7.png', 1),
(3, 'พนักงานประจำ', '2010-01-20', 'นาย', 'เผด็จศึก', 'แจ้งบุรี', '1111111111111111111', '2022-10-19', '1149900610471', '0972701660', 'padetsuek.2543@gmail.com', './file/employee/id/u599mMBWxX0Go28SiVMBiFDp7.jpg', './file/employee/address/CovLmYAcUaNRVYIT5rAJCgJHR.png', 1),
(34, 'พนักงานรายวัน', '2023-02-15', 'นางสาว', 'ธัญญารัตน์', 'เคล้าสี', '227/15', '1999-08-05', '1319900683582', '0615849725', 'stangstang0508@gmail.com', './file/employee/id/0vQTOAqz77CvwZiyeRJWHi1dK.jpg', './file/employee/address/TBPCkiNPUFpR7nL132ADRiy20.png', 1),
(36, 'พนักงานรายวัน', '2023-02-27', 'นาย', 'กานจนา', 'รักดี', '225', '2023-02-16', '1319900683582', '0255215663', 'lllll@gmail.com', './file/employee/id/1Lkzzybl1NgAN29dHCglIvVU0.jpg', './file/employee/address/s2uWRVJudlDEgnKNJwi3DGeQb.png', 1),
(42, 'พนักงานชั่วคราว', '2023-03-14', 'นาย', 'สมรรถชัย', 'จันทรัตน์', '1', '1990-01-13', '1111111111111', '1111111111', 'laber1@gmail.com', './file/employee/id/tJFIjMsmQ5PLljrPNptpgb25i.jpg', './file/employee/address/nmXcpLyW0ja3xwt7yk6M8LRL3.jpg', 0),
(44, 'พนักงานชั่วคราว', '2023-03-14', 'นาง', 'วัฒนา', 'พันธ์ลำเจียก', '2', '2022-07-13', '2222222222222', '2222222222', 'laber2@gmail.com', './file/employee/id/XiqHfcnq0K2JRYq1suRAXIQrd.jpg', './file/employee/address/h0cbgfLkevJKSJydiAfoFtsbB.jpg', 1),
(46, 'พนักงานชั่วคราว', '2023-03-14', 'นาย', 'เดชรัชต์', 'ใจถวิล', '3', '2023-03-01', '3333333333333', '3333333333', 'laber3@gmail.com', './file/employee/id/Jkj9u2FGCYWaGw57diDiOvvra.jpg', './file/employee/address/sxYyfYAFiItFJEzKIsk7moRcD.jpg', 1),
(48, 'พนักงานชั่วคราว', '2023-03-14', 'นาย', 'สมรรถชัย', 'จันทรัตน์', '1', '2023-03-01', '1111111111111', '1111111111', 'employee1@gmail.com', './file/employee/id/7iVCBvMXK06nNQRgP3eXvdTOp.jpg', './file/employee/address/xdNipkh0zqbLE5YDXp2pEuXEC.jpg', 1),
(50, 'พนักงานชั่วคราว', '2023-03-14', 'นาง', 'วัฒนา', 'พันธ์ลำเจียก', '2', '2023-03-01', '2222222222222', '2222222222', 'employee2@gmail.com', './file/employee/id/NFFqns3vyz0jQTkC4geUUvsPi.jpg', './file/employee/address/QjpzG1QN5HfN1kxbTrcUaNBEz.jpg', 1),
(52, 'พนักงานชั่วคราว', '2023-03-14', 'นาย', 'เดชรัชต์', 'ใจถวิล', '3', '2023-03-13', '3333333333333', '3333333333', 'employee3@gmail.com', './file/employee/id/eGh7gS5FLDMsH3SVJUil1ds7r.jpg', './file/employee/address/70FEclDbxlIEF5a4EAoCuX6Q5.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderorder_tb`
--

CREATE TABLE `orderorder_tb` (
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orderorder_tb`
--

INSERT INTO `orderorder_tb` (`name`, `phone`, `address`, `email`) VALUES
('ๅๅๅๅๅ', 'ๅๅๅๅๅๅๅ', '111', '1111111111@gmail.com'),
('111', '111111', '11111111', ''),
('11111', '111111', '1111111', 'vitoon.1405@hotmail.com'),
('11111', '11111', '11111', 'vitoon.1405@hotmail.com'),
('111', '1111', '111111', '111111@gmail.com'),
('mart12345', '111111', '111111111111111111111', 'vitoon.1405@hotmail.com'),
('mart12345', '0972701660', '1000000000000000000', 'padetsuek.2543@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `order_details_tb`
--

CREATE TABLE `order_details_tb` (
  `unique_id` int(6) NOT NULL COMMENT 'ค่าเอกลักษณ์',
  `order_id` int(6) NOT NULL COMMENT 'รหัสรายการใบสั่งซื้อ',
  `order_dt` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ซื้อของในใบสั่งซื้อ',
  `product_id` int(6) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `order_amt` int(6) NOT NULL COMMENT 'จำนวนต่อหน่วยสินค้า',
  `order_pr` float NOT NULL COMMENT 'ราคาต่อหน่วยสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_details_tb`
--

INSERT INTO `order_details_tb` (`unique_id`, `order_id`, `order_dt`, `product_id`, `order_amt`, `order_pr`) VALUES
(1, 1, '2023-03-06 16:50:45', 1, 20, 20),
(2, 1, '2023-03-06 16:50:45', 2, 20, 20),
(3, 1, '2023-03-06 16:50:45', 3, 20, 20),
(4, 2, '2023-03-11 16:58:06', 1, 20, 30),
(5, 2, '2023-03-11 16:58:07', 2, 20, 30),
(6, 2, '2023-03-11 16:58:07', 3, 20, 30),
(7, 3, '2023-03-11 17:27:08', 1, 20, 10000),
(8, 3, '2023-03-11 17:27:08', 2, 20, 2000),
(9, 4, '2023-03-11 21:40:35', 6, 50, 20),
(10, 4, '2023-03-11 21:40:35', 10, 50, 20),
(12, 5, '2023-03-11 22:04:41', 0, 15, 20),
(16, 5, '2023-03-13 00:38:16', 1, 20, 50),
(17, 5, '2023-03-13 00:38:17', 3, 20, 10),
(18, 5, '2023-03-13 01:03:39', 16, 1000, 20),
(21, 6, '2023-03-13 23:49:53', 16, 2990, 6),
(22, 7, '2023-03-14 12:29:21', 3, 17, 30);

-- --------------------------------------------------------

--
-- Table structure for table `order_tb`
--

CREATE TABLE `order_tb` (
  `order_id` int(6) NOT NULL COMMENT 'รหัสรายการใบสั่งซื้อ',
  `sell_id` int(4) NOT NULL COMMENT 'รหัสผู้ขาย',
  `datebill` datetime NOT NULL COMMENT 'วันที่วางบิล',
  `datereceive` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่รับของ',
  `payment_sl` varchar(30) NOT NULL COMMENT 'วิธีการชำระเงิน',
  `payment_dt` date NOT NULL COMMENT 'วันที่ชำระเงิน',
  `all_amount_odr` int(11) NOT NULL COMMENT 'จำนวนสินค้าทั้งหมด',
  `all_price_odr` float NOT NULL COMMENT 'ราคาสินค้าทั้งหมด',
  `note` varchar(255) NOT NULL COMMENT 'หมายเหตุ',
  `bank_slip` varchar(255) DEFAULT NULL COMMENT 'สลิปธนาคาร',
  `receipt` varchar(255) DEFAULT NULL COMMENT 'ใบเสร็จ',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'ใบส่งของ',
  `order_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'สถานะใบสั่งซื้อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_tb`
--

INSERT INTO `order_tb` (`order_id`, `sell_id`, `datebill`, `datereceive`, `payment_sl`, `payment_dt`, `all_amount_odr`, `all_price_odr`, `note`, `bank_slip`, `receipt`, `invoice`, `order_status`) VALUES
(1, 2, '2023-03-06 16:50:44', '2023-03-06', 'เงินสด', '2023-03-06', 60, 1200, '', '', './file/order/receipt/3n4tJbTYitn5DtyxhPLPx2eZz.png', './file/order/invoice/bDYKAQ8C86wdDTbgbOQSPV8EZ.png', 0),
(2, 2, '2023-03-11 16:58:05', '2023-03-11', 'เงินสด', '2023-03-11', 90, 1950, 'ซื้อ 3 รายการ', '', NULL, NULL, 0),
(4, 2, '2023-03-11 21:40:30', '2023-03-14', 'เงินสด', '2023-03-14', 100, 2050, '', '', NULL, NULL, 1),
(5, 2, '2023-03-11 22:04:40', '2023-03-30', 'เงินสด', '2023-03-11', 80, 23450, '', '', NULL, NULL, 1),
(6, 2, '2023-03-13 23:47:43', '2023-03-13', 'เงินสด', '2023-03-13', 6, 17990, '', '', NULL, NULL, 1),
(7, 2, '2023-03-14 12:29:19', '2023-03-14', 'เงินสด', '2023-03-14', 30, 560, '', '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `otherprice_tb`
--

CREATE TABLE `otherprice_tb` (
  `unique_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT 'รหัสรายการใบสั่งซื้อ',
  `listother` varchar(255) NOT NULL COMMENT 'ค่าใช้จ่าย',
  `priceother` int(11) NOT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `otherprice_tb`
--

INSERT INTO `otherprice_tb` (`unique_id`, `order_id`, `listother`, `priceother`) VALUES
(1, 2, 'ค่าส่ง', 150),
(2, 3, '1', 1111111),
(3, 4, 'ค่าสงของ', 50),
(9, 5, 'ค่าส่ง', 250),
(10, 5, 'ค่าเคลม', 2000),
(12, 6, 'ค่าส่ง', 50),
(13, 7, 'ค่าส่ง', 50);

-- --------------------------------------------------------

--
-- Table structure for table `product_exchange_tb`
--

CREATE TABLE `product_exchange_tb` (
  `product_exchange_id` int(5) NOT NULL COMMENT 'รหัสการเปลี่ยนสินค้า',
  `product_id` int(5) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `exchange_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่การเปลี่ยนสินค้า',
  `damage_proof` varchar(255) NOT NULL COMMENT 'หลักฐานความเสียหาย',
  `note` text NOT NULL COMMENT 'หมายเหตุ',
  `exchange_amount` int(5) NOT NULL COMMENT 'จำนวนการเปลี่ยนสินค้า',
  `exchange_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'สถานะการเปลี่ยนสินค้า/เปลี่ยนสินค้าแล้วหรือไม่',
  `exchange_period` date DEFAULT NULL COMMENT 'ระยะรับการเปลี่ยนสินค้า',
  `exchange_name` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `exchange_tel` varchar(20) NOT NULL COMMENT 'เบอร์โทร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_exchange_tb`
--

INSERT INTO `product_exchange_tb` (`product_exchange_id`, `product_id`, `exchange_date`, `damage_proof`, `note`, `exchange_amount`, `exchange_status`, `exchange_period`, `exchange_name`, `exchange_tel`) VALUES
(1, 16, '2023-03-11 21:59:41', '', '', 1, 1, '2023-03-18', 'นานานานา', '089-0563248');

-- --------------------------------------------------------

--
-- Table structure for table `product_tb`
--

CREATE TABLE `product_tb` (
  `product_id` int(10) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `product_name` varchar(30) NOT NULL COMMENT 'ชื่อสินค้า',
  `category_id` int(3) NOT NULL COMMENT 'รหัสประเภทของสินค้า',
  `brand` varchar(100) NOT NULL COMMENT 'ยี่ห้อสินค้า',
  `model` varchar(30) NOT NULL DEFAULT '-' COMMENT 'รุ่นสินค้า',
  `sell_id` int(4) NOT NULL COMMENT 'รหัสผู้ขาย',
  `product_detail` longtext NOT NULL COMMENT 'ข้อความรายละเอียดสินค้า',
  `product_img` varchar(255) NOT NULL COMMENT 'รูปภาพสินค้า',
  `product_detail_img` varchar(255) NOT NULL COMMENT 'รูปรายละเอียดสินค้า',
  `product_dlt_unit` int(6) NOT NULL COMMENT 'จำนวนหักจากคลัง',
  `product_unit` varchar(10) NOT NULL COMMENT 'หน่วยนับ',
  `price` float NOT NULL COMMENT 'ราคาขาย',
  `notification_amt` int(2) NOT NULL COMMENT 'จำนวนแจ้งเตือนขั้นต่ำ',
  `product_rm_unit` int(6) NOT NULL COMMENT 'จำนวนในคลัง',
  `product_exchange_id` int(5) NOT NULL COMMENT 'รหัสการเปลี่ยนสินค้า',
  `sales_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'สถานะการขาย',
  `set_n_amt` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'ตั้งค่าสินค้าคงคลังขั้นต่ำล่วงหน้า',
  `date_n_amt` date DEFAULT NULL COMMENT 'วันที่เริ่มใช้งานล่วงหน้า',
  `notification_amt2` int(6) DEFAULT NULL COMMENT 'จำนวนแจ้งเตือนขั้นต่ำล่วงหน้า',
  `vat` tinyint(1) NOT NULL COMMENT 'ภาษีมูลค่าเพิ่ม',
  `set_exchange` tinyint(1) NOT NULL COMMENT 'สถานะการเปลี่ยนสินค้า/สินค้ารองรับการเปลี่ยน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_tb`
--

INSERT INTO `product_tb` (`product_id`, `product_name`, `category_id`, `brand`, `model`, `sell_id`, `product_detail`, `product_img`, `product_detail_img`, `product_dlt_unit`, `product_unit`, `price`, `notification_amt`, `product_rm_unit`, `product_exchange_id`, `sales_status`, `set_n_amt`, `date_n_amt`, `notification_amt2`, `vat`, `set_exchange`) VALUES
(1, 'ถั่วฝักยาว-สายธารา ', 13, 'SEEDLINE', '-', 3, 'ถั่วฝักยาวคัดพิเศษ สายธารา (SAITHARA)    \r\n     ชนิดของพันธุ์ (ไทย) : ถั่วฝักยาวพันธุ์คัดพิเศษ\r\n     ชนิดของพันธุ์ (อังกฤษ) : YARD LONG BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Vigna unguiculata (L.) Walp.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ติดฝักดกมาก ฝักสีเขียวอ่อน ผิวเรียบ เนื้อแน่น รสชาติดี ความยาวฝัก 55-60 ซม. น้ำหนักดี ไม่เป็นหางหนู การเจริญเติบโตดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี        \r\n     อายุการเก็บเกี่ยว : 50-55 วันหลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 100 กรัม/กระป๋อง, 500 กรัม/กระป๋อง                                                                ', './file/product/image1/jkhsVzOmWlKJE5ZjBtRdt1RBo.jpg', '', 30, 'ซอง', 20, 5, 14, 0, 1, 0, '2023-03-31', 5, 0, 0),
(2, 'ถั่วฝักยาว-เนื้อทองเก้า', 13, 'SEEDLINE', '-', 3, 'ถั่วฝักยาวพันธุ์คัดพิเศษ เนื้อทองเก้า  (NUAETHONG 9)\r\n     ชนิดของพันธุ์ (ไทย) : ถั่วฝักยาวพันธุ์คัดพิเศษ\r\n     ชนิดของพันธุ์ (อังกฤษ) : YARD LONG BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Vigna unguiculata (L.) Walp.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ติดฝักดกมาก ฝักสีเขียว เนื้อแน่นรสชาติดี ความยาวฝัก 55-60 ซม. ฝักยาว ไม่เป็นหางหนู ไม่ฝ่อง่าย การเจริญเติบโตดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี         \r\n     อายุการเก็บเกี่ยว : 50-55 วันหลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 10 กรัม/ซอง', './file/product/image1/oClKnKQIcPuFE6F9pJejbIyyY.jpg', '', 30, 'ซอง', 20, 5, 20, 0, 1, 0, '0000-00-00', 0, 0, 1),
(3, 'ถั่วฝักยาว-สายฝน', 13, 'SEEDLINE', '-', 3, '                                    ถั่วฝักยาวไร้ค้างคัดพิเศษ สายฝน  (SAIFON)\r\n     ชนิดของพันธุ์ (ไทย) : ถั่วฝักยาวไร้ค้างพันธุ์คัดพิเศษ\r\n     ชนิดของพันธุ์ (อังกฤษ) : YARD LONG BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Vigna unguiculata (L.) Walp.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ติดฝักดก ฝักเรียว ยาวสีเขียวสด เนื้อแน่น รสชาติดี ความยาวฝัก 30-40 ซม. น้ำหนักดี การเจริญเติบโตดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี        \r\n     อายุการเก็บเกี่ยว : 45-50 วันหลังหยอดเมล็ด        \r\n     ขนาดบรรจุ : 100 กรัม/กระป๋อง, 500 กรัม/กระป๋อง                                                                        ', './file/product/image1/COF1dKbpgQNCW8UDAOnPgY882.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(4, 'ถั่วฝักยาว-สายสวรรค์', 13, 'SEEDLINE', '-', 3, 'ถั่วฝักยาวพันธุ์คัดพิเศษ สายสวรรค์  (SAISAWAN)    \r\n     ชนิดของพันธุ์ (ไทย) : ถั่วฝักยาวพันธุ์คัดพิเศษ\r\n     ชนิดของพันธุ์ (อังกฤษ) :YARD LONG BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Vigna unguicalata (L.) Walp.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ติดฝักดกมาก ฝักสีเขียว เนื้อแน่น รสชาติดี ความยาวฝักประมาณ 65-70 ซม. ฝักยาว ไม่เป็นหางหนู ไม่ฝ่อง่าย การเจริญเติบโตดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี    \r\n     อายุการเก็บเกี่ยว : 50-55 วันหลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 10 กรัม/ซอง', './file/product/image1/2bH1G6zbNMimtwXZV1CJtBzyv.jpg', '', 30, 'ซอง', 20, 5, 20, 0, 1, 0, '0000-00-00', 0, 0, 0),
(5, 'ถั่วฝักยาว-เส้นสุวรรณ', 13, 'SEEDLINE', '-', 3, 'ถั่วฝักยาวพันธุ์คัดพิเศษ เส้นสุวรรณ (SENSUWAN)    \r\n     ชนิดของพันธุ์ (ไทย) : ถั่วฝักยาวพันธุ์คัดพิเศษ\r\n     ชนิดของพันธุ์ (อังกฤษ) : YARD LONG BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Vigna ungiculata (L.) Walp.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ติดฝักดกมาก ฝักสีเขียวสด ผิวเรียบ ความยาวฝัก 55-60 ซม. น้ำหนักดี ไม่เป็นหางหนู การเจริญเติบโตดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี    \r\n     อายุการเก็บเกี่ยว : 50-55 วันหลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 10 กรัม/ซอง', './file/product/image1/tyYs0krMAgyED2LEEWAoYIice.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(6, 'ถั่วพู-SL', 13, 'SEEDLINE', '-', 2, 'ถั่วพูคัดพิเศษ SL (TOUPU SL)\r\n     ชนิดพันธุ์ (ไทย) : ถั่วพูคัดพิเศษ\r\n     ชนิดพันธุ์ (อังกฤษ)    : WINGED BEAN SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Psophocarpus tetragonolobus L.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง เจริญเติบโตดี ติดฝักดก ฝักสีเขียวสด น้ำหนักดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี\r\n     อายุการเก็บเกี่ยว : 50-60 วัน หลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 10 กรัม/ซอง', './file/product/image1/nmsiDVMU02JGQ4nbI8ZcO74bi.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(7, 'น้ำเต้า-SL', 13, 'SEEDLINE', '-', 3, 'น้ำเต้าคัดพิเศษ SL (NAMTAO)\r\n     ชนิดพันธุ์ (ไทย) : น้ำเต้าคัดพิเศษ\r\n     ชนิดพันธุ์ (อังกฤษ)    : BOTTLE GOURD SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Lagenaria siceraria Standl.\r\n     ลักษณะพันธุ์ : มีการเจริญเติบโตดี แข็งแรง ทนทานต่อโรคได้ ผลรูปทรงกลม สีเขียวอ่อน เนื้อหนาและแน่น รสชาติหวาน ให้ผลผลิตสูง\r\n     ขนาดบรรจุ : 5 กรัม/ซอง', './file/product/image1/QDo4ApSFYmScwJSF1k1HfjkXO.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(8, 'บวบงู-นาคี', 13, 'SEEDLINE', '-', 3, 'บวบงูคัดพิเศษ นาคี (NAKEE)\r\n     ชนิดพันธุ์ (ไทย) : บวบงูคัดพิเศษ\r\n     ชนิดพันธุ์ (อังกฤษ)    : SNAKE GOURD SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Trichosanthes anguina L.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง เจริญเติบโตและแตกแขนงดี ติดผลดก ผลตรงยาว สีเขียวสวย มีลายทางสีขาวสลับ น้ำหนักดี ผลผลิตสูง ทนทานโรคได้ดี ปลูกได้ตลอดปี\r\n     อายุการเก็บเกี่ยว : 45-50 วัน หลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 20 เมล็ด/ซอง', './file/product/image1/mBue932mQ5jhYRqNtuDcvg73X.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(9, 'บวบหอม-เทพธิดา', 13, 'SEEDLINE', '-', 3, 'บวบหอมคัดพิเศษ เทพธิดา (THEPTHIDA)    \r\n     ชนิดพันธุ์ (ไทย) : บวบหอมคัดพิเศษ\r\n     ชนิดพันธุ์ (อังกฤษ)     : SMOOTH LUFFA SPECIAL SELECTION\r\n     ชื่อวิทยาศาสตร์ : Luffa cylindrica (L.) M.Roem.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง เจริญเติบโตได้ดี และแตกแขนงดี ติดผลดก ผลตรงสม่ำเสมอ ผลสีเขียวสวย ทรงกระบอก รสชาติดี มีกลิ่นหอม สามารถเก็บเกี่ยวผลผลิตได้นาน น้ำหนักดี ผลผลิตสูง ทนทานต่อโรคได้ดี ปลูกได้ตลอดปี     \r\n     อายุการเก็บเกี่ยว : 35-40 วัน หลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 20 เมล็ด/ซอง', './file/product/image1/bX7sBNml2EFVW7cBpBPv8BGOH.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(10, 'แตงโมลูกผสม-แบล็คเรด', 13, 'SEEDLINE', '-', 3, 'แตงโมลูกผสม แบล็คเรด (BLACK RED)\r\n     ชนิดของพันธุ์ (ไทย) : แตงโมลูกผสม\r\n     ชนิดของพันธุ์ (อังกฤษ) : F1 HYBRID WATERMELON\r\n     ชื่อวิทยาศาสตร์ : Citrullus lanatus (Thunb) Mansf. / Citrullus vulgaris Schrad E\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง ทรงผลกลมรี ลูกใหญ่พิเศษ เนื้อสีแดงเข้ม เนื้อแน่น ไส้ไม่ล้มง่าย รสชาติหวานกรอบ ความหวานมากกว่า 12 บริกซ์ ผิวสีดำสลับลายทาง สีเข้ม เปลือกบางแต่แข็งแรง สามารถเก็บผลผลิตได้นาน ทนทานต่อการขนส่ง น้ำหนักผล 6-8 กก. \r\n     อายุการเก็บเกี่ยว : 65-75 วัน หลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 40 เมล็ด/ซอ                                ', './file/product/image1/pGEDIcXeqH9Lt56Awl5gRVILY.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(11, 'กะหล่ำปลี-ไทร์อัมพ์', 13, 'SEEDLINE', '-', 3, 'กะหล่ำปลีลูกผสม ไทรอัมพ์  (TRIUMPH T-050)\r\n     ชนิดของพันธุ์ (ไทย) : กะหล่ำปลีลูกผสม\r\n     ชนิดของพันธุ์ (อังกฤษ) : F1 HYBRID CABBAGE\r\n     ชื่อวิทยาศาสตร์ : Bassica oleracea L. var. capitata L.\r\n     ลักษณะพันธุ์ : ลำต้นแข็งแรง เจริญเติบโตดี ห่อหัวแน่น ทรงหัวกลมแบน ใบและหัวสีเขียวเข้ม ทรงพุ่มปานกลาง ทนทานต่อโรคและสภาพอากาศร้อน น้ำหนักต่อหัวประมาณ 900 - 1,000 กรัม สามารถขนส่งทางไกลได้ รสชาติดี ผลผลิตต่อไร่สูง\r\n     อายุการเก็บเกี่ยว : 50-55 วัน หลังย้ายกล้า\r\n     ขนาดบรรจุ : 250 เมล็ด/ซอง                                                                                                                                                                                                                                                                                                                                                                        ', './file/product/image1/BSUvPBDJvFPqTfmXKTaF1sDOJ.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(12, 'ฟักทอง-ซูเปอร์บิ๊ก ', 13, 'SEEDLINE', '-', 3, 'ฟักทองลูกผสม ซูเปอร์บิ๊ก (SUPER BIG)    \r\n     ชนิดพันธุ์ (ไทย) : ฟักทองลูกผสม\r\n     ชนิดพันธุ์ (อังกฤษ) : F1 HYBRID PUMPKIN\r\n     ชื่อวิทยาศาสตร์ : Cucurbita moschata Duchesne ex Poir.\r\n     ลักษณะพันธุ์ : ลำต้นใหญ่ แข็งแรง เจริญเติบโตดี ติดผลดก ทรงผลสวย ผิวคางคก ผลแป้นใหญ่ พูใหญ่สม่ำเสมอ เนื้อผล สีเหลืองเข้ม หนาแน่นมัน รสชาติดี หวานมัน ขนาดผลสม่ำเสมอ น้ำหนักผล 7-9 กก./ผล ทนทานโรคได้ดี ปลูกได้ตลอดปี\r\n     อายุการเก็บเกี่ยว : 80-85 วัน หลังหยอดเมล็ด\r\n     ขนาดบรรจุ : 20 เมล็ด/ซอง                                                                        ', './file/product/image1/lkJSqbefcyK61cyNSOiJTAIC3.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(13, 'ฟักทอง-ทิพย์ทอง', 13, 'SEEDLINE', '-', 2, 'ฟักทองลูกผสม ทิพย์ทอง (THIPTHONG)    \r\n     ชนิดพันธุ์ (ไทย) : ฟักทองลูกผสม\r\n     ชนิดพันธุ์ (อังกฤษ) : F1 HYBRID PUMPKIN\r\n     ชื่อวิทยาศาสตร์ : Cucurbita moschata Duchesne ex Poir.\r\n     ลักษณะพันธุ์ : ลำต้นใหญ่ แข็งแรง เจริญเติบโตดี ติดผลดก ทรงผลสวย ผิ', './file/product/image1/q5UKJOT0P3a5DFzbdfvGu7b4Z.jpg', '', 30, 'ซอง', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(14, 'มากีต้า ', 12, 'EUR', 'RBC-411U', 6, '                                                                                                            Makita RBC411U เครื่องตัดหญ้าสะพายข้างเบนซิน 2 จังหวะ 1.9 แรงม้า (ผสมออโต้ลุป 1 : 25)                                                                                                            ', './file/product/image1/8byOUuj6bhY69baeoT9ANhzgo.webp', '', 30, 'เครื่อง', 9990, 5, 30, 0, 0, 0, '0000-00-00', 0, 0, 1),
(15, 'โรบิน', 12, 'EUR', 'NB-411', 6, '                                                                                                                                                                                    เครื่องตัดหญ้า โรบิ้น Robin รุ่น NB421 (ก้านนอก) พร้อมชุดตัด ของแท้ 100%\r\n\r\n? เครื่องยนต์ 2 จังหวะ\r\n? ประสิทธิภ                                    ', './file/product/image1/HPwujNmDHYgYZ0yfJxPJYSADQ.png', '', 30, 'เครื่อง', 12000, 5, 30, 0, 0, 0, '0000-00-00', 0, 0, 1),
(16, 'Honda Gx35', 12, 'EUR', '4 จังหวะ', 6, '                                                                                                                                                                                                                                                                                                                                                                        ', './file/product/image1/shBJ5fcVtfpWn3ozQlbaL04os.png', '', 30, 'เครื่อง', 6800, 5, 21, 0, 1, 0, '0000-00-00', 0, 0, 1),
(17, 'CG', 12, 'EUR', '-', 6, '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ', './file/product/image1/9j7JQqwocWizlnH5W1W2W2cTP.png', '', 31, 'เครื่อง', 3000, 5, 28, 0, 1, 1, '2023-03-31', 5, 0, 1),
(18, 'เครื่องพ่นยาสะพายหลัง', 9, 'EUR', 'EUR-767', 6, '                                    เครื่องพ่นยาสะพายหลัง(ยี่ห้อEURO) 25ลิตร รุ่นEUR-767\r\nระบบ [Easy Start] สตาร์ทง่ายมาก\r\n   จุดเด่น - ข้อดี \r\n        : มีขนาดกระทัดรัด \r\n        : พ่นได้เร็ว พ่นได้แรง \r\n        : พ่นน้ำยากระจายได้สมำเสมอทั่วถึง \r\n      ', './file/product/image1/Z8flQbqlIPHoCYh3AymArZ6Zy.png', '', 30, 'เครื่อง', 2700, 5, 4, 0, 0, 0, '0000-00-00', 0, 0, 1),
(19, 'เครื่องพ่นยาแบตเตอรี่', 9, 'EUR', '-', 6, '                                                                                                                                                                                                                                                                                                ', './file/product/image1/Y3G6ZLObfyRk0nvzRS3AA2VGJ.png', '', 30, 'เครื่อง', 590, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(20, 'คาร์บูเรเตอร์ 070', 8, 'EUR', 'สติลแท้', 6, 'คาร์บูเรเตอร์ 070 สติลแท้                                                                                                                                                                                                                        ', './file/product/image1/23GO72XUx9ZgpWv0VVXHa1STl.webp', '', 30, 'ชิ้น', 1700, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(21, 'คาร์บูเรเตอร์ 070', 8, 'EUR', 'นิวเวท', 6, '                                                                                          ', './file/product/image1/5uco8Zjc5YWDcPx3OjDDRIgek.webp', '', 30, 'ชิ้น', 800, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(22, 'คาร์บูเรเตอร์ 070', 8, 'EUR', 'สติล B', 6, '                                                                                                                                                ', './file/product/image1/wuox1GanWnH3kP10q6dPyvRx2.webp', '', 30, 'ชิ้น', 800, 5, 22, 0, 1, 0, '0000-00-00', 0, 0, 1),
(23, 'คาร์บูเรเตอร์ YD 3800', 8, 'EUR', 'ฮัวอี้', 6, '                                                                                                                                                                                                                                                                                                ', './file/product/image1/cJa3kVLWzLpxtpFVv80BJu12w.png', '', 30, 'ชิ้น', 450, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(24, 'คาร์บูเรเตอร์ YD 3800', 8, 'EUR', 'บิ๊กติน', 6, '                                                                                                                                                ', './file/product/image1/XY9V57TzmW9tapAIQo8VjFt3N.png', '', 30, 'ชิ้น', 450, 5, 27, 0, 1, 0, '0000-00-00', 0, 0, 1),
(25, 'คาร์บูเรเตอร์ YD 3800', 8, 'EUR', 'ธรรมดา', 6, 'คาร์บูเรเตอร์ YD 3800 รุ่น ธรรมดา                                                                                                                                                              ', './file/product/image1/BFBkL8a42xiABh8pOCK9BtkKo.png', '', 30, 'ชิ้น', 350, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(26, 'ใบมีดตัดหญ้าวงเดือน 24T(9นิ', 1, 'ยูโร', '-', 6, '                                                                         ขนาด230 1.4x2.0x25.4 mm. 24T(9นิ้ว)                                                                                                            ', './file/product/image1/yR3FWZdNO31jUtxKIy3bY7FC6.jpg', '', 30, 'ชิ้น', 150, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(27, 'ใบมีดตัดหญ้าวงเดือน 30T(9นิ้ว)', 1, 'ยูโร', '-', 6, ' ขนาด230 1.4x2.0x25.4 mm. 30T(9นิ้ว)                                                                        ', './file/product/image1/NQNg6cBj9W9kQevZlGaATycWe.jpg', '', 30, 'ชิ้น', 160, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(28, 'ใบมีดตัดหญ้า 24T(10นิ้ว) ', 1, 'ยูโร', '-', 6, 'ขนาด255 1.8x25.4 mm. 24T(10นิ้ว) ', './file/product/image1/lRhICa2wOWtiBk913jdnbWPFL.png', '', 30, 'ชิ้น', 120, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(29, 'ใบรถเกี่ยวข้าว เจาะ4รู', 1, 'EUR', '-', 6, '                                    ใบรถเกี่ยวข้าว เจาะ4รู                                    ', './file/product/image1/FkfQpuYYPFSSbZdHq96OgrKPL.jfif', '', 30, 'ชิ้น', 45, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(30, 'ใบรถเกี่ยวข้าว เจาะ2รู', 1, 'EUR', '-', 6, '                                    ใบรถเกี่ยวข้าว เจาะ2รู                                    ', './file/product/image1/wj1xjhzJvf3nlpgNGIkRpUDme.jfif', '', 30, 'ชิ้น', 45, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(31, 'เชือกเอ็นสีใส', 6, 'EUR', '-', 6, '', './file/product/image1/mZ5QhY4fJ2eFQT5aYZsHzYxYj.jfif', '', 30, 'ชิ้น', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(32, 'เชือกเอ็นสีเขียวสะท้อนแสง', 6, 'EUR', '-', 6, '', './file/product/image1/82MO5STMIGRvTleKFD3cD4a08.jpg', '', 30, 'ชิ้น', 20, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(33, 'ชุดเสื้อสูบเครื่องตัดหญ้า', 2, 'EUR', '411', 6, 'ชุดเสื้อสูบ 411 ใช้กับเครื่องตัดหญ้า Makita411 และ Robin411\r\n\r\nประกอบด้วย\r\n1. เสื้อสูบ เครื่องตัดหญ้า รุ่น 411\r\n2. ลูกสูบ  เส้นผ่าศุนย์กลาง 40 มิลลิเมตร\r\n3. แหวนลูกสูบ ⊘41.5มม. สูง1.3มม.\r\n4. สลักลูกสูบ 33mm*10mm*10mm รูใน6.2มม. หนา1.7มม.\r\n5. กิ้บล็อคสลัก ', './file/product/image1/XNWOPqx6sWOLq44ZXB1jQBupQ.jfif', '', 30, 'กล่อง', 165, 5, 29, 0, 1, 0, '0000-00-00', 0, 0, 0),
(34, 'ชุดเสื้อสูบ + ลูกสูบ TL33 ใช้ก', 2, 'Mitsubishi', 'TL33', 6, 'ชุดเสื้อสูบ + ลูกสูบ TL33 ใช้กับเครื่องตัดหญ้า Mitsubishi รุ่น TL33\r\nประกอบด้วย\r\n1. เสื้อสูบ เครื่องตัดหญ้าแบบสะพายบ่า รุ่น TL33\r\n2. ลูกสูบ  เส้นผ่าศุนย์กลาง 36 มิลลิเมตร\r\n3. แหวนลูกสูบ\r\n4. สลักลูกสูบ (แท่งเหล็ก สั้นๆ)\r\n5. ปิ๊นล๊อคสลัก หรือบางคนก็เรียก กิ', './file/product/image1/wdp0D7w0wVpI3BSen5lVpqtWU.jpg', '', 30, 'กล่อง', 380, 5, 27, 0, 1, 0, '0000-00-00', 0, 0, 0),
(35, 'ใบตัดข้าวดีด 18 นิ้ว', 4, 'EUR', 'SK-5', 8, 'ใบตัดข้าว แบบคม ขนาด 18 นิ้ว SK-5 100% เกรดพรีเมี่ยม                                    ', './file/product/image1/b1bx2UNS70S2sm1Ic5aiK4NJA.png', '', 30, 'ชิ้น', 200, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(36, 'ใบตัดข้าวดีด 20 นิ้ว', 4, 'EUR', 'SK-5', 6, '                                    ใบตัดข้าว แบบคม ขนาด 18 นิ้ว SK-5 100% เกรดพรีเมี่ยม                                          ', './file/product/image1/mduKzPsjqd9E7GazMK5zflZcI.png', '', 30, 'ชิ้น', 200, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(38, 'สกรูน็อตแหวน 1/2x2', 5, 'U-HENG  ', '-', 6, '                                    สกรูน็อตแหวน 1/2x2                                    ', './file/product/image1/Q8O71ClzE9QSmYmLXiLUPyWDh.png', '', 30, 'ซอง', 25, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(39, 'สกรูเกลียวปล่อยหัว F-HM412 ขนา', 5, 'HUMMER', 'F-HM412', 6, 'สกรูเกลียวปล่อยหัว F-HM412 ขนาด 4x1/2 นิ้ว (25ตัว/แพ็ค)', './file/product/image1/S7i6F771bk5VcVp0kbNMTeHhK.jpg', '', 30, 'ซอง', 10, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(40, 'สกรูเกลียวปล่อยหัว 10x1-1/2นิ้', 0, 'HUMMER', 'F-HM10112 ', 6, 'สกรูเกลียวปล่อยหัว F-HM10112 ขนาด 10x1-1/2นิ้ว (500ตัว/กล่อง)', './file/product/image1/urBh7ZGmm1hXtPQf4m2e6wxn9.jpg', '', 30, 'กล่อง', 230, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(41, 'สกรูพร้อมน็อต 5/8x2', 5, 'U-HENG', '-', 6, 'สกรูพร้อมน็อต 5/8x2 (2ชิ้น/แพ็ค)', './file/product/image1/I5hj3uEuF4LgE62xfy8paR6Ei.jpg', '', 30, 'ซอง', 41, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(42, 'สกรูเกลียวปล่อยหัว 10x3 นิ้ว ', 5, 'HUMMER', 'F-HM1030 ', 6, ' สกรูเกลียวปล่อยหัว F-HM1030 ขนาด 10x3 นิ้ว (25ตัว/แพ็ค)', './file/product/image1/JqyMDMUZ52ud7BrCRzm0juWme.jpg', '', 30, 'ถุง', 58, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(43, 'สกรูงานไม้ เบอร์ 7x1 นิ้ว ', 5, 'Wood Screws', '-', 6, 'สกรูงานไม้ เบอร์ 7x1 นิ้ว ชุบซิ้งค์ Wood Screws', './file/product/image1/Z2udxXiGGIOjbb8w016kU9mHZ.jpg', '', 30, 'กล่อง', 181, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(44, 'ข้อต่อสตัดเกลียว M10', 5, 'FIX-XY', 'EA-010', 6, 'ข้อต่อสตัดเกลียว M10 รุ่น EA-010 (5ชิ้น/แพ็ค)                                                                                                             ', './file/product/image1/hMiPq8QIU6OkFo4cX7Y20CvOX.jpg', '', 30, 'ซอง', 110, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(45, 'สกรูยึดแทนรีเวท-สว่าน 8x20มม.', 5, 'SEALTEX ', '-', 6, '                                    สกรูยึดแทนรีเวท-สว่าน 8x20มม. (500/ก.)                                    ', './file/product/image1/w6PbPzcvnz2HGEVXhSjPU8onO.jpg', '', 30, 'กล่อง', 207, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(46, 'สกรูยึดแทนรีเวท  ปลายสว่าน 8 ย', 5, '  FIX-XY  ', '-', 8, '                                    สกรูยึดแทนรีเวท  ปลายสว่าน ขนาด 8 ยาว20 มม.(25pcs/bag)                                    ', './file/product/image1/nHUK0Y6Y41yzTAHY0sfcfUaHi.jpg', '', 30, 'ซอง', 28, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(47, 'น็อตหัวกลม 3/8x8', 5, 'U-HENG  ', '-', 6, 'น็อตหัวกลม 3/8x8', './file/product/image1/h7UKvoQYIXDycb0KryP4t2QSq.jpg', '', 30, 'ถุง', 90, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(48, 'น็อตหัวกลม 3/8x6-1/2', 5, 'U-HENG', '-', 6, 'น็อตหัวกลม 3/8x6-1/2', './file/product/image1/1mkIqofGqp81e6M6WNKDjyPvv.jpg', '', 30, 'ถุง', 90, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(49, 'น็อตชุบ', 5, 'U-HENG', '-', 6, 'น็อตตัวเมีย หกเหลี่ยม ชุบขาว 1/4                                                                                                            ', './file/product/image1/gEMcQyc3zea61Ma79TwvW506y.jpg', '', 3, 'ถุง', 100, 5, 3, 0, 0, 0, '0000-00-00', 0, 0, 0),
(50, 'ชุดหัวเกียร์ ตัดหญ้า 28 มม. ', 3, '-', '9 ฟัน', 6, '                                    ชุดหัวเกียร์ ตัดหญ้า 28 มม. 9 ฟัน                                    ', './file/product/image1/BmZyD9KYBqCdDHWsmZG3krjIh.webp', '', 30, 'ชิ้น', 299, 5, 27, 0, 1, 0, '0000-00-00', 0, 0, 1),
(51, 'ปะกับหัวเกียร์ เครื่องตัดหญ้า ', 3, '-', 'GX35', 6, 'ปะกับหัวเกียร์/ปะกับใบมีด เครื่องตัดหญ้า (อย่างดี)\r\nอะไหล่เครื่องตัดปัญญา. ปะกับหัวเกียร์ เครื่องตัดหญ้า 411, GX35.6ฟัน/10ฟัน/13ฟัน. ปะกับรองใบมีด ปะกับใบมีด. รูปถ่ายจากสินค้าจริง. อะไหล่ตรงรุ่น. สินค้ารับประกันคุณภาพ', './file/product/image1/Wn9CmVt4KZyL50dt7Ao7L21R2.webp', '', 30, 'ชิ้น', 45, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(52, 'จานรองใบมีดเครื่องตัดหญ้า', 3, '-', '-', 2, '                                                                                                            จานรองใบมีดเครื่องตัดหญ้า. หัวเกียร์เครื่องตัดหญ้า. จานรองเครื่องตัดหญ้า. จานรองใบมีดตัดหญ้า. ชุดจานตัดหญ้า. จานรองใบ กลาง จานรองใบมีด หัวเกียร์ เครื่องตัดหญ้า แบบกลาง อย่างดี                                                                                                            ', './file/product/image1/dUjEMKAPxDRxOqDSVzozwuxh2.webp', '', 30, 'กล่อง', 40, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(53, 'ชุดเฟืองเกียร์(1ชุดมี3ชิ้น:เพล', 3, '-', '-', 8, '                                    อะไหล่เครื่องตัดหญ้าหัวเกียร์ ชุดเฟืองเกียร์(1ชุดมี3ชิ้น:เพลา+เฝืองใหญ่+เฝืองเล็ก ) ประกับรองใบมีด6ฟัน ซื้อ 1 แถม 1 : ซื้อ ชุดเฟืองเกียร์ 1ชุด แถม เปลือกหัวเกียร์ 1ชุด ซื้อเยอะแถมเยอะ --- * --- ชุดประกับรองใบมีด        ', './file/product/image1/XG4URQGsF9as5wpDYkUtiSDnV.webp', '', 30, 'กล่อง', 97, 5, 27, 0, 1, 0, '0000-00-00', 0, 0, 0),
(54, 'จานยึดใบมีดตัดหญ้าสะพายบ่า', 7, 'EUR', '-', 2, '                                    จานยึดใบมีดตัดหญ้าสะพายบ่า ขนาด 8 3/4 นิ้ว พร้อมใบมีด (ขนาด1.5*3.5) 3 ใบ+น็อตยึด                                    ', './file/product/image1/98v5YqgyobIDUYLppSANx5g5S.webp', './file/product/image2/9wSBFWriQk2MKnWmj66cbzjQ8.webp', 30, 'ชิ้น', 180, 5, 26, 0, 1, 0, '0000-00-00', 0, 0, 1),
(55, 'จานเอ็นตัดหญ้า ', 7, 'คาราเต้', 'M.116-26', 2, '                                                                        จานเอ็นตัดหญ้า คาราเต้ รุ่น M.116-26 สีแดง\r\nจานเอ็นตัดหญ้า ผลิตจากเหล็กคุณภาพสูง มีความเหนียวและทนพิเศษ ให้คุณจัดการสวนและงานเกษตรต่าง ๆ ได้สะดวกและรวดเร็วยิ่งขึ้น เหมาะใช้กับเครื่องตัดหญ้าสะพายบ่าและเครื่องเล็มหญ้า                                                                        ', './file/product/image1/rHbMPpUniD9mhxx5nkko0kqPE.jpg', '', 30, 'ซอง', 135, 5, 28, 0, 1, 0, '0000-00-00', 0, 0, 1),
(56, 'ยางกันสั่นสะเทือน', 10, 'EUR', 'M5', 2, 'Package included: 1 x rubber mounts\r\n\r\nSpecification: \r\n    Brand new\r\n\r\n    Material: rubber and steel\r\n\r\n    Threaded: M5/M6/M8 (3 kinds)\r\n\r\n    M8 Size: approx. 25X20mm\r\n\r\n    M6 Size: approx. 20X20mm\r\n\r\n    M5 Size: approx. 15X15mm\r\n\r\n    Color: as pi', './file/product/image1/ZmwQXU6Rb5pU3MLyxS9yyCEwL.webp', '', 30, 'ชิ้น', 30, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(57, 'ยางกันสั่นสะเทือน ', 10, 'EUR', 'M6', 6, 'Package included: 1 x rubber mounts\r\n\r\nSpecification: \r\n    Brand new\r\n\r\n    Material: rubber and steel\r\n\r\n    Threaded: M5/M6/M8 (3 kinds)\r\n\r\n    M8 Size: approx. 25X20mm\r\n\r\n    M6 Size: approx. 20X20mm\r\n\r\n    M5 Size: approx. 15X15mm\r\n\r\n    Color: as pi', './file/product/image1/9NQQ1yVVlHzKt7dvAVJgQ4u4x.webp', '', 30, 'ซอง', 35, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(58, 'ยางกันสั่นสะเทือน ', 10, 'EUR', 'M8', 8, '                                    Package included: 1 x rubber mounts\r\nSpecification: \r\n    Brand new\r\n    Material: rubber and steel\r\n\r\n    Threaded: M5/M6/M8 (3 kinds)\r\n\r\n    M8 Size: approx. 25X20mm\r\n    M6 Size: approx. 20X20mm\r\n    M5 Size: approx.', './file/product/image1/aUZ3hgYNkvnCYYTReCPcTc8wI.webp', '', 30, 'ซอง', 40, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(59, 'เครื่องสูบน้ำแก๊งหุงต้ม', 11, 'SAKARI LPG', 'WP-134X ', 2, '                                    \r\nขนาดเส้นผ่านศูนย์กลาง	4 นิ้ว (100 มม)\r\nระยะส่งสูงสุด	28 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	1800 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์ LPG 4 จังหวะ\r\n 	ระบายความร้อนด้วยพัดลมดูดอากาศ\r\nแรงม้าสูงสุด	13 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือก                                    ', './file/product/image1/iUocOFb8HASXcaHiW3ObgDsfA.jpg', '', 30, 'เครื่อง', 23000, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(60, 'เครื่องสูบน้ำเบนซิน', 11, 'SAKARI', 'WP552', 2, ' ขนาดเส้นผ่านศูนย์กลาง	2 นิ้ว (50 มม)\r\nระยะส่งสูงสุด	32 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	600 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์เบนซิน 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	5.5 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือกดึงสตาร                                    ', './file/product/image1/667Sb3HdD1ojU8QqoLgmSRf5J.jpg', '', 30, 'เครื่อง', 6850, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(61, 'เครื่องสูบน้ำดีเซล', 11, 'HONMAR', 'CBP-20E', 2, '                                    \r\nเส้นผ่านศูนย์กลางท่อ-ดูดส่ง	2 นิ้ว (50 มม)\r\nระยะส่งน้ำสูงสุด	28 เมตร\r\nระยะสูบน้ำลึกสุด	8 เมตร\r\nปริมาตรน้ำสูบได้สูงสุด	600 ต่อนาที\r\n 	 \r\nรุ่นเครื่องยนต์	HONMAR DH600E\r\nประเภทเครื่องยนต์	เครื่องยนต์ดีเซล 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	5                                     ', './file/product/image1/4FSUxBK7FTwdJ9CBZcYx3wIxv.jpg', '', 30, 'เครื่อง', 22500, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(62, 'เครื่องสูบน้ำเบนซิน', 11, 'SAKARI', 'WP-653', 2, '                                    \r\nขนาดเส้นผ่านศูนย์กลาง	3 นิ้ว (80 มม)\r\nระยะส่งสูงสุด	28 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	1250 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์เบนซิน 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	6.5 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือกดึงสตา                                    ', './file/product/image1/mdM5mrI2OtjmYjoWBUBRMFPPk.jpg', '', 30, 'เครื่อง', 7600, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(63, 'เครื่องสูบน้ำเบนซิน ', 11, 'SAKARI', 'WP-134', 6, '                                    \r\nขนาดเส้นผ่านศูนย์กลาง	4 นิ้ว (100 มม)\r\nระยะส่งสูงสุด	28 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	1800 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์เบนซิน 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	13 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือกดึงสตา                                    ', './file/product/image1/eqOcmSKZgK349xrhEJUX3TstU.jpg', '', 30, 'เครื่อง', 20000, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(64, 'เครื่องสูบน้ำเบนซิน', 11, 'SAKARI', 'WP-20X', 6, '                                    \r\nขนาดเส้นผ่านศูนย์กลาง	2 นิ้ว (50 มม)\r\nระยะส่งสูงสุด	32 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	600 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์เบนซิน 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	4 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือกดึงสตาร์ท                                    ', './file/product/image1/UtDBe8BKcDSDMsCzmigkAqcQ8.jpg', '', 30, 'เครื่อง', 6650, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(65, 'เครื่องสูบน้ำเบนซิน', 11, ' SAKARI', 'WP-25X', 6, '                                    \r\nเส้นผ่านศูนย์กลางท่อ-ดูดส่ง	3 นิ้ว (80 มม)\r\nระยะส่งน้ำสูงสุด	26 เมตร\r\nระยะสูบน้ำลึกสุด	8 เมตร\r\nปริมาตรน้ำสูบได้สูงสุด	1000 ต่อนาที\r\n 	 \r\nรุ่นเครื่องยนต์	HONMAR DH850E\r\nประเภทเครื่องยนต์	เครื่องยนต์ดีเซล 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	7                                    ', './file/product/image1/erZWPs5Yttbx4T35cl46D8PMj.jpg', '', 30, 'เครื่อง', 26000, 5, 30, 0, 0, 0, '0000-00-00', 0, 0, 1),
(66, 'เครื่องสูบน้ำเบนซิน', 11, ' SAKARI', 'WP-30X', 2, '                                    \r\nขนาดเส้นผ่านศูนย์กลาง	3 นิ้ว (80 มม)\r\nระยะส่งสูงสุด	28 เมตร\r\nระยะดูดลึกสูงสุด	8 เมตร\r\nปริมาณน้ำสูงสุด	1100 ลิตรต่อนาที\r\nเครื่องยนต์	เครื่องยนต์เบนซิน 4 จังหวะ\r\n 	ระบายความร้อนด้วยอากาศ\r\nแรงม้าสูงสุด	5.5 แรงม้าที่ 3600 รอบต่อนาที่\r\nระบบสตาร์ท	เชือกดึงสตา                                    ', './file/product/image1/etmITDcTedemGpWVa6RRMdNLP.jpg', '', 30, 'เครื่อง', 7250, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 1),
(67, 'ซันฟิต', 14, 'ซันคร็อพ', '', 9, '                                     ทะเบียนวัตถุอันตรายเลขที่ 2217-2555\r\nชื่อสามัญ : เพรทิลาคลอร์  \r\n                 Pretilachlor  30% W/V EC\r\n\r\nประโยชน์ : ควบคุมวัชพืชก่อนวัชพืชงอก ในนาดำและในนาหว่านน้ำตมในระยะ เริ่มต้น 0-4 วัน  เช่น หญ้าข้าวนก หญ้าดอก', './file/product/image1/PYwrYdNVEGf4ldmKOLh1esMuK.png', '', 30, 'ชิ้น', 120, 5, 29, 0, 1, 0, '0000-00-00', 0, 0, 0),
(68, 'ซันคร็อพ', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 2250-2556\r\nชื่อสามัญ : บิวทาคลอร์ (มีเซฟเฟนเนอร์)\r\n                  Butachlor  60% W/V EC \r\nประโยชน์ : ควบคุมวัชพืชก่อนวัชพืชงอกในนาดำและในนาหว่านน้ำตมในระยะเริ่มต้น 0-4 วัน  เช่น หญ้าข้าวนก หญ้าดอกขาว ขาเขียดและกกต่างๆ', './file/product/image1/eypLvHtVN8fH5YoTXoPeOYoV1.png', '', 30, 'ชิ้น', 100, 5, 29, 0, 1, 0, '0000-00-00', 0, 0, 0),
(69, 'ซันคร็อพ NB', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 2250-2556\r\nชื่อสามัญ : บิวทาคลอร์ (ไม่มีเซฟเฟนเนอร์) \r\nButachlor  60% W/V EC \r\n\r\nประโยชน์ : ควบคุมวัชพืชก่อนวัชพืชงอก ในนาดำและในนาหว่านน้ำตมในระยะเริ่มต้น 0-4 วัน  เช่น หญ้าข้าวนก หญ้าดอกขาว ขาเขียดและกกต่างๆ\r\n', './file/product/image1/y4hlbWQzWNq6CFkcNH4r3tYyO.png', '', 30, 'ชิ้น', 80, 5, 29, 0, 1, 0, '0000-00-00', 0, 0, 0),
(70, 'ซันโปร700', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 1633-2556\r\nชื่อสามัญ : บิวทาคลอร์+โพรพานิล\r\n                 Butachlor 35% + Propanil 35% W/V EC\r\nประโยชน์ : ใช้หลังวัชพืชงอก(post-emergence) ในนาหว่านน้ำตมหลังหว่านข้าวระยะ 7-12 วัน เพื่อกำจัดวัชพืชประเภทใบแคบ เช่น หญ้าข้าวนก แล', './file/product/image1/g7hXuuif255jCPpjmxm0M5u3L.png', '', 30, 'ชิ้น', 90, 5, 28, 0, 1, 0, '0000-00-00', 0, 0, 0),
(71, 'ซันคาล่า', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 606-2556\r\nชื่อสามัญ : อะเซโทคลอร์  \r\n                 Acetochlor  50% W/V EC\r\nประโยชน์ : ใช้กำจัดวัชพืชก่อนงอกหรือ พืชที่ปลูกยังไม่งอก  ใช้ในพืชไร่และพืชผัก กำจัดวัชพืชประเภทใบแคบ และใบกว้าง', './file/product/image1/MJIJgPRWVHiW99O5dRlt0kjlY.png', '', 30, 'ชิ้น', 75, 5, 28, 0, 1, 0, '0000-00-00', 0, 0, 0),
(72, 'อะลาคลอร์ 48', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 620-2556\r\n\r\nชื่อสามัญ : อะลาคลอร์    \r\n                 Alachlor  48%  W/V EC\r\nประโยชน์ : สารควบคุมวัชพืชก่อนงอกในพืชตระกูลถั่ว ฝ้าย ข้าวโพด มันสำปะหลัง หอม กระเทียม ก่อนฉีดพ่นยาควรเตรียมดินให้ร่วนซุย และดินมีความชื้น ', './file/product/image1/HnKD0VLPhA8I4Xk3gFYBUELJl.png', '', 30, 'ชิ้น', 90, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(73, 'ซันคร็อพโซน', 14, 'ซันคร็อพ', '', 2, 'ทะเบียนวัตถุอันตรายเลขที่ 1974-2556\r\nชื่อสามัญ : พาราควอต ไดคลอไรด์    \r\n                  Paraquat dichloride  27.6% W/V SL\r\nประโยชน์ : ยากำจัดวัชพืชชนิดสัมผัสทำลายวัชพืชสีเขียวทุกชนิด การฉีดพ่น ควรระวังไม่ให้ถูกพืชที่ปลูก นิยมใช้แพร่หลายในพืชไร่ พืชสวนแ', './file/product/image1/rzfkxevKl6UkoBrn2RZoXWrsf.png', '', 30, 'ชิ้น', 89, 5, 29, 0, 1, 0, '0000-00-00', 0, 0, 0),
(74, 'ไดยูรอน 80', 14, 'ซันคร็อพ', '', 9, 'ทะเบียนวัตถุอันตรายเลขที่ 1248-2555\r\nชื่อสามัญ : ไดยูรอน    \r\n                   Diuron  80% WP\r\nประโยชน์ : สารควบคุมกำจัด ก่อนวัชพืชงอกและหลังวัชพืชงอก ในอ้อย สับปะรด  กาแฟ ชา มะละกอ กล้วย ส้ม มันสำปะหลัง ปาล์ม และพื้นที่ที่ไม่ได้ทำการเกษตร เพื่อกำจัดวัช', './file/product/image1/sQ8P2XEzs3Bg7tN30QznAqQ1f.png', '', 30, 'ชิ้น', 99, 5, 30, 0, 1, 0, '0000-00-00', 0, 0, 0),
(75, 'ซันโปรนิล', 14, 'ซันคร็อพ', '', 9, '                                    ทะเบียนวัตถุอันตรายเลขที่ 1973-2556\r\nชื่อสามัญ : โพรพานิล    Propanil 36% W/V EC\r\nประโยชน์ : ใช้หลังวัชพืชงอก(post-emergence) ในข้าวนาหว่านน้ำตม เพื่อกำจัดวัชพืชประเภทใบแคบ เช่น หญ้าข้าวนก และหญ้าดอกขาว วัชพืชประเภทใบกว', './file/product/image1/w9uMROWa6m2HOUnfxkXt49CNo.png', '', 30, 'ชิ้น', 99, 5, 30, 0, 0, 0, '0000-00-00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_details_tb`
--

CREATE TABLE `sales_details_tb` (
  `unique_id` int(6) NOT NULL,
  `sales_list_id` int(6) NOT NULL COMMENT 'รหัสรายการขาย',
  `sales_dt` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ซื้อ',
  `product_id` int(6) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `sales_amt` int(6) NOT NULL COMMENT 'จำนวนต่อหน่วยสินค้า',
  `sales_pr` int(6) NOT NULL COMMENT 'ราคาต่อหน่วยสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales_details_tb`
--

INSERT INTO `sales_details_tb` (`unique_id`, `sales_list_id`, `sales_dt`, `product_id`, `sales_amt`, `sales_pr`) VALUES
(1, 1, '2023-03-06 11:21:53', 11, 1, 20),
(2, 2, '2023-03-06 14:59:00', 11, 1, 20),
(3, 3, '2023-03-06 20:52:57', 17, 1, 2990),
(4, 4, '2023-03-08 16:29:36', 1, 6, 120),
(5, 5, '2023-03-11 15:10:12', 16, 1, 6800),
(6, 5, '2023-03-11 15:10:12', 44, 2, 220),
(7, 6, '2023-03-11 16:57:04', 16, 1, 6800),
(8, 6, '2023-03-11 16:57:04', 20, 1, 1700),
(9, 6, '2023-03-11 16:57:04', 44, 1, 110),
(10, 6, '2023-03-11 16:57:04', 23, 1, 450),
(11, 6, '2023-03-11 16:57:04', 22, 3, 2400),
(12, 6, '2023-03-11 16:57:04', 54, 1, 180),
(13, 6, '2023-03-11 16:57:05', 52, 1, 40),
(14, 6, '2023-03-11 16:57:05', 34, 1, 380),
(15, 6, '2023-03-11 16:57:05', 50, 1, 299),
(16, 6, '2023-03-11 16:57:05', 55, 1, 135),
(17, 6, '2023-03-11 16:57:05', 53, 1, 97),
(18, 6, '2023-03-11 16:57:05', 68, 1, 100),
(19, 6, '2023-03-11 16:57:05', 21, 1, 800),
(20, 6, '2023-03-11 16:57:05', 33, 1, 165),
(21, 6, '2023-03-11 16:57:05', 69, 1, 80),
(22, 6, '2023-03-11 16:57:05', 73, 1, 89),
(23, 7, '2023-03-11 17:02:01', 17, 1, 2990),
(24, 7, '2023-03-11 17:02:01', 16, 1, 6800),
(25, 7, '2023-03-11 17:02:01', 44, 1, 110),
(26, 7, '2023-03-11 17:02:02', 20, 1, 1700),
(27, 7, '2023-03-11 17:02:02', 23, 1, 450),
(28, 7, '2023-03-11 17:02:02', 21, 1, 800),
(29, 8, '2023-03-11 17:04:54', 17, 1, 2990),
(30, 8, '2023-03-11 17:04:54', 16, 1, 6800),
(31, 8, '2023-03-11 17:04:55', 44, 1, 110),
(32, 8, '2023-03-11 17:04:55', 20, 3, 5100),
(33, 8, '2023-03-11 17:04:55', 22, 2, 1600),
(34, 8, '2023-03-11 17:04:55', 54, 1, 180),
(35, 8, '2023-03-11 17:04:55', 24, 1, 450),
(36, 8, '2023-03-11 17:04:55', 52, 1, 40),
(37, 8, '2023-03-11 17:04:55', 53, 1, 97),
(38, 8, '2023-03-11 17:04:55', 50, 1, 299),
(39, 8, '2023-03-11 17:04:55', 34, 1, 380),
(40, 8, '2023-03-11 17:04:55', 70, 1, 90),
(41, 8, '2023-03-11 17:04:55', 71, 1, 75),
(42, 8, '2023-03-11 17:04:55', 67, 1, 120),
(43, 9, '2023-03-11 17:04:56', 17, 1, 2990),
(44, 9, '2023-03-11 17:04:56', 16, 1, 6800),
(45, 9, '2023-03-11 17:04:56', 44, 1, 110),
(46, 9, '2023-03-11 17:04:56', 20, 3, 5100),
(47, 9, '2023-03-11 17:04:56', 22, 2, 1600),
(48, 9, '2023-03-11 17:04:56', 54, 1, 180),
(49, 9, '2023-03-11 17:04:56', 24, 1, 450),
(50, 9, '2023-03-11 17:04:56', 52, 1, 40),
(51, 9, '2023-03-11 17:04:56', 53, 1, 97),
(52, 9, '2023-03-11 17:04:56', 50, 1, 299),
(53, 9, '2023-03-11 17:04:56', 34, 1, 380),
(54, 9, '2023-03-11 17:04:57', 70, 1, 90),
(55, 9, '2023-03-11 17:04:57', 71, 1, 75),
(56, 10, '2023-03-11 17:06:29', 17, 1, 2990),
(57, 10, '2023-03-11 17:06:30', 16, 1, 6800),
(58, 10, '2023-03-11 17:06:30', 11, 1, 20),
(59, 10, '2023-03-11 17:06:30', 44, 1, 110),
(60, 10, '2023-03-11 17:06:30', 20, 1, 1700),
(61, 10, '2023-03-11 17:06:30', 21, 1, 800),
(62, 10, '2023-03-11 17:06:30', 22, 1, 800),
(63, 10, '2023-03-11 17:06:30', 23, 1, 450),
(64, 10, '2023-03-11 17:06:30', 24, 1, 450),
(65, 10, '2023-03-11 17:06:30', 54, 1, 180),
(66, 10, '2023-03-11 17:06:30', 52, 1, 40),
(67, 10, '2023-03-11 17:06:30', 55, 1, 135),
(68, 11, '2023-03-14 09:01:39', 17, 2, 5980),
(69, 12, '2023-03-14 12:12:36', 3, 20, 400),
(70, 12, '2023-03-14 12:12:37', 4, 10, 200),
(71, 13, '2023-03-17 14:07:17', 17, 1, 3000),
(72, 13, '2023-03-17 14:07:17', 16, 1, 6800),
(73, 14, '2023-03-17 14:07:56', 17, 1, 3000),
(74, 14, '2023-03-17 14:07:56', 16, 1, 6800),
(75, 15, '2023-03-17 14:10:00', 17, 1, 3000),
(76, 15, '2023-03-17 14:10:01', 16, 1, 6800);

-- --------------------------------------------------------

--
-- Table structure for table `sales_tb`
--

CREATE TABLE `sales_tb` (
  `sales_list_id` int(6) NOT NULL COMMENT 'รหัสรายการขาย',
  `payment_sl` varchar(255) NOT NULL COMMENT 'วิธีการชำระเงิน',
  `payment_dt` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่',
  `employee_id` int(5) NOT NULL COMMENT 'รหัสพนักงานขาย',
  `discount` varchar(20) DEFAULT NULL COMMENT 'ส่วนลด',
  `all_quantity` varchar(20) NOT NULL COMMENT 'จำนวนสินค้าทั้งหมด',
  `all_price` varchar(20) NOT NULL COMMENT 'ยอดที่ต้องชำระทั้งหมด',
  `import_files` varchar(255) DEFAULT NULL COMMENT 'ไฟล์แนบ',
  `note` varchar(255) DEFAULT NULL COMMENT 'หมายเหตุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales_tb`
--

INSERT INTO `sales_tb` (`sales_list_id`, `payment_sl`, `payment_dt`, `employee_id`, `discount`, `all_quantity`, `all_price`, `import_files`, `note`) VALUES
(1, 'เงินสด', '2023-03-06 11:21:53', 1, NULL, '1', '20', '', NULL),
(2, 'โอนผ่านบัญชีธนาคาร', '2023-03-06 14:59:00', 1, NULL, '1', '20', './file/sales/sales_slip/DI1PW7vU0CWR6alAk3xLTDJOH.jpg', 'สลิปธนาคาร'),
(3, 'โอนผ่านบัญชีธนาคาร', '2023-03-06 20:52:57', 1, NULL, '1', '2990', './file/sales/sales_slip/kwYMUnMoDg1WoXVFyg8xWVKrf.jpg', 'ใบสลิปธนาคาร'),
(4, 'เงินสด', '2023-03-08 16:29:35', 1, NULL, '6', '120', '', NULL),
(5, 'โอนผ่านบัญชีธนาคาร', '2023-03-11 15:10:12', 1, NULL, '3', '7020', '', ''),
(6, 'ผ่อนชำระ', '2023-03-11 16:57:03', 1, NULL, '18', '13825', '', NULL),
(7, 'ผ่อนชำระ', '2023-03-11 17:02:01', 1, NULL, '6', '12850', '', NULL),
(8, 'ผ่อนชำระ', '2023-03-11 17:04:54', 1, NULL, '17', '18331', '', NULL),
(9, 'ผ่อนชำระ', '2023-03-11 17:04:55', 1, NULL, '17', '18331', '', NULL),
(10, 'เงินสด', '2023-03-11 17:06:29', 1, NULL, '12', '14475', '', NULL),
(11, 'เงินสด', '2023-03-14 09:01:39', 1, NULL, '2', '5980', '', NULL),
(12, 'โอนผ่านบัญชีธนาคาร', '2023-03-14 12:12:36', 3, NULL, '30', '600', './file/sales/sales_slip/g9zJ4p2xpTP6TnEG1NhAWAKja.jpg', 'ซื้อถั่วฝักยาว'),
(13, 'ผ่อนชำระ', '2023-03-17 14:07:17', 1, NULL, '2', '9800', '', NULL),
(14, 'ผ่อนชำระ', '2023-03-17 14:07:56', 1, NULL, '2', '9800', '', NULL),
(15, 'ผ่อนชำระ', '2023-03-17 14:10:00', 1, NULL, '2', '9800', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `search_category_tb`
--

CREATE TABLE `search_category_tb` (
  `unique_id` int(8) NOT NULL COMMENT 'ค่าเอกลักษณ์',
  `category_id` int(3) NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `search_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันเวลาที่ค้นหา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_category_tb`
--

INSERT INTO `search_category_tb` (`unique_id`, `category_id`, `search_date`) VALUES
(1, 1, '2023-03-12 19:09:15'),
(2, 2, '2023-03-12 19:09:16'),
(3, 2, '2023-03-12 19:09:17'),
(4, 2, '2023-03-12 19:09:18'),
(5, 2, '2023-03-12 19:09:18'),
(6, 2, '2023-03-12 19:09:18'),
(7, 2, '2023-03-12 19:09:19'),
(8, 4, '2023-03-12 19:09:20'),
(9, 8, '2023-03-12 19:12:33'),
(10, 3, '2023-03-12 19:18:10'),
(11, 4, '2023-03-12 19:18:21'),
(12, 5, '2023-03-12 19:18:25'),
(13, 8, '2023-03-12 19:18:31'),
(14, 14, '2023-03-12 19:18:35'),
(15, 1, '2023-03-12 19:19:03'),
(16, 4, '2023-03-12 19:19:04'),
(17, 5, '2023-03-12 19:19:06'),
(18, 7, '2023-03-12 19:19:07'),
(19, 1, '2023-05-18 10:27:33'),
(20, 2, '2023-05-18 10:27:33'),
(21, 3, '2023-05-18 10:27:34'),
(22, 9, '2023-05-18 10:27:35'),
(23, 7, '2023-05-18 10:27:35'),
(24, 14, '2023-05-18 10:27:36'),
(25, 15, '2023-05-18 10:27:42'),
(26, 11, '2023-05-18 10:27:42'),
(27, 1, '2023-05-18 10:28:12'),
(28, 1, '2023-05-24 04:16:37'),
(29, 1, '2023-06-09 04:52:12'),
(30, 2, '2023-06-09 04:52:13'),
(31, 15, '2023-06-09 04:52:50'),
(32, 14, '2023-06-09 04:52:53'),
(33, 13, '2023-06-09 04:52:57'),
(34, 12, '2023-06-09 04:52:59'),
(35, 11, '2023-06-09 04:53:04'),
(36, 9, '2023-06-09 04:53:07'),
(37, 10, '2023-06-09 04:53:09'),
(38, 9, '2023-06-09 04:53:11'),
(39, 8, '2023-06-09 04:53:13'),
(40, 7, '2023-06-09 04:53:16'),
(41, 6, '2023-06-09 04:53:20'),
(42, 5, '2023-06-09 04:53:22'),
(43, 4, '2023-06-09 04:53:25'),
(44, 7, '2023-06-09 04:53:30'),
(45, 1, '2023-06-09 04:53:35'),
(46, 9, '2023-06-09 04:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `search_tb`
--

CREATE TABLE `search_tb` (
  `search_id` int(8) NOT NULL COMMENT 'ค่าเอกลักษณ์',
  `keyword` varchar(255) NOT NULL COMMENT 'คำค้นหา',
  `search_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันเวลาที่ค้นหา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_tb`
--

INSERT INTO `search_tb` (`search_id`, `keyword`, `search_date`) VALUES
(1, 'ใบตัดห', '2023-03-12 19:09:26'),
(2, '1', '2023-03-12 19:09:28'),
(3, 'ถั่ว', '2023-03-12 19:19:20'),
(4, 'ฝน', '2023-03-14 04:05:20'),
(5, 'เครื่องสูบน้ำ', '2023-05-18 10:27:55'),
(6, 'ใบตัดหญ้า', '2023-05-18 10:28:10'),
(7, 'ใบตัดหญ้า', '2023-05-18 10:28:20'),
(8, 'สาย', '2023-06-09 04:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `sell_tb`
--

CREATE TABLE `sell_tb` (
  `sell_id` int(4) NOT NULL COMMENT 'รหัสผู้ขาย',
  `sell_type` varchar(50) NOT NULL COMMENT 'ประเภทผู้ขาย',
  `sell_name` varchar(50) NOT NULL COMMENT 'ชื่อผู้ขาย',
  `sell_address` text NOT NULL COMMENT 'ที่อยู่',
  `sell_tax_id` varchar(25) NOT NULL COMMENT 'หมายเลขประจำตัวผู้เสียภาษี',
  `sell_telephone` varchar(20) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `sell_website` varchar(255) NOT NULL COMMENT 'เว็บไซต์',
  `seller_firstname` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `seller_lastname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `seller_nickname` varchar(50) NOT NULL COMMENT 'ชื่อเล่น',
  `seller_email` varchar(70) NOT NULL COMMENT 'อีเมล',
  `seller_telephone` varchar(20) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `seller_channel` varchar(30) NOT NULL COMMENT 'ช่องทางการติดต่ออื่นๆ ',
  `seller_card_id` varchar(255) NOT NULL COMMENT 'สำเนาบัตรประชาชน',
  `seller_cardname` varchar(255) NOT NULL COMMENT 'นามบัตร',
  `sell_documents` varchar(255) NOT NULL COMMENT 'เอกสารอื่นๆ',
  `sell_note` varchar(255) NOT NULL COMMENT 'หมายเหตุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sell_tb`
--

INSERT INTO `sell_tb` (`sell_id`, `sell_type`, `sell_name`, `sell_address`, `sell_tax_id`, `sell_telephone`, `sell_website`, `seller_firstname`, `seller_lastname`, `seller_nickname`, `seller_email`, `seller_telephone`, `seller_channel`, `seller_card_id`, `seller_cardname`, `sell_documents`, `sell_note`) VALUES
(2, '', 'บริษัท ซีดไลน์ จำกัด', '70 หมู่ 13 ถนน พุทธมณฑลสาย 5 ตำบล ไร่ขิง อำเภอสามพราน จังหวัด นครปฐม 13000 ', '11111111111111', '020-1920000', 'www.seedline.co.th', 'ซานฟา', 'อาวัชนานุกูล', 'กิ๊ฟ', 'gogl0501lover@gmail.com', '092-2503638', 'lineid:gif123', './file/seller/id/ZqdojQMcSGMimjWD3YyfdF4Eb.png', './file/seller/card/ki5aDjyahhlLlnI77FjXM85JW.png', '', ''),
(3, '', 'บริษัท อาร์เจส อินเตอร์เทรด (2017) จำกัด', '56/6 ม.9 ต.นาดี อ.เมืองสมุทรสาคร จ.สมุทรสาคร \r\n74000', '0745560004119', '099-4549601', 'www.krungtepworapen.co.th', 'ปณวัต', 'ศรีโชติ', 'ต่าย', 'worapen@gmail.com', '099-4549601', '', './file/seller/id/pO7dQuY0FqG85YgklQolNJClz.png', './file/seller/card/syb9KWQ2knsslgzKGu2J9PDu6.png', '', ''),
(6, '', 'บริษัท กรุงเทพ วรเพ็ญ จำกัด', '10 เพชรเกษม110 แยก14-1-1-2 ถนนเพชรเกษม \r\nแขวงหนองคางพูล เขตหนองแขม กรุงเทพมหานคร\r\n10160', '-', '083-1788738', 'krungtepworapen.com', 'ณัฐพงศ์', 'ตันเจริญ', '-', 'worapen3@gmail.com', '096-7538950', 'EURO168', './file/seller/id/YKyY0n3tOXPmsWtdANrTar35O.png', './file/seller/card/VeMMA8nT0ub1aJWTizbdjdqVG.png', '', ''),
(9, '', 'บริษัท ซันคร็อพ กรุ๊ป จำกัด', '60/96 หมู่ 7 ซอย 59 ถนนพหลโยธิน แขวงอนุสาวรีย์ เขตบางเขน กรุงเทพมหานคร 10220', '-', '081-9112390', 'www.suncrop.net', 'พระอาทิตย์', 'ซันคร็อพ ', 'อาทิตย์', 'suncropgroup@gmail.com', '089-3625874', '-', './file/seller/id/bccFZ3TBLQc2sGPOqaHwW1PlJ.png', './file/seller/card/Q0DSOtkwtDy2Qo17VHnlorJyt.png', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `stock_tb`
--

CREATE TABLE `stock_tb` (
  `stock_id` int(2) NOT NULL COMMENT 'รหัสสต็อกสินค้า',
  `order_id` int(6) NOT NULL COMMENT 'รหัสใบสั่งซื้อ',
  `product_id` int(6) NOT NULL COMMENT 'รหัสรายการสินค้า',
  `amount_exp` int(11) NOT NULL COMMENT 'จำนวนที่มีวันหมดอายุ',
  `exp_date` date DEFAULT NULL COMMENT 'วันหมดอายุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stock_tb`
--

INSERT INTO `stock_tb` (`stock_id`, `order_id`, `product_id`, `amount_exp`, `exp_date`) VALUES
(1, 1, 1, 14, '2023-03-13'),
(2, 1, 2, 20, '2023-03-31'),
(3, 1, 3, 0, '2023-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `user_account_tb`
--

CREATE TABLE `user_account_tb` (
  `unique_id` int(5) NOT NULL COMMENT 'ค่าเอกลักษณ์',
  `account_username` varchar(70) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `account_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `account_user_type` enum('A','L','E') NOT NULL DEFAULT 'E' COMMENT 'ประเภทผู้ใช้งาน',
  `account_user_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'สถานะการใช้งานระบบ',
  `employee_id` int(5) NOT NULL COMMENT 'รหัสพนักงานขาย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_account_tb`
--

INSERT INTO `user_account_tb` (`unique_id`, `account_username`, `account_password`, `account_user_type`, `account_user_status`, `employee_id`) VALUES
(1, 'admin.1@gmail.com', '$2y$10$tg7c67aMA/rm/7wTgv1aWOe9dsm/AYzPfiLF3QSSiaz66B0Gxv.7i', 'A', 1, 0),
(2, 'vitoon.1405@hotmail.com', '$2y$10$5BefmcWcXK3CsMK/9mjKzuR/V5upabplcweKrIFQ99q6FMXryYZau', 'L', 1, 1),
(3, 'niramolsiriyuth@gmail.com', '$2y$10$KeppvQzCHpT34Aez1xop6ea5rAVUqoVf0fGD8kXK9XdWVHE.utYRW', 'L', 1, 2),
(4, 'padetsuek.2543@gmail.com', '$2y$10$AOcpTYee8Uxon8vlNpok6ejV/yu4DJlhmwISau/WeqfdZmqWKJ7SS', 'E', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_tb`
--
ALTER TABLE `bank_tb`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `sell_id` (`sell_id`);

--
-- Indexes for table `category_tb`
--
ALTER TABLE `category_tb`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contract_tb`
--
ALTER TABLE `contract_tb`
  ADD PRIMARY KEY (`contract_code`),
  ADD KEY `sales_list_id` (`sales_list_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `costprice_tb`
--
ALTER TABLE `costprice_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `debt_payment_details_tb`
--
ALTER TABLE `debt_payment_details_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `contract_code` (`contract_code`);

--
-- Indexes for table `employeebank_tb`
--
ALTER TABLE `employeebank_tb`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee_tb`
--
ALTER TABLE `employee_tb`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employee_email` (`employee_email`);

--
-- Indexes for table `order_details_tb`
--
ALTER TABLE `order_details_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_tb`
--
ALTER TABLE `order_tb`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `sell_id` (`sell_id`);

--
-- Indexes for table `otherprice_tb`
--
ALTER TABLE `otherprice_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product_exchange_tb`
--
ALTER TABLE `product_exchange_tb`
  ADD PRIMARY KEY (`product_exchange_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_tb`
--
ALTER TABLE `product_tb`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sell_id` (`sell_id`),
  ADD KEY `product_exchange_id` (`product_exchange_id`),
  ADD KEY `product_exchange_id_2` (`product_exchange_id`);

--
-- Indexes for table `sales_details_tb`
--
ALTER TABLE `sales_details_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `sales_list_id` (`sales_list_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales_tb`
--
ALTER TABLE `sales_tb`
  ADD PRIMARY KEY (`sales_list_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `search_category_tb`
--
ALTER TABLE `search_category_tb`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `search_tb`
--
ALTER TABLE `search_tb`
  ADD PRIMARY KEY (`search_id`);

--
-- Indexes for table `sell_tb`
--
ALTER TABLE `sell_tb`
  ADD PRIMARY KEY (`sell_id`),
  ADD UNIQUE KEY `seller_email` (`seller_email`);

--
-- Indexes for table `stock_tb`
--
ALTER TABLE `stock_tb`
  ADD PRIMARY KEY (`stock_id`) USING BTREE,
  ADD KEY `order_id` (`order_id`,`product_id`);

--
-- Indexes for table `user_account_tb`
--
ALTER TABLE `user_account_tb`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_tb`
--
ALTER TABLE `bank_tb`
  MODIFY `bank_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการบัญชีธนาคาร', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `category_tb`
--
ALTER TABLE `category_tb`
  MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทของสินค้า', AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contract_tb`
--
ALTER TABLE `contract_tb`
  MODIFY `contract_code` int(6) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสัญญาการซื้อขาย', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `costprice_tb`
--
ALTER TABLE `costprice_tb`
  MODIFY `unique_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ค่าอัตลักษณ์', AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `debt_payment_details_tb`
--
ALTER TABLE `debt_payment_details_tb`
  MODIFY `unique_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ค่าเอกลักษณ์', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employeebank_tb`
--
ALTER TABLE `employeebank_tb`
  MODIFY `bank_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการบัญชีธนาคาร', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employee_tb`
--
ALTER TABLE `employee_tb`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสพนักงานขาย', AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_details_tb`
--
ALTER TABLE `order_details_tb`
  MODIFY `unique_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ค่าเอกลักษณ์', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_tb`
--
ALTER TABLE `order_tb`
  MODIFY `order_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการใบสั่งซื้อ', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `otherprice_tb`
--
ALTER TABLE `otherprice_tb`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_exchange_tb`
--
ALTER TABLE `product_exchange_tb`
  MODIFY `product_exchange_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการเปลี่ยนสินค้า', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_tb`
--
ALTER TABLE `product_tb`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการสินค้า', AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `sales_details_tb`
--
ALTER TABLE `sales_details_tb`
  MODIFY `unique_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `sales_tb`
--
ALTER TABLE `sales_tb`
  MODIFY `sales_list_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการขาย', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `search_category_tb`
--
ALTER TABLE `search_category_tb`
  MODIFY `unique_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ค่าเอกลักษณ์', AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `search_tb`
--
ALTER TABLE `search_tb`
  MODIFY `search_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ค่าเอกลักษณ์', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sell_tb`
--
ALTER TABLE `sell_tb`
  MODIFY `sell_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ขาย', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stock_tb`
--
ALTER TABLE `stock_tb`
  MODIFY `stock_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสต็อกสินค้า', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_account_tb`
--
ALTER TABLE `user_account_tb`
  MODIFY `unique_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ค่าเอกลักษณ์', AUTO_INCREMENT=100013;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
