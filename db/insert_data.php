<!-- <script>
var name = []
const xhttp = new XMLHttpRequest();
xhttp.open("GET", "https://pokeapi.co/api/v2/pokemon?limit=10&offset=0", true);
xhttp.onload = function() {
  if (xhttp.status === 200) {
    name = JSON.parse(xhttp.response);
    console.log(xhttp.response.results)
  } else {
    console.error("Request fail. Status: " + xhttp.status);
  }
};
xhttp.send();
</script> -->

<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "OnlineStore";
  $conn = new mysqli($host, $username, $password);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
  $sql = "CREATE DATABASE IF NOT EXISTS $database";
  if ($conn->query($sql)) echo "*Database 'OnlineStore' created successfully!<br>";
  else echo "Error creating database: " . $conn->error. "<br>";
  $conn->select_db($database);

  // Table products
  $sql = "CREATE TABLE IF NOT EXISTS `products` (
    `productID` int(11) NOT NULL,
    `productName` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `productPrice` decimal(6,2) NOT NULL,
    `productImg` varchar(300) NOT NULL,
    `productHot` tinyint(1) NOT NULL,
    `productRating` decimal(2,1) NOT NULL,
    `productDes` varchar(255) NOT NULL,
    PRIMARY KEY (`productID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
  
  if ($conn->query($sql)) echo "*Table 'products' created successfully!<br>";
  else echo "Error creating table: " . $conn->error. "<br>";

  $sql = "INSERT INTO `products` (`productID`, `productName`, `productPrice`, `productImg`, `productHot`, `productRating`, `productDes`) VALUES
  (1, 'bulbasaur', 19.99, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png', 0, 4.2, 'Bulbasaur, the adorable Grass/Poison Pokémon, is a classic starter known for its versatility and evolving into the mighty Venusaur.'),
  (2, 'ivysaur', 21.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/2.png', 0, 4.3, 'Ivysaur, the graceful Grass/Poison Pokémon, bridges the gap between Bulbasaur and Venusaur. With budding potential, it embodies both charm and budding strength.'),
  (3, 'venusaur', 54.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/3.png', 0, 3.7, 'Venusaur, the majestic Grass/Poison Pokémon, commands respect with its imposing flower. A pinnacle of strength and loyalty, it\'s the evolved gem in the Bulbasaur line.'),
  (4, 'charmander', 34.64, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png', 0, 4.4, 'Charmander, the fiery friend, starts as a small flame with big potential. Its evolution into Charizard marks a journey of growing strength and fiery prowess.'),
  (5, 'charmeleon', 56.54, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/5.png', 0, 4.6, 'Charmeleon, the fiery rebel, blazes a path toward strength. This Fire-type, evolving from Charmander, hints at the imminent power of the formidable Charizard.'),
  (6, 'charizard', 23.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png', 0, 4.8, 'Charizard, the fiery powerhouse, dominates the skies with independence and relentless strength.'),
  (7, 'squirtle', 45.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png', 1, 4.1, 'Squirtle, the Water-type buddy, brings playfulness and resilience. Evolving into Blastoise, it\'s a force to be reckoned with in battles.'),
  (8, 'wartortle', 74.58, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/8.png', 0, 4.3, 'Wartortle, the Water-type gem, strikes a balance of charm and tenacity on its evolution path towards the formidable Blastoise.'),
  (9, 'caterpie', 40.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/9.png', 1, 3.2, 'Caterpie, the Bug-type cutie, evolves into the speedy Butterfree. A small crawler with big potential in the Pokémon world.'),
  (10, 'metapod', 45.39, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/11.png', 0, 2.5, 'Metapod, the cocoon Pokémon, embodies patience and resilience in the evolution from Caterpie to the graceful Butterfree.'),
  (11, 'butterfree', 23.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/12.png', 0, 3.7, 'Butterfree, the elegant Bug/Flying Pokémon, showcases beauty in transformation. Evolving from Caterpie, it graces the skies with gentle charm.'),
  (12, 'weedle', 34.93, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/13.png', 0, 2.7, 'Weedle, the Poison/Bug Pokémon, evolves into the formidable stinger Beedrill. Small but packing a venomous punch in the Pokémon world.'),
  (13, 'kakuna', 48.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/14.png', 1, 2.0, 'Kakuna, the cocoon Pokémon, readies itself for the powerful sting of Beedrill, symbolizing resilience in its evolutionary journey.'),
  (14, 'beedrill', 23.00, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/15.png', 0, 3.3, 'Beedrill, the swift Poison/Bug Pokémon, emerges as a formidable stinger from the Weedle line, showcasing speed and potent venom in battles.'),
  (15, 'pidgeot', 58.34, 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/16.png', 0, 4.4, 'Pidgeot, the majestic Flying-type, rules the skies with speed and power. Evolving from Pidgeotto, it\'s the pinnacle of the Pidgey line.')";
  
  

  
  for ($i = 1; $i <= 100; $i++) {
    
    echo $i . "<br>";
  }
  
  if ($conn->query($sql) === TRUE) echo "-> Table 'products' records inserted successfully!<br>";
  else echo "Error: " . $sql . "<br>" . $conn->error. "<br>";

  // Table users
  $sql = "CREATE TABLE `users` (
    `userID` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `fullname` varchar(50) NOT NULL,
    `level` int(11) NOT NULL,
    `orders` int(11) NOT NULL,
    `buys` decimal(10,2) NOT NULL,
    `fire` int(11) NOT NULL,
    `water` int(11) NOT NULL,
    `grass` int(11) NOT NULL,
    `electric` int(11) NOT NULL,
    PRIMARY KEY (`userID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
  if ($conn->query($sql) === TRUE) echo "*Table 'users' created successfully! <br>";
  else echo "Error creating table: " . $conn->error . '<br>';
  
  $my_password = "123456789";
  $hashed_password = password_hash($my_password, PASSWORD_DEFAULT);
  
  $sql = "INSERT INTO `users` (`username`, `password`, `fullname`, `level`, `orders`, `buys`, `fire`, `water`, `grass`, `electric`) VALUES
('dinhledung@mail.com', '$hashed_password', 'Đinh Lê Dũng', 3, 122, 180.00, 40, 10, 15, 25)";
  if ($conn->query($sql) === TRUE) {
      echo "-> Table 'user' record inserted successfully! <br>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
  }

  // Table recent_login
  $sql = "CREATE TABLE `recent_login` (
    `no` int(11) NOT NULL AUTO_INCREMENT,
    `token` varchar(64) NOT NULL,
    `userID` int(11) NOT NULL,
    PRIMARY KEY (`no`),
    UNIQUE KEY `token` (`token`)
)";

  if ($conn->query($sql) === TRUE) echo "*Table 'recent_login' created successfully! <br>";
  else echo "Error creating table: " . $conn->error . "<br>";
  
  $conn->close();
?>