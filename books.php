<?php
  session_start();
  $title = "All Books";
  $count = 0;

  include('./template/header.php');
  require('mysqli_connect.php');

  $query = "SELECT isbn, image FROM bookinventory WHERE quantity != 0 ORDER BY isbn DESC";
  $result = mysqli_query($dbc, $query);
  if(!$result){
    echo "Can't retrieve data " . mysqli_error($dbc);
    exit;
  }
?>
  <p class="lead text-center text-muted">Select a book to begin your Epic journey!</p>
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="details.php?book=<?php echo substr($query_row['image'], 0, -4); ?>">
              <img class="img-responsive img-thumbnail mb-5" src="./image/books/<?php echo $query_row['image']; ?>">
            </a>
          </div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
<?php
      }
  if(isset($dbc)) { mysqli_close($dbc); }
  include('./template/footer.php');
?>