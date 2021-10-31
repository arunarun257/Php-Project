<?php
session_start();
$title = "Checking out";
include('./template/header.php');
require('mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_SESSION['err'] = 1;
	foreach ($_POST as $key => $value) {
		if (trim($value) == '') {
			echo $value;
			$_SESSION['err'] = 0;
		}
		break;
	}
	
	if ($_SESSION['err'] == 0) {
		header("Location: checkout.php");
	} else {
		unset($_SESSION['err']);
	}
	
	$_SESSION['ship'] = array();
	foreach ($_POST as $key => $value) {
		if ($key != "submit") {
			$_SESSION['ship'][$key] = $value;
		}
	}
	extract($_SESSION['ship']);
	
	function getCustomerId($dbc, $firstname, $lastname, $address, $city, $zip_code, $country)
	{
		$query = "SELECT customerid from customers WHERE 
		firstname = '$firstname' AND
		lastname = '$lastname' AND 
		address= '$address' AND 
		city = '$city' AND 
		zip_code = '$zip_code' AND 
		country = '$country'";
		$result = mysqli_query($dbc, $query);
		if ($result && mysqli_num_rows($result) != 0) {
			$row = mysqli_fetch_assoc($result);
			return $row['customerid'];
		} else {
			return null;
		}
	}
	
	function getCustomerPayment($dbc, $customerid, $cardnumber, $expirydate, $cvv)
	{
		$date = date("Y-m-d H:i:s");
		$query = "SELECT customerid from paymentdetails WHERE 
		customerid = $customerid AND
		cardnumber = $cardnumber AND
		expirydate = $expirydate AND
		cvv = $cvv AND
		paymentdate = $date";
		$result = mysqli_query($dbc, $query);
		if ($result && mysqli_num_rows($result) != 0) {
			$row = mysqli_fetch_assoc($result);
			return $row['customerid'];
		} else {
			return null;
		}
	}
	
	function setPaymentCustomerDetails($dbc, $customerid, $cardnumber, $expirydate, $cvv)
	{
		$date = date("Y-m-d H:i:s");
		$query1 = "INSERT INTO paymentdetails VALUES 
			(DEFAULT, $customerid, '" . $cardnumber . "', '" . $expirydate . "', $cvv, '" . $date . "')";
		$result1 = mysqli_query($dbc, $query1);
		if (!$result1) {
			echo "1" . mysqli_error($dbc);
			exit;
		}
	}
	
	function setCustomerId($dbc, $firstname, $lastname, $address, $city, $zip_code, $country, $cardnumber, $expirydate, $cvv, $date)
	{
		$query = "INSERT INTO customers VALUES 
			('', '" . $firstname . "', '" . $lastname . "', '" . $address . "', '" . $city . "', '" . $zip_code . "', '" . $country . "')";
	
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "2" . mysqli_error($dbc);
			exit;
		}
		$customerid = mysqli_insert_id($dbc);
		$query1 = "INSERT INTO paymentdetails VALUES 
			(DEFAULT, $customerid,'" . $cardnumber . "', $expirydate, $cvv, '" . $date . "')";
		$result1 = mysqli_query($dbc, $query1);
		if (!$result1) {
			echo "3" . mysqli_error($dbc);
			exit;
		}
	
		return $customerid;
	}
	
	function insertIntoOrder($dbc, $customerid, $isbn, $price, $date)
	{
		$query = "INSERT INTO bookinventoryorder VALUES 
		('', '" . $customerid . "', '" . $isbn ."', '" . $price . "', '" . $date . "' )";
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "4" . mysqli_error($dbc);
			exit;
		}
	}
	
	function getbookprice($dbc, $bookimage)
	{
		$query = "SELECT price FROM bookinventory WHERE image = '$bookimage'";
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "5" . mysqli_error($dbc);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['price'];
	}

	function getbookisbn($dbc, $bookimage)
	{
		$query = "SELECT isbn FROM bookinventory WHERE image = '$bookimage'";
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "6" . mysqli_error($dbc);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['isbn'];
	}
	
	function getOrderId($dbc, $customerid)
	{
		$query = "SELECT orderid FROM bookinventoryorder WHERE customerid = '$customerid' ORDER BY orderid DESC";
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "7" . mysqli_error($dbc);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['orderid'];
	}
	
	function updateBook($dbc, $bookimage)
	{
		$query = "UPDATE bookinventory SET  
		book_purchased = '1'
		WHERE image = $bookimage";
		echo $query .  " ," . $bookimage;
		$result = mysqli_query($dbc, $query);
		if (!$result) {
			echo "Can't update data " . mysqli_error($dbc);
			exit;
		}
	}
	
	$customerid = getCustomerId($dbc, $firstname, $lastname, $address, $city, $zip_code, $country);
	
	if ($customerid == null) {
		$date = date("Y-m-d H:i:s");
		$customerid = setCustomerId($dbc, $firstname, $lastname, $address, $city, $zip_code, $country, $cardnumber, $expirydate, $cvv, $date);
	} else {
		$paymentCustomerId = getCustomerPayment($dbc, $customerid, $cardnumber, $expirydate, $cvv);
		if ($paymentCustomerId == null) {
			$paymentCustomerId = setPaymentCustomerDetails($dbc, $customerid,  $cardnumber, $expirydate, $cvv);
		}
	}

	$isbn = '';
	
	foreach ($_SESSION['cart'] as $bookimage => $qty) {
		$isbn = getbookisbn($dbc, $bookimage);
		$price = getbookprice($dbc, $bookimage);
	}
	
	$date = date("Y-m-d H:i:s");

	insertIntoOrder($dbc, $customerid, $isbn, $price, $date);
	
	$orderid = getOrderId($dbc, $customerid);
	
	foreach ($_SESSION['cart'] as $bookimage => $qty) {
		$bookprice = getbookprice($dbc, $bookimage);
	
		$s = "SELECT quantity FROM bookinventory WHERE image = '{$bookimage}'";
		$result = mysqli_query($dbc, $s);
	
		$s = "SELECT quantity FROM bookinventory WHERE image = '{$bookimage}'";
		$result = mysqli_query($dbc, $s);
		$val = mysqli_fetch_array($result)['quantity'];
	
		$queryUpdate = "UPDATE bookinventory SET  
		quantity = ($val - $qty)
		WHERE image = '{$bookimage}'";
		$result = mysqli_query($dbc, $queryUpdate);
	}
	
	session_unset();
	?>
	<h1 class="text-center text-success">Order sucessfully placed.</h1>
	<?php
	}

if (isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
?>
		<form id="basic-form" method="post" action="checkout.php" class="form-horizontal">
		<div class="form-group">
			<label for="name" class="control-label">First Name</label>
			<div >
				<input type="text" name="firstname" placeholder="First Name" class="form-control" required>
			</div>
		</div>

		<div class="form-group">
			<label for="name" class="control-label">Last Name</label>
			<div >
				<input type="text" name="lastname" placeholder="Last Name" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="control-label">Address</label>
			<div >
				<input type="text" name="address" placeholder="Address" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="control-label">City</label>
			<div >
				<input type="text" name="city" placeholder="City" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="zip_code" class="control-label">Zip Code</label>
			<div >
				<input type="text" name="zip_code" placeholder="Zip Code" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="country" class="control-label">Country</label>
			<div >
				<input type="text" name="country" placeholder="Country" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="cardnumber" class="control-label">Card Number</label>
			<div >
				<input type="tel" name="cardnumber" pattern="[0-9\s]{13,19}" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="expirydate" class="control-label">Expiry Date</label>
			<div >
				<input type="date" name="expirydate" placeholder="yyyy-mm-dd" min="2022-01-01" max="2030-12-31" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="cvv" class="control-label">CVV</label>
			<div >
				<input type="tel" name="cvv" pattern="^\d{1,3}$" placeholder="xxx" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<div>
			</div>
			<div>
				<input type="submit" name="submit" value="Purchase" class="btn btn-warning">
			</div>
			<div>
			</div>
		</div>
	</form>
<?php
} else {
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
}

if (isset($dbc)) {
	mysqli_close($dbc);
}
include('./template/footer.php');

?>
