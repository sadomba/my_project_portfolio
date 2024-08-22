<?php
 $dbhost = 'localhost';
 $dbuser = 'root';
 $dbpass = '';
 $datab = 'aide';
 $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$datab);

mysqli_select_db($conn,$datab);

?>