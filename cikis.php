<?php
  session_start();
  unset($_SESSION['username']);
  header("Location:giris3.php");
?>