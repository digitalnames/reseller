<?php

$servername = "localhost";
$username = "hbfgkmgn_tnsadmin";
$password = "Tns4$2021";
$dbname = "hbfgkmgn_reseller_digital_names";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}