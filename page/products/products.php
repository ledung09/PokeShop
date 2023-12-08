<?php 
require_once "db/connect.php";
if (isset($_GET['id'])) {
  $product_id = $_GET['id'];
  if (!is_numeric($product_id)) {
    include "./page/error/noproduct.php";
  } else {
    $sql = "SELECT * FROM `products` WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      include "./page/error/noproduct.php";
    } else {
      $row = $result->fetch_assoc();
?>
<div class="row mt-5 mb-4 d-flex align-items-center">
  <div class="col-md-4 d-flex justify-content-center ">
    <img class="w-75" src="<?php echo $row['productImg']; ?>" alt="Pokeon-Image">
  </div>
  <div class="col-md-8 px-5">
    <h1 class="mb-3 text-capitalize fw-bold fst-italic"><?php echo $row['productName']; ?></h1>
    <h5 class="mb-4 fst-italic">Rating:
      <?php echo $row['productRating']; ?><span class="text-warning">&starf;</span>
    </h5>
    <?php 
    if (isset($_SESSION['user_id'])){
      $u_id = $_SESSION['user_id'];

      $sql1 = "SELECT * FROM users WHERE userID = ?";
      $stmt1 = $conn->prepare($sql1);
      $stmt1->bind_param("s", $u_id);
      $stmt1->execute();
      $result1 = $stmt1->get_result();
      $row1 = $result1->fetch_assoc();
      $stmt1->close();
        
      if ($row1['level'] >= 3 && $row['productHot'] == 1) {
?>
    <div class="row">
      <div class="col-md-6">
        <h2>$<span class="display-2 text-decoration-line-through"><?php echo $row['productPrice']-0 ?></span></h2>
        <p>Original Price</p>
      </div>
      <div class="col-md-6">
        <h2 class="text-danger">$<span class="display-2"><?php echo $row['productPrice']-10 ?></span></h2>
        <p class="text-danger">New Price</p>
      </div>
    </div>
    <p class="text-danger">*Exclusive deal for user with level ≥ 3!</p>
    <?php
      } else {
?>
    <h2>$<span class="display-2"><?php echo $row['productPrice']-0 ?></span></h2>
    <?php
      }
    } else {
      ?>
    <h2>$<span class="display-2"><?php echo $row['productPrice']-0 ?></span></h2>
    <?php
    }
    ?>
  </div>
</div>
<h5 class="mt-3 mb-4 px-5" style="text-align: justify;">
  <u>Description:</u>&nbsp;<?php echo $row['productDes'] ;?>
</h5>
<div class="mb-3 d-flex justify-content-end px-5">
  <a href="/index.php?page=products" class="text-decoration-none fs-6 link-opacity-75-hover mb-4">
    << Go to Products page </a>
</div>
<?php
    }  
  }
} else {
  if (isset($_SESSION['user_id'])) {
    $retrieve_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE userID = ?";
    $result = $conn->prepare($sql);
    $result->bind_param("s", $retrieve_id);
    $result->execute();
    $row = $result->get_result()->fetch_assoc();
    
    $sql1 = "SELECT * FROM products ORDER BY `productPrice` DESC LIMIT 1";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
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
  <a href="<?php echo "/index.php?page=products&id=" . $row1['productID'] ?>"
    class="col-md-8 text-decoration-none text-black px-0">
    <div class="border border-secondary rounded-3 pt-3 ps-4 mt-5">
      <h2 class="mb-2">Top price</h2>
      <div class="row fav--product w-100">
        <div class="col-md-2"></div>
        <div class="col-md-4">
          <img class="w-75" src="<?php echo $row1['productImg'] ?>" alt="Product-image">
        </div>
        <div class="fav--info col-md-4 d-flex flex-column justify-content-center">
          <p class="mb-1 fs-4"><?php echo $row1['productName'] ?></p>
          <h4>$<span class="display-5"><?php echo $row1['productPrice'] ?></span></h4>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </a>
</div>
<?php
  }
?>
<?php 
$query = "";
if (!isset($_GET['query'])) {
  $limpp = 10;
  $query = "SELECT * FROM `products` LIMIT $limpp";
  
  if (isset($_GET['items_per_page']) && isset($_GET['product_page'])) {
    $itempp = $_GET['items_per_page'];
    $startid = ($_GET['product_page'] - 1) * $_GET['items_per_page'];
    $query = "SELECT * FROM `products` WHERE productID > $startid ORDER BY productID LIMIT $itempp";
  }
} else {
  $asciiRegex = '/^[ -~]+$/';
  $inputValue = $_GET['query'];
  if (preg_match($asciiRegex, $inputValue) && strlen($inputValue) < 255) {
    $query = "SELECT * FROM `products` WHERE productName LIKE ?";
  }
}
$stmt = $conn->prepare($query);
if (isset($_GET['query'])) {
  $inputValue = '%' . strtolower($_GET['query']) . '%';
  $stmt->bind_param("s", $inputValue);
}
?>
<div class="row mt-5 mb-md-0 mb-4">
  <div class="col-md-6 mb-md-2 mb-3">
    <h3 class="">Your future companions here 👇</h3>
  </div>
  <div class="col-md-5 ms-auto position-relative" style="height: 37.6px;">
    <form id="search-form" class="input-group position-absolute" style="width:90%;" action="" method="post">
      <div id="search-whole" class="w-75">
        <input type="text" id="search-input" class="form-control px-3 shadow-none" placeholder="Search your Pokémon?"
          value="<?php echo isset($_GET['query']) ? $_GET['query'] : "" ?>">
        <div id="search-result" class="list-group list-group-flush w-100">
        </div>
      </div>
      <button id="search-btn" class="btn btn-success" style="height: 37.6px;" type="submit">Go</button>
    </form>
  </div>
</div>
<div class="form-check mt-2">
  <input type="radio" class="form-check-input" id="radio1" name="displayRadio" value="lazyloading">
  <label class="form-check-label" for="radio1">Lazy loading</label>
</div>
<div class="mt-2">
  <div class="d-flex gap-1">
    <div class="form-check mb-2">
      <input type="radio" class="form-check-input" id="radio2" name="displayRadio" value="pagination">
      <label class="form-check-label" for="radio2">Pagination (items per page</label>
    </div>
    <div class="d-flex">
      <select name="ippage" id="pageitemsl" class="h-fit">
        <option value="5">5</option>
        <option value="10">10</option>
      </select>
      )
    </div>
  </div>

</div>

<?php
  if ($query == "") {
    // Invalid user input
    include "./page/error/inputlength.php";
?>
<script>
alert("Invalid input! Input contains only ASCII characters and has length < 255!");
</script>
<?php    
  } else {
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) {
      // No result return from database
  ?>
<?php 
    include "./page/error/noproduct.php";
?>
<script>
alert("No Pokémon found in the database!");
</script>
<?php
    }
    else {
?>
<div class="row mt-1 mb-5 mx-auto row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gy-5"
  id="productList">
  <?php
      while ($row = $res->fetch_assoc()) { ?>
  <div class="col d-flex justify-content-center">
    <div class="w-100 border border-secondary rounded-3 ">
      <a href="<?php echo "/index.php?page=products&id=" . $row['productID']; ?>"
        class="w-100 d-flex flex-column align-items-center text-decoration-none text-black">
        <h4 class="mt-2">
          <?php echo $row['productName']; ?>
        </h4>
        <img src="<?php echo $row['productImg'] ?>" alt="<?php echo "product-" . $row['productID']?>">
        <p>
          $<?php echo $row['productPrice']; ?>
        </p>
      </a>
    </div>
  </div>
  <?php 
      }
    } 
  }
  ?>

</div>


<!-- LazyLoading / Pagination -->
<script>
const pageItemSL = document.getElementById("pageitemsl")
const radio1 = document.getElementById("radio1")
const radio2 = document.getElementById("radio2")


pageItemSL.addEventListener("change", () => {
  window.location.href = `/index.php?page=products&items_per_page=${pageItemSL.value}&product_page=1`;
})
</script>
<?php 
if (isset($_GET['items_per_page']) && isset($_GET['product_page'])) {
  $itemperpage = $_GET['items_per_page'];
  $productpage = $_GET['product_page'];
  $productpage_max = ceil(21/$itemperpage);
  $pageperlist = 3;
  $pageperlistmid = 2;

?>
<div class="row mb-5" id="pageNav">
  <ul class="pagination d-flex justify-content-center">
    <?php 
      if ($productpage > 1) {
    ?>
    <li class="page-item-nav"><a class="page-link"
        href="<?php echo'/index.php?page=products&items_per_page=' . $itemperpage . '&product_page=' . ($productpage - 1);?>">Previous</a>
    </li>
    <?php
      }
        if ($productpage <= $pageperlistmid) {
          for ($i = 0; $i < $pageperlist; $i++) {
    ?>
    <li class="page-item"><a class="page-link page-link-nav"
        href="<?php echo'/index.php?page=products&items_per_page=' . $itemperpage . '&product_page=' . ($i+1);?>">
        <?php echo ($i + 1);?>
      </a></li>
    <?php
          }
        } else if ($productpage + $pageperlistmid > $productpage_max) {
          for ($i = $productpage_max-$pageperlist; $i < $productpage_max; $i++) {
            ?>
    <li class="page-item"><a class="page-link page-link-nav"
        href="<?php echo'/index.php?page=products&items_per_page=' . $itemperpage . '&product_page=' . ($i+1);?>">
        <?php echo ($i + 1);?>
      </a></li>
    <?php
          }
        } else {
          for ($i = $productpage-$pageperlistmid; $i < $productpage + $pageperlistmid - 1; $i++) {
            ?>
    <li class="page-item"><a class="page-link page-link-nav"
        href="<?php echo'/index.php?page=products&items_per_page=' . $itemperpage . '&product_page=' . ($i+1);?>">
        <?php echo ($i + 1);?>
      </a></li>
    <?php
          }
        }
    ?>
    <!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li> -->
    <?php 
      if ($productpage < $productpage_max) {
    ?>
    <li class="page-item-nav"><a class="page-link"
        href="<?php echo'/index.php?page=products&items_per_page=' . $itemperpage . '&product_page=' . ($productpage + 1);?>">Next</a>
    </li>
    <?php
      }
    ?>
  </ul>
</div>
<script>
radio1.checked = false;
radio2.checked = true;
pageItemSL.value = parseInt(<?php echo $_GET['items_per_page']; ?>);

const activePages = document.getElementsByClassName('page-item');
const linkPages = document.getElementsByClassName('page-link-nav');

for (let i = 0; i < activePages.length; i++) {
  activePages[i].classList.remove('active');
  if (<?php echo $productpage;?> === parseInt(linkPages[i].textContent)) {
    activePages[i].classList.add('active');
  }
}
</script>
<?php
} else {
?>
<script>
radio1.checked = true;
radio2.checked = false;
</script>
<?php
}
?>
<!-- Script for DOM handling -->
<script>
const searchForm = document.getElementById("search-form");
const searchWhole = document.getElementById("search-whole");
const searchInput = document.getElementById("search-input");
const searchBtn = document.getElementById("search-btn");
const searchResult = document.getElementById("search-result");

var inputTxt = searchBtn.value;
var productName = [];

searchForm.addEventListener("submit", (e) => {
  e.preventDefault();
  var inputValue = searchInput.value;
  var asciiRegex = /^[ -~]+$/;
  if (asciiRegex.test(inputValue) || inputValue === "") {
    var url = "index.php?page=products";
    if (inputValue.length > 254) {
      alert("Input length is more than 254 characters");
    } else {
      if (inputValue !== "")
        url += "&query=" + encodeURIComponent(inputValue);
      window.location.href = url;
    }
  } else {
    alert("Invalid input! Please enter only ASCII characters.");
  }
});

searchInput.addEventListener("focus", () => {
  searchWhole.style.boxShadow = "0 0 0 0.25rem rgba(13,110,253,.25)";
  searchWhole.style.borderColor = "#86b7fe";
  searchWhole.style.borderRadius = "0.375rem";
  searchResult.style.display = "block";
})

searchInput.addEventListener("blur", () => {
  searchWhole.style.boxShadow = "none";
  searchWhole.style.borderColor = "dee2e6";
  searchResult.style.display = "none";
})
</script>

<!-- Script for AJAX -->
<script>
const xhttp = new XMLHttpRequest();
xhttp.open("GET", "/server/server_item.php", true);
xhttp.setRequestHeader("Content-Type", "text/xml");
xhttp.onload = function() {
  if (xhttp.status === 200) {
    var xmlDoc = xhttp.responseXML;
    var products = xmlDoc.getElementsByTagName('product');
    var output = '';
    for (var i = 0; i < products.length; i++) {
      var id = products[i].getElementsByTagName('id')[0].textContent;
      var name = products[i].getElementsByTagName('name')[0].textContent;
      var price = products[i].getElementsByTagName('price')[0].textContent;
      output += 'ID: ' + id + ' - ProductName: ' + name + ' - Price: $' + price + '<br>';
      productName.push({
        id: id,
        name: name
      });
    };
    if (products.length === 0) response.innerHTML = "No item in `products` table!";
  } else console.error("Request fail. Status: " + xhttp.status);
};
xhttp.send();
</script>

<!-- Script for search result -->
<script>
searchForm.addEventListener("keyup", (e) => {
  const searchText = e.target.value;
  searchResult.innerHTML = "";
  if (searchText.length !== 0) {
    productName.forEach((product) => {
      if (product.name.toLowerCase().startsWith(searchText.toLowerCase())) {
        searchResult.innerHTML +=
          `<div 
          onmousedown="window.location.href = '/index.php?page=products&id=${product.id}';"
          class="list-group-item list-group-item-action" style='cursor: pointer'
          >
            ${product.name}
          </div>`;
      }
    })
    const lastChild = document.querySelector('#search-result:last-child');
    if (lastChild) lastChild.style.borderRadius = '0.375rem';
  }
})
</script>

<script>
var displayBtns = document.querySelectorAll('input[name="displayRadio"]');
displayBtns.forEach(function(displayBtn) {
  displayBtn.addEventListener('change', function() {
    if (this.value === "lazyloading") {
      window.location.href = "index.php?page=products";
    } else {
      window.location.href = `index.php?page=products&items_per_page=${pageItemSL.value}&product_page=1`;
    }
    // This function will be called when any radio button is selected
    console.log('Selected color:', this.value);
  });
});
</script>

<?php 
if (!isset($_GET['items_per_page']) || !isset($_GET['product_page'])) {
  

?>
<!-- Check scroll  -->
<script>
// Scroll to top
document.addEventListener('DOMContentLoaded', function() {
  window.scrollTo(0, 0);
});

const productList = document.getElementById('productList');
var startID = 1;

window.onscroll = function() {
  var windowHeight = window.innerHeight; // Viewport height
  var body = document.body; // Body element
  var html = document.documentElement; // HTML element
  var documentHeight = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html
    .offsetHeight); // Total document height
  var scrollTop = window.pageYOffset || html.scrollTop || body.scrollTop; // Scroll position

  // Check if the user has scrolled to the bottom
  if (scrollTop + windowHeight >= documentHeight - 1) {
    if (startID < 50) startID += 5;
    // console.log(startID)
    xhttp.open("GET", `/server/server_getitem.php?startID=${startID}`, true);
    xhttp.onload = function() {
      if (xhttp.status === 200) {
        console.log(xhttp.response)
        productList.innerHTML += xhttp.response
        if (xhttp.response.length === 0) {
          // End of list 
        };
      } else console.log("xxx");
    };
    xhttp.send();
  }
};
</script>



<?php 
  }
}
?>