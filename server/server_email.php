<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "OnlineStore";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = 'SELECT `username` FROM `users`';
$result = $conn->query($sql);
$xml = new SimpleXMLElement('<data/>');
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $item = $xml->addChild('user', $row['username']);
  }
}

$conn->close();
header('Content-Type: application/xml');
echo $xml->asXML();
?>