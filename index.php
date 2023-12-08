<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pokémon store</title>
  <link rel="shortcut icon" href="https://www.narita-airport.jp/img/original/3786">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
    session_start();
    require_once "db/connect.php";
    if (isset($_COOKIE['token'])) {
      $sql = "SELECT * FROM recent_login WHERE `no` = (SELECT MAX(`no`) FROM recent_login)";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($_COOKIE['token'] == $row['token']) $_SESSION['user_id'] = $row['userID'];
      }
    }
  ?>

  <header class="container-fluid">
    <div class="row">
      <div class="col-md-2"></div>
      <a class="col-md-2 text-center" href="index.php?page=home">
        <img class="logo w-75 p-2" src="./img/Logo.png" alt="Logo">
      </a>
      <div class="col-md-8"></div>
    </div>
  </header>

  <nav class="bg-dark navbar-dark container-fluid">
    <ul class="navbar-nav">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-1">
          <li class="nav-item">
            <a class="nav-link fit-content mx-auto text-white" href="index.php?page=home">Home</a>
          </li>
        </div>
        <div class="col-md-1">
          <li class="nav-item">
            <a class="nav-link fit-content mx-auto text-white" href="index.php?page=products">Products</a>
          </li>
        </div>
        <?php 
          if (isset($_SESSION['user_id'])) {
        ?>
        <div class="col-md-1">
          <li class="nav-item">
            <a class="nav-link fit-content mx-auto text-white" href="index.php?page=hotdeal">Hot Deal</a>
          </li>
        </div>
        <?php    
          } 
        ?>
        <div class=" col-md-1">
          <li class="nav-item">
            <?php 
              if (!isset($_SESSION['user_id'])) {
            ?>
            <a class="nav-link fit-content mx-auto text-white" href="index.php?page=login">Login</a>
            <?php    
              } else {
            ?>
            <a class="nav-link fit-content mx-auto text-white" href="/page/logged/logout.php">Logout</a>
            <?php 
              }
            ?>
          </li>
        </div>
        <div class="col-md-1">
          <li class="nav-item">
            <?php 
              if (!isset($_SESSION['user_id'])) {
            ?>
            <a class="nav-link fit-content mx-auto text-white" href="index.php?page=register">Register</a>
            <?php
              }
            ?>
          </li>
        </div>
      </div>
    </ul>
  </nav>
  <main>
    <div class="row w-100 mx-auto">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <?php 
          $page = "home";
          $myArray = array("hotdeal", "home", "products", "login", 'register');
          if (isset($_GET["page"])) $page = $_GET["page"];
          if ($page == "hotdeal") include "page/logged/hotdeal/hotdeal.php";
          else if (isset($_SESSION['user_id']) && $page == 'home') include "page/logged/dashboard/dashboard.php";
          else if (in_array($page, $myArray )) include "page/" . $page . "/" . $page . ".php";
          else include "page/error/error.php";
        ?>
      </div>
      <div class="col-md-2"></div>
    </div>
  </main>
  <footer class="container-fluid bg-black py-3 mt-5">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2 footer--img text-center">
        <img class="w-100 p-2 my-auto" src="./img/Logo.png" alt="Logo">
      </div>
      <div class="col-md-5 about--us text-white d-flex flex-column justify-content-center">
        <p class="text-uppercase fw-bold fs-6 mb-2">About us</p>
        <p class="text-justify mb-2">The Pokémon Store is a virtual paradise for Pokémon enthusiasts, offering a vast
          array of official Pokémons. Fans can explore a wide variety of products featuring their favorite Pokémon
          characters, making it the ultimate destination for all things Pokémon.</p>
        <button type="button" class="btn btn-light mt-3" data-bs-toggle="modal" data-bs-target="#myModal">
          View us on Google Map
        </button>
      </div>
      <div class="col-md-3"></div>
    </div>
  </footer>
  <?php
    $conn->close();
  ?>

</html>

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Our location</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p>Click the map for more detail!</p>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5046388940455!2d106.65512307451715!3d10.77260825926519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec17709146b%3A0x54a1658a0639d341!2zxJDhuqFpIEjhu41jIELDoWNoIEtob2EgLSAyNjggTMO9IFRoxrDhu51uZyBLaeG7h3Q!5e0!3m2!1sen!2s!4v1701618065345!5m2!1sen!2s"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" class="w-100 h-100"></iframe>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>