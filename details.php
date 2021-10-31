<?php
session_start();
$image = $_GET['book'] . '.jpg';
require('mysqli_connect.php');

$query = "SELECT * FROM bookinventory WHERE image = '$image'";
$result = mysqli_query($dbc, $query);
if (!$result) {
  echo "Can't retrieve data " . mysqli_error($dbc);
  exit;
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
  echo "No books!";
  exit;
}

$title = $row['title'];
include('./template/header.php');
?>
<div class="row">
  <div class="flex-center">
    <img class="img-responsive img-thumbnail" src="./image/books/<?php echo $row['image']; ?>">
    <h3>Book Title</h3>
    <p><?php echo $row['title']; ?></p>
    <h3>Book Description</h3>
    <p><?php echo $row['description']; ?></p>
    <h3>Book Details</h3>
    <table style="width: 20em;" class="table">
      <?php 
      $tableHeadArray = [
        "isbn" => "ISBN",
        "title" => "Title",
        "author" => "Author",
        "price" => "Price",
        "quantity" => "Quantity"
      ];
      foreach ($row as $key => $value) {
        if ($key == "description" || $key == "image" || $key == "title") {
          continue;
        }
        $key = $tableHeadArray[$key];
      ?>
        <tr>
          <th><?php echo $key; ?></th>
          <td><?php echo $value; ?></td>
        </tr>
      <?php
      }
      if (isset($dbc)) {
        mysqli_close($dbc);
      }
      ?>
    </table>
    <form method="post" action="cart.php">
      <input type="submit" value="Buy now" name="cart" class="btn btn-warning">
      <input type="hidden" name="book" value="<?php echo $image; ?>">
    </form>
  </div>
</div>
<?php
include('./template/footer.php');
?>