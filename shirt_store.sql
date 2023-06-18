-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2023 lúc 03:33 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shirt_store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `Cat_ID` varchar(10) NOT NULL,
  `Cat_Name` varchar(30) NOT NULL,
  `Cat_Des` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`Cat_ID`, `Cat_Name`, `Cat_Des`) VALUES
('C01', 'Polo', 'Polo shirt'),
('C02', 'T-shirt', 'T-shirt'),
('C03', 'Henley shirts', 'Henley shirts'),
('C04', 'Sweater', 'Sweater shirts');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shirt`
--

CREATE TABLE `shirt` (
  `ShiID` varchar(10) NOT NULL,
  `ShiName` varchar(30) NOT NULL,
  `ShiPrice` bigint(20) NOT NULL,
  `ShiDes` varchar(30) NOT NULL,
  `ShiDate` datetime NOT NULL,
  `ShiImg` varchar(1000) NOT NULL,
  `ShiQty` int(10) NOT NULL,
  `Cat_ID` varchar(10) NOT NULL,
  `SoldQty` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shirt`
--

INSERT INTO `shirt` (`ShiID`, `ShiName`, `ShiPrice`, `ShiDes`, `ShiDate`, `ShiImg`, `ShiQty`, `Cat_ID`, `SoldQty`) VALUES
('S001', 'Purple T-Shirt', 35, '2023-05-10 18:42:09', '2023-05-10 21:48:13', 'ts1.jpg', 20, 'C02', 51),
('S002', 'Yellow Bird T-Shirt', 40, '2023-05-10 18:39:22', '2023-05-10 21:48:18', 'ts2.jpg', 12, 'C02', 51),
('S003', 'Blue T-Shirt', 30, '2023-05-10 18:44:50', '2023-05-10 21:48:25', 'ts4.jpg', 2, 'C02', 0),
('S004', 'Black T-Shirt', 20, '2023-05-10 18:47:28', '2023-05-10 21:48:31', 'ts5.jpg', 10, 'C02', 0),
('S005', 'Yellow T-Shirt', 40, '2023-05-10 20:48:39', '2023-05-10 21:48:37', 'ts3.jpg', 11, 'C02', 0),
('S006', 'Turquoise Polo', 60, 'Turquoise color', '2023-05-10 21:54:47', 'pl1.jpg', 30, 'C01', 66),
('S007', 'Brown Polo', 55, 'Brown color', '2023-05-10 21:57:13', 'pl2.jpg', 25, 'C01', 99),
('S008', 'Orange Polo', 100, 'Orange color', '2023-05-10 22:02:12', 'pl3.jpg', 50, 'C01', 0),
('S009', 'Stripes Polo', 75, 'Black and white stripes', '2023-05-10 22:03:38', 'pl4.jpg', 46, 'C01', 99),
('S010', 'Black sweater', 110, 'Black color', '2023-05-10 22:09:29', 'swt1.jpg', 20, 'C04', 99),
('S011', 'Brown sweater', 55, 'Brown color', '2023-05-10 22:10:11', 'swt2.jpg', 55, 'C04', 99),
('S012', 'Blue sweater', 45, 'Blue color', '2023-05-10 22:10:45', 'swt3.jpg', 1, 'C04', 0),
('S013', 'Yellow sweater', 67, 'Yellow color', '2023-05-10 22:12:03', 'swt4.jpg', 5, 'C04', 0),
('S014', 'White henleys', 88, 'White color', '2023-05-10 22:12:46', 'henley1.png', 13, 'C03', 99);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thecart`
--

CREATE TABLE `thecart` (
  `No` int(11) NOT NULL,
  `pro_Name` varchar(255) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `cart_Qty` int(5) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `total_Price` int(10) DEFAULT NULL,
  `cart_Img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thecart`
--

INSERT INTO `thecart` (`No`, `pro_Name`, `size`, `cart_Qty`, `date`, `Username`, `total_Price`, `cart_Img`) VALUES
(1, 'Black sweater', 'M', 2, '2023-05-18 12:48:34', 'user', 220, 'swt1.jpg'),
(2, 'Brown Polo', 'XL', 6, '2023-05-18 12:59:35', 'user', 330, 'pl2.jpg'),
(3, 'Brown sweater', 'XL', 1, '2023-05-18 13:01:16', 'nghiep', 55, 'swt2.jpg'),
(4, 'White henleys', 'XL', 5, '2023-05-18 13:01:29', 'nghiep', 440, 'henley1.png'),
(5, 'Brown Polo', 'M', 1, '2023-05-20 14:49:00', 'user1', 55, 'pl2.jpg'),
(6, 'White henleys', 'XL', 2, '2023-05-20 14:50:47', 'user1', 176, 'henley1.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `Username` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullName` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`Username`, `Password`, `email`, `fullName`, `address`, `telephone`, `admin`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'admin', 'VN', '123', 1),
('nghiep', '01262c2a9106788c2f4bec30ecb9f4be', 'nghiep22@gmail.com', 'nghiep', 'VN', '', 0),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com', 'user', 'VN', '1234', 0),
('user1', '24c9e15e52afc47c225b757e7bee1f9d', 'user1@gmail.com', 'User', 'VN', '123', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Cat_ID`);

--
-- Chỉ mục cho bảng `shirt`
--
ALTER TABLE `shirt`
  ADD PRIMARY KEY (`ShiID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Chỉ mục cho bảng `thecart`
--
ALTER TABLE `thecart`
  ADD PRIMARY KEY (`No`),
  ADD KEY `usrname` (`Username`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `thecart`
--
ALTER TABLE `thecart`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `shirt`
--
ALTER TABLE `shirt`
  ADD CONSTRAINT `shirt_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `category` (`Cat_ID`);

--
-- Các ràng buộc cho bảng `thecart`
--
ALTER TABLE `thecart`
  ADD CONSTRAINT `usrname` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
