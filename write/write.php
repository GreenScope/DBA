<?php

// Database Credentials
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$database = new mysqli($servername, $username, $password, $dbname);

// Check connection and terminate on error with Error Code 00
if ($database->connect_error) {
    die("E00: " . $database->connect_error);
}


// Function to decide which table to upload to
function compareTime($sensorName, $country, $city, $area) {
  global $database;

  // Escape variables to prevent SQL injection
  $sensorName = $database->real_escape_string($sensorName);
  $country = $database->real_escape_string($country);
  $city = $database->real_escape_string($city);
  $area = $database->real_escape_string($area);


  // Check if the location exists in the database
  $sql = "SELECT *
          FROM 'Location'
          WHERE country = '$country' AND city = '$city' AND area = '$area'";
  
  $result = $database->query($sql);

  // Check if the table exists
  if ($database->errno == 1146) {
    die("E01: " . $database->error);
  }
  // If there are no results
  if ($result) {
    if ($result->num_rows === 0) {
      die("E02: Invalid location given");
    }
  } else {
    die("EXX: " . $database->error);
  }

  // Get timestamp of the latest entry in the specified location
  $sql = "SELECT stored_at 
          FROM $sensorName 
          WHERE country = '$country' AND city = '$city' AND area = '$area' 
          ORDER BY stored_at DESC 
          LIMIT 1";


  $result = $database->query($sql);

  // Check if the table exists
  if ($database->errno == 1146) {
    die("E03: " . $database->error);
  }
  // If there are no results
  if ($result) {
    if ($result->num_rows === 0) {
      die("E04: No previous records found, assuming first entry and continuing");
    }
    $tz = new DateTimeZone('Asia/Karachi');
    $row = $result->fetch_assoc();

    $storedTime = new DateTime($row['stored_at'], $tz);
    $currentTime = new DateTime('now', $tz);

    $diff = $storedTime->diff($currentTime);
    $differenceInMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
    return $differenceInMinutes;

  } else {
    die("EXX: " . $database->error);
  }
}
?>
