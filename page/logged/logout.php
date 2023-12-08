<?php
  session_start();
  session_unset();
  session_destroy();
  setcookie("token",  "", time() - 1, "/");
  header('Location: ../../../../index.php');
  exit();
?>