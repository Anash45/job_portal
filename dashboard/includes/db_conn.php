<?php
$servername = "localhost";
$username = "root";
$password = ""; //UvnEnk>7
$dbname = "jobs_portal_v3";

// $servername = "dedi706.your-server.de";
// $username = "jobsmz_1";
// $password = "fGHQKuV9WnH5WWNQ";
// $dbname = "job_new";
header('Content-Type: text/html; charset=utf-8');
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

mysqli_set_charset($conn, 'utf8');

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
