<?php 
  session_start();
  ob_start();
  require_once "../../db/connect.php";
  $email = "";
  $password = "";
  if (isset($_POST['submit_login'])) {
    $email = $_POST['uname'];
    $password = $_POST['passw'];
    $_SESSION['input_username'] = $email;
  };

  // Valid email, password one more time 
  $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/'; // Match Email format
  $asciiRegex = '/^[\x20-\x7E]+$/'; // Match ASCII
  $valid_email = false;
  $valid_pass = false;

  if (strlen($email) >= 1 && strlen($email) < 3) {
    $valid_email = false;
  } else {
    if (strlen($email) == 0) {
      $valid_email = false;
    } else {
      // Check if username is maximum 243 characters
      if (strlen($email) > 254) {
        $valid_email = false;
      } else {
        // Check if vaid email styling
        if (preg_match($emailRegex, $email) && preg_match($asciiRegex, $email)) {
          if (strpos($email, " ") !== false) $valid_email = false;
          else $valid_email = true;
        } else {
          $valid_email = false;
        }
      }
    }
  }

  // Check if password is filled
  if (strlen($password) == 0 || strlen($password) > 255) {
    $valid_pass = false;
  } else {
    if (strpos($password, " ") !== false) $valid_pass = false;
    else $valid_pass = true;
  }

  if ($valid_email == false || $valid_pass == false) {
    $_SESSION['login_fail'] = true;
    header('Location: ../../../../index.php?page=login');
    exit();
  }
// 
  $sql = "SELECT * FROM users WHERE username = ?";
  $result = $conn->prepare($sql);
  $result->bind_param("s", $email);
  $result->execute();
  $result = $result->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];
    if (password_verify($password, $hashedPassword)) {
      $uid = $row['userID'];
      $_SESSION['user_id'] = $uid;
      if ((isset($_POST['remember'])) && ($_POST['remember'] == 'on')) {
        $token = bin2hex(random_bytes(32));
        
        $sql = "INSERT INTO recent_login (token, userID) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $token, $uid);
        $stmt->execute();
        $stmt->close();
        
        setcookie("token",  $token, time() + 60 * 60 * 24 * 30, "/", "", true, true);
      } else {
        setcookie("token",  "", time() - 1, "/");
      }
      header('Location: ../../../../index.php');
      exit();
    } else {
      $_SESSION['login_fail'] = true;
      header('Location: ../../../../index.php?page=login');
      exit();
    }
  } else {
    $_SESSION['login_fail'] = true;
    header('Location: ../../../../index.php?page=login');
    exit();
  }
?>