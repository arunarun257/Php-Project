CREATE DATABASE Project1;
USE Project1;
CREATE TABLE `bookinventory` (
  `isbn` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `author` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `image` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `description` text COLLATE latin1_general_ci DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookinventoryorder`
--

DROP TABLE IF EXISTS `bookinventoryorder`;
CREATE TABLE `bookinventoryorder` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `customerid` int(10) UNSIGNED NOT NULL,
  `isbn` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `amount` decimal(6,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `customerid` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `lastname` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `address` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `city` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `zip_code` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `country` varchar(60) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentdetails`
--

DROP TABLE IF EXISTS `paymentdetails`;
CREATE TABLE `paymentdetails` (
  `paymentid` int(11) NOT NULL,
  `customerid` int(11) UNSIGNED NOT NULL,
  `cardnumber` varchar(19) NOT NULL,
  `expirydate` varchar(10) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `paymentdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookinventory`
--
ALTER TABLE `bookinventory`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `bookinventoryorder`
--
ALTER TABLE `bookinventoryorder`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `customerid` (`customerid`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerid`);

--
-- Indexes for table `paymentdetails`
--
ALTER TABLE `paymentdetails`
  ADD PRIMARY KEY (`paymentid`),
  ADD KEY `customerid` (`customerid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookinventoryorder`
--
ALTER TABLE `bookinventoryorder`
  MODIFY `orderid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `paymentdetails`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `bookinventoryorder`
  ADD CONSTRAINT `bookinventoryorder_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`),
  ADD CONSTRAINT `bookinventoryorder_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `bookinventory` (`isbn`);


ALTER TABLE `paymentdetails`
  ADD CONSTRAINT `paymentdetails_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`);
COMMIT;