<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "OnlineStore";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$startID = $_GET['startID'];

$sql = 'SELECT * FROM `products` WHERE productID > ' . $startID . ' ORDER BY productID LIMIT 5';
$result = $conn->query($sql);

$res = "";

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$productID = $row['productID'];
$productName = $row['productName'];
$productImg = $row['productImg'];
$productPrice = $row['productPrice'];
$res .= '
<div class="col d-flex justify-content-center">
<div class="w-100 border border-secondary rounded-3 ">
  <a href="/index.php?page=products&id=' . $productID . '"
class="w-100 d-flex flex-column align-items-center text-decoration-none text-black">
<h4 class="mt-2">
  ' . $productName . ' 
</h4>
<img src="' . $productImg .'" alt="product-' . $productID . '">
<p>
  $' . $productPrice . '
</p> 
</a>
</div>
</div>
';
}
}

$conn->close();
echo $res;
?>