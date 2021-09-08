<?php
$host = "localhost";
$user = "estagiouser";
$pass = "12345";
$db = "estagio";

// $link = mysqli_connect($host, $user, $pass, $db);
$link = new mysqli($host, $user, $pass, $db);
if ($link->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>
  