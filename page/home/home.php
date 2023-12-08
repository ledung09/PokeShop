<?php 
  if (!isset($_SESSION['user_id'])) {
?>
<div class="row mt-5 mx-auto">
  <div class="col-md-6 d-flex justify-content-center mb-md-0 mb-4">
    <img class="w-75" src="../../img/home/Banner.jpg" alt="Banner">
  </div>
  <div class="col-md-6 d-flex flex-column justify-content-center">
    <h1 class="text-uppercase text-center mb-3" style="line-height: 1.3;">Get your shopping output today</h1>
    <p class="text-center mb-4">Tens of Pokemon are ready to be picked!</p>
    <div class="d-flex justify-content-center gap-4 mt-1">
      <a href="index.php?page=login">
        <button type="button" class="btn btn-primary text-center">Login</button>
      </a>
      <a href="index.php?page=products">
        <button type="button" class="btn btn-warning text-center">Purchase Pokemons</button>
      </a>
    </div>
  </div>
</div>
<h3 class="mt-5 ms-3">These amazing creatures are waiting for you...</h3>
<div class="row mt-4 mb-5 mx-auto">
  <img src="../../img/home/Hero1.jpg" alt="Hero1">

</div>
<h3 class="mt-5 me-3 text-end">Start your journey today!</h3>
<div class="row mt-4 mb-5 mx-auto">
  <img src="../../img/home/Hero2.jpg" alt="Hero2">
</div>
<?php    
  } 
?>