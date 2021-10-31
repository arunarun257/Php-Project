<?php

session_start();
$title = "Shopping cart";
include('./template/header.php');
require('mysqli_connect.php');

if (isset($_POST['book'])) {
	$bookimage = $_POST['book'];
}

function getBookByImage($dbc, $image)
{
	$query = "SELECT title, author, price FROM bookinventory WHERE image = '$image'";
	$result = mysqli_query($dbc, $query);
	if (!$result) {
		echo "Can't retrieve data " . mysqli_error($dbc);
		exit;
	}
	return $result;
}

if (isset($bookimage)) {
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
		$_SESSION['total_price'] = '0.00';
	}

	if (!isset($_SESSION['cart'][$bookimage])) {
		$_SESSION['cart'][$bookimage] = 1;
	}
}

if (isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
?>
	<form action="cart.php" method="post">
		<table class="table">
			<thead class="table-dark">
				<tr>
					<th>Item</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($_SESSION['cart'] as $image => $qty) {
					$book = mysqli_fetch_assoc(getBookByImage($dbc, $image));
				?>
					<tr>
						<td><?php echo $book['title']; ?></td>
						<td><?php echo "$" . $book['price']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>
	<br /><br />
	<div class="text-center w-100">
		<a href="checkout.php" class="btn btn-warning text-center">Checkout now</a>
	</div>

<?php
} else {
	echo "<p class=\"text-warning\">Empty cart!</p>";
}
if (isset($dbc)) {
	mysqli_close($dbc);
}
include('./template/footer.php');
?>
