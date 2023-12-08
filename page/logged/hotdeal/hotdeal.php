<?php 
require_once "db/connect.php";
if (!isset($_SESSION['user_id'])) {
  echo '<br>';
  echo "Page not avalaible!\n";
  echo '<br>';
  echo "This page is for logged in user only!\n";
  echo '<br>';
  echo "Please login to access!\n";
  echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
} else {
  $retrieve_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE userID = '$retrieve_id'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
?>
<?php
  if ($row['level'] < 3) {
?>
<h4 class="mt-5 mb-0 text-danger">* Hot Deal are only available for level ≥3 user only!</h4>
<?php    
  }
?>
<div class="row justify-content-between mx-auto mb-2">
  <div
    class="col-md-3 profile--info border border-secondary rounded-3 d-flex flex-column align-items-center justify-content-center mt-5">
    <img class="profile--img w-50" src="https://cdn-icons-png.flaticon.com/512/6676/6676023.png" alt="profile-img">
    <h5>
      <?php echo $row['fullname']?>
    </h5>
    <i class="mb-2">
      Level <?php echo $row['level'] ?>
    </i>
  </div>
  <?php
  if ($row['level'] < 3) {
  ?>
  <div class="col-md-8 pt-4 ps-4 mt-5">
    <h5 class="mb-3">⚠️&nbsp;Your current level: <span class="text-danger"><?php echo $row['level'] ?></span></h5>
    <h4>Sorry, there is no Hot Deal for you!</h4>
  </div>
  <?php    
  } else {
    $sql1 = "SELECT * FROM products WHERE productHot = 1";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows == 0) {
    } else {
      while ($r = $result1->fetch_assoc()) {
  ?>
  <a href="<?php echo "/index.php?page=products&id=". $r['productID']; ?>"
    class="col-md-8 text-decoration-none text-black mt-5 px-0">
    <div class="border border-secondary rounded-3 pt-3 ps-4">
      <h2 class="mb-3"><?php echo $r['productName'] ?></h2>
      <div class="row mb-2">
        <div class="col-md-4">
          <img src="<?php echo $r['productImg'] ?>" alt="Product-image">
        </div>
        <div class="col-md-4">
          <h3>$<span class="display-3 text-decoration-line-through"><?php echo $r['productPrice']-0 ?></span></h3>
          <p>Original Price</p>
        </div>
        <div class="col-md-4">
          <h3 class="text-danger">$<span class="display-3"><?php echo $r['productPrice']-10 ?></span></h3>
          <p class="text-danger">New Price</p>
        </div>
      </div>
    </div>
  </a>
  <div class="col-md-3 mt-5"></div>
  <?php
    }
  }
  ?>
</div>
<?php
  }
}

?>