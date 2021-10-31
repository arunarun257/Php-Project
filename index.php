<?php
session_start();

$title = "Home";
include('./template/header.php');
require('mysqli_connect.php');
?>

      <div class="flex-center">
        <h2>About the Author</h2>
        <img class="img-responsive img-thumbnail author-img mb-5" src="./image/author/Chetan.jpg">
        <p><b>Chetan Bhagat</b>(born 22 April 1974)[2] is an Indian author and columnist. He was included in Time magazine's list of World's 100 Most Influential People in 2010. Chetan Bhagat tracks his writing journey that commenced in 2004 with his first book, <b>Five Point Someone, a campus caper</b>, and has reached book No 11, India Positive, which is on national affairs..</p>
        <h3>Notable Accolades</h3>
        <ul>
          <li>Featured on Time magazine's list of World's 100 Most Influential People of 2010 in the Artists category</li>
          <li>Listed '47' among the "100 Most Creative People 2011" by the Fast Company American business magazine and business media brand</li>
          <li>Won the "CNN-IBN Indian of the Year 2014" award in the Entertainment category</li>
          <li>Ranked No. 82 on the 2017 Forbes India Celebrity 100 list.</li>
        </ul>
      </div>

<?php
include('./template/footer.php');
?>