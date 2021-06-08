<?php
$ini_array = parse_ini_file("config.ini");
$servername = $ini_array['dbhost'];
$username = $ini_array['dbuname'];
$password = $ini_array['dbpass'];
$dbname = $ini_array['dbname'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	header("Location: ".BASE_URL."setup.php");
  	die("Connection failed: " . mysqli_connect_error());
}

$query = '';
$sqlScript = file('../db/digital_name.sql');
foreach ($sqlScript as $line)	{
	
	$startWith = substr(trim($line), 0 ,2);
	$endWith = substr(trim($line), -1 ,1);
	
	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}
		
	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
		$query= '';		
	}
}
echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';
?>