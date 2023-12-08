<?php
if (isset($_SESSION['user_id'])) {
  $retrieve_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE userID = '$retrieve_id'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
?>

<div class="row justify-content-between mx-auto">
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
  <div class="col-md-8 border border-secondary rounded-3 pt-4 ps-4 mt-5">
    <h2 class="mb-3">Purchase statistic</h2>
    <div class="row">
      <div class="col-md-6">
        <h4><span class="display-3">
            <?php echo $row['orders'] ?>
          </span></h4>
        <p>Orders</p>
      </div>
      <div class="col-md-6">
        <h4>$<span class="display-3"><?php echo $row['buys'] ?></span></h4>
        <p>Dollars</p>
      </div>
    </div>
  </div>

  <div class="container-fluid border border-secondary rounded-3 pt-4 ps-4 mt-5 mb-5">
    <h2 class="mb-3">Variant statistic</h2>
    <div class="w-75 mx-auto mt-4">
      <div class="progress mb-4">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
          style="width:<?php echo $row['fire'] ?>%">
          <?php echo $row['fire'] ?>%F
        </div>
      </div>
      <div class="progress mb-4">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
          style="width:<?php echo $row['water'] ?>%">
          <?php echo $row['water'] ?>%W
        </div>
      </div>
      <div class="progress mb-4">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
          style="width:<?php echo $row['grass'] ?>%">
          <?php echo $row['grass'] ?>%G
        </div>
      </div>
      <div class="progress mb-4">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
          style="width:<?php echo $row['electric'] ?>%">
          <?php echo $row['electric'] ?>%E
        </div>
      </div>
    </div>
  </div>
</div>
<?php  
}
?>